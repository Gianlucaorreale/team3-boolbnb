<template>
    <div class="container">
        <form action="" method="get">
            <div class="d-flex">
                <!-- Choose beds -->
                <label for="bed">
                    Choose the num of beds
                </label>
                <select v-model="bed" name="bed" id="bed">
                    <option v-for="bed in beds" :key="bed" :value="bed">{{bed}}</option>
                </select>

                <!-- Choose rooms -->
                <label for="room">
                    Choose the num of rooms
                </label>
                <select v-model="room" name="room" id="room">
                    <option v-for="room in rooms" :key="room" :value="room">{{room}}</option>
                </select>

                <!-- Choose bathrooms -->
                <label for="bathroom">
                    Choose the num of bathrooms
                </label>
                <select v-model="bathroom" name="bathroom" id="bathroom">
                    <option v-for="bathroom in bathrooms" :key="bathroom" :value="bathroom">{{bathroom}}</option>
                </select>
            </div>
            <div>
                <h3>Choose your services</h3>
                <div class="row">
                    <div class="col-3" v-for="item in services" :key="item.id">
                        <input class="mr-1" :id="item.label" name="services[]" type="checkbox" :value="item.id" v-model="service">
                        <label :for="item.label">{{item.label}}</label>
                    </div>
                </div>
            </div>
        </form>
        <button class="btn btn-primary" @click="$router.back()">Torna indietro</button>
        <div class="d-flex flex-wrap pt-4 justify-content-center">
            <ul class="mb-4">
                <CardApartment v-for="apartment in filterApartments" :key="apartment.id" :apartment="apartment" />
            </ul>
        </div>
    </div>
</template>

<script>
    import CardApartment from '../apartments/CardApartment.vue';
     export default{
        name:'ApartmentsList',
        data(){
            return {
                beds: ['1','2','3','4','5','6','7','8+'],
                rooms: ['1','2','3','4','5','6','7','8+'],
                bathrooms: ['1','2','3','4','5','6','7','8+'],
                bed: null,
                room: null,
                service: [],
                bathroom: null,
                services: [],
                apartments: [],
                apartmentsFilter: [],
                dist: '',
                lat: null,
                long : null,
                radius: 20,
            };
        },
        components:{ CardApartment },
        computed: {
            filterApartments(){
                
                this.apartmentsFilter = this.apartments.filter(apartment => {
                    if (!this.bed) return true;
                    if (apartment.num_bed == this.bed) return true;
                });
                this.apartmentsFilter = this.apartmentsFilter.filter(apartment => {
                    if (!this.room) return true;
                    if (apartment.num_rooms == this.room) return true;
                });
                this.apartmentsFilter = this.apartmentsFilter.filter(apartment => {
                    if (!this.bathroom) return true;
                    if (apartment.num_bathroom == this.bathroom) return true;
                });
                // this.apartmentsFilter = this.apartmentsFilter.filter(apartment => {

                // });
                return this.apartmentsFilter
            }
        },
        methods:{
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
                });
            },

            fetchApartments(){
                axios.get(`http://127.0.0.1:8000/api/apartments`).then((res)=>{
                    this.apartments = res.data;
                })
            },
            getServices(){
                axios.get(`http://127.0.0.1:8000/api/services`).then((res)=>{
                    this.services = res.data;
                })
            }
        },
        mounted(){
            this.searchApartments();
            this.getServices();
        },
    };

</script>

<style>

</style>