<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex justify-content-end mb-3">
                    <router-link class="btn btn-success" :to="{ name: 'admin.positions.create' }">Create Position</router-link>
                </div>
                <div class="card">
                    <div class="card-header">
                        List of positions
                    </div>
                    <div class="card-body">
                        <table class="table table-striped caption-top">
                            <thead>
                                <tr>
                                    <td> <strong>#</strong> </td>
                                    <td> <strong>Position</strong> </td>
                                    <td> <strong>Actions</strong> </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(position, index) in positions" :key="position.id">
                                    <td class="col-md-1">{{ index + 1 }}</td>  
                                    <td>{{ position.name }}</td>
                                    <td class="col-md-2">
                                        <router-link 
                                            class="btn btn-primary btn-sm" 
                                            :to="{ name: 'admin.positions.single', params: {id: position.id} }"
                                        > View </router-link>
                                        <button @click="remove(position.id)" class="btn btn-danger btn-sm">Remove</button>
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
    name: 'admin-user-positions',

    computed: mapGetters({
        positions: 'positions/positions'
    }),

    methods: {
        remove(id) {
            this.$store.dispatch('positions/removePosition', { id })
                .then((result) => {
                    if(result.data.success){
                        this.$store.dispatch('positions/fetchPositions')
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