<template>

  <nav class="navbar navbar-expand-lg navbar-light shadow-sm px-5 py-0">
    <div class="navbar-brand d-flex">
      <p class="bool my-2">BOOL</p>
      <p class="beb my-3">b&b</p>
    </div>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div
      class="collapse navbar-collapse justify-content-between"
      id="navbarNavDropdown"
    >
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'home-page' }"
            >Home</router-link
          >
        </li>
        <li class="nav-item">
          <router-link class="nav-link" :to="{ name: 'apartments-list' }"
            >Apartments</router-link
          >
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="/admin" class="nav-link">
            Admin
          </a>
        </li>
      </ul>
    </div>
  </nav>
 
</template>

<script>
export default {
  name: "HeaderNav",
};
</script>

<style>
.navbar {
  background-color: #EDC021;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 10;
  
}

.bool{
  color: #DE1010;
  font-size: 1.5rem;
  font-weight: 900;
  font-style: oblique;
}

.beb{
  color: white;
  text-shadow: 1px 1px 1px gray;
}
</style>