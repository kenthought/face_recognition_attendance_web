<template>
  <div class="p-5">
    <h2 class="text-normal mt-3 mb-3">Students</h2>
    <hr />
    <b-button class="mt-3" variant="outline-primary" v-b-modal.modal_add
      ><b-icon icon="plus-circle-fill"></b-icon> Add Student</b-button
    >
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
        @row-clicked="onRowClicked"
      ></b-table>
    </div>
    <!-- Add Modal -->
    <b-modal
      id="modal_add"
      ref="modal_add"
      size="lg"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <div slot="modal-header">
        <div v-if="view == false">
          <h5 class="modal-title">Add Student</h5>
        </div>
        <div v-else>
          <div class="row">
            <div class="col-xl-10">
              <h5 class="modal-title">Student Details</h5>
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
            :disabled="editing != true ? (view == true ? true : false) : false"
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
            :disabled="editing != true ? (view == true ? true : false) : false"
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
            :disabled="editing != true ? (view == true ? true : false) : false"
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
            :disabled="editing != true ? (view == true ? true : false) : false"
          ></b-form-input>
        </b-form-group>
        <b-form-group
          class="mb-2"
          label="Course"
          label-for="course"
          invalid-feedback="Course is required"
          :state="course_state"
        >
          <b-form-input
            id="course"
            v-model="item.course"
            :state="course_state"
            required
            :disabled="editing != true ? (view == true ? true : false) : false"
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
            :disabled="editing != true ? (view == true ? true : false) : false"
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
            :disabled="editing != true ? (view == true ? true : false) : false"
          ></b-form-textarea>
        </b-form-group>
      </form>
      <div slot="modal-footer" v-if="view == true">
        <b-button
          v-if="editing == true"
          size="sm"
          variant="success"
          @click="handleSubmit"
          >Update</b-button
        >
        <b-button
          size="sm"
          variant="danger"
          @click="$bvModal.show('modal_confirm')"
          >Delete</b-button
        >
        <b-button size="sm" @click="$bvModal.hide('modal_add')">Close</b-button>
      </div>
    </b-modal>

    <b-modal id="modal_confirm" title="Delete Teacher" @ok="deleteRecord">
      Confirm Delete?
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

export default {
  data() {
    return {
      item: {
        first_name: "",
        last_name: "",
        middle_name: "",
        birthday: "",
        course: "",
        contact_no: "",
        address: "",
      },
      first_name_state: null,
      last_name_state: null,
      middle_name_state: null,
      birthday_state: null,
      course_state: null,
      contact_state: null,
      address_state: null,
      fields: [
        {
          key: "last_name",
          sortable: true,
        },
        {
          key: "first_name",
          sortable: false,
        },
        {
          key: "middle_name",
          sortable: false,
        },
        {
          key: "birthday",
          sortable: false,
        },
        {
          key: "course",
          sortable: false,
        },
        {
          key: "contact_no",
          sortable: false,
        },
        {
          key: "address",
          sortable: false,
        },
      ],
      items: [],
      view: false,
      editing: false,
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.load_item();
    console.log(this.editing);
  },
  methods: {
    load_item() {
      const db = getDatabase();
      const students = ref(db, "students");
      onValue(students, (snapshot) => {
        this.items = [];
        const data = snapshot.val();
        var result = Object.keys(data).map((key) => {
          this.items.push(data[key]);
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
      this.middle_name_state = true;
      if (this.item.first_name != "") this.first_name_state = true;
      else this.first_name_state = false;
      if (this.item.last_name != "") this.last_name_state = true;
      else this.last_name_state = false;
      if (this.item.birthday != "") this.birthday_state = true;
      else this.birthday_state = false;
      if (this.item.course != "") this.course_state = true;
      else this.course_state = false;
      if (this.item.contact_no != "") this.contact_state = true;
      else this.contact_state = false;
      if (this.item.address != "") this.address_state = true;
      else this.address_state = false;

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
        const studentKey = push(child(ref(db), "students")).key;
        set(ref(db, "students/" + studentKey), {
          id: studentKey,
          first_name: this.item.first_name,
          last_name: this.item.last_name,
          middle_name: this.item.middle_name,
          birthday: this.item.birthday,
          course: this.item.course,
          contact_no: this.item.contact_no,
          address: this.item.address,
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
              "Student added"
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
        updates["/students/" + this.item.id] = this.item;

        update(ref(db), updates)
          .then((response) => {
            this.$nextTick(() => {
              this.$bvModal.hide("modal_add");
            });
            this.toast(
              "b-toaster-top-center",
              "success",
              "Successful",
              "Student updated"
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
    deleteRecord() {
      const db = getDatabase();
      remove(ref(db, "/students/" + this.item.id))
        .then((response) => {
          this.$nextTick(() => {
            this.$bvModal.hide("modal_add");
          });
          this.toast(
            "b-toaster-top-center",
            "success",
            "Successful",
            "Students deleted"
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
    },
    resetModal() {
      this.item = {
        first_name: "",
        last_name: "",
        middle_name: "",
        birthday: "",
        course: "",
        contact_no: "",
        address: "",
      };
      this.first_name_state = null;
      this.last_name_state = null;
      this.middle_name_state = null;
      this.birthday_state = null;
      this.course_state = null;
      this.contact_state = null;
      this.address_state = null;
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
