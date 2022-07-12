<template>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row col-sm-12 col-lg-7 m-auto">
            <div class=" d-flex justify-content-between align-items-center">
                <h1>Handbook</h1>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="col-lg-6">
                    <select @change="selectHandbook()" :key="handbooks.length" v-model="handbookVersion" class="form-select" aria-label="Default select example">
                        <option :value="handbook.id" :key="handbook.id"  v-for="handbook in handbooks">{{handbook.version_name}}</option>
                    </select>
                </div>
                <div v-if="user.is_admin" class="d-flex col-lg-6 justify-content-end">
                    <div class="col-lg-2 ml-auto">
                        <button class="btn btn-primary" @click="setModalType(null)">Add</button>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-warning" @click="setModalType('update')">Edit</button>
                    </div>
                    <div class="col-lg-2">
                        <button class="btn btn-danger" @click="deleteHandbook()">Delete</button>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Contents -->
        <div class="row mt-3">
            <div class="col-sm-12 col-lg-7 m-auto content-pages">
                <router-view></router-view>
            </div>
        </div>

        <button class="visually-hidden" data-bs-toggle="modal" data-bs-target="#newHandbookVersion" ref="handbookModalBtn"></button>
        <!-- Modal -->
        <div class="modal fade" id="newHandbookVersion" tabindex="-1" aria-labelledby="newHandbookVersion" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Handbook Version</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form v-if="!loading" @submit.prevent="login" @keydown="handbookForm.onKeydown($event)">
                        <!-- Version Name -->
                        <div class="mb-3 row">
                            <label class="col-form-label text-md-start">Version Name</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon3">{{preVersion}}</span>
                                <input v-model="handbookForm.version_name" :class="{ 'is-invalid': handbookForm.errors.has('version_name') }" class="form-control" name="version_name">
                                <has-error :form="handbookForm" field="version_name" />
                            </div>
                        </div>
                    </form>
                    <div v-else>
                        {{ type ? 'Saving Handbook...' : 'Creating new Handbook...' }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" ref="modalHandbookForm">Close</button>
                    <button type="button" class="btn btn-primary" @click="saveHandbook()">Save Handbook</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from "vuex";
import Swal from 'sweetalert2'
import moment, { now } from 'moment';


export default {
    name: 'admin-announcement',
    data: () => ({
        handbookVersion: null,
        preVersion: '',
        type: 'update',
    }),
    
    computed: mapGetters({
        user: 'auth/user',
        handbook: "handbook/handbook",
        loading: "handbook/loading",
        handbooks: "handbook/handbooks",
        handbookForm: "handbook/handbookForm",
        handbookFormRules: "handbook/handbookFormRules",
        selected_handbook: 'handbook-page/selected_handbook',
    }),

    mounted() {
        this.$store.dispatch('handbook/fetchHandbooks').then(() => {
            this.handbookVersion = this.handbooks[this.handbooks.length - 1]?.id;

            this.preVersion = (this.handbookVersion ? (this.handbookVersion + 1) : 1) + '-' + moment(new Date()).format('DDMMYY') + '__';
            this.selectHandbook();
        });
    },
    methods: {
        latestHandbook(handbook) {
            const lastHandbook = this.handbooks[this.handbooks.length - 1];
            
            return lastHandbook.id === handbook.id;
        },

        setModalType(type) {
            this.type = type;

            if (type) {
                if(type == "update"){
                    this.preVersion = (this.handbookVersion ? this.handbookVersion : 1) + '-' + moment(new Date()).format('DDMMYY') + '__';
                }
                this.handbookForm.version_name = this.handbook.version_name.split("__")[1];
            } else {
                this.handbookForm.reset();
            }

            this.$refs['handbookModalBtn'].click();
        },

        saveHandbook() {
            const id = this.type ? this.handbookVersion : null;
            
            this.handbookForm.version_name = this.handbookForm.version_name ? this.preVersion + this.handbookForm.version_name : '';

            this.$store.dispatch('handbook/saveHandbook', id)
                .then(({success, message}) => {
                    if (success) {
                        Swal.fire({
                            icon: 'success',
                            title: message
                        })
                        this.$refs['modalHandbookForm'].click();
                    }
                })
                .catch(err => {
                    console.log(err)
                })
        },

        deleteHandbook() {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    this.$store.dispatch('handbook/deleteHandbook', this.handbookVersion)
                    .then(({success, message}) => {
                        if (success) {
                            Swal.fire(
                            'Deleted!',
                            'Handbook version has been deleted.',
                            'success')
                            this.selectHandbook();
                        } else {
                            Swal.fire(
                            'Error!',
                            message,
                            'error')
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
            })
        },

        selectHandbook() {
            this.$store.dispatch('handbook/fetchHandbook', this.handbookVersion)
            this.$store.dispatch('handbook-page/fetchHandbooksPage', this.handbookVersion).then((response)=>{
                console.log(response)
                var id = null;
                if(this.$route.params.id){
                    id = this.$route.params.id;

                }else{
                    id = response.data[0].id;
                }

                this.$store.dispatch('handbook-page/selectHandbook', {id})

                if(response.data.length > 0){
                    this.$store.dispatch('handbook-page/fetchSingleHandbook', {id})
                    this.$router.push({ name: 'handbook.pages.view', params: {id} }) 
                }
            })
        }
    },
}

</script>

<style lang="scss" scoped>
    .content-pages {
        border-top: 1px solid rgba(62, 64, 66, 0.2);
    }
</style>