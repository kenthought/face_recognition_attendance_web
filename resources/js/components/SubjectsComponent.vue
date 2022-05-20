<template>
    <div class="container pb-4">
        <h2 class="text-normal mt-3 mb-3">Subjects</h2>
        <hr />
        <b-button class="mt-3" variant="outline-primary" v-b-modal.modal_add
            ><b-icon icon="plus-circle-fill"></b-icon> Add Subject</b-button
        >
        <div class="row justify-content-center mt-4">
            <b-table hover :items="items"></b-table>
        </div>

        <!-- Add Modal -->
        <b-modal
            id="modal_add"
            ref="modal"
            title="Add Subject"
            @show="resetModal"
            @hidden="resetModal"
            @ok="handleOk"
        >
            <form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-group
                    label="Subject Name"
                    label-for="subjectName-input"
                    invalid-feedback="Subject name is required"
                    :state="nameState"
                >
                    <b-form-input
                        id="subjectName-input"
                        v-model="name"
                        :state="nameState"
                        required
                    ></b-form-input>
                </b-form-group>
            </form>
        </b-modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: [
                { age: 40, first_name: "Dickerson", last_name: "Macdonald" },
                { age: 21, first_name: "Larsen", last_name: "Shaw" },
                { age: 89, first_name: "Geneva", last_name: "Wilson" },
                { age: 38, first_name: "Jami", last_name: "Carney" },
            ],
        };
    },
    mounted() {
        console.log("Component mounted.");
    },
};
</script>
