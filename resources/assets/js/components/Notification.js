Vue.component('notification', {
    data: function () {
        return {
            count: 0,
            loading: false,
            notifications: [],
        }
    },
    mounted() {
       this.getLastNotification();
    },
    methods: {
        getLastNotification: function() {
            this.loading = true;

            this.$http.get('/api/v1/notifications/0/5').then(response => {
                this.count = response.body.count;
                this.notifications = response.body.notifications;

                this.loading = false;
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with notification api',
                    duration: 10000,
                });
            });
        },

        setNotificationAsRead: function() {
            if (this.count == 0) return false;

            this.count = 0;

            this.$http.get('/api/v1/notifications/set-as-read').then(response => {
            
            }, response => {
                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with notification api',
                    duration: 10000,
                });
            });
            
        }
    }
}) 