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
    <div class="card mt-3 mb-3 p-3 rounded">
      <form action="">
          <div class="form-row">
              <div class="form-group col-md-6 mt-3">
                  <label for="inputEmail4"></label>
                  <input type="email" class="form-control" placeholder="inserire email" id="inputEmail4">
              </div>
              <label for="exampleFormControlTextarea1"></label>
              <textarea class="form-control mx-1" id="exampleFormControlTextarea1" placeholder="inserire testo" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary mt-3 mb-3">Invia</button>
     </form>
    </div>
  </div>
  </template>
  
  <script>
import Axios from "axios";

export default {
  name: "ApartmentDetailPage",

  data() {
    return {
      apartment: {},
    };
  },
  methods: {
    fetchApartment() {
      Axios.get("http://localhost:8000/api/apartments/" + this.$route.params.id)
        .then((res) => {
          console.log(res);
          this.apartment = res.data[0];
        })
        .catch((err) => {
          console.error(err);
        })
        .then(() => {
          console.log("chiamata terminata!");
        });
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