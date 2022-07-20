<template>
    <div class="row">
        <div class="col-sm-12 border-bottom mb-3">
            <h1>Leave Request</h1>
        </div>
        <div class="col-sm-12 border-bottom mb-3">
            <card :title="$t('Create Leave Application')">
                <form @submit.prevent="submitApplication">
                    <div class="form-group py-3">
                        <label for="filed" class="control-label">Date Filed</label>
                        <input v-model="form.filed" type="date" class="form-control" name="filed" />
                    </div>
                    <div class="form-group py-3">
                        <label for="employee" class="control-label">Employee</label>
                        <select v-model="form.user_id" name="employee" id="employee" class="form-control">
                            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.full_name }}</option>
                        </select>
                    </div>
                    <div class="form-group py-3">
                        <label for="leave_type" class="control-label">Type of leave request</label>
                        <select v-model="form.type" name="leave_type" id="leave_type" class="form-control">
                            <option value="sick">Sick Leave</option>
                            <option value="personal">Personal Leave (SIL)</option>
                            <option value="parental">Maternity/Parental Leave</option>
                            <option value="bereavement">Bereavement Leave</option>
                            <option value="unpaid">Unpaid Leave</option>
                            <option value="offset">Offset: (Please indicate Date/Time)</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="row py-3">
                        <div class="col-sm-12 col-lg-6">
                            <label for="offset_date" class="control-label">Offset Date</label>
                            <input v-model="form.offset_date" type="date" name="offset_date" class="form-control" />
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <label for="offset_time" class="control-label">Offset Time</label>
                            <input v-model="form.offset_time" type="time" name="offset_time" class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <label class="control-label">Date(s) of request</label>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group py-3">
                                <label for="leave_from" class="control-label">From</label>
                                <input v-model="form.from" type="date" name="leave_from" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group py-3">
                                <label for="leave_to" class="control-label">To</label>
                                <input v-model="form.to" type="date" name="leave_to" class="form-control" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group py-3">
                        <label for="status" class="control-label">Request Status</label>
                        <select v-model="form.status" name="status" id="status" class="form-control">
                            <option value="approved">APPROVED</option>
                            <option value="pending">PENDING</option>
                            <option value="declined">DECLINED</option>
                        </select>
                    </div>

                    <div class="form-group py-3">
                        <label for="reason" class="control-label">Reason</label>
                        <textarea v-model="form.reason" name="reason" id="reason" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="py-3">
                        <small>
                            <strong>IMPORTANT: </strong> This request is subject to approval of the Management. Please note that the Management has the sole discretion to either <strong>APPROVE</strong> or <strong>DECLINE</strong> any requests based on the current business needs to ensure that company's operation is not getting compromised
                        </small>
                    </div>

                    <div class="form-group py-3 d-flex justify-content-end">
                        <a @click="submitApplication" href="javascript:void(0)" class="btn btn-success">Submit</a>
                    </div>
                </form>
            </card>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError } from '~/config/alerts'
import * as routeNames from '~/config/route-names'

export default {
    name: 'leave-create',

    data: () => ({
        form: new Form({
            filed: '',
            user_id: '',
            type: '',
            from: '',
            to: '',
            status: 'pending',
            reason: '',
            offset_date: '',
            offset_time: ''
        })
    }),

    computed: mapGetters({
        users: 'users/users'
    }),

    methods: {
        submitApplication() {
            this.$store.dispatch('leave-applications/createLeaveApplication', this.form)
                .then(res => {
                    ToastSuccess(res.message)
                    this.$router.push({ name: [routeNames.leave_list] })
                })
                .cathc(err => ToastError())
        }
    },

    mounted() {
        this.$store.dispatch('users/fetchUsers')
    },

    metaInfo () {
        return { title: this.$t('Create Leave Application') }
    },
}
</script>