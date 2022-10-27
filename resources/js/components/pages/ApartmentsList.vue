<template>
    <div class="container d-flex flex-wrap pt-4">
        <ul class="mb-4">
           <CardApartment v-for="apartment in apartments" :key="apartment.id" :apartment="apartment" />
        </ul>
    </div>
</template>

<script>
    import CardApartment from '../apartments/CardApartment.vue';
     export default{
        name:'ApartmentsList',
        data(){
            return {
                apartments: [],
            };
        },
        components:{ CardApartment },
        
        methods:{
            fetchApartments(){
                axios.get(`http://127.0.0.1:8000/api/apartments`).then((res)=>{
                    this.apartments = res.data;
                })
            },
        },
        mounted(){
            this.fetchApartments();
        },
    };

</script>

<style>

</style>