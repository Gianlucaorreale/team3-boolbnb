<template>
    <div>
        <router-link class="btn btn-primary offset-2 col-8 mt-2" 
            :to="{name: 'apartments-list'}">
            Vai agli appartamenti
      </router-link>
      <SearchBarApartment/>
    </div>
</template>

<script>
import SearchBarApartment from '../apartments/SearchBarApartment.vue';


 export default {
    name: "HomePage",
    components: { SearchBarApartment }
}
</script>

<style>


</style>
