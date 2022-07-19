<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Add Position
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="save" @keydown="form.onKeydown($event)">
                            <!-- Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('name') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                                    <has-error :form="form" field="name" />
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <v-button :loading="form.busy" class="btn btn-primary btn-sm">
                                Submit
                            </v-button>

                            <router-link 
                                class="btn btn-secondary btn-sm" 
                                :to="{ name: 'admin.positions.list' }"
                            > Back to List </router-link>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import { ToastSuccess, ToastError } from '~/config/alerts'

export default {

    middleware: 'admin',

    data: () => ({
        form: new Form({
        name: ''
        })
    }),

    computed: mapGetters({
        position: 'positions/position'
    }),

    methods: {
        async save () {
            this.$store.dispatch('positions/savePosition', this.form)
            .then((result) => {
                console.log
                if(result.data.success){
                    this.form.reset()
                    this.$store.dispatch('positions/fetchPositions')
                    ToastSuccess('Success!', result.data.message)
                    this.$router.push({ name: 'admin.positions.list' })
                }else{
                    ToastError('Oops!', 'There\'s something wrong, please try again.')
                }
            }).catch((error) => {
                if(error.response){
                    ToastError('Oops!', error.response.data.errors.name[0])
                }
            })
        }
    }
}
</script>