<template>
    <div class="apartment container">
      <CardApartment :apartment="apartment"/>
    </div>
  </template>
  
  <script>
  import Axios from 'axios';
import CardApartment from '../apartments/CardApartment.vue';
  
  export default {
      name: "ApartmentDetailPage",
      components: {
    CardApartment
},
      data() {
        return {
          apartment: {},
        };
      },
      methods: {
        fetchApartment() {
          Axios.get("http://localhost:8000/api/apartments/"+ this.$route.params.id).then(res => {
            console.log(res);
            this.apartment = res.data[0];
          }).catch(err => {
            console.error(err);
          }).then(() => {
            console.log("chiamata terminata!");
          });
        }
      },
      mounted(){
        this.fetchApartment();
      }
  }
  </script>
  
  <style>
  
  </style>