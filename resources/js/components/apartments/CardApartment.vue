<template>
  <router-link class="link-card" 
    :to="{name: 'apartment-detail', params:{ id : apartment.descriptive_title }}">
    <div class="card">
    <img v-if="apartment.image" class="card-img-top" width="100" height="100" :src="require('../../../../public/storage/' + apartment.image)" :alt="apartment.descriptive_title">
    <div class="card-body">
      <h5 class="card-title">{{ apartment.descriptive_title }}</h5>
      <p>{{ apartment.address }}</p>
      </div>
    </div>  
  </router-link>
</template>

<script>
    
    export default{
        name:"ApartmentDetailPage",
        props:{
        apartment:Object,
        },
    methods:{
        // pubblicata(apartment){
        //     const apartmentDate = new Date(apartment.created_at);
        //         let day = apartmentDate.getDate();
        //         if(day < 10){
        //           day = `0.${day}`;
        //         }
        //         let month = apartmentDate.getMonth()+1;
        //         if (month < 10){
        //           month = `0.${month}`;
        //         }
        //         let year = apartmentDate.getFullYear();
                    
        //         return `${day}/${month}/${year}`;
        //     },
        }
    };
</script>

<style lang="scss">
    ul{
        list-style-type: none;
    }
    .link-card:hover {
      text-decoration: none;
      color: black;
    }
    .link-card {
      color: black
    }


</style>