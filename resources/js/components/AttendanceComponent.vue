<template>
    <div class="pr-3">
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
                @row-clicked="onRowClicked"
            ></b-table>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.");
    },
};
</script>
