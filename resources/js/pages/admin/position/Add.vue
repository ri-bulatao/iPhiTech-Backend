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
                            <v-button :loading="form.busy">
                                Submit
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

  methods: {
    async save () {
        const { data } = await this.form.post(route('user.add.position'))
        console.log(data)
        if(data.success){
            this.$store.dispatch('positions/savePosition', { position: data })
            this.$router.push({ name: 'admin.positions' })
        }
        
    }
  }
}
</script>