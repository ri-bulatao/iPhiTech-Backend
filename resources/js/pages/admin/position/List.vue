<template>
    <div>
        <div class="row">
            <div class="col-sm-12 mt-4">
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
                                        <router-link :to="{ name: 'admin.positions.single' }">
                                            <v-button type="primary" class="btn btn-primary btn-sm">
                                                View
                                            </v-button>
                                        </router-link>
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: result.data.message
                        })
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
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