<template>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto d-flex justify-content-between align-items-center">
                <h1>Handbook</h1>
                <select :key="handbooks.length" v-model="handbookVersion" class="form-select" aria-label="Default select example">
                    <option :value="handbook.id" :key="handbook.id"  v-for="handbook in handbooks">{{handbook.version_name}}</option>
                </select>
            </div>
        </div>
        
        <!-- Contents -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from "vuex";


export default {
    name: 'admin-announcement',
    data: () => ({
        handbookVersion: '',
    }),
    
    computed: mapGetters({
        handbooks: "handbook/handbooks",
    }),
    beforeMount() {
    },
    mounted() {
        this.$store.dispatch('handbook/fetchHandbooks').then(() => {
            this.handbookVersion = this.handbooks[this.handbooks.length - 1].version_name;
        });
    },
    methods: {
        latestHandbook(handbook) {
            const lastHandbook = this.handbooks[this.handbooks.length - 1];
            
            return lastHandbook.id === handbook.id;
        }
    },
}

</script>