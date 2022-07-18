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
                    <a href="javascript:void(0)" @click="timein" class="btn btn-lg btn-success mx-3">{{ 'Time in: ' + timeinPretty }}</a>
                    <a href="javascript:void(0)" @click="timeout" class="btn btn-lg btn-danger mx-3">{{ 'Time out: ' + timeoutPretty }}</a>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 m-auto">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError } from '~/config/alerts'

export default {
    name: 'attendance',

    data: () => ({
        isTimein: false,
        isTimeout: false,
        timeinPretty: 'TIME IN',
        timeoutPretty: 'TIME OUT'
    }),

    computed: mapGetters({
        'user': 'auth/user',
        attendances: 'attendances/attendances',
        'attendanceToday': 'attendances/attendanceToday'
    }),

    methods: {
        timein() {
            let payload = {
                user_id: this.user.id
            }
            this.$store.dispatch('attendances/timein', payload)
                .then(res => ToastSuccess(null, 'Timed In!'))
                .catch(err => ToastError())
        },

        timeout() {
            let payload = {
                user_id: this.user.id
            }

            this.$store.dispatch('attendances/timeout', payload)
                .then(res => ToastSuccess(null, 'Timed Out!'))
                .catch(err => ToastError())
        }
    },

    mounted() {
        let payload = {
            user_id: this.user.id
        }
        
        this.$store.dispatch('attendances/fetchAttendances', payload)
            .then(res => console.log(res))

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