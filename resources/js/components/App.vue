<template>
  <div>
    <header>
      <HeaderNav />
    </header>
    <main class="fixed-navbar">
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import HeaderNav from "./includes/HeaderNav.vue";
export default {
  name: "App",
  components: { HeaderNav },
};
</script>

<style lang="scss" scoped>
.fixed-navbar{
  margin-top: 65px;
  background-color: #ffffed;
}
</style>
