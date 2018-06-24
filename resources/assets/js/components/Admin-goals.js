import Paginate from 'vuejs-paginate'

Vue.component('admin-goals', {
    components: {
        'paginate': Paginate
    },
    data: function () {
        return {
            createModal: false,
            editModal: false,  
            deleteModal: false,         
            create: {
                name: '',
                description: '',
            },
            edit: {},
            offset: 0,
            loading: false,
            pageCount: 0,
            perPage: 20,
            currentPage: 0,
            goals: [],
            delete: 0,
        }
    },
    mounted: function() {
        this.getGoals();
    },
    methods: {
        getGoals: function() {
            this.loading = true;

            this.$http.get('goals/' + this.perPage + '/' + this.offset, this.create).then(response => {
                this.pageCount = Math.ceil(response.body.count/this.perPage);
                this.goals = response.body.faq;
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

        editGoalOpen: function(key) {
            this.editModal = true;
            this.edit = this.goals[key];
        },

        deleteGoalOpen: function(key) {
            this.deleteModal = true;
            this.delete = this.goals[key].id;
        },

        deleteGoal: function() {
            this.loading = true;
            
            this.$http.delete('goals/' + this.delete).then(response => {
                this.loading = false;
                this.deleteModal = false;  

                this.getGoals();
                
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

        editGoal: function() {
            if (this.edit.name == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Name is required field',
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
            this.loading = true;

            let data = {
                name: this.edit.name,
                description: this.edit.description,                
            }
            this.$http.put('goals/' + this.edit.id, data).then(response => {
                this.editModal = false;  
                
                this.getGoals();

                this.loading = false;
            }, response => {
                this.loading = false;
                this.editModal = false;  

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
            
        },

        createGoal: function() {
            if (this.create.name == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Name is required field',
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
            this.loading = true;

            this.$http.post('goals', this.create).then(response => {
                this.createModal = false;  
                
                this.getGoals();

                this.loading = false;
            }, response => {
                this.loading = false;
                this.createModal = false;  

                this.$notify.error({
                    title: 'Error',
                    message: 'An error has occurred. Try later.',
                    duration: 10000,
                });
            });
        }
    }
}) 