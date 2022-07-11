<template>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row">
            <div class="col-sm-12 col-lg-7 m-auto d-flex justify-content-between align-items-center">
                <h1>Announcements</h1>
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

export default {
    name: 'admin-announcement',

    methods: {
        listenForAnnouncements() {
            Echo.channel('posted-announcements')
                .listen('AnnouncementPosted', post => {
                    if (! ('Notification' in window)) {
                        alert('Web Notification is not supported');
                        return;
                    }

                    Notification.requestPermission( permission => {
                        let notification = new Notification('Announcement Posted', {
                            body: post.message
                        });

                        // link to page on clicking the notification
                        notification.onclick = () => {
                            window.open(window.location.href);
                        };
                    });
                })
        }
    }
}

</script>