<template>
  <div class="card offset-3 col-6 mb-4">
    <img class="card-img-top" width="100" height="100" :src="apartment.image" :alt="apartment.descriptive_title">
    <div class="card-body">
      <h5 class="card-title">{{ apartment.descriptive_title }}</h5>
      <span class="card-text">camere:{{ apartment.num_bed }},bagni:{{ apartment.num_bathroom }}metri quadri:{{ apartment.square_meters }}</span>
      <p>{{ apartment.address }}</p>
      <p>{{ pubblicata(apartment) }}</p>
      <router-link class="btn btn-primary offset-2 col-8 mt-2" 
        :to="{name: 'ApartmentDetailPage', params:{ id : apartment.descriptive_title }}">
        Vedi
      </router-link>
      <!-- //da modificare con metodo professionale la presa dell id nell apartament -->
    </div>
  </div>  
</template>

<script>
    
    export default{
        name:"ApartmentDetailPage",
        props:{
        apartment:Object,
        },
    methods:{
        pubblicata(apartment){
            const apartmentDate = new Date(apartment.created_at);
                let day = "0" + apartmentDate.getDate();
                let month = apartmentDate.getMonth()+1;
                let year = apartmentDate.getFullYear();
                    
                return `${day}/${month}/${year}`;
            },
        }
    };
</script>

<style lang="scss">
    ul{
        list-style-type: none;
    }



</style>