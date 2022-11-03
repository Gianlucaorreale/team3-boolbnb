<template>
  <div class="container">
    <form action="" method="get">
      <div class="row my-3">
        <!-- Choose beds -->
        <div class="col">
          <label for="bed"> Choose the num of beds: </label>
          <select class="custom-select" v-model="bed" name="bed" id="bed">
            <option selected value="">Scegli...</option>
            <option v-for="bed in beds" :key="bed" :value="bed">
              {{ bed }}
            </option>
          </select>
        </div>

        <!-- Choose rooms -->
        <div class="col">
          <label for="room"> Choose the num of rooms: </label>
          <select class="custom-select" v-model="room" name="room" id="room">
            <option selected value="">Scegli...</option>
            <option v-for="room in rooms" :key="room" :value="room">
              {{ room }}
            </option>
          </select>
        </div>

        <!-- Choose bathrooms -->
        <div class="col">
          <label for="bathroom"> Choose the num of bathrooms: </label>
          <select
            class="custom-select"
            v-model="bathroom"
            name="bathroom"
            id="bathroom"
          >
            <option selected value="">Scegli...</option>
            <option
              v-for="bathroom in bathrooms"
              :key="bathroom"
              :value="bathroom"
            >
              {{ bathroom }}
            </option>
          </select>
        </div>
      </div>
      <div>
        <h3>Choose your services:</h3>
        <div class="row">
          <div class="col-6 col-lg-3" v-for="item in services" :key="item.id">
            <input
              class="mr-1"
              :id="item.label"
              name="services[]"
              type="checkbox"
              :value="item.id"
              v-model="service"
            />
            <label :for="item.label">
              <i :class="item.icon + ' mr-2'"></i>
              {{ item.label }}
            </label>
          </div>
        </div>
        <div class="row" v-show="dist">
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
            />
            <p class="m-0">Raggio attuale: {{ radius }} Km</p>
          </div>
        </div>
      </div>
    </form>
    <ul class="row p-0">
      <CardApartment
        v-for="apartment in filterApartments"
        :key="apartment.id"
        :apartment="apartment"
      />
    </ul>
    <div id="map"></div>
  </div>
</template>

<script>
import CardApartment from "../apartments/CardApartment.vue";
export default {
  name: "ApartmentsList",
  data() {
    return {
      beds: ["1", "2", "3", "4", "5", "6", "7", "8+"],
      rooms: ["1", "2", "3", "4", "5", "6", "7", "8+"],
      bathrooms: ["1", "2", "3", "4", "5", "6", "7", "8+"],
      bed: null,
      room: null,
      service: [],
      bathroom: null,
      services: [],
      apartments: [],
      apartmentsFilter: [],
      dist: "",
      lat: null,
      long: null,
      radius: 20,
    };
  },
  components: { CardApartment },
  computed: {
    filterApartments() {
      this.apartmentsFilter = this.apartments.filter((apartment) => {
        if (!this.bed) return true;
        if (apartment.num_bed == this.bed) return true;
      });
      this.apartmentsFilter = this.apartmentsFilter.filter((apartment) => {
        if (!this.room) return true;
        if (apartment.num_rooms == this.room) return true;
      });
      this.apartmentsFilter = this.apartmentsFilter.filter((apartment) => {
        if (!this.bathroom) return true;
        if (apartment.num_bathroom == this.bathroom) return true;
      });
      if (this.service) {
        this.service.forEach((ser) => {
          this.apartmentsFilter = this.apartmentsFilter.filter((apartment) => {
            const apartmentServices = apartment.services.map(
              (apartmentService) => {
                return apartmentService.id;
              }
            );
            if (apartmentServices.includes(ser)) return true;
          });
        });
      }
      return this.apartmentsFilter;
    },
  },
  methods: {
    searchApartments() {
      if (this.$route.query.address) this.dist = this.$route.query.address;
      else this.fetchApartments();
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
          this.getMap()
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

    fetchApartments() {
      axios.get(`http://127.0.0.1:8000/api/apartments`).then((res) => {
        this.apartments = res.data;
      });
    },
    getServices() {
      axios.get(`http://127.0.0.1:8000/api/services`).then((res) => {
        this.services = res.data;
      });
    },
  },
  mounted() {
    this.searchApartments();
    this.getServices();
  },
};
</script>

<style lang="scss" scoped>
#map {
  width: 100%;
  height: 400px;
  border-radius: 20px;
  box-shadow: black 5px 6px 20px -11px;
}
</style>