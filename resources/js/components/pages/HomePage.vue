<template>
    <div>
      <SearchBarApartment @sendApartments="getApartments"/>
      <section
        id="detail-apartment"
        class="container-fluid my-5 p-5"
      >
        <h1 class="text-center" v-if="!apartments.length">
          La Ricerca non ha prodotto risultati!
        </h1>

        <div v-else class="text-center">
          <router-link :to="{name:'apartments-list'}" class="text-center">
            <button class="btn btn-primary">La ricerca ha trovato {{apartments.length}} appartamenti</button>
          </router-link>
        </div>
      </section>
    </div>
</template>

<script>
import SearchBarApartment from '../apartments/SearchBarApartment.vue';


 export default {
    name: "HomePage",
    components: { SearchBarApartment },
    data(){
      return {
        apartments: [],
      }
    },
    methods: {
      getApartments(value){
        this.apartments = value;
      }
    }
}
</script>

<style>


</style>
