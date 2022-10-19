<template>
  <div class="p-5">
    <h2 class="text-normal mt-3 mb-3">Attendance</h2>
    <div class="row justify-content-center mt-4 p-3">
      <b-table
        show-empty
        striped
        hover
        responsive
        :fields="fields"
        :items="items"
        label-sort-asc=""
        label-sort-desc=""
        label-sort-clear=""
      ></b-table>
    </div>
  </div>
</template>

<script>
import { getDatabase, ref, onValue } from "firebase/database";
export default {
  data() {
    return {
      fields: [
        {
          key: "student_name",
          sortable: true,
        },
        {
          key: "subject",
          sortable: false,
        },
        {
          key: "timeType",
          sortable: false,
        },
        {
          key: "time",
          sortable: false,
        },
      ],
      items: [],
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.load_item();
  },
  methods: {
    load_item() {
      const db = getDatabase();

      const attendance = ref(db, "attendance");
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
