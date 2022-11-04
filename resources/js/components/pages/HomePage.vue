<template>
  <div class="text-center research" :style="currentImage"> 
    <div class="container">
      <div class="row">
        <div class="d-flex col-8 offset-2 justify-content-center align-items-baseline">
        <h1 class="mr-3">Benvenuto su</h1>
        <img
          class="logo"
          :src="require('../../../../public/images/logo.png')"
          alt=""
        />
        </div>
        <h2 class="col-8 offset-2">Quando vuoi Dove vuoi Con chi vuoi</h2>
        <SearchBarApartment class="offset-2 col-8" @searchWithDist="setDistAndGo" />
        <p class="quote col-8 offset-2" :class="currentIndex == index ? 'active' : ''" v-for="(pic,index) in pictures" :key="index"><i class="fa-solid fa-quote-left"></i>{{pic.description}}<i class="fa-solid fa-quote-right"></i></p>
      </div>
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
      currentIndex:0,
      currentImage: '',
      currentQuote: '',
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
    changeBackground(){
      setInterval(() => {
        this.currentIndex++;
        if (this.currentIndex == this.pictures.length) this.currentIndex = 0;
        this.pictures.forEach((pic,index) => {
          if (this.currentIndex == index) return this.currentImage = 'background-image: url('+ pic.url +')';
        });
        return this.currentImage;
      }, 5000);
    },
    setDistAndGo(value) {
      this.address = value;
      this.$router.push({name:'apartments-list', query: { address: this.address }});
    },
  },
  mounted(){
    this.currentImage= 'background-image: url('+this.pictures[0].url+')';
    this.changeBackground();
  }
  

  };




</script>

<style lang="scss" scoped>

.research {
  height: calc(100vh - 55px);
  align-items: center;
  display: flex;
  background-position: center;
  transition: background-image 0.15s ease-in-out;
  background-size: cover;
  color: white;
  text-shadow: 1px 1px 1px black;
  .quote {
    display: none;
    font-size: 30px;
    &.active {
      display: block;
    }
  }
}
</style>
