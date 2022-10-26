<template>
    <div class="apartment container d-flex justify-content-center align-items-center">
       <div class="card p-2">
           <h1>{{apartment.descriptive_title}}</h1>
           <address><strong>{{apartment.address}}</strong></address>
           <p>{{apartment.square_meters}}mq</p>
           <div class="d-flex">
            <img :src="apartment.image" :alt="apartment.descriptive_title">
                <ul>
                   <li v-for="service in apartment.services" :key="service.id" :service="service">
                      {{service.label}}
                  </li>
              </ul>
           </div>
       </div>
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
  
  <style scoped lang="scss">
  .apartment{
    height: 100vh;
  }
  </style>