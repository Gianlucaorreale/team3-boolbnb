<template>
  <section>
    <div class="container mt-5">
      <div class="row">
        <div class="col-12">
          <div class="form-group position-relative">
            <div id="address-tomtom">   
              <button
                class="btn btn-outline-secondary search-btn"
                type="button"
                id="search"
                @click="searchApartments"
              >
                <i class="fa-solid fa-magnifying-glass"></i> Cerca
              </button>
            </div>
          </div>
          <div class="col-12 py-4">
            <label for="customRange1" class="form-label fs-4">
              Seleziona il raggio
            </label>
            <input
              v-model="radius"
              @change="getApartments"
              min="0"
              max="50"
              step="1"
              type="range"
              class="form-range"
              id="customRange1"
              :disabled="!dist"
            />
            <p v-show="dist" class="m-0">Raggio attuale: {{ radius }} Km</p>
          </div>
          <div class="col-8 offset-2">
            <div id="map"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import TheLoader from "../generics/TheLoader.vue";
import CardApartment from "./CardApartment.vue";
import SearchBox from '@tomtom-international/web-sdk-plugin-searchbox';
import { services } from '@tomtom-international/web-sdk-services';
export default {
  components: { CardApartment, TheLoader },
  name: "SearchBarApartment",
  data() {
    return {
      isLoading: false,
      apartments: [],
      searchError: false,
      dist: null,
      bed: null,
      room: null,
      lat: null,
      long: null,
      radius: 20,
    };
  },
  methods: {
    fetchApartments() {
      this.isLoading = true;
      axios
        .get("http://127.0.0.1:8000/api/apartments")
        .then((res) => {
          this.apartments = res.data;
        })
        .catch((err) => {
          console.error(err);
        })
        .then(() => {
          console.log("chiamata terminata Appartamenti");
          this.isLoading = false;
          this.getMap();
        });
    },
    searchApartments() {
      this.searchError = false;
      if (this.dist == null) return;
      if (this.dist) {
        const config = {
          params: {
            countryCode: "IT",
            query: this.dist,
            key: "k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
          },
        };
        delete axios.defaults.headers.common["X-Requested-With"];
        axios
          .get("https://api.tomtom.com/search/2/search/.json", config)
          .then((res) => {
            this.lat = res.data.results[0].position.lat;
            this.long = res.data.results[0].position.lon;
            this.getApartments(this.radius || 20, "radius");
          })
          .catch((err) => {
            console.error(err);
            this.searchError = true;
          })
          .then(() => {
            console.log("chiamata terminata LatLong");
          });
      } else {
        this.dist = null;
        this.lat = null;
        this.long = null;
        this.apartments = [];
        this.getApartments();
      }
    },

    //Formula distanza per calcolare la distanza in km tra 2 punti
    distance(lat1, lon1, lat2, lon2, unit) {
      if (lat1 == lat2 && lon1 == lon2) {
        return 0;
      } else {
        var radlat1 = (Math.PI * lat1) / 180;
        var radlat2 = (Math.PI * lat2) / 180;
        var theta = lon1 - lon2;
        var radtheta = (Math.PI * theta) / 180;
        var dist =
          Math.sin(radlat1) * Math.sin(radlat2) +
          Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist);
        dist = (dist * 180) / Math.PI;
        dist = dist * 60 * 1.1515;
        if (unit == "K") {
          dist = dist * 1.609344;
        }
        if (unit == "N") {
          dist = dist * 0.8684;
        }
        return dist;
      }
    },
    getApartments(value, type, page = 1) {
      // Mappa al caricamento
      this.apartments = [];
      this.isLoading = true;
      axios
        .get("http://127.0.0.1:8000/api/apartments")
        .then((res) => {
          const apartments = res.data;
          if (this.lat && this.long) {
            this.apartments = apartments.filter((apartment) => {
              const lat = apartment.latitude;
              const long = apartment.longitude;
              if (
                this.distance(lat, long, this.lat, this.long, "K") < this.radius
              ) {
                return true;
              }
              return false;
            });
          } else {
            console.log("Nessun Appartamento nel raggio impostato");
          }
        })
        .catch((err) => {
          console.error(err);
        })
        .then(() => {
          console.log("chiamata terminata Appartamenti");
          this.isLoading = false;
          this.getMap();
          this.$emit('sendApartments', this.apartments);
        });
    },
    getMap() {
      if (!this.lat && !this.long) {
        const map = tt.map({
          key: "k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
          container: "map",
          center: [12.496366, 41.902782],
          zoom: 4,
        });
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());
        var popupOffset = 25;
        map.on("load", () => {
          this.apartments.forEach((element) => {
            var marker = new tt.Marker()
              .setLngLat([element.longitude, element.latitude])
              .addTo(map);
            var popup = new tt.Popup({ offset: popupOffset }).setHTML(
              `<p class="mt-1">${element.descriptive_title}</p>
              <p class="m-0">${element.address}</p>`
            );
            marker.setPopup(popup);
          });
        });
      } else {
        const map = tt.map({
          key: "k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
          container: "map",
          center: [this.long, this.lat],
          zoom: this.radius > 20 ? 13 : 18,
        });
        var popupOffset = 25;
        map.on("load", () => {
          this.apartments.forEach((element) => {
            var marker = new tt.Marker()
              .setLngLat([element.longitude, element.latitude])
              .addTo(map);
            var popup = new tt.Popup({ offset: popupOffset }).setHTML(
              `<p class="mt-1">${element.descriptive_title}</p>
                <p class="m-0">${element.address}</p>`
            );
            marker.setPopup(popup);
          });
        });
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());
      }
    },
    getSearchBox(){
      var options = {
          searchOptions: {
              key: 'k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA',
              language: 'it-IT',
              limit: 10,
          },
          autocompleteOptions: {
              key: 'k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA',
              language: 'it-IT',
          }
      };
      const addressContainer = document.getElementById("address-tomtom")
      var ttSearchBox = new SearchBox(services, options);
      var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
      addressContainer.append(searchBoxHTML);
      const tomtomInput = document.getElementsByClassName("tt-search-box-input")[0];
      tomtomInput.setAttribute("class","input-tomtom");
      tomtomInput.addEventListener("input" , (e)=> {
        this.dist = e.target.value;
      })
      tomtomInput.addEventListener("change", (e) => {
        this.dist = e.target.value;
      })
      tomtomInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
          this.dist = e.target.value;
          this.searchApartments();
        }
      });
    }
  },
  mounted() {
    this.getSearchBox();
    this.dist = this.$route.query.search;
    if (this.$route.query.search) this.searchApartments();
    this.fetchApartments();
  },
};
</script>

