<template>
    <div
        class="col-md-2 d-flex flex-column flex-shrink-0 p-3 bg-light"
        style="width: 280px"
    >
        <router-link
            to="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none"
        >
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            <span class="fs-4">FRA WebApp</span>
        </router-link>
        <hr />
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <router-link  class="nav-link link-dark" to="/">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#home"></use>
                    </svg>
                    Home
                </router-link>
            </li>
            <li>
                <router-link class="nav-link link-dark" to="/attendance">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Attendance
                </router-link>
            </li>
            <li>
                <router-link class="nav-link link-dark" to="/teachers">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Teachers
                </router-link>
            </li>
            <li>
                <router-link class="nav-link link-dark" to="/students">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Students
                </router-link>
            </li>
            <li>
                <router-link class="nav-link link-dark" to="/subjects">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#speedometer2"></use>
                    </svg>
                    Subjects
                </router-link>
            </li>
        </ul>
    </div>
</template>
<script>
export default {};
</script>
<style scoped>
.nav .active {
    color: #fff;
    background-color: #0d6efd;
}
</style>
