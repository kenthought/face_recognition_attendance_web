<template>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Login</h5>
            <b-form class="mt-3" @submit.stop.prevent="btnSubmit">
              <b-form-group
                id="input-group-1"
                label="Email address:"
                label-for="email"
              >
                <b-form-input
                  id="email"
                  v-model="email"
                  type="email"
                  placeholder="Enter email"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                id="input-group-2"
                label="Password:"
                label-for="password"
              >
                <b-form-input
                  id="password"
                  v-model="password"
                  type="password"
                  placeholder="Enter password"
                  required
                ></b-form-input>
              </b-form-group>
              <div class="text-center mt-2">
                <b-button type="submit" variant="primary">Login</b-button>
              </div>
            </b-form>
            <div class="row text-center mt-3">
              <div class="col">
                <p class="small">
                  Don't have an account? Click here to
                  <router-link class="link" :to="{ name: 'register' }"
                    >Register</router-link
                  >
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { getAuth, signInWithEmailAndPassword } from "firebase/auth";
import firebaseApp from "../../firebase/firebaseConfig";

export default {
  data() {
    return {
      email: "",
      password: "",
      loggedIn: false,
      loggedInError: false,
      error: false,
      errorMessage: "",
    };
  },
  methods: {
    btnSubmit() {
      const auth = getAuth(firebaseApp);
      signInWithEmailAndPassword(auth, this.email, this.password)
        .then((userCredential) => {
          const user = userCredential.user;
          this.loggedIn = true;
          this.error = false;
          this.loggedInError = false;
          this.$router.push("/");
        })
        .catch((error) => {
          const errorCode = error.code;
          const errorMessage = error.message;
          this.toast("b-toaster-top-center", "danger", "Error", errorMessage);
        });
    },
    toast(toaster, variant = null, title, body) {
      this.counter++;
      this.$bvToast.toast(body, {
        title,
        autoHideDelay: 5000,
        toaster: toaster,
        solid: true,
        variant: variant,
      });
    },
  },
};
</script>
