<template>
  <div
    class="col-md-2 d-flex flex-column flex-shrink-0 p-3 bg-light"
    style="width: 280px"
    v-if="isLoggedIn"
  >
    <router-link to="/" class="text-center text-dark pt-1 text-decoration-none">
      <h4 class="mt-3">SPCT ATTENDANCE</h4>
    </router-link>
    <hr />
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <router-link class="nav-link text-dark" to="/">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#home"></use>
          </svg>
          Home
        </router-link>
      </li>
      <li>
        <router-link class="nav-link text-dark" to="/attendance">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#attendance"></use>
          </svg>
          Attendance
        </router-link>
      </li>
      <li>
        <router-link class="nav-link text-dark" to="/teachers">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#teachers"></use>
          </svg>
          Teachers
        </router-link>
      </li>
      <!-- <li>
        <router-link class="nav-link text-dark" to="/students">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#students"></use>
          </svg>
          Students
        </router-link>
      </li> -->
      <li>
        <router-link class="nav-link text-dark" to="/subjects">
          <svg class="bi me-2" width="16" height="16">
            <use xlink:href="#subjects"></use>
          </svg>
          Subjects
        </router-link>
      </li>
      <hr />
      <li>
        <div class="text-center mt-4">
          <b-button @click="signOut"> Sign Out </b-button>
        </div>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: {
    isLoggedIn: Boolean,
    signOut: Function,
  },
};
</script>
<style scoped>
.nav .active {
  color: #fff !important;
  background-color: #0d6efd;
}
</style>
