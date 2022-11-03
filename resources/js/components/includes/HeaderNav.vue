<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <router-link class="navbar-brand" :to="{ name: 'home-page' }"
      >BoolB&B</router-link
    >
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
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-toggle="dropdown"
            aria-expanded="false"
          >
            Dropdown link
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
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
</style>