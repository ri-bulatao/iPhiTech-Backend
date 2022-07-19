<template>
    <div class="row">
        <div class="m-auto border-bottom">
            <small>Attendance List</small>
        </div>
        
        <div>
            <div class="d-flex m-auto justify-content-center py-3">
                <table class="table table-striped" v-if="!user.is_admin">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Date</td>
                            <td>Time In</td>
                            <td>Time Out</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="attendance in attendances">
                            <td>{{ attendance.id }}</td>
                            <td>{{ attendance.date }}</td>
                            <td>{{ attendance.time_in }}</td>
                            <td>{{ attendance.time_out }}</td>
                            <td>{{ attendance.status }}</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-striped" v-else>
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>First Name</td>
                            <td>Last Name</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="attendance in attendances">
                            <td>{{ attendance.id }}</td>
                            <td>{{ attendance.first_name }}</td>
                            <td>{{ attendance.last_name }}</td>
                            <td>
                                <router-link :to="{ name: [routeNames.attendance_employee], params: { id: attendance.id } }" class="btn btn-sm btn-primary">View</router-link>
                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-danger">Clear</a> -->
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
export default {
    name: 'attendance-list',
    
    data: () => ({
        routeNames
    }),

    computed: mapGetters({
        user: 'auth/user',
        attendances: 'attendances/attendances'
    }),

    mounted() {
        let payload = {
            user_id: this.user.id
        }
        
        this.$store.dispatch('attendances/fetchAttendances', payload)

        this.$store.dispatch('attendances/fetchAttendanceToday', payload)
            .then(res => {
                this.timeinPretty = res.time_in_pretty
                this.timeoutPretty = res.time_out_pretty

                if( res.time_in !== null ) this.isTimein = true

                if( res.time_out !== null ) this.isTimeout = true;

            })
    }
}
</script>