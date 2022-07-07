<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Position Detail
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                            <!-- Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('name') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                                    <has-error :form="form" field="name" />
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <router-link :to="{ name: 'admin.positions.list' }">
                                <v-button type="secondary">
                                    Back to List
                                </v-button>
                            </router-link>
                            <v-button :loading="form.busy" type="primary">
                                Update
                            </v-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Form from 'vform'
import Swal from 'sweetalert2'
import { mapGetters } from 'vuex'

export default {
    data: () => ({
        form: new Form({
            name: ''
        })
    }),

    computed: mapGetters({
        position: 'positions/position'
    }),
    
    created(){
        this.$store.dispatch('positions/fetchSinglePosition', { id: this.$route.params.id })
        .then(()=>{
            this.form.keys().forEach(key => {
                this.form[key] = this.position[key]
            })
        });
    },

    methods: {
        async update () {
            this.$store.dispatch('positions/updatePosition', { id: this.$route.params.id, form: this.form })
            .then((result) => {
                console.log(result)
                if(result.data.success){
                    this.form.reset()
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
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: error.response.data.errors.name[0]
                })
            })
        }
    }
}

</script>