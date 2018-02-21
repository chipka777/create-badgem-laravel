Vue.component('history', {
    props: ['id'],
    data: function () {
        return {
            loading: false,
            histories: [],
            count: 0,
            offset: 0,
            requestCount: 5,
        }
    },
    mounted() {
       this.getHistory();
    },
    methods: {
        getHistory: function() {
            this.loading = true;

            this.$http.get('/api/v1/history/' + this.offset + '/' + this.requestCount + '/' + this.id).then(response => {
                this.histories = this.histories.concat(response.body.histories);
                this.count = response.body.count - this.offset;

                this.loading = false;
            }, response => {
                this.loading = false;

                this.$notify.error({
                    title: 'Error',
                    message: 'Some error with histories api',
                    duration: 10000,
                });
            });
        },

        loadMore: function() {
            this.offset += 5;

            this.getHistory();
        }
    }
}) 