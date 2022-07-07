<template>
    <div class="row">
        <div class="m-auto">
            <card :title="$t('Update Announcement')">
                <form action="javascript:void(0)">
                    <div class="row">
                        <input type="hidden" v-model="form.id" name="id">
                        <div class="form-group py-2">
                            <label for="title">Title</label>
                            <input v-model="form.title" type="text" name="title" class="form-control" placeholder="Announcement's title">
                        </div>
                        <div class="form-group py-2">
                            <label for="excerpt">Excerpt</label>
                            <textarea v-model="form.excerpt" name="excerpt" id="excerpt" placeholder="Announcement's short description" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group py-2">
                            <label for="receiver">Receiver</label>
                            <select v-model="form.receiver" name="receiver" id="receiver" class="form-control">
                                <option value="employee" selected>All Employees</option>
                                <option value="developers">Developers</option>
                                <option value="team_leads">Team Leads</option>
                                <option value="managers">Managers</option>
                                <option value="admins">Admins</option>
                            </select>
                        </div>
                        <div class="form-group py-2">
                            <label for="content">Content</label>
                            <textarea v-model="form.content" name="content" id="content" class="form-control" placeholder="Announcement's contents" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group py-2 d-flex justify-content-end">
                        <button class="btn btn-success float-right">Update</button>
                    </div>
                </form>
            </card>
        </div>
    </div>
</template>

<script>
import Form from 'vform'

export default {

    name: 'announcement.create',

    data: () => ({
        form: new Form({
            id: '',
            title: '',
            excerpt: '',
            receiver: 'employee',
            content: ''
        })
    }),

    metaInfo () {
        return { title: this.$t('Announcement') }
    }
}
</script>