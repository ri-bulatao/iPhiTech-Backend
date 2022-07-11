<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        User Detail
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
                            <!-- First Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('first_name') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                                    <has-error :form="form" field="first_name" />
                                </div>
                            </div>

                            <!-- Middle Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('middle_name') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.middle_name" :class="{ 'is-invalid': form.errors.has('middle_name') }" class="form-control" type="text" name="middle_name">
                                    <has-error :form="form" field="middle_name" />
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('last_name') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" name="last_name">
                                    <has-error :form="form" field="last_name" />
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('phone_number') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }" class="form-control" type="text" name="phone_number">
                                    <has-error :form="form" field="phone_number" />
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('email') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                                    <has-error :form="form" field="email" />
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('gender') }}</label>
                                <div class="col-md-12">
                                    <select v-model="form.gender" name="gender" id="gender" class="form-control">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Marital Status -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('marital_status') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.marital_status" :class="{ 'is-invalid': form.errors.has('marital_status') }" class="form-control" type="text" name="marital_status">
                                    <has-error :form="form" field="marital_status" />
                                </div>
                            </div>

                            <!-- Date of birth -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('date_of_birth') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.date_of_birth" :class="{ 'is-invalid': form.errors.has('date_of_birth') }" class="form-control" type="date" name="date_of_birth">
                                    <has-error :form="form" field="date_of_birth" />
                                </div>
                            </div>

                            <!-- Street Address -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('street_address') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.street_address" :class="{ 'is-invalid': form.errors.has('street_address') }" class="form-control" type="text" name="street_address">
                                    <has-error :form="form" field="street_address" />
                                </div>
                            </div>

                            <!-- Additional Address -->
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label class="col-md-12">{{ $t('country') }}</label>
                                        <div class="col-md-12">
                                            <select v-model="form.country" name="country" id="country" class="form-control" v-on:change="countryChange">
                                                <option :value="country.isoCode" v-for="(country, index) in countries" :key="index">{{ country.name }}</option>
                                            </select>
                                            <has-error :form="form" field="country" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label class="col-md-12">{{ $t('state') }}</label>
                                        <div class="col-md-12">
                                            <select v-model="form.state" name="state" id="state" class="form-control" v-on:change="stateChange">
                                                <option :value="state.isoCode" v-for="(state, index) in states" :key="index">{{ state.name }}</option>
                                            </select>
                                            <has-error :form="form" field="state" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label class="col-md-12">{{ $t('city') }}</label>
                                        <div class="col-md-12">
                                            <select v-model="form.city" name="city" id="city" class="form-control">
                                                <option :value="city.name" v-for="(city, index) in cities" :key="index">{{ city.name }}</option>
                                            </select>
                                            <has-error :form="form" field="city" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 row">
                                        <label class="col-md-12">{{ $t('zip_code') }}</label>
                                        <div class="col-md-12">
                                            <input v-model="form.zip_code" :class="{ 'is-invalid': form.errors.has('zip_code') }" class="form-control" type="text" name="zip_code">
                                            <has-error :form="form" field="zip_code" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('position') }}</label>
                                <div class="col-md-12">
                                    <select v-model="form.position" name="position" id="position" class="form-control">
                                        <option :value="position.id" v-for="(position, index) in positions" :key="index">{{ position.name }}</option>
                                    </select>
                                    <has-error :form="form" field="position" />
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('new_password') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.new_password" :class="{ 'is-invalid': form.errors.has('new_password') }" :error="true ? 'That username is already taken' : null" class="form-control" type="password" name="new_password">
                                    <has-error :form="form" field="new_password" />
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('confirm_password') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.confirm_password" :class="{ 'is-invalid': form.errors.has('confirm_password') }" class="form-control" type="password" name="confirm_password">
                                    <has-error :form="form" field="confirm_password" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <hr>
                                <h3 class="col-md-12 col-form-label text-md-center">Emergency Contact</h3>
                            </div>

                            <!-- Emergency Contact Full Name -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('full_name') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.ec_full_name" :class="{ 'is-invalid': form.errors.has('ec_full_name') }" class="form-control" type="text" name="ec_full_name">
                                    <has-error :form="form" field="ec_full_name" />
                                </div>
                            </div>

                            <!-- Emergency Contact Relation -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('ec_relationship') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.ec_relationship" :class="{ 'is-invalid': form.errors.has('ec_relationship') }" class="form-control" type="text" name="ec_relationship">
                                    <has-error :form="form" field="ec_relationship" />
                                </div>
                            </div>

                            <!-- Emergency Contact Phone Number -->
                            <div class="mb-3 row">
                                <label class="col-md-12">{{ $t('phone_number') }}</label>
                                <div class="col-md-12">
                                    <input v-model="form.ec_phone_number" :class="{ 'is-invalid': form.errors.has('ec_phone_number') }" class="form-control" type="text" name="ec_phone_number">
                                    <has-error :form="form" field="ec_phone_number" />
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <v-button :loading="form.busy" class="btn btn-primary btn-sm">
                                Update
                            </v-button>
                            
                            <router-link 
                                class="btn btn-secondary btn-sm" 
                                :to="{ name: 'admin.users.list' }"
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
import Swal from 'sweetalert2'
import { mapGetters } from 'vuex'

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
            ec_phone_number: '',
            new_password: '',
            confirm_password: '',
            street_address: '',
            city: '',
            state: '',
            zip_code: '',
            country: '',
            position: ''
        }),
    }),

    computed: mapGetters({
        user: 'users/user',
        countries: 'users/countries',
        cities: 'users/cities',
        states: 'users/states',
        positions: 'positions/positions'
    }),
    
    created(){
        this.$store.dispatch('users/fetchSingleUser', { id: this.$route.params.id })
        .then(()=>{
            this.form.keys().forEach(key => {
                this.form[key] = this.user[key]
            })

            if(this.user.emergency_contact){
                const emergency_contact         = JSON.parse(this.user.emergency_contact);
                this.form['ec_full_name']       = emergency_contact.full_name;
                this.form['ec_relationship']    = emergency_contact.relationship;
                this.form['ec_phone_number']    = emergency_contact.phone_number;
            }

            if(this.user.user_address){
                let user_address            = this.user.user_address;
                this.form['street_address'] = user_address.street_address;
                this.form['city']           = user_address.city;
                this.form['state']          = user_address.state;
                this.form['zip_code']       = user_address.zip_code;
                this.form['country']        = user_address.country;

                this.$store.dispatch('users/fetchStatesOfCountry', { countryCode: user_address.country })
                this.$store.dispatch('users/fetchCitiesOfState', { countryCode: user_address.country })
            }

            if(this.user.position){
                let position = this.user.position;

                this.form['position'] = position.id;
            }
        });
    },

    methods: {
        async update () {
            // Check the password
            if(this.form.new_password != ""){
                if(this.form.new_password != this.form.confirm_password){
                    Toast.fire({
                        icon: 'error',
                        title: "Oops!",
                        text: "Those passwords don't match. Try again "
                    })
                    
                    return false;
                }
            }

            this.$store.dispatch('users/updateUser', { id: this.$route.params.id, form: this.form })
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
                if(error.response){
                    Toast.fire({
                        icon: 'error',
                        title: "Oops!",
                        text: error.response.data.errors.new_password[0]
                    })
                }
            })
        },

        countryChange() {
            this.$store.dispatch('users/fetchStatesOfCountry', { countryCode: this.form.country })
        },

        stateChange() {
            this.$store.dispatch('users/fetchCitiesOfState', { countryCode: this.form.country })
        }
    }
}

</script>