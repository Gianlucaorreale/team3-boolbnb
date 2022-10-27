<template>
    <div>
        <HeaderNav/>
        <main>
            <router-view></router-view> 
        </main>
    </div>
   
</template>

<script>
import HeaderNav from './includes/HeaderNav.vue'
    export default {
        name:'App',
        components: { HeaderNav },
    }
</script>

<style>

</style>
