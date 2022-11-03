<template>
  <div class="text-center research">
    <div class="container">
      <h1 class="titolone">Benvenuto su BoolB&B</h1>
      <h2>Quando vuoi Dove vuoi Con chi vuoi</h2>
      <div class="container" id="galleryImages">
        <div class="row text-center">
                <div id="carousel" class="img-fluid">
                    <div id="leftarrow" v-on:click="gotoPrev" >
                      <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div class="gallery">
                        <figure v-for="(pic,index) in pictures" :class ="currentIndex === index ? `active` : ` `">
                            <img :src="pic.url" :alt="pic.title" />
                            <figcaption class="text-white">
                                <h3>{{ pic.title }}</h3>
                                <h5>{{ pic.description  }}</h5>
                            </figcaption>
                        </figure>
                    </div>
                    <i class="fa-solid fa-arrow-right" id="rightarrow" v-on:click="gotoNext"></i>
                </div>
               
            </div>
        </div>
      </div>
  <SearchBarApartment @searchWithDist="setDistAndGo" />
      
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
      currentIndex:0,
      pictures :[
        {
           url: 'https://cdn.pixabay.com/photo/2019/10/06/08/57/tiber-river-4529605_960_720.jpg',
          title: 'Roma',
          description:
            'Quando fa la stupida di sera è ancora piu bella',
        },
      
        {
          url: 'https://cdn.pixabay.com/photo/2017/08/10/00/50/man-2616599_960_720.jpg',
          title: 'Napoli',
           description:
             'Dovunque sono andato nel mondo ho visto che c’era bisogno di un poco di Napoli.',
         },
      
         {
           url: 'https://cdn.pixabay.com/photo/2017/06/24/00/54/milan-cathedral-2436458_960_720.jpg',
           title: 'Milano',
           description:
             'Sei troppo bella per dirti addio. Tu chiami e poi noi tutti ubbidiamo.',
         },
         {
           url: 'https:static1.evcdn.net/images/reduction/1583177_w-1920_h-1080_q-70_m-crop.jpg',
           title: 'Bologna',
           description:
             'Ma quant è bello andare in giro per i colli bolognesi',
         },
         {
           url: 'https://cdn.pixabay.com/photo/2018/06/17/16/59/girl-3480900_960_720.jpg',
           title: 'Genova',
           description:'Vedrai una città regale addossata ad una collina alpestre superba per uomini e per mura,il cui solo aspetto la indica Signora del Mare: Genova',
         },
       ]
  
        };
    },
  methods: {
    setDistAndGo(value) {
      this.address = value;
      this.$router.push({name:'apartments-list', query: { address: this.address }});
    },
    gotoNext(){
      this.currentIndex++;
      if(this.currentIndex > this.pictures.length -1){
      this.currentIndex = 0;
        }
      },
      gotoPrev(){
        this.currentIndex--;
        if(this.currentIndex < 0){
          this.currentIndex = this.pictures.length - 1;
          }
        }
  },
  

  };




</script>

<style lang="scss" scoped>

.research {
  height: calc(100vh - 200px);
  align-items: center;
}
.titolone{
  padding-top:50px;
}
#carousel{
    height:300px;
    width:600px;
    position:relative;
}
#carousel .gallery{
    height:100%;}

#carousel .gallery img{
    height:100%;
    width:100%;
}

.gallery img{
    height:100%;
    width:300px;
    object-fit:cover;
     /* display:none;  */
}
#carousel .gallery figure{
    height:100%;
    display:none;
    
}
#carousel .gallery .active{
    display:block;
}
#leftarrow{
    font-size: 50px;
    position:absolute;
    top:50%;
    right:110%;
    transform: translateY(-50%);
    color:orangered;
}
#rightarrow{
    font-size: 50px;
    position:absolute;
    top:50%;
    left:110%;
    transform: translateY(-50%);
    color:orangered;
}

#carousel .gallery figure{
    position: relative;
}
#carousel .gallery figcaption{
    position:absolute;
    top:20px;
    right:5px;
    left:20px;
}

</style>
