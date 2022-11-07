<template>
  <div class="apartment container pb-1">

      <!-- dettaggli appartamento -->
      <div v-if="isLoading" class="loader">
        <div class="spinner-grow text-info" role="status">
          <p>loading...</p>
        </div>
      </div>
      <div v-else class="row pt-3">
        <div class="col-12">
          <h1>{{ apartment.descriptive_title }}</h1>
          <address>
            <i class="fa-solid fa-location-dot"></i>
            <strong>{{ apartment.address }}</strong>
          </address>
          
          <div class="row justify-content-between position-relative">
            <!-- immagine -->
            <div class="col-12 col-md-7">
              <img
              class="image-apartment rounded"
              v-if="apartment.image"
              :src="require('../../../../public/storage/' + apartment.image)"
              :alt="apartment.descriptive_title"
              />
              <img
              class="image-apartment rounded"
              v-else
              src="https://img.freepik.com/free-vector/beautiful-home_24877-50819.jpg?w=2000"
              />
              <!-- servizi -->
              <hr />
              <div class="my-3">
                <h3>COSA TROVERAI</h3>
                <div class="row">
                  <span
                  class="col-6 py-2"
                  v-for="service in apartment.services"
                  :key="service.id"
                  :service="service"
                  >
                    <i :class="service.icon + ' mr-4'"></i>
                    {{ service.label }}
                  </span>
              </div>
            </div>
            <hr />
            <h3>COSA OFFRE QUESTA ESPERIENZA</h3>
            <p>
              Abitazione di {{ apartment.square_meters }}mq, semplice,
              accogliente, moderno e luminoso, composto da
              {{ apartment.num_rooms }} stanze,
              {{ apartment.num_bathroom }} bagni e
              {{ apartment.num_bed }} letti. Completo di tutti gli
              elettrodomestici necessari: lavastoviglie, microonde, bollitore.
              Il salotto ha un divano letto matrimoniale molto comodo, grandi
              finestre e una TV. Nel bagno è presente una lavatrice e un phon.
            </p>
            <hr />
            
            <h3>DA SAPERE</h3>
            <ul class="to-know">
              <li>Check-in: Flessibili</li>
              <li>Check-out: 16:00</li>
              <li>È consentito portare animali domestici</li>
              <li>
                Si applicano le pratiche di sicurezza di BoolB&B per l'emergenza
                COVID-19
              </li>
              <li>È consentito fumare</li>
            </ul>
            <hr />
            
            <H5>
              <i class="fa-regular fa-pen-to-square"></i>
              CANCELLAZIONE GRATUITA FINO AD UNA SETTIMANA PRIMA
            </H5>
            <hr />
          </div>
          
          <!-- messaggi -->
          <div class="col-12 col-md-4">
            <div class="card w-100 message shadow rounded p-3">
              <h3>Manda un messaggio.</h3>
              
              <div v-if="errors">
                <div
                v-if="errors.email"
                class="alert alert-danger"
                role="alert"
                >
                {{ errors.email }}
              </div>
              
              <div
              v-if="errors.content"
              class="alert alert-danger"
              role="alert"
              >
              {{ errors.content }}
            </div>
          </div>
          
          <div v-if="sent">
            <div class="alert alert-success" role="alert">
              Messaggio inviato con successo!
            </div>
          </div>
          
          <form @submit.prevent="sendForm()">
            <div class="form-row">
              <div class="form-group col-md-12 mt-3">
                <label for="email">Email:</label>
                <input
                type="email"
                name="email"
                class="form-control"
                placeholder="inserire email"
                v-model="form.email"
                id="email"
                required
                />
              </div>
              <div class="form-group col-md-12 mt-3">
                <label for="content">Testo:</label>
                <textarea
                class="form-control mx-1"
                name="content"
                id="content"
                placeholder="inserire testo"
                v-model="form.content"
                rows="4"
                required
                ></textarea>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="send-button btn mt-3 mb-3">
                Invia
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- map -->

<div class="row my-3">
  <div class="col-12 mb-3">
    <h3>DOVE TI TROVERAI</h3>
  </div>
  <div class="col-12">
    <div id="map"></div>
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
        content: "",
        email: "",
      },
      lat: "",
      long: "",
      sent: false,
      errors: {},
      apartment: {},
      isLoading: false,
    };
  },
  methods: {
    sendForm() {
      this.sent = false;
      Axios.post("http://localhost:8000/api/apartments/email", [
        this.apartment,
        this.form,
      ])
        .then((res) => {
          this.form.content = "";
          this.form.email = "";
          this.errors = {};
          if (res.data.errors) {
            if (res.data.errors.email)
              this.errors.email = res.data.errors.email[0];
            if (res.data.errors.content)
              this.errors.content = res.data.errors.content[0];
          } else {
            this.sent = true;
          }
        })
        .catch((err) => {
          console.log(err);
        })
        .then(() => {
          console.log("Chiamata Terminata");
        });
    },
    fetchApartment() {
      this.isLoading = true;
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
          this.isLoading = false;
          console.log("chiamata terminata!");
          this.getMap();
        });
    },

    getMap() {
      const map = tt.map({
        key: "k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
        container: "map",
        center: [this.long, this.lat],
        zoom: 15,
      });
      var popupOffset = 25;
      map.on("load", () => {
        var marker = new tt.Marker()
          .setLngLat([this.long, this.lat])
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
#map {
  width: 100%;
  height: 400px;
  border-radius: 20px;
  box-shadow: black 5px 6px 20px -11px;
}
address {
  font-size: 1.3rem;
}

.to-know {
  list-style-type: circle;
  padding-left: 20px;
}

.message {
  position: sticky;
  top: 80px;
  right: 0;
}
i {
  width: 20px;
  height: 20px;
  font-size: 20px;
}
.send-button {
  background-color: #ffbd59;
}
.image-apartment{
  max-width: 100%;
  height: 400px;
  object-fit: cover;
  object-position: center;
}
  .loader {
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    position: fixed;
    z-index: 9;
    display: flex;
    justify-content: center;
    align-items: center;
    .spinner-grow {
      width: 150px;
      height: 150px;
      display: flex;
      justify-content: center;
      align-items: center;
      p {
        color: black;
        font-size: 25px;
      }
    }
  }
</style>