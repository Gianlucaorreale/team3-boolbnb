<template>
    <div class="search-bar">
      <input id="query"
        type="text"
        class="me-2 rounded border-0 p-2"
    />
      <button class="rounded border-0 py-2 px-4" onclick="search()">
        Cerca
      </button>
      <div id="mymap" style="height:50vh;">
        {{map}}
    </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "SearchBarApartment",
    data() {
      return {
        searchText: "",
         
      };
    },
  
    methods: {
       
        APIKEY: "xnU4V8EAyAUoA2mApWozIuuMusi5WDmF",
         Rome: [41.5330, 12.3040],
         map: tt.map({
           key:APIKEY,
           container:'mymap',
           center: Rome,
           style:'tomtom://vector/1/basic-main'
        }),

       moveMap (lnglat){
        map.flyTo({
            center: lnglat,
            zoom: 20,
        })
       }, 

       handleResults (result){
        if(result.results){
           moveMap(result.results[0].position)
        }
       }, 

        search () {
        tt.services.fuzzySearch({
            key:APIKEY,
            query : document.getElementById("query").value,
        }).go().then(handleResults)
       } 
     }
   }
  </script>
  
  <style lang="scss" scoped>
  </style>

  <script>
   
   var APIKEY = "xnU4V8EAyAUoA2mApWozIuuMusi5WDmF"
        var Rome = [41.5330, 12.3040]
       
</script>