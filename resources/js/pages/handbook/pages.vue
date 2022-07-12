<template>
    <div>
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="main-pages">
                    <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white">
                        <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
                            <span class="fs-5 fw-semibold">{{page_title}}</span>
                        </div>
                        <div class="list-group list-group-flush border-bottom scrollarea">
                            <div
                                class="list-group-item list-group-item-action py-3 lh-tight" 
                                aria-current="true"
                                v-for="(item, index) in handbooks_page" 
                                :key="index" 
                                v-bind:class="{ active : handbook_selected == item.id }"
                                @click="selectHandbook(item.id)"
                            >
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <span class="mb-1">{{ item.title }}</span>
                                </div>
                            </div>
                            <div
                                class="list-group-item list-group-item-action py-3 lh-tight cursor-pointer" 
                                aria-current="true"
                                @click="setModalType('save')"
                            >
                                <div class="d-flex w-100 align-items-center justify-content-center">
                                    <span class="mb-1"><fa icon="plus" fixed-width />New Page</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-8 m-auto" v-if="handbooks_page.length > 0">
                <router-view></router-view>
            </div>
            <div class="col-sm-12 col-lg-8 m-auto" v-else>
                <h3 class="text-center">Data not found!</h3>
            </div>
        </div>
        <button class="visually-hidden" data-bs-toggle="modal" data-bs-target="#newHandbookPage" ref="handbookModalBtn"></button>
        <!-- Modal -->
        <div class="modal fade" id="newHandbookPage" tabindex="-1" aria-labelledby="newHandbookPage" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Handbook Page</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm" v-if="!loading">
                            <div class="form-group py-2">
                                <label for="title">Title</label>
                                <input v-model="handbookPageForm.title" type="text" name="title" class="form-control" placeholder="New Handbook page title">
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" ref="modalhandbookPageForm">Close</button>
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
        handbook_selected: null,
        type: null
    }),

    computed: mapGetters({
        handbooks_page: 'handbook-page/handbooks_page',
        selected_handbook: 'handbook-page/selected_handbook',
        handbook: 'handbook/handbook',
        page_title: 'handbook/page_title',
        loading: "handbook-page/loading",
        handbookPageForm: "handbook-page/handbookPageForm"
    }),

    watch:{
        selected_handbook(){
            this.handbook_selected = this.selected_handbook;
        }
    },  

    created(){
        this.handbook_selected = this.$route.params.id
        this.$store.dispatch('handbook-page/selectHandbook', {id: this.handbook_selected})
    },

    methods: {
        setModalType(type) {
            this.type = type;
            this.$refs['handbookModalBtn'].click();
            this.handbookPageForm.reset()
        },
        selectHandbook(id){
            this.handbook_selected = id
            if( this.selected_handbook != id ){
                this.$store.dispatch('handbook-page/selectHandbook', {id})
                this.$store.dispatch('handbook-page/fetchSingleHandbook', {id})
                this.$router.push({ name: 'handbook.pages.view', params: {id} }) 
            }
        },
        saveHandbook() {
            const handbookId = this.handbook.id;

            this.$store.dispatch('handbook-page/saveHandbookPage', {id: null, type: this.type, handbookId: handbookId })
                .then(({success, message}) => {
                    if(success){
                        Swal.fire({
                            icon: 'success',
                            title: message
                        })
                        this.$refs['modalhandbookPageForm'].click();
                        this.$store.dispatch('handbook-page/getLastHandbook').then((data) => {
                                var first_page = data.id;
                                this.$store.dispatch('handbook-page/fetchSingleHandbook', {id: first_page})
                                this.$router.push({ name: 'handbook.pages.view', params: {id: first_page} }) 
                            })
                    }
                    
                })
                .catch(err => {
                    console.log(err)
                })
        },
    }
}
</script>

<style lang="scss" scoped>

body {
    min-height: 100vh;
    min-height: -webkit-fill-available;
}

html {
    height: -webkit-fill-available;
}

.cursor-pointer{
    cursor: pointer;
}

.main-pages {
    border-right:  1px solid rgba(62, 64, 66, 0.2);
}

.bi {
    vertical-align: -.125em;
    pointer-events: none;
    fill: currentColor;
}

.dropdown-toggle { outline: 0; }

.nav-flush .nav-link {
    border-radius: 0;
}

.btn-toggle {
    display: inline-flex;
    align-items: center;
    padding: .25rem .5rem;
    font-weight: 600;
    color: rgba(0, 0, 0, .65);
    background-color: transparent;
    border: 0;
}
.btn-toggle:hover,
.btn-toggle:focus {
    color: rgba(0, 0, 0, .85);
    background-color: #d2f4ea;
}

.btn-toggle::before {
    width: 1.25em;
    line-height: 0;
    content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
    transition: transform .35s ease;
    transform-origin: .5em 50%;
}

.btn-toggle[aria-expanded="true"] {
    color: rgba(0, 0, 0, .85);
}
.btn-toggle[aria-expanded="true"]::before {
    transform: rotate(90deg);
}

.btn-toggle-nav a {
    display: inline-flex;
    padding: .1875rem .5rem;
    margin-top: .125rem;
    margin-left: 1.25rem;
    text-decoration: none;
}
.btn-toggle-nav a:hover,
.btn-toggle-nav a:focus {
    background-color: #d2f4ea;
}

.scrollarea {
    overflow-y: auto;
}

.fw-semibold { font-weight: 600; }
.lh-tight { line-height: 1.25; }

</style>