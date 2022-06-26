<template>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Categories</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12  ">
                    <router-link :to="{name:'createCategory'}" type="button" class="btn btn-primary btn-sm">
                        ADD CATEGORY
                    </router-link>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Role List</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cursor-hand" v-for="category in categories.data" :key="category.id">
                                        <td class="text-capitalize">{{category.category}}</td>
                                        <td>
                                            <router-link :to="{name: 'updateCategory', params: { id: category.id }}" class="btn btn-sm btn-success">Edit</router-link>
                                            <button class="btn btn-sm btn-danger" @click="deleteCategory(category.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <Pagination :data="categories" @pagination-change-page="getCategories" :limit="5" />
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";

export default {
    components: {
        Pagination: LaravelVuePagination,
    },
    data() {
        return {
            categories: {}
        }
    },
    methods: {
        getCategories(page = 1) {
            axios
                .get('api/category?page=' + page)
                .then(response => (
                    this.categories = response.data
                ))
                .catch(err => console.log(err))
        },

        deleteCategory(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        axios.delete("api/category/" + id).then((response) => {
                            Toast.fire({
                                icon: "success",
                                title: response.data,
                                customClass: {
                                    title: "text-capitalize",
                                },
                            });
                            this.getCategories();
                        });
                    } catch (error) {
                        Swal.fire("Error!", "Someting went wrong.", "error");
                    }
                }
            });
        }
    },
    mounted() {
        this.getCategories();
    }
}
</script>
