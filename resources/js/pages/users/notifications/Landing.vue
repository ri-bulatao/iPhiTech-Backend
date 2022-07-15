<template>
    <div class="container-fluid row">
        <div class="col-lg-7 m-auto">
            <div class="pb-3 mb-3 border-bottom">
                <h1>Notifications</h1>
            </div>
            <div class="row">
                <div class="col-sm-12 m-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>View</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="notification in notifications">
                                <td>{{ notification.id }}</td>
                                <td>{{ notification.title }}</td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" @click="() => viewNotification(notification)">View</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary" @click="() => updateReadStatus(notification)" v-if="notification.read">Mark as Unread</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary" @click="() => updateReadStatus(notification)" v-else>Mark as Read</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" @click="() => deleteReady(notification)">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'
import Swal from 'sweetalert2'
import { ToastSuccess, ToastError, AlertQuestion } from '~/config/alerts'

export default {
    name: 'notifications',

    middleware: 'auth',

    computed: mapGetters({
        notifications: 'notifications/notifications'
    }),

    methods: {
        viewNotification(notification) {
            let url = notification.url
            let payload = {
                id: notification.id,
                title: notification.title,
                url: url,
                read: true
            }

            this.$store.dispatch('notifications/updateNotification', payload)
                .then(res => {
                    this.$router.push(url)
                })
                .catch(err => {
                    ToastError()
                })

        },

        updateReadStatus(notification) {
            let payload = {
                id: notification.id,
                title: notification.title,
                read: !notification.read,
                url: notification.url
            }
            this.$store.dispatch('notifications/updateNotification', payload)
                .then(res => {
                    ToastSuccess('Success', res.message)
                    this.$store.dispatch('notifications/fetchNotifications')
                })
                .catch(err => TaostError())
        },

        deleteReady(notification) {

            AlertQuestion('Are you sure to delete ?', 'There is no undo for this action', true, 'Yes, Delete!')
                .then(result => {
                    if(result.isConfirmed) {
                        this.deleteNotification(notification)
                    }
                })
        },

        deleteNotification(notification) {
            this.$store.dispatch('notifications/deleteNotification', notification.id)
                .then(res => {
                    ToastSuccess('Success', res.message)
                    this.$store.dispatch('notifications/fetchNotifications')
                })
                .catch(err => {
                    ToastError()
                })
        }
    },

    mounted() {
        this.$store.dispatch('notifications/fetchNotifications')
            .catch(err => ToastError())
    }
}

</script>