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
                <router-link :to="{name:'createProduct'}" type="button" class="btn btn-primary btn-sm">
                    ADD PRODUCT
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
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="cursor-hand" v-for="product in products.data" :key="product.id">
                                    <td class="text-capitalize">{{product.name}}</td>
                                    <td class="text-capitalize">{{product.category.category}}</td>
                                    <td class="text-capitalize">{{product.description}}</td>
                                    <td>
                                        <router-link :to="{name: 'updateProduct', params: { id: product.id }}" class="btn btn-sm btn-success">Edit</router-link>
                                        <button class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <Pagination :data="products" @pagination-change-page="getProducts" :limit="5" />
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
            categories: {},
            products: {}
        }
    },
    methods: {
        getProducts(page = 1) {
            axios.get('api/product?page=' + page).then((data) => {
                    this.products = data.data
                    console.log(data);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteProduct(id) {
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
                        axios.delete("api/product/" + id).then((response) => {
                            Toast.fire({
                                icon: "success",
                                title: response.data,
                                customClass: {
                                    title: "text-capitalize",
                                },
                            });
                            this.getProducts();
                        });
                    } catch (error) {
                        Swal.fire("Error!", "Someting went wrong.", "error");
                    }
                }
            });
        }
    },
    mounted() {
        this.getProducts();
    }
}
</script>
