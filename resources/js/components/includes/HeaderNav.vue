<template>
  <nav class="navbar navbar-expand-lg navbar-light shadow-sm px-5">
    <div class="navbar-brand">
      BoolB&B
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
nav {
  background-color: #c9e265;
}
</style>