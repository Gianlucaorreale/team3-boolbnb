<template>
  <div class="container-fluid">
    <ul class="row p-0">
      <div class="col-12 col-md-6">
        <div class="row position-relative">
          <form class="filters col-12" action="" method="get">
            <div class="row my-3 m-0">
              <!-- Choose beds -->
              <div class="col">
                <div class="d-flex align-items-center">
                  <label class="my-0 mx-2" for="bed">beds: </label>
                  <select class="custom-select" v-model="bed" name="bed" id="bed">
                    <option selected value="">Scegli...</option>
                    <option v-for="bed in beds" :key="bed" :value="bed">
                      {{ bed }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Choose rooms -->
              <div class="col">
                <div class="d-flex align-items-center">
                  <label class="my-0 mx-2" for="room">rooms: </label>
                  <select class="custom-select" v-model="room" name="room" id="room">
                    <option selected value="">Scegli...</option>
                    <option v-for="room in rooms" :key="room" :value="room">
                      {{ room }}
                    </option>
                  </select>
                </div>
              </div>

              <!-- Choose bathrooms -->
              <div class="col">
                <div class="d-flex align-items-center">
                  <label class="my-0 mx-2" for="bathroom">bathrooms: </label>
                  <select class="custom-select" v-model="bathroom" name="bathroom" id="bathroom">
                    <option selected value="">Scegli...</option>
                    <option v-for="bathroom in bathrooms" :key="bathroom" :value="bathroom">
                      {{ bathroom }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div>
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
              <div v-show="showFilters" class="row">
                <div class="col-6 col-lg-4" v-for="item in services" :key="item.id">
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
              <div @click="showFilters = !showFilters" class="row w-100 service-filters">
                <div class="col-12 text-center">
                  <h4 v-if="!showFilters" class="my-0">Filtra i servizi <i class="fa-solid fa-sliders"></i></h4>
                  <i v-if="!showFilters" class="fa-solid fa-chevron-down my-0"></i>
                  <i v-else class="fa-solid fa-chevron-up my-0"></i>
                </div>
              </div>
            </div>
          </form>
          <div class="row">
            <CardApartment class="col-12 col-xl-6 p-4"
            v-for="apartment in filterApartments"
            :key="apartment.id"
            :apartment="apartment"
            />
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 p-0 position-relative">
        <div id="map"></div>
      </div>
    </ul>
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
      showFilters: false,
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
.filters {
  position: sticky;
  background-color: rgb(237, 237, 237);
  z-index: 3;
  padding: 5px;
  top: 65px;
  right: 0;
}

.service-filters{
  cursor: pointer;
}

#map {
  width: 100%;
  z-index: 3;
  height: calc(100vh - 60px);
  position: sticky;
  top: 65px;
  left: 0px;
}
</style>