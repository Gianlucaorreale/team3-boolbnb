<template>
  <div class="text-center">
    <div class="container">
      <h1>Benvenuto su BoolB&B</h1>
      <h2>Dove vuoi alloggiare?</h2>
    </div>

    <SearchBarApartment @sendApartments="getApartments" />

    <section id="detail-apartment" class="container my-5 p-5">
      <h2 class="text-center" v-if="!apartments.length && address">
        La ricerca non ha prodotto risultati!
      </h2>

      <div v-if="apartments.length" class="text-center">
        <router-link
          :to="{ name: 'apartments-list', query: { address: address } }"
          class="text-center"
        >
          <button class="btn btn-primary">
            La ricerca ha trovato {{ apartments.length }} appartamenti
          </button>
        </router-link>
      </div>
    </section>
  </div>
</template>

<script>
import SearchBarApartment from "../apartments/SearchBarApartment.vue";

export default {
  name: "HomePage",
  components: { SearchBarApartment },
  data() {
    return {
      apartments: [],
      address: "",
    };
  },
  methods: {
    getApartments(value) {
      this.apartments = value.apartments;
      this.address = value.address;
    },
  },
};
</script>

<style>
</style>
