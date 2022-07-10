<template>
  <card :title="$t('your_info')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')" />
      <div class="mb-3 row">
        <h3 class="col-md-12 col-form-label text-md-center">General Information</h3>
      </div>
      
      <!-- First Name -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('first_name') }}</label>
        <div class="col-md-7">
          <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
          <has-error :form="form" field="first_name" />
        </div>
      </div>

      <!-- Middle Name -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('middle_name') }}</label>
        <div class="col-md-7">
          <input v-model="form.middle_name" :class="{ 'is-invalid': form.errors.has('middle_name') }" class="form-control" type="text" name="middle_name">
          <has-error :form="form" field="middle_name" />
        </div>
      </div>

      <!-- Last Name -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('last_name') }}</label>
        <div class="col-md-7">
          <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" name="last_name">
          <has-error :form="form" field="last_name" />
        </div>
      </div>

      <!-- Phone Number -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('phone_number') }}</label>
        <div class="col-md-7">
          <input v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }" class="form-control" type="text" name="phone_number">
          <has-error :form="form" field="phone_number" />
        </div>
      </div>

      <!-- Email -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('email') }}</label>
        <div class="col-md-7">
          <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
          <has-error :form="form" field="email" />
        </div>
      </div>

      <!-- Gender -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('gender') }}</label>
        <div class="col-md-7">
          <input v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" class="form-control" type="text" name="gender">
          <has-error :form="form" field="gender" />
        </div>
      </div>

      <!-- Marital Status -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('marital_status') }}</label>
        <div class="col-md-7">
          <input v-model="form.marital_status" :class="{ 'is-invalid': form.errors.has('marital_status') }" class="form-control" type="text" name="marital_status">
          <has-error :form="form" field="marital_status" />
        </div>
      </div>

      <!-- Date of birth -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('date_of_birth') }}</label>
        <div class="col-md-7">
          <input v-model="form.date_of_birth" :class="{ 'is-invalid': form.errors.has('date_of_birth') }" class="form-control" type="text" name="date_of_birth">
          <has-error :form="form" field="date_of_birth" />
        </div>
      </div>
      
      <div class="mb-3 row">
        <hr>
        <h3 class="col-md-12 col-form-label text-md-center">Emergency Contact</h3>
      </div>

      <!-- Emergency Contact Full Name -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('full_name') }}</label>
        <div class="col-md-7">
          <input v-model="form.ec_full_name" :class="{ 'is-invalid': form.errors.has('ec_full_name') }" class="form-control" type="text" name="ec_full_name">
          <has-error :form="form" field="ec_full_name" />
        </div>
      </div>

      <!-- Emergency Contact  Relationship -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('ec_relationship') }}</label>
        <div class="col-md-7">
          <input v-model="form.ec_relationship" :class="{ 'is-invalid': form.errors.has('ec_relationship') }" class="form-control" type="text" name="ec_relationship">
          <has-error :form="form" field="ec_relationship" />
        </div>
      </div>

      <!-- Emergency Contact Phone Number -->
      <div class="mb-3 row">
        <label class="col-md-3 col-form-label text-md-end">{{ $t('phone_number') }}</label>
        <div class="col-md-7">
          <input v-model="form.ec_phone_number" :class="{ 'is-invalid': form.errors.has('ec_phone_number') }" class="form-control" type="text" name="ec_phone_number">
          <has-error :form="form" field="ec_phone_number" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mb-3 row">
        <div class="col-md-9 ms-md-auto">
          <v-button :loading="form.busy" type="success">
            {{ $t('update') }}
          </v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      first_name: '',
      middle_name: '',
      last_name: '',
      phone_number: '',
      email: '',
      gender: '',
      marital_status: '',
      date_of_birth: '',
      ec_full_name: '',
      ec_relationship: '',
      ec_phone_number: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })

    const emergency_contact = JSON.parse(this.user.emergency_contact);
    this.form['ec_full_name'] = emergency_contact.full_name;
    this.form['ec_relationship'] = emergency_contact.relationship;
    this.form['ec_phone_number'] = emergency_contact.phone_number;
  },

  methods: {
    async update () {
      const { data } = await this.form.patch(route('settings.update.profile'))

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>
