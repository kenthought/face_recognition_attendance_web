<template>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Register</h5>
            <form class="mt-3" ref="form" @submit.stop.prevent="btnSubmit">
              <b-form-group
                class="mb-2"
                label="First Name"
                label-for="first_name"
                invalid-feedback="First name is required"
                :state="first_name_state"
              >
                <b-form-input
                  id="first_name"
                  v-model="item.first_name"
                  :state="first_name_state"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Last Name"
                label-for="last_name"
                invalid-feedback="Last name is required"
                :state="last_name_state"
              >
                <b-form-input
                  id="last_name"
                  v-model="item.last_name"
                  :state="last_name_state"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Middle Name"
                label-for="middle_name"
                :state="middle_name_state"
              >
                <b-form-input
                  id="middle_name"
                  v-model="item.middle_name"
                  :state="middle_name_state"
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Birthday"
                label-for="birthday"
                invalid-feedback="Birthday is required"
                :state="birthday_state"
              >
                <b-form-input
                  id="birthday"
                  v-model="item.birthday"
                  :state="birthday_state"
                  type="date"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Contact no."
                label-for="contact_no"
                invalid-feedback="Contact no. is required"
                :state="contact_state"
              >
                <b-form-input
                  id="contact_no"
                  v-model="item.contact_no"
                  :state="contact_state"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Address"
                label-for="address"
                invalid-feedback="Address is required"
                :state="address_state"
              >
                <b-form-textarea
                  id="address"
                  v-model="item.address"
                  placeholder="Address"
                  rows="3"
                  max-rows="6"
                  :state="address_state"
                  required
                ></b-form-textarea>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="ID number"
                label-for="id_number"
                invalid-feedback="ID number is required"
                :state="id_number_state"
              >
                <b-form-input
                  id="id_number"
                  v-model="item.id_number"
                  :state="id_number_state"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Email address:"
                label-for="email"
                invalid-feedback="Email is required"
                :state="email_state"
              >
                <b-form-input
                  id="email"
                  v-model="item.email"
                  type="email"
                  placeholder="Enter email"
                  :state="email_state"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Password:"
                label-for="password"
                :invalid-feedback="
                  password_state == false
                    ? 'Password is required'
                    : password_match_state == false
                    ? 'Password did not match!'
                    : 'Password is required'
                "
                :state="password_state"
              >
                <b-form-input
                  id="password"
                  v-model="item.password"
                  type="password"
                  placeholder="Enter password"
                  :state="password_state && password_match_state"
                  required
                ></b-form-input>
              </b-form-group>
              <b-form-group
                class="mb-2"
                label="Confirm Password:"
                label-for="confirm_password"
                invalid-feedback="Password did not match!"
                :state="password_match_state"
              >
                <b-form-input
                  id="confirm_password"
                  v-model="item.confirm_password"
                  type="password"
                  placeholder="Confirm password"
                  :state="password_match_state"
                  required
                ></b-form-input>
              </b-form-group>
              <div class="text-center mt-2">
                <b-button type="submit" variant="primary" :disabled="loading">
                  <b-spinner class="mr-2" small v-show="loading"></b-spinner
                  >Register</b-button
                >
              </div>
            </form>
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
      item: {
        first_name: "",
        last_name: "",
        middle_name: "",
        birthday: "",
        contact_no: "",
        address: "",
        id_number: "",
        email: "",
        password: "",
        confirm_password: "",
      },
      first_name_state: null,
      last_name_state: null,
      middle_name_state: null,
      birthday_state: null,
      contact_state: null,
      address_state: null,
      email_state: null,
      id_number_state: null,
      password_state: null,
      password_match_state: null,
      loading: false,
    };
  },
  methods: {
    storeUser(userId, item) {
      const db = getDatabase(firebaseApp);
      set(ref(db, "teachers/" + userId), {
        first_name: item.first_name,
        last_name: item.last_name,
        middle_name: item.middle_name,
        id_number: item.id_number,
        birthday: item.birthday,
        contact_no: item.contact_no,
        address: item.address,
        email: item.email,
        created_at: new Date().toDateString(),
      });
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();

      if (this.item.first_name != "") this.first_name_state = true;
      else this.first_name_state = false;
      if (this.item.last_name != "") this.last_name_state = true;
      else this.last_name_state = false;
      if (this.item.birthday != "") this.birthday_state = true;
      else this.birthday_state = false;
      if (this.item.contact_no != "") this.contact_state = true;
      else this.contact_state = false;
      if (this.item.address != "") this.address_state = true;
      else this.address_state = false;
      if (this.item.email != "") this.email_state = true;
      else this.email_state = false;
      if (this.item.id_number != "") this.id_number_state = true;
      else this.id_number_state = false;
      if (this.item.password != "") this.password_state = true;
      else this.password_state = false;
      if (this.item.password == this.item.confirm_password)
        this.password_match_state = true;
      else this.password_match_state = false;
      this.middle_name_state = true;
      this.loading = false;

      return valid;
    },
    btnSubmit() {
      this.loading = true;

      if (!this.checkFormValidity()) return;

      if (this.password_match_state) {
        const auth = getAuth(firebaseApp);
        const name =
          this.item.first_name +
          (this.item.middle_name.length == 0
            ? " "
            : " " + this.item.middle_name.charAt(0) + ". ") +
          this.item.last_name;
        createUserWithEmailAndPassword(
          auth,
          this.item.email,
          this.item.password
        )
          .then((userCredential) => {
            // Signed in
            const user = userCredential.user;
            this.storeUser(user.uid, this.item);
            this.reset();
            this.loading = false;
            this.toast(
              "b-toaster-top-center",
              "success",
              "Success",
              "User created!"
            );
            this.$router.push("/");
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
      this.item = {
        first_name: "",
        last_name: "",
        middle_name: "",
        birthday: "",
        contact_no: "",
        address: "",
        email: "",
        id_number: "",
        password: "",
        confirm_password: "",
      };
      this.first_name_state = null;
      this.last_name_state = null;
      this.middle_name_state = null;
      this.birthday_state = null;
      this.contact_state = null;
      this.address_state = null;
      this.email_state = null;
      this.id_number_state = null;
      this.password_state = null;
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
