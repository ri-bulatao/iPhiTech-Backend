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
                                <router-link :to="{ name: [routeNames.attendance_edit], params: { id: attendance.id } }" class="btn btn-sm btn-warning">Edit</router-link>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger" @click="() => prepareRemove(attendance.id)">Delete</a>
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
import * as routeNames from '~/config/route-names'
import { ToastSuccess, ToastError, AlertQuestion } from '~/config/alerts'

export default {
    name: 'attendance-employee',

    data: () => ({
        routeNames
    }),

    computed: mapGetters({
        attendances: 'attendances/attendances'
    }),

    methods: {
        prepareRemove(id) {
            AlertQuestion('Are you sure?', 'There is no going back once deleted', true, 'Yes, Delete it!')
                .then(res => {
                    this.removeAttendance(id)
                })
        },

        removeAttendance(id) {
            let payload = {
                id: id
            }
            this.$store.dispatch('attendances/deleteAttendance', payload)
                .then(res => {
                    payload = {
                        user_id: this.$route.params.id
                    }
                    ToastSuccess('Attendance Deleted')
                    this.$store.dispatch('attendances/fetchEmployeeAttendances', payload)
                })
                .catch(err => ToastError())
        }
    },

    mounted() {
        let payload = {
            user_id: this.$route.params.id
        }
        this.$store.dispatch('attendances/fetchEmployeeAttendances', payload)
    }
}
</script>