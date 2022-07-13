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
                                        <button @click="remove(user.id)" class="btn btn-danger btn-sm">Remove</button>
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
import Swal from 'sweetalert2'

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

export default {
    name: 'admin-user-users',
    middleware: 'admin',
    computed: mapGetters({
        users: 'users/users'
    }),

    methods: {
        remove(id) {
            this.$store.dispatch('users/removeUser', { id })
                .then((result) => {
                    if(result.data.success){
                        this.$store.dispatch('users/fetchUsers')

                        Toast.fire({
                            icon: 'success',
                            title: "Success!",
                            text: result.data.message
                        })
                    }else{

                        Toast.fire({
                            icon: 'error',
                            title: "Oops!",
                            text: "There's something wrong, please try again."
                        })
                    }
                }).catch((error) => {
                    console.log(error)
                })
        }
    }
}

</script>