<template>
    <div>
        <div class="row mt-3">

            <ul class="pagination justify-content-end">
                <li :class="`page-item ${(page <= 1) ? 'disabled' : ''}`">
                    <a href="javascript:void(0)" class="page-link" @click="page--">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                
                <li v-if="page > 2" class="page-item"><a @click="page = page - 2" href="javascript:void(0)" class="page-link">{{ page - 2 }}</a></li>
                <li v-if="page > 1" class="page-item"><a @click="page--" href="javascript:void(0)" class="page-link">{{ page - 1 }}</a></li>
                <li class="page-item disabled"><a href="javascript:void(0)" class="page-link">{{ page }}</a></li>
                <li v-if="(page + 1) <= pageCount" class="page-item"><a @click="page++" href="javascript:void(0)" class="page-link">{{ page + 1 }}</a></li>
                <li v-if="(page + 2) <= pageCount" class="page-item"><a @click="page = page + 2" href="javascript:void(0)" class="page-link">{{ page + 2 }}</a></li>
                
                <li :class="`page-item ${(page >= pageCount) ? 'disabled' : ''}`">
                    <a href="javascript:void(0)" class="page-link" @click="page++">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </div>
        <div v-if="handbook" class="mt-3 overflow-auto">
            <vue-pdf-embed 
            ref="pdfRef"
            :source="handbook.pdf ?? ''"
            :page="page"
            @rendered="handlePdfRender" />
        </div>
        <div class="mt-3" v-else>
            <h2>No Data</h2>
        </div>
    </div>
</template>

<script>
import VuePdfEmbed from 'vue-pdf-embed/dist/vue2-pdf-embed'
import { mapGetters } from 'vuex'
import * as routeNames from '~/config/route-names'

export default {
    name: 'handbook-single',
    middleware: 'auth',
    data: () => ({
        page: 1,
        pageCount: 1,
        showAllPages: true
    }),

    components: {
        VuePdfEmbed
    },

    computed: mapGetters({
        handbook: 'handbook/handbook'
    }),

    watch: {
        showAllPages() {
            this.page = this.showAllPages ? null : 1
        },
    },

    methods: {
        handlePdfRender() {
            this.pageCount = this.$refs.pdfRef.pageCount
        }
    }
}

</script>