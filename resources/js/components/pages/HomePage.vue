<template>
    
    <div>
    <ApartmentsList />
   
    </div>

</template>

<script>
import ApartmentsList from './ApartmentsList.vue';

 export default {
    name:'HomePage',
    components:{
        ApartmentsList
    }    
 }
</script>

<style>
ul{
    list-style-type: none;
}


</style>
