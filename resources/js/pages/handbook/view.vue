<template>
    <div>
        <div class="row">
            <div class="col-lg-12 p-3">
                <div class="page-header">
                    <h2>{{ handbook_page.title }}</h2>
                    <small>sample</small>
                </div>
                <hr>
                <div class="page-body">
                    <div class="py-2 overflow-hidden" v-html="handbook_page.content"></div>
                </div>
                <div class="page-footer d-flex justify-content-end">
                    <div>
                        <button class="btn btn-warning" @click="setModalType(null)">Edit</button>
                        <button class="btn btn-danger" @click="deleteHandbookPage()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <button class="visually-hidden" data-bs-toggle="modal" data-bs-target="#updateHandbookPage" ref="handbookModalBtn"></button>
        <!-- Modal -->
        <div class="modal fade" id="updateHandbookPage" tabindex="-1" aria-labelledby="updateHandbookPage" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Handbook Page</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm" v-if="!loading">
                            <div class="form-group py-2">
                                <label for="title">Title</label>
                                <input v-model="handbookPageForm.title" type="text" name="title" class="form-control" placeholder="Handbook page title">
                            </div>
                            <div class="form-group py-2">
                                <label for="content">Content</label>
                                <vue-editor id="editor"
                                    v-model="handbookPageForm.content">
                                </vue-editor>
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

import { mapGetters } from 'vuex'
import { VueEditor } from 'vue2-editor'
import Swal from 'sweetalert2'

export default {
    components: { VueEditor },

    data: () => ({
        type: null
    }),

    computed: mapGetters({
        loading: "handbook-page/loading",
        handbook_page: 'handbook-page/handbook_page',
        handbookPageForm: "handbook-page/handbookPageForm",
        selected_handbook: "handbook-page/selected_handbook",
    }),

    methods: {
        setModalType(type) {
            this.type = type;
            this.$refs['handbookModalBtn'].click();

            this.handbookPageForm.keys().forEach(key => {
                this.handbookPageForm[key] = this.handbook_page[key]
            })
        },

        saveHandbook() {
            const id = this.selected_handbook;

            this.$store.dispatch('handbook-page/saveHandbookPage', {id, type: 'update'})
                .then(({success, message}) => {
                    if(success){
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

        deleteHandbookPage() {
            var id = this.selected_handbook;
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
                    
                    this.$store.dispatch('handbook-page/deleteHandbookPage', id)
                    .then(({success, message}) => {
                        if (success) {
                            Swal.fire(
                                'Deleted!',
                                'Handbook version has been deleted.',
                                'success'
                            )
                            this.$store.dispatch('handbook-page/getLastHandbook').then((data) => {
                                var first_page = data.id;
                                this.$store.dispatch('handbook-page/fetchSingleHandbook', {id: first_page})
                                this.$router.push({ name: 'handbook.pages.view', params: {id: first_page} }) 
                            })
                            
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
    }
}
</script>