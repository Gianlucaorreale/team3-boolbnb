<template>
    <div class="search-bar">
      <input id="query"
        type="text"
        class="me-2 rounded border-0 p-2"
    />
      <button class="rounded border-0 py-2 px-4" @click="search">
        Cerca
      </button>
      <div id="mymap" style="height:50vh;">
    </div>
    </div>
  </template>

  <script>
  export default {
    name: "SearchBarApartment",
    data() {
      return {
        searchText: "",
        Rome: [41.5330, 12.3040],
      };
    },
  
    methods: {
      moveMap (lnglat){
        const map = tt.map({
          key:"k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
          center: this.Rome,
          container: 'mymap',
          style:'tomtom://vector/1/basic-main',
          });
        map.flyTo({
            center: lnglat,
            zoom: 13,
        })
       }, 

       handleResults (result){
        if(result.results){
           this.moveMap(result.results[0].position)
        }
       }, 

        search () {
          tt.services.fuzzySearch({
              key:"k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
              query : document.getElementById("query").value,
          }).go().then(this.handleResults)
       },

       getMap () {
         const map = tt.map({
          key:"k8P3Rx9lwVUMwJiJA3JF9ARIMpojuobA",
          center: this.Rome,
          container: 'mymap',
          style:'tomtom://vector/1/basic-main',
          });
       }
      },
      mounted(){
        this.getMap();
      }
   }
  </script>
  
  <style lang="scss" scoped>
  </style>