<template>
  <div class="p-5">
    <h2 class="text-normal mt-3 mb-3">Subjects</h2>
    <hr />
    <b-button class="mt-3" variant="outline-info" v-b-modal.modal_add
      ><b-icon icon="plus-circle-fill"></b-icon> Add Subject</b-button
    >
    <div class="row justify-content-center mt-4 p-3">
      <b-table
        id="subjects-table"
        show-empty
        striped
        hover
        responsive
        :fields="fields"
        :items="items"
        label-sort-asc=""
        label-sort-desc=""
        label-sort-clear=""
        :per-page="7"
        :current-page="currentPage"
        @row-clicked="onRowClicked"
      ></b-table>
    </div>
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="7"
      aria-controls="subjects-table"
    ></b-pagination>

    <!-- Add Modal -->
    <b-modal
      id="modal_add"
      ref="modal_add"
      size="lg"
      @hidden="resetModal"
      @ok="handleOk"
      ><div slot="modal-header">
        <div v-if="view == false">
          <h5 class="modal-title">Add Subject</h5>
        </div>
        <div v-else>
          <div class="row">
            <div class="col-xl-10">
              <h5 class="modal-title">Subject Details</h5>
            </div>
            <div class="pt-1 col-xl-2">
              <b-form-checkbox id="editing" v-model="editing" name="editing">
                Edit
              </b-form-checkbox>
            </div>
          </div>
        </div>
        <div class="col-lg-3"></div>
      </div>
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          class="mb-2"
          label="Subject Name"
          label-for="subject_name"
          invalid-feedback="Subject name is required"
          :state="subject_name_state"
        >
          <b-form-input
            id="subject_name"
            v-model="item.subject_name"
            :state="subject_name_state"
            required
            :disabled="editing != true ? (view == true ? true : false) : false"
          ></b-form-input>
        </b-form-group>
        <!-- <b-form-group
          class="mb-2"
          label="Subject Teacher"
          label-for="teacher_id"
          invalid-feedback="Subject teacher is required"
          :state="teacher_id_state"
        >
          <b-form-select
            id="teacher_id"
            v-model="item.teacher_id"
            :options="options"
            :state="teacher_id_state"
            required
            :disabled="editing != true ? (view == true ? true : false) : false"
          ></b-form-select>
        </b-form-group> -->
        <b-form-group
          class="mb-2"
          label="Status"
          label-for="status"
          invalid-feedback="Status is required"
          :state="status_state"
        >
          <b-form-input
            id="status"
            v-model="item.status"
            :state="status_state"
            required
            :disabled="editing != true ? (view == true ? true : false) : false"
          ></b-form-input>
        </b-form-group>
        <b-form-group
          class="mb-2"
          label="Time in"
          label-for="time_in"
          invalid-feedback="Time in is required"
          :state="time_in_state"
        >
          <b-form-timepicker
            id="time_in"
            v-model="item.time_in"
            locale="en"
            :state="time_in_state"
            required
            :disabled="editing != true ? (view == true ? true : false) : false"
          ></b-form-timepicker>
        </b-form-group>
        <b-form-group
          class="mb-2"
          label="Time out"
          label-for="time_out"
          invalid-feedback="Time out is required"
          :state="time_out_state"
        >
          <b-form-timepicker
            id="time_out"
            v-model="item.time_out"
            locale="en"
            :state="time_out_state"
            required
            :disabled="editing != true ? (view == true ? true : false) : false"
          ></b-form-timepicker>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import {
  getDatabase,
  ref,
  set,
  child,
  push,
  update,
  onValue,
  remove,
} from "firebase/database";
import { getAuth } from "firebase/auth";
export default {
  data() {
    return {
      item: {
        subject_name: "",
        teacher_id: null,
        status: "",
        time_in: "",
        time_out: "",
      },
      currentPage: 1,
      fields: [
        {
          key: "subject_name",
          sortable: true,
        },
        {
          key: "status",
          sortable: false,
        },
        {
          key: "time_in",
          sortable: false,
        },
        {
          key: "time_out",
          sortable: false,
        },
      ],
      subject_name_state: null,
      teacher_id_state: null,
      status_state: null,
      time_in_state: null,
      time_out_state: null,
      items: [],
      options: [{ value: null, text: "Please select an option" }],
      view: false,
      editing: false,
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
    console.log(this.editing);
  },
  methods: {
    load_item() {
      const db = getDatabase();
      const auth = getAuth();

      const subjects = ref(db, "subjects/" + auth.currentUser.uid);
      onValue(subjects, (snapshot) => {
        this.items = [];
        const data = snapshot.val();
        var result = Object.keys(data).map((key) => {
          this.items.push(data[key]);
        });
      });

      const teachers = ref(db, "teachers");
      onValue(teachers, (snapshot) => {
        const data = snapshot.val();
        var result = Object.keys(data).map((key) => {
          var first_name = data[key].first_name;
          var middle_name = data[key].middle_name;
          var last_name = data[key].last_name;
          var full_name = (first_name, middle_name, last_name) => {
            if (!middle_name) {
              middle_name = "";
            } else {
              middle_name = middle_name.substr(0, 1) + ".";
            }
            var name = [first_name, middle_name, last_name];
            name = name.filter(Boolean);
            return name.join(" ");
          };
          this.options.push({
            value: data[key].id,
            text: full_name(first_name, middle_name, last_name),
          });
        });
      });
    },
    onRowClicked(items) {
      this.view = true;
      this.item = items;
      console.log(this.item);
      this.$bvModal.show("modal_add");
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      if (this.item.subject_name != "") this.subject_name_state = true;
      else this.subject_name_state = false;
      // if (this.item.teacher_id != null) this.teacher_id_state = true;
      // else this.teacher_id_state = false;
      if (this.item.status != "") this.status_state = true;
      else this.status_state = false;
      if (this.item.time_in != "") this.time_in_state = true;
      else this.time_in_state = false;
      if (this.item.time_out != "") this.time_out_state = true;
      else this.time_out_state = false;

      return valid;
    },
    handleOk(bvModalEvent) {
      // Prevent modal from closing
      bvModalEvent.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return;
      }

      if (this.editing != true) {
        const db = getDatabase();
        const auth = getAuth();
        const subjectKey = push(
          child(ref(db), "subjects/" + auth.currentUser.uid)
        ).key;
        set(ref(db, "subjects/" + auth.currentUser.uid + "/" + subjectKey), {
          id: subjectKey,
          subject_name: this.item.subject_name,
          // teacher_id: this.item.teacher_id,
          status: this.item.status,
          time_in: this.item.time_in,
          time_out: this.item.time_out,
          created_at: new Date().toDateString(),
        })
          .then((response) => {
            this.$nextTick(() => {
              this.$bvModal.hide("modal_add");
            });
            this.toast(
              "b-toaster-top-center",
              "success",
              "Successful",
              "Subject added"
            );
          })
          .catch((response) => {
            // console.log(response);
            this.toast(
              "b-toaster-top-center",
              "danger",
              "Error",
              "Error executing action."
            );
          });
      } else {
        const db = getDatabase();
        const updates = {};
        updates["/subjects/" + this.item.id] = this.item;

        update(ref(db), updates)
          .then((response) => {
            this.$nextTick(() => {
              this.$bvModal.hide("modal_add");
            });
            this.toast(
              "b-toaster-top-center",
              "success",
              "Successful",
              "Subject updated"
            );
          })
          .catch((response) => {
            this.toast(
              "b-toaster-top-center",
              "danger",
              "Error",
              "Error executing action."
            );
          });
      }
    },
    resetModal() {
      this.item = {
        subject_name: "",
        // teacher_id: null,
        status: "",
        time_in: "",
        time_out: "",
      };
      this.subject_name_state = null;
      // this.teacher_id_state = null;
      this.status_state = null;
      this.time_in_state = null;
      this.time_out_state = null;
      this.view = false;
      this.editing = false;
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