<style lang="scss">
.btn-outline-secondary {
  color: #2f4f4f;
  border-color: #2f4f4f;
  &:hover {
    background-color: #2f4f4f;
    color: white;
  }
}
.search-btn {
  position: absolute;
  z-index: 20;
  top: 0;
  right: 0px;
  bottom: 0;
}

//Map Style
#map {
  width: 100%;
  height: 400px;
  border-radius: 20px;
  box-shadow: black 5px 6px 20px -11px;
}

// SearchBox Style
.tt-search-box-close-icon{
  display: none;
}
.tt-search-box{
  position: relative;
  .tt-search-box-input-container {
    border: 1px solid #ccc;
    background-color: white;
    padding: 9px 10px;
    display: flex;
    align-items: center;
    transition: border-color .2s ease,box-shadow .2s ease;
    .input-tomtom {
      border: 0px;
      width: 100%;
    }
    .input-tomtom:focus-visible {
      outline: none;
    }
  }
  .tt-search-box-result-list-container {
    max-height: 270px;
    overflow: auto;
    position: absolute;
    z-index: 10;
    width: 100%;
    box-shadow: 0 2px 9px -1px rgb(0 0 0 / 19%);
    .tt-search-box-result-list {
      background-color: #fff;
      cursor: pointer;
      height: auto;
      padding: 10px;
      border-bottom: 1px solid #edf2f7;
      color: #7a7e80;
      display: flex;
      align-items: center;
      .tt-search-box-result-list-text-content {
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          margin-right: 10px;
          display: inline;
      }
      .tt-search-box-result-list-bold {
          font-weight: 700;
          color: #000;
      }
    }
  }
}
</style>