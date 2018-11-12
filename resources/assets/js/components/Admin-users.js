Vue.component('admin-users', {
    data: function () {
        return {
            dialogVisible: false,
            dialogName: '',
            dialogId: '',
            resend: false,
            loading: false,
            deleteModal: false,
            currentDeleteId: 0,
            currentDeleteName: '',
        }
    },
    mounted() {
        
    },
    methods: {
        openModal: function (name, id, resend = false)
        {
            this.dialogId = id;
            this.dialogName = name;
            this.dialogVisible = true;
            this.resend = resend;
        },

        openDeleteModal: function(id, name)
        {
            this.deleteModal = true;
            this.currentDeleteId = id;
            this.currentDeleteName = name;
        },

        deleteUser: function()
        {
            this.loading = true;
            this.$http.post('/user/delete', {'id': this.currentDeleteId}).then(response => {
                this.loading = false;
                this.deleteModal = false;                  
                
                var status = response.body.status;
                this.$notify.success({
                    title: 'Success',
                    message:  response.body.message,
                    duration: 10000,
                });

                window.location.href = window.location.href;

            }, response => {
                this.loading = false;
                this.dialogVisible = false;  

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                  });
            });
        },

        sendInvite: function()
        {
            this.loading = true;
            this.$http.post('/user/send-invite', {'id': this.dialogId, 'resend': this.resend}).then(response => {
                this.loading = false;
                this.dialogVisible = false;                  
                
                var status = response.body.status;

                switch (status) {
                    case 'error':
                        this.$notify.error({
                            title: 'Error',
                            message: response.body.message,
                            duration: 10000,
                        });
                        break;
                    case 'success':
                        this.$notify.success({
                            title: 'Success',
                            message:  response.body.message,
                            duration: 10000,
                        });
                        break;
                    case 'repeat':
                        this.$notify({
                            title: 'Resending',
                            message:  response.body.message,
                            duration: 10000,
                            type: 'warning'
                        });
                        break;
                }
            }, response => {
                this.loading = false;
                this.dialogVisible = false;  

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                  });
            });
        }
    }
}) 