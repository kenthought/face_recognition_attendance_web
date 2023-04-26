<template>
  <div class="p-5">
    <h2 class="text-normal mt-3 mb-3">Attendance</h2>
    <hr />

    <div class="row justify-content-center mt-4 p-3">
      <b-table
        id="attendance-table"
        show-empty
        striped
        hover
        responsive
        :sort-by.sync="sortBy"
        :sort-desc="true"
        :fields="fields"
        :items="items"
        label-sort-asc=""
        label-sort-desc=""
        label-sort-clear=""
        :per-page="7"
        :current-page="currentPage"
      ></b-table>
    </div>
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="7"
      aria-controls="attendance-table"
    ></b-pagination>
  </div>
</template>

<script>
import { getDatabase, ref, onValue } from "firebase/database";
import { getAuth } from "firebase/auth";
export default {
  data() {
    return {
      sortBy: "time",
      currentPage: 1,
      fields: [
        {
          key: "class_name",
          sortable: false,
        },
        {
          key: "student_name",
          sortable: true,
        },
        {
          key: "subject",
          sortable: false,
        },
        {
          key: "time",
          sortable: true,
        },
      ],
      items: [],
    };
  },
  computed: {
    rows() {
      return this.items.length;
    },
  },
  mounted() {
    console.log("Component mounted.");
    this.load_item();
  },
  methods: {
    load_item() {
      const db = getDatabase();
      const auth = getAuth();

      const attendance = ref(db, "attendance/" + auth.currentUser.uid);
      onValue(attendance, (snapshot) => {
        this.items = [];
        const data = snapshot.val();
        var result = Object.keys(data).map((key) => {
          this.items.push(data[key]);
        });
      });
    },
  },
};
</script>
