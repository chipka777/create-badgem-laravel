import Paginate from 'vuejs-paginate'

Vue.component('admin-team', {
    components: {
        'paginate': Paginate
    },
    data: function () {
        return {
            createModal: false,
            editModal: false,  
            deleteModal: false,         
            create: {
                firstName: '',
                lastName: '',
                avatar: '',    
                description: '',            
            },
            edit: {},
            offset: 0,
            loading: false,
            pageCount: 0,
            perPage: 20,
            currentPage: 0,
            teams: [],
            delete: 0,
        }
    },
    mounted: function() {
        this.getMembers();
    },
    methods: {
        getMembers: function() {
            this.loading = true;

            this.$http.get('team/' + this.perPage + '/' + this.offset, this.create).then(response => {
                this.pageCount = Math.ceil(response.body.count/this.perPage);
                this.teams = response.body.team;
                this.loading = false;
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
        },

        paginateCallBack: function(pageNum) {
            this.offset = (pageNum * this.perPage) - this.perPage;
            this.currentPage = pageNum;
            this.getQuestions();
        },

        editMemberOpen: function(key) {
            this.editModal = true;
            this.edit = this.teams[key];
        },

        deleteMemberOpen: function(key) {
            this.deleteModal = true;
            this.delete = this.teams[key].id;
        },

        deleteMember: function() {
            this.loading = true;
            
            this.$http.delete('team/' + this.delete).then(response => {
                this.loading = false;
                this.deleteModal = false;  

                this.getMembers();    
            }, response => {
                this.loading = false;
                this.deleteModal = false;  

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
                
        },

        editMember: function() {
            if (this.edit.first_name == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'First Name is required field',
                    duration: 10000,
                });
            }

            if (this.edit.last_name == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Last Name is required field',
                    duration: 10000,
                });
            }

            if (this.edit.description == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Description is required field',
                    duration: 10000,
                });
            }
            this.edit.image = $('#editAvatar')[0].files[0];                
            
            this.loading = true;

            var data = new FormData();
      
            data.append("image", this.edit.image);
            data.append("firstName", this.edit.first_name);
            data.append("lastName", this.edit.last_name);          
            data.append("description", this.edit.description);     

            this.$http.post('team/' + this.edit.id, data).then(response => {
                this.loading = false;
                
                if (response.body.status === 'success') {
                    this.editModal = false;  
                
                    return this.getMembers();    
                }                

                this.$notify.error({
                    title: 'Error',
                    message: response.body.message,
                    duration: 10000,
                });
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
            
        },

        createMember: function() {
            
            this.create.avatar = $('#avatar')[0].files[0];

            if (this.create.firstName == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'First Name is required field',
                    duration: 10000,
                });
            }

            if (this.create.lastName == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Last Name is required field',
                    duration: 10000,
                });
            }

            if (this.create.description == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Description is required field',
                    duration: 10000,
                });
            }

            if (this.create.avatar == undefined) {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Avatar is required field',
                    duration: 10000,
                });
            }

            this.loading = true;

            var data = new FormData();
      
            data.append("image", this.create.avatar);
            data.append("firstName", this.create.firstName);
            data.append("lastName", this.create.lastName);          
            data.append("description", this.create.description);                          

            this.$http.post('team', data).then(response => {
                this.loading = false;
                
                if (response.body.status === 'success') {
                    this.createModal = false;  
                
                    return this.getMembers();    
                }                

                this.$notify.error({
                    title: 'Error',
                    message: response.body.message,
                    duration: 10000,
                });
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
        }
    }
}) 