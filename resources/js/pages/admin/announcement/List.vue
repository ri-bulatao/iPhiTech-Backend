<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex justify-content-end">
                    <router-link class="btn btn-success" :to="{ name: 'admin.announcements.create' }">Create Announcement</router-link>
                </div>
                <table class="table table-striped caption-top">
                    <caption>List of Announcements</caption>
                    <thead>
                        <tr>
                            <td> <strong><a href="javascript:void(0)" @click="() => handleSort('id')">ID</a></strong> </td>
                            <td> <strong> <a href="javascript:void(0)" @click="() => handleSort('title')">Announcement Title</a> </strong> </td>
                            <td><strong><a href="javascript:void(0)" @click="() => handleSort('excerpt')">Excerpt</a></strong></td>
                            <td><strong><a href="javascript:void(0)" @click="() => handleSort('status')">Status</a></strong></td>
                            <td> <strong>Actions</strong> </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="announcement in announcements" :key="announcement.id">
                            <td>{{ announcement.id }}</td>  
                            <td>{{ announcement.title }}</td>
                            <td>{{ announcement.excerpt }}</td>
                            <td>{{ announcement.status }}</td>
                            <td>
                                <router-link :to="{ name: 'admin.announcements.single', params: { id: announcement.id } }" class="btn btn-primary btn-sm">View</router-link>
                                <router-link :to="{ name: 'admin.announcements.edit', params: { id: announcement.id } }" class="btn btn-warning btn-sm">Edit</router-link>
                                <a @click="() => deleteReady(announcement.id)" href="javascript:void(0)" class="btn btn-danger btn-sm">Delete</a>
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
import { ToastSuccess, ToastError, AlertQuestion } from '~/config/alerts'

export default {

    data: () => ({
        sortBy: 'title',
        sortOrder: 'asc'
    }),

    computed: mapGetters({
        announcements: 'announcements/announcements'
    }),

    methods: {
        handleSort(handle) {
            this.sortBy = handle
            this.sortOrder = this.sortOrder == 'asc' ? 'desc' : 'asc'
            
            let payload = {
                sortBy: this.sortBy,
                sortOrder: this.sortOrder
            }

            this.$store.dispatch('announcements/fetchAnnouncements', payload)
                .catch(err => ToastError())
        },

        deleteReady(id) {
            AlertQuestion('Are you sure to delete ?', 'There is no undo for this action', true, 'Yes, Delete!')
                .then(res => {
                    this.delete(id)
                })
        },

        delete(id) {
            this.$store.dispatch('announcements/deleteAnnouncement', id)
                .then(res => {
                    ToastSuccess('Deleted!', res.message)
                    this.$store.dispatch('announcements/fetchAnnouncements')
                })
                .catch(err => {
                    ToastError()
                })
        }
    },

    mounted() {
        let payload = {
            sortBy: this.sortBy,
            sortOrder: this.sortOrder
        }
        this.$store.dispatch('announcements/fetchAnnouncements', payload)
            .catch(err => {
                ToastError()
            })
    }
}
</script>