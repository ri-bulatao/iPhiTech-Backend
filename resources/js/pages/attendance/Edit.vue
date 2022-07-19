<template>
    <div class="container-fluid">
        <!-- Header-->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto border-bottom mb-3">
                <h1>Attendance</h1>
                <small>Attendance</small>
            </div>
        </div>

        <!-- Contents -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto border-bottom mb-3">
                <div class="user-info">
                    <p>First Name</p>
                    <p>Last Name</p>
                    <p>Position</p>
                </div>
                <form @submit.prevent="update">
                    <div class="form-group my-2">
                        <label for="date" class="control-label">Date</label>
                        <input v-model="form.date" type="date" class="form-control" placeholder="Date" name="date" />
                    </div>
                    <div class="form-group my-2">
                        <label for="time_in" class="control-label">Time In</label>
                        <input v-model="form.time_in" type="time" class="form-control" placeholder="Time in" name="time_in" />
                    </div>
                    <div class="form-group my-2">
                        <label for="time_out" class="control-label">Time Out</label>
                        <input v-model="form.time_out" type="time" name="time_out" placeholder="Time out" class="form-control">
                    </div>
                    <div class="form-group py-2">
                        <a href="javascript:void(0)" class="btn btn-primary" @click="update">Update</a>
                        <a href="javascript:void(0)" class="btn btn-secondary" @click="$router.back()">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import { ToastError, ToastSuccess } from '~/config/alerts'
export default {
    name: 'attendance-edit',

    data: () => ({
        form: new Form({
            date: null,
            time_in: null,
            time_out: null
        })
    }),

    computed: mapGetters({
        attendance: 'attendances/attendance'
    }),

    methods: {
        back() {
            this.$router.back()
        },

        update() {
            let payload = {
                id: this.$route.params.id,
                date: this.form.date,
                time_in: this.form.time_in,
                time_out: this.form.time_out
            }

            this.$store.dispatch('attendances/updateAttendance', payload)
                .then(res => ToastSuccess(res.message))
                .catch(err => ToastError())
        }
    },

    mounted() {
        let payload = {
            id: this.$route.params.id
        }

        this.$store.dispatch('attendances/fetchAttendance', payload)
            .then(res => {
                console.log(res)
                this.form.date =  this.attendance.date
                this.form.time_in = '0' + this.attendance.time_in
                this.form.time_out = this.attendance.time_out
            })
    }
}
</script>