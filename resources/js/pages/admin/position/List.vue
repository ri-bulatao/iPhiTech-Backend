<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped caption-top">
                    <caption>List of positions</caption>
                    <thead>
                        <tr>
                            <td> <strong>#</strong> </td>
                            <td> <strong>Position</strong> </td>
                            <td> <strong>Actions</strong> </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(position, index) in positions" :key="position.id">
                            <td>{{ index + 1 }}</td>  
                            <td>{{ position.name }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
    name: 'admin-user-positions',

    computed: mapGetters({
        positions: 'positions/positions'
    })
}

</script>