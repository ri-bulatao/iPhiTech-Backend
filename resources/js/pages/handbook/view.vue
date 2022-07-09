<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white">
                    <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
                        <span class="fs-5 fw-semibold">Content Pages</span>
                    </div>
                    <div class="list-group list-group-flush border-bottom scrollarea">
                    <a href="#" class="list-group-item list-group-item-action active py-3 lh-tight" aria-current="true">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">List group item heading</strong>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">List group item heading</strong>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 lh-tight">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">List group item heading</strong>
                        </div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action py-3 lh-tight" aria-current="true">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1">List group item heading</strong>
                        </div>
                    </a>
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

    data: () => ({
        sortBy: 'title',
        sortOrder: 'asc'
    }),

    computed: mapGetters({
        announcements: 'announcements/announcements'
    }),

    methods: {
        handleSort(handle) {
            this.sortBy = handle
            this.sortOrder = this.sortOrder == 'asc' ? 'desc' : 'asc'
            
            let payload = {
                sortBy: this.sortBy,
                sortOrder: this.sortOrder
            }

            this.$store.dispatch('announcements/fetchAnnouncements', payload)
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!',
                        text: 'Something went wrong!'
                    })
                })
        },

        deleteReady(id) {
            Swal.fire({
                icon: 'question',
                title: 'Are you sure to delete ?',
                text: 'There is no undo for this action',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!'
            })
            .then(result => {
                if(result.isConfirmed) {
                    this.delete(id)
                }
            })
        },

        delete(id) {
            this.$store.dispatch('announcements/deleteAnnouncement', id)
                .then(res => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        message: res.message
                    })

                    this.$store.dispatch('announcements/fetchAnnouncements')

                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!',
                        text: 'Something went wrong!'
                    })
                })
        }
    },

    mounted() {
        let payload = {
            sortBy: this.sortBy,
            sortOrder: this.sortOrder
        }
        this.$store.dispatch('announcements/fetchAnnouncements', payload)
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'Something went wrong!'
                })
            })
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

main {
  display: flex;
  flex-wrap: nowrap;
  height: 100vh;
  height: -webkit-fill-available;
  max-height: 100vh;
  overflow-x: auto;
  overflow-y: hidden;
}

.b-example-divider {
  flex-shrink: 0;
  width: 1.5rem;
  height: 100vh;
  background-color: rgba(0, 0, 0, .1);
  border: solid rgba(0, 0, 0, .15);
  border-width: 1px 0;
  box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
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