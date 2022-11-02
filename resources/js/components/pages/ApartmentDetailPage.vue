<template>
  <div
    class="apartment container"
  >
    <div>
      <h1>{{ apartment.descriptive_title }}</h1>
      <address>
        <strong>{{ apartment.address }}</strong>
      </address>
      <p>{{ apartment.square_meters }}mq</p>
      <div class="d-flex">
        <img v-if="apartment.image"
          :src="require('../../../../public/storage/' + apartment.image)"
          :alt="apartment.descriptive_title"
          
        />
        <img v-else src="https://img.freepik.com/free-vector/beautiful-home_24877-50819.jpg?w=2000"
        />
        <ul>
          <li
            v-for="service in apartment.services"
            :key="service.id"
            :service="service"
          >{{ service.label }}
          </li>
        </ul>
       </div>
    </div>
    <div class="row">
      <div class="col-8">

      </div>
      <div class="col-4 card mt-3 mb-3 p-3 rounded">
        <h3>Manda un messaggio.</h3>
        <div v-if="errors">
          <p v-if="errors.email">{{errors.email}}</p>
          <p v-if="errors.content">{{errors.content}}</p>
        </div>
        <div v-if="sent">
          <p>Messaggio inviato con successo</p>
        </div>
        
        <form @submit.prevent="sendForm()">
          <div class="form-row">
            <div class="form-group col-md-12 mt-3">
              <label for="email">Email:</label>
              <input type="email" name="email" class="form-control" placeholder="inserire email" v-model="form.email" id="email" required>
            </div>
            <div class="form-group col-md-12 mt-3">
              <label for="content">Testo:</label>
              <textarea class="form-control mx-1" name="content" id="content" placeholder="inserire testo" v-model="form.content" rows="4" required></textarea>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary mt-3 mb-3">Invia</button>
          </div>
        </form>
      </div>
    </div>
    
      <div class="col-8 offset-2">
            <div id="map">

      </div>
      
    </div>
  </div>
  </template>
  
  <script>
import Axios from "axios";


export default {
  name: "ApartmentDetailPage",

  data() {
    return {
      form: {
        content: '',
        email: '',
      },
      lat: '',
      long: '',
      sent: false,
      errors: {},
      apartment: {},
      isLoading: false,
    };
  },
  methods: {
    sendForm() {
      this.isLoading = true;
      this.sent = false;
      Axios.post('http://localhost:8000/api/apartments/email', [this.apartment, this.form])
      .then(res => {
        this.form.content = '';
        this.form.email = '';
        this.errors = {};
        if (res.data.errors) {
          if (res.data.errors.email) this.errors.email = res.data.errors.email[0];
          if (res.data.errors.content) this.errors.content = res.data.errors.content[0];
        } else {
          this.sent = true;
        };
      }).catch(err =>{
        console.log(err);
      })
      .then(()=>{
        console.log('Chiamata Terminata')
        this.isLoading = false;
      })
    },
    fetchApartment() {
      Axios.get("http://localhost:8000/api/apartments/" + this.$route.params.id)
        .then((res) => {
          this.apartment = res.data[0];
          this.lat = this.apartment.latitude;
          this.long = this.apartment.longitude;
        })
        .catch((err) => {
          console.error(err);
        })
        .then(() => {
          console.log("chiamata terminata!");
          this.getMap();
        });
    },

    

    
    
    getMap() {
      
        const map = tt.map({
          key: "k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
          container: "map",
          center: [this.long, this.lat],
          zoom : 15,
        });
        var popupOffset = 25;
        map.on("load", () => {
          
            var marker = new tt.Marker()
              .setLngLat([this.lat, this.long])
              .addTo(map);
            var popup = new tt.Popup({ offset: popupOffset }).setHTML(
              `<p class="mt-1">${this.apartment.descriptive_title}</p>
                <p class="m-0">${this.apartment.address}</p>`
            );
            marker.setPopup(popup);
          });
        
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());
      
    },
    
    
  },
  mounted() {
   this.fetchApartment();
  },
};
</script>
  
  <style scoped lang="scss">
.apartment {
  height: 100vh;
  img{
    height: 400px;
    border-radius: 20px;
    }
    img:hover{
      box-shadow: 5px 5px #adb5bd;
    }
  }
</style>