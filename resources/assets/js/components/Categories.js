Vue.component('categories', {
    data: function () {
        return {
            categories: [],
            loader: false,
            checked: 'checked',
        }
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        getCategories: function() {
            this.showLoader();
            this.$http.get('/api/v1/categories/all').then(response => {
                this.categories = response.data;
                this.hideLoader();
            }, response => {
                console.log('Some error with categories api!');
            });
        },
        setVisibleCategory: function(id) {
            this.$http.get('/dashboard/categories/' + id + '/edit').then(response => {
                if (response.body == "1") $("#checkbox-" + id).prop("checked", true);
                else $("#checkbox-" + id).prop("checked", false);
            }, response => {
                console.log('Some error with categories api!');
            });
        }, 
        addCategory: function() {
            var name = $('#name-add').val();
            this.showLoadBtn();
            this.$http.post('/dashboard/categories', {'name': name}).then(response => {
                this.hideLoadBtn();
                $("#createModal").modal('hide');
                this.getCategories();
            }, response => {
               $('.create-load-btn').removeClass('btn-primary ').addClass('btn-danger').text('Error').attr('style','margin-left: 86%').removeAttr('disabled').children('i').hide();
            });
           
        },
        openDeleteCategory: function(id, name) {
            $("#deleteModal").modal('show');
            $(".del-category-name").text(name);
            $('#del-category-id').val(id);
        },
        deleteCategory: function() {
            var id = $('#del-category-id').val();
            this.showLoadBtn();
            this.$http.delete('/dashboard/categories/' + id).then(response => {
                this.hideLoadBtn();
                $("#deleteModal").modal('hide');
                this.getCategories();
            }, response => {
               console.log('Error');
            });
        },
        openEditCategory: function(id, name) {
            $("#editModal").modal('show');
            $(".edit-category-name").text(name);
            $('#name-edit').val(name);
            $('#edit-category-id').val(id);
        },
        saveCategory: function() {
            var name = $('#name-edit').val();
            var id = $('#edit-category-id').val();
            this.showLoadBtn();
            this.$http.put('/dashboard/categories/' + id, {'name': name}).then(response => {
                this.hideLoadBtn();
                $("#editModal").modal('hide');
                this.getCategories();
            }, response => {
               console.log('Error');
            });
        },
        showLoader: function() {
            $('.loader').show();
            $('#category-table').hide();
        },
        hideLoader: function() {
            $('.loader').hide();
            $('#category-table').show();
           
        },
        showLoadBtn: function() {
            $('.create-btn').addClass('hidden');
            $('.create-load-btn').removeClass('hidden');
        },
        hideLoadBtn: function() {
            $('.create-btn').removeClass('hidden');
            $('.create-load-btn').addClass('hidden');
           
        }
    }
})