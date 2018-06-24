import Paginate from 'vuejs-paginate'

Vue.component('admin-faq', {
    components: {
        'paginate': Paginate
    },
    data: function () {
        return {
            createModal: false,
            editModal: false,  
            deleteModal: false,         
            create: {
                question: '',
                answer: '',
            },
            edit: {},
            offset: 0,
            loading: false,
            pageCount: 0,
            perPage: 20,
            currentPage: 0,
            faqs: [],
            delete: 0,
        }
    },
    mounted: function() {
        this.getQuestions();
    },
    methods: {
        getQuestions: function() {
            this.loading = true;

            this.$http.get('faq/' + this.perPage + '/' + this.offset, this.create).then(response => {
                this.pageCount = Math.ceil(response.body.count/this.perPage);
                this.faqs = response.body.faq;
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

        editQuestionOpen: function(key) {
            this.editModal = true;
            this.edit = this.faqs[key];
        },

        deleteQuestionOpen: function(key) {
            this.deleteModal = true;
            this.delete = this.faqs[key].id;
        },

        deleteQuestion: function() {
            this.loading = true;
            
            this.$http.delete('faq/' + this.delete).then(response => {
                this.loading = false;
                this.deleteModal = false;  

                this.getQuestions();
                
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

        editQuestion: function() {
            if (this.edit.question == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Question is required field',
                    duration: 10000,
                });
            }

            if (this.edit.answer == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Answer is required field',
                    duration: 10000,
                });
            }
            this.loading = true;

            let data = {
                question: this.edit.question,
                answer: this.edit.answer,                
            }
            this.$http.put('faq/' + this.edit.id, data).then(response => {
                this.editModal = false;  
                
                this.getQuestions();

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

        createQuestion: function() {
            
            if (this.create.question == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Question is required field',
                    duration: 10000,
                });
            }

            if (this.create.answer == '') {
                return this.$notify.error({
                    title: 'Error',
                    message: 'Answer is required field',
                    duration: 10000,
                });
            }
            this.loading = true;

            this.$http.post('faq', this.create).then(response => {
                this.createModal = false;  
                
                this.getQuestions();

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