<template>
    <div class="apartment container">
       <img :src="apartment.image" :alt="apartment.descriptive_title">
       <h1>{{apartment.descriptive_title}}</h1>
       <p>{{apartment.square_meters}}mq</p>
       <address>{{apartment.address}}</address>
       <ul>
           <li v-for="service in apartment.services" :key="service.id" :service="service">
            <img :src="service.label" alt="">
            {{service.label}}
          </li>
       </ul>
    </div>
  </template>
  
  <script>
  import Axios from 'axios';

  
  export default {
      name: "ApartmentDetailPage",
      
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