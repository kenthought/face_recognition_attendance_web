<template>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Register</h5>
            <b-form class="mt-3" ref="form" @submit.stop.prevent="btnSubmit">
              <b-form-group id="input-group-1" label="Name:" label-for="name">
                <b-form-input
                  id="name"
                  v-model="name"
                  type="text"
                  placeholder="Enter Name"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                id="input-group-2"
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
                id="input-group-3"
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
              <b-form-group
                id="input-group-4"
                label="Confirm Password:"
                label-for="confirm_password"
              >
                <b-form-input
                  id="confirm_password"
                  v-model="confirm_password"
                  type="password"
                  placeholder="Confirm password"
                  :state="password_match_state"
                  required
                ></b-form-input>
                <b-form-invalid-feedback :state="password_match_state">
                  Password does not match
                </b-form-invalid-feedback>
              </b-form-group>
              <div class="text-center mt-2">
                <b-button type="submit" variant="primary" :disabled="loading">
                  <b-spinner class="mr-2" small v-show="loading"></b-spinner
                  >Register</b-button
                >
              </div>
            </b-form>
            <div class="row text-center mt-3">
              <div class="col">
                <p class="small">
                  Already registered? Click here to
                  <router-link class="link" :to="{ name: 'login' }"
                    >Sign in</router-link
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
import { getAuth, createUserWithEmailAndPassword } from "firebase/auth";
import firebaseApp from "../../firebase/firebaseConfig";
import { getDatabase, ref, set } from "firebase/database";
export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirm_password: "",
      password_match_state: null,
      loading: false,
    };
  },
  methods: {
    storeUser(userId, name, email, created_at) {
      const db = getDatabase(firebaseApp);
      set(ref(db, "users/" + userId), {
        name,
        email,
        created_at,
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      if (this.password == this.confirm_password)
        this.password_match_state = true;
      else this.password_match_state = false;

      this.loading = false;
      return valid;
    },
    btnSubmit() {
      this.loading = true;
      if (!this.checkFormValidity()) return;

      if (this.password_match_state) {
        const auth = getAuth(firebaseApp);
        createUserWithEmailAndPassword(auth, this.email, this.password)
          .then((userCredential) => {
            // Signed in
            const user = userCredential.user;
            this.storeUser(
              user.uid,
              this.name,
              this.email,
              new Date().toDateString()
            );
            this.reset();
            this.loading = false;
            this.toast(
              "b-toaster-top-center",
              "success",
              "Success",
              "User created!"
            );
          })
          .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            this.loading = false;
            this.toast("b-toaster-top-center", "danger", "Error", errorMessage);
          });
      }
    },
    reset() {
      this.name = "";
      this.email = "";
      this.password = "";
      this.confirm_password = "";
      this.password_match_state = null;
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
