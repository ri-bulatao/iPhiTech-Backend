<template>
    <div class="row">
        <div class="col-sm-12 border-bottom mb-3">
            <h1>Leave Request</h1>
        </div>
        <div class="col-sm-12 border-bottom mb-3">
            <card :title="$t('Leave Application List')">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Employee</td>
                            <td>From</td>
                            <td>To</td>
                            <td>Status</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="application in applications" :key="application.id">
                            <td>{{ application.id }}</td>
                            <td>{{ application.user.full_name }}</td>
                            <td>{{ application.from }}</td>
                            <td>{{ application.to }}</td>
                            <td>{{ application.status }}</td>
                            <td>
                                <a @click="() => updateApplication(application, 'approved')" href="javascript:void(0)" class="btn btn-sm btn-success">Approve</a>
                                <a @click="() => updateApplication(application, 'declined')" href="javascript:void(0)" class="btn btn-sm btn-secondary">Decline</a>
                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info">View</a> -->
                                <router-link :to="{ name: [routeNames.leave_edit], params: { id: application.id } }" class="btn btn-sm btn-warning">Edit</router-link>
                                <a @click="() => prepareDelete(application)" href="javascript:void(0)" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        <tr class="no-data">
                            <td colspan="6" class="text-center">No data available in table</td>
                        </tr>
                    </tbody>
                </table>
            </card>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import * as routeNames from '~/config/route-names'
import { ToastSuccess, ToastError, AlertQuestion } from '~/config/alerts'

export default {
    name: 'leave-list',

    data: () => ({
        routeNames
    }),

    computed: mapGetters({
        applications: 'leave-applications/leave_applications'
    }),

    methods: {
        updateApplication(application, status) {
            application.status = status

            this.$store.dispatch('leave-applications/updateLeaveApplication', application)
                .then(res => {
                    ToastSuccess(res.message)
                    this.$store.dispatch('leave-applications/fetchLeaveApplications')
                })
                .catch(err => ToastError())
        },

        prepareDelete(application) {
            AlertQuestion('Are you sure?', 'There is no undo for this action', true, 'Yes, Delete it')
                .then(res => {
                    this.deleteApplication(application)
                })
        },

        deleteApplication(application) {
            this.$store.dispatch('leave-applications/deleteLeaveApplication', application)
                .then(res => {
                    ToastSuccess(res.message)
                    this.$store.dispatch('leave-applications/fetchLeaveApplications')
                })
                .catch(err => ToastError())
        }
    },

    mounted() {
        this.$store.dispatch('leave-applications/fetchLeaveApplications')
    },

    metaInfo () {
        return { title: this.$t('Leave Application List') }
    },
}
</script>