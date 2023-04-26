<script>
import { getAuth, onAuthStateChanged, signOut } from "firebase/auth";
import sidebar from "./components/view/sidebar.vue";
import Landing from "./components/LandingPage.vue";
export default {
  components: { sidebar, Landing },
  data() {
    return {
      isLoggedIn: null,
    };
  },
  mounted() {
    this.checkUserIsLoggedIn();
  },
  methods: {
    checkUserIsLoggedIn() {
      const auth = getAuth();
      onAuthStateChanged(auth, (user) => {
        if (user) this.isLoggedIn = true;
        else this.isLoggedIn = false;
      });
    },
    signOut() {
      const auth = getAuth();
      signOut(auth)
        .then(() => {
          this.$router.push("/landing");
          // Sign-out successful.
        })
        .catch((error) => {
          // An error happened.
        });
    },
  },
};
</script>

<template>
  <div id="app">
    <div class="container-fluid">
      <div
        class="text-center"
        style="height: 100vh; line-height: 100vh"
        v-if="isLoggedIn == null"
      >
        <b-spinner variant="info" type="grow"></b-spinner>
      </div>
      <div class="row content-size" v-else>
        <sidebar :isLoggedIn="isLoggedIn" :signOut="signOut" />
        <div class="col-md-10 pt-5">
          <router-view />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
