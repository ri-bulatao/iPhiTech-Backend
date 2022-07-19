<template>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto border-bottom mb-3">
                <h1>Attendance</h1>
                <small>Attendance</small>
            </div>
        </div>
        
        <!-- Contents -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto mb-3">
                <div class="d-flex m-auto justify-content-center py-3">
                    <a href="javascript:void(0)" @click="timein" class="btn btn-lg btn-success mx-3">{{ timeinPretty }}</a>
                    <a href="javascript:void(0)" @click="timeout" class="btn btn-lg btn-danger mx-3">{{ timeoutPretty }}</a>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 m-auto">
                <AttendanceList />
            </div>
        </div>
    </div>
</template>

<script>
import AttendanceList from './List.vue'
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError } from '~/config/alerts'

export default {
    name: 'attendance',

    components: {AttendanceList},

    data: () => ({
        timeinPretty: 'TIME IN',
        timeoutPretty: 'TIME OUT'
    }),

    computed: mapGetters({
        'user': 'auth/user',
        attendances: 'attendances/attendances',
        attendanceToday: 'attendances/attendanceToday'
    }),

    methods: {
        timein() {
            let payload = {
                user_id: this.user.id
            }
            this.$store.dispatch('attendances/timein', payload)
                .then(res => {
                    ToastSuccess(null, 'Timed In!')
                    this.$store.dispatch('attendances/fetchAttendances', payload)
                    this.$store.dispatch('attendances/fetchAttendanceToday', payload)
                        .then(res => {
                            if( res.time_in !== null ) this.timeinPretty = res.time_in_pretty
                            if( res.time_out !== null ) this.timeoutPretty = res.time_out_pretty
                        })
                })
                .catch(err => ToastError())
        },

        timeout() {
            let payload = {
                user_id: this.user.id
            }

            this.$store.dispatch('attendances/timeout', payload)
                .then(res => {
                    ToastSuccess(null, 'Timed Out!')
                    this.$store.dispatch('attendances/fetchAttendances', payload)
                    this.$store.dispatch('attendances/fetchAttendanceToday', payload)
                        .then(res => {
                            if( res.time_in !== null ) this.timeinPretty = res.time_in_pretty
                            if( res.time_out !== null ) this.timeoutPretty = res.time_out_pretty
                        })
                })
                .catch(err => ToastError())
        }
    },

    mounted() {
        let payload = {
            user_id: this.user.id
        }
        
        this.$store.dispatch('attendances/fetchAttendances', payload)

        this.$store.dispatch('attendances/fetchAttendanceToday', payload)
            .then(res => {
                if( res.time_in !== null ) this.timeinPretty = res.time_in_pretty
                if( res.time_out !== null ) this.timeoutPretty = res.time_out_pretty
            })
    }
}
</script>