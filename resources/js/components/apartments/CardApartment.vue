<template>
  <router-link
    class="link-card px-0 m-2 col-md-4 col-lg-3"
    :to="{
      name: 'apartment-detail',
      params: { id: apartment.descriptive_title },
    }"
  >
    <div class="h-100 d-flex flex-column justify-content-between">
      <!-- immagine -->
      <img
        v-if="apartment.image"
        class="rounded mb-2"
        :src="require('../../../../public/storage/' + apartment.image)"
        :alt="apartment.descriptive_title"
      />
      <img
        v-else
        class="rounded mb-2"
        src="https://img.freepik.com/free-vector/beautiful-home_24877-50819.jpg?w=2000"
        alt="no-image"
      />
      <!-- descizione -->
      <div class="body text-center">
        <h5 class="title font-weight-bold">
          {{ apartment.descriptive_title }}
        </h5>
        <address class="address mb-0">
          <i class="fa-solid fa-location-dot"></i>
          {{ apartment.address }}
        </address>
      </div>
      <!-- servizi -->
      <div class="services text-center">
        <span
          class="mr-2"
          v-for="service in apartment.services"
          :key="service.label"
        >
          <i class="service-icon" :class="service.icon"></i
        ></span>
      </div>
    </div>
  </router-link>
</template>

<script>
export default {
  name: "ApartmentDetailPage",
  props: {
    apartment: Object,
  },
  methods: {},
};
</script>

<style lang="scss">
ul {
  list-style-type: none;
}
.link-card:hover {
  text-decoration: none;
  color: black;
}

.link-card:hover img {
  box-shadow: 0 3px 5px grey;
}

.link-card:hover .title {
  text-shadow: 0 1px 1px grey;
}

.link-card:hover .address {
  text-shadow: 0 1px 1px grey;
}

.link-card:hover .service-icon {
  text-shadow: 0 1px 1px grey;
}
.link-card {
  color: black;
}

img {
  width: 100%;
  height: 50%;
  object-fit: cover;
  object-position: center;
}
</style>