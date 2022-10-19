<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Home</div>
          <div class="card-body">Home</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import firebaseApp from "../../firebase/firebaseConfig";
import { getAuth } from "firebase/auth";
import { getDatabase, ref, onValue } from "firebase/database";
export default {
  // data() {
  //   return {};
  // },
  mounted() {
    this.getUser();
  },
  methods: {
    getUser() {
      const auth = getAuth();
      const db = getDatabase(firebaseApp);
      const user = auth.currentUser;
      console.log("ee", user);
      const users = ref(db, "users");
      onValue(users, (snapshot) => {
        const data = snapshot.val();
        console.log(data);
      });
    },
  },
};
</script>
