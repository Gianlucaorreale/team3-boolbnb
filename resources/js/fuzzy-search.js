
        
        var APIKEY = "xnU4V8EAyAUoA2mApWozIuuMusi5WDmF"
        var Rome = [41.5330, 12.3040]
        var map = tt.map({
           key:APIKEY,
           container:'mymap',
           center: Rome,
           style:'tomtom://vector/1/basic-main'
       });
       var moveMap = function(lnglat){
        map.flyTo({
            center: lnglat,
            zoom: 20,
        })
       }

       var handleResults = function(result){
        if(result.results){
            moveMap(result.results[0].position)
        }
       };

       var search = function() {
        tt.services.fuzzySearch({
            key:APIKEY,
            query : document.getElementById("query").value,
        }).go().then(handleResults)
       }
   
