Vue.component('login-page', {
    props: ['user'],
    data: function () {
        return {
            currentSection: 'login',
            activeUser: this.user,
            loading: false,
            loginForm: {
                email: '',
                password: '',
                remember: false,
            },
            registerForm: {
                name: '',
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            activateForm: {
                code: '',
            }
        }
    },
    mounted() {
        if (this.user) this.currentSection = "activate";
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

            data.append('name', this.registerForm.name);
            data.append('first_name', this.registerForm.first_name);
            data.append('last_name', this.registerForm.last_name);
            data.append('email', this.registerForm.email);
            data.append('password', this.registerForm.password);
            data.append('password_confirmation', this.registerForm.password_confirmation);
            
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

    }
}) 