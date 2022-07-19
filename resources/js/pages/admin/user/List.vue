<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex justify-content-end mb-3">
                    <router-link class="btn btn-success" :to="{ name: 'admin.user.create' }">Create User</router-link>
                </div>
                <div class="card">
                    <div class="card-header">
                        List of users
                    </div>
                    <div class="card-body">
                        <table class="table table-striped caption-top">
                            <thead>
                                <tr>
                                    <td> <strong>#</strong> </td>
                                    <td> <strong>Name</strong> </td>
                                    <td> <strong>Email</strong> </td>
                                    <td> <strong>Position</strong> </td>
                                    <td> <strong>Actions</strong> </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(user, index) in users" :key="user.id">
                                    <td class="col-md-1">{{ index + 1 }}</td>  
                                    <td>{{ user.full_name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.position ? user.position.name : 'N/a' }}</td>
                                    <td class="col-md-2">
                                        <router-link 
                                            class="btn btn-primary btn-sm" 
                                            :to="{ name: 'admin.user.single', params: {id: user.id} }"
                                        > View </router-link>
                                        <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError, AlertQuestion } from '~/config/alerts'

export default {
    name: 'admin-user-users',
    middleware: 'admin',
    computed: mapGetters({
        users: 'users/users'
    }),

    methods: {
        deleteUser(id) {

            AlertQuestion('Are you sure?', 'You won\'t be able to revert this!', true, 'Yes, delete it!')
                .then((result) => {
                    if (result.isConfirmed) {
                        this.remove(id)
                }
            })
        },
        remove(id) {
            this.$store.dispatch('users/removeUser', { id })
                .then((result) => {
                    if(result.data.success){
                        this.$store.dispatch('users/fetchUsers')

                        ToastSuccess('Deleted!', result.data.message)
                    }else{
                        ToastError('Error!', result.data.message)
                    }
                }).catch((error) => {
                    console.log(error)
                })
        }
    }
}

</script>