<template>
  <div class="loader text-center">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TheLoader',
}
</script>

<style lang="scss" scoped>
 .spinner-border{
   font-size: 30px;
   width: 100px;
   height: 100px;
 }
</style>