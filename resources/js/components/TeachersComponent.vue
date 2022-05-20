<template>
    <div class="container">
        <h2 class="text-normal mt-3 mb-3">Teachers</h2>
        <hr />
        <b-button class="mt-3" variant="outline-primary" v-b-modal.modal_add
            ><b-icon icon="plus-circle-fill"></b-icon> Add Teacher</b-button
        >
        <div class="row justify-content-center mt-4">
            <b-table hover :items="items"></b-table>
        </div>

        <!-- Add Modal -->
        <b-modal
            id="modal_add"
            ref="modal"
            title="Add Teacher"
            size="lg"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" method="POST" @submit.stop.prevent="handleSubmit">
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
            </form>
        </b-modal>

        <!-- Toast -->
        <b-toast id="my-toast" variant="warning" solid>
            <template #toast-title>
                <div class="d-flex flex-grow-1 align-items-baseline">
                    <b-img
                        blank
                        blank-color="#ff5555"
                        class="mr-2"
                        width="12"
                        height="12"
                    ></b-img>
                    <strong class="mr-auto">Notice!</strong>
                    <small class="text-muted mr-2">42 seconds ago</small>
                </div>
            </template>
            This is the content of the toast. It is short and to the point.
        </b-toast>
    </div>
</template>

<script>
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
                    key: "age",
                    label: "Person age",
                    sortable: true,
                    // Variant applies to the whole column, including the header and footer
                    variant: "danger",
                },
            ],
            items: [],
        };
    },
    created() {
    },
    mounted() {
        console.log("Component mounted.");
        this.load_item();
    },
    methods: {
        load_item() {
            axios.get("getTeachers").then((response) => {
                console.log("wew",response);
                this.items = response.data;
            });
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

            axios
                .post("addTeacher", this.item)
                .then((response) => {
                    console.log(response);
                    // Hide the modal manually
                    this.items = response.data;
                    this.$nextTick(() => {
                        this.$bvModal.hide("modal_add");
                    });
                    this.toast(
                        "b-toaster-top-center",
                        "success",
                        "Successful",
                        "Teacher added"
                    );
                })
                .catch((response) => {
                    console.log(response);
                    this.toast(
                        "b-toaster-top-center",
                        "danger",
                        "Error",
                        response.body.error
                    );
                });
        },
        toast(toaster, variant = null, title, body) {
            this.counter++;
            this.$bvToast.toast(body, {
                title,
                toaster: toaster,
                solid: true,
                variant: variant,
                appendToast: false,
            });
        },
    },
};
</script>
