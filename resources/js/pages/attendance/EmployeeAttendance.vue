<template>

    <div class="container-fluid">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto border-bottom mb-3">
                <h1>Attendance</h1>
                <small>Attendance</small>
            </div>
        </div>
        <!-- Content -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 d-flex m-auto justify-content-center py-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Date</td>
                            <td>Time In</td>
                            <td>Time Out</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="attendance in attendances" :key="attendance.id">
                            <td>{{ attendance.id }}</td>
                            <td>{{ attendance.date }}</td>
                            <td>{{ attendance.time_in }}</td>
                            <td>{{ attendance.time_out }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-warning">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    name: 'attendance-employee',

    computed: mapGetters({
        attendances: 'attendances/attendances'
    }),

    mounted() {
        let payload = {
            user_id: this.$route.params.id
        }
        this.$store.dispatch('attendances/fetchEmployeeAttendances', payload)
            .then(res => console.log(res))
            .catch(err => console.log(err))
    }
}
</script>