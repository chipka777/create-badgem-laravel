Vue.component('login-page', {
    props: ['user', 'error'],
    data: function () {
        return {
            currentSection: 'login',
            activeUser: this.user,
            loading: true,
            showPage: false,
            loginForm: {
                email: '',
                password: '',
                remember: false,
            },
            registerForm: {
                email: '',
                confirm_email: '',
                password: '',
                password_confirmation: '',
                invite_code: ''
            },
            activateForm: {
                code: '',
            },
            forgottenForm: {
                email: '',
            }
        }
    },
    mounted() {
        if (this.user) this.currentSection = "activate";

        if (this.error) {
            this.$notify.error({
                title: 'Error',
                message: this.error,
                duration: 30000,
              });
        }

        let self = this;

        setTimeout(function() {
            self.showPage = true;
            self.loading = false;
        }, 2000);
    },
    methods: {
        login: function(form) {
            this.loading = true;

            var data = new FormData();

            data.append('email', this.loginForm.email);
            data.append('password', this.loginForm.password);
            data.append('remember', this.loginForm.remember);

            this.$http.post('/login', data).then(response => {
                this.loading = false;                
                var status = response.body.status;

                if (status == "OK") {
                    this.$notify.success({
                        title: 'Success',
                        message: 'You have successfully entered',
                        duration: 10000,
                      });
                    
                      window.location.href = "/";
                    
                } else {
                    this.$notify.error({
                        title: 'Error',
                        message: response.body.errors,
                        duration: 10000,
                      });
                }
            }, response => {
                this.loading = false;                                
                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with login api',
                    duration: 10000,
                  });
            });
        },
        register: function(form) {
            this.loading = true;

            var data = new FormData();

            data.append('email', this.registerForm.email);
            data.append('email_confirmation', this.registerForm.confirm_email);            
            data.append('password', this.registerForm.password);
            data.append('password_confirmation', this.registerForm.password_confirmation);
            data.append('invite_code', this.registerForm.invite_code);            
            
            this.$http.post('/register', data).then(response => {
                this.loading = false;
                var status = response.body.status;

                if (status == "OK") {
                    this.$notify.success({
                        title: 'Success',
                        message: 'Enter the code you receive on the email',
                        duration: 10000,
                      });

                    this.activeUser = true;
                    this.currentSection = "activate";                
                      
                } else {
                    this.$notify.error({
                        title: 'Error',
                        message: response.body.errors,
                        duration: 10000,
                      });
                }
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with register api',
                    duration: 10000,
                  });
            });
        },

        openWindow: function(url) {
            let width = window.innerWidth / 3;
            let height = window.innerHeight / 2;            
            let left = window.innerWidth / 2 - (width / 2);
            let top = window.innerHeight / 2 - (height / 2);

            window.open(url,'name','width=' + width + ',height=' + height + ',top=' + top + ',left=' + left);
        },
        activate: function() {
            this.loading = true;

            this.$http.post('/activate', {code: this.activateForm.code}).then(response => {
                this.loading = false;
                var status = response.body.status;

                if (status == "OK") {
                    this.$notify.success({
                        title: 'Success',
                        message: 'Your account has been successfully activated',
                        duration: 10000,
                      });
                    this.currentSection = 'login';
                    this.activeUser = false;
                } else {
                    this.$notify.error({
                        title: 'Error',
                        message: 'You entered an invalid code, please try again',
                        duration: 10000,
                      });
                }
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with register api',
                    duration: 10000,
                  });
            });
        },

        forgottenPassword: function () {
            this.loading = true;

            this.$http.post('/password-recovery', {email: this.forgottenForm.email}).then(response => {
                this.loading = false;
                var status = response.body.status;

                if (status == "OK") {
                    this.$notify.success({
                        title: 'Success',
                        message: 'The new password was successfully sent to the email address',
                        duration: 10000,
                      });
                    this.currentSection = 'login';
                } else {
                    this.$notify.error({
                        title: 'Error',
                        message: response.body.errors,
                        duration: 10000,
                      });
                }
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with password recovery api',
                    duration: 10000,
                  });
            });
        }

    }
}) 