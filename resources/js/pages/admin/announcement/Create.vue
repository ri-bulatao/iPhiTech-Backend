<template>
    <div class="row">
        <div class="m-auto">
            <card :title="$t('Create Announcement')">
                <form @submit.prevent="submitForm">
                    <div class="form-group py-2">
                        <label for="title">Title</label>
                        <input v-model="form.title" type="text" name="title" class="form-control" placeholder="Announcement's Title">
                    </div>
                    <div class="form-group py-2">
                        <label for="excerpt">Excerpt</label>
                        <textarea v-model="form.excerpt" name="excerpt" id="excerpt" cols="30" rows="6" class="form-control" placeholder="Announcement's short description"></textarea>
                    </div>
                    <div class="form-group py-2">
                        <label for="receiver">Receiver</label>
                        <select v-model="form.receiver" name="receiver" id="receiver" class="form-control">
                            <option value="0">All Employee</option>
                            <option value="1">Developers</option>
                            <option value="2">Managers</option>
                            <option value="3">Graphics</option>
                            <option value="4">Admins</option>
                        </select>
                    </div>
                    <div class="form-group py-2">
                        <label for="content">Content</label>
                         <vue-editor id="editor"
                            useCustomImageHandler
                            @image-added="handleImageAdded" v-model="form.content"></vue-editor>
                    </div>
                    <div class="form-group py-2 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </card>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import Swal from 'sweetalert2'
import Cookies from 'js-cookie'
import { VueEditor } from 'vue2-editor'

export default {

    name: 'announcement-create',

    components: { VueEditor },

    data: () => ({
        form: new Form({
            title: '',
            excerpt: '',
            receiver: '0',
            content: ''
        })
    }),

    methods: {
        submitForm() {
            this.$store.dispatch('announcements/createAnnouncement', this.form)
                .then(res => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Created!',
                        text: res.message
                    })
                    
                    this.redirect()

                })
                .catch(err => {
                    console.log(err)
                })
        },

        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            let formData = new FormData()
            formData.append('image', file)

            this.$store.dispatch('announcements/uploadImage', formData)
                .then(res => {
                    let url = res.data.url
                    Editor.insertEmbed(cursorLocation, 'image', url)
                    resetUploader()
                })

        },

        redirect() {
            let intended_url = Cookies.get('intended_url')

            if( intended_url ) {
                Cookies.remove('intended_url')
                this.$router.push({ name: intended_url })
            }
            else {
                this.$router.push({ name: 'admin.announcements.list' })
            }
        }
    },

    metaInfo () {
        return { title: this.$t('Create Announcement') }
    },
}
</script>