<template>
  <div class="text-center research">
    <div class="container">
      <h1>Benvenuto su BoolB&B</h1>
      <h2>Dove vuoi alloggiare?</h2>
      
      <SearchBarApartment @searchWithDist="setDistAndGo" />
      
    </div>
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
    setDistAndGo(value) {
      this.address = value;
      this.$router.push({name:'apartments-list', query: { address: this.address }});
    },
  },
};
</script>

<style lang="scss" scoped>
.research {
  height: calc(100vh - 200px);
  display: flex;
  align-items: center;
}
</style>
