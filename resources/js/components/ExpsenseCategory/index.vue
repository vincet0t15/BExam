<template>
<div>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Roles</h3>
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
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Role List</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cursor-hand" v-for="category in categories.data" :key="category.id">
                                        <td class="text-capitalize">{{category.category}}</td>
                                        <td class="text-capitalize">{{category.description}}</td>
                                        <td>{{ moment(category.created_at).format("YYYY-MM-DD") }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" @click="openUpdateModal(category)">Edit</button>
                                            <button class="btn btn-sm btn-danger" @click="deleteCategory(category.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary float-right btn-sm font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                        ADD ROLE
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.category">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.description">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="storeCategory">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.category">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.description">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updateCategory">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import axios from "axios";
import moment from "moment";
export default {
    data() {
        return {
            moment: moment,
            categories: {},
            category_id: "",
            form: {
                category: "",
                description: ""
            }
        }
    },

    methods: {
        getCategory() {
            axios
                .get('api/expenses-category')
                .then(response => (
                    this.categories = response,
                    console.log(this.categories)
                ))
                .catch(err => console.log(err))
        },

        storeCategory() {
            axios
                .post('api/expenses-category', this.form)
                .then(response => (
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                        customClass: {
                            title: "text-capitalize",
                        },
                    }),
                    this.getCategory(),
                    $("#exampleModal").modal("hide")
                ))
                .catch(err => console.log(err))
        },

        openUpdateModal(value) {
            this.category_id = value.id;
            this.form.category = value.category;
            this.form.description = value.description;
            $("#UpdateModal").modal("show");
        },

        updateCategory() {
            axios
                .patch('api/expenses-category/' + this.category_id, this.form)
                .then(response => (
                    this.getCategory(),
                    $("#UpdateModal").modal("hide")
                ))
                .catch(err => console.log(err))
        },

        deleteCategory(id) {
            Swal.fire({
                title: "Are you sure you want to delete?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        axios.delete("api/expenses-category/" + id).then((response) => {
                            this.getCategory();
                            Toast.fire({
                                icon: "success",
                                title: response.data.message,
                                customClass: {
                                    title: "text-capitalize",
                                },
                            })
                        });
                    } catch (error) {
                        Swal.fire("Error!", "Someting went wrong.", "error");
                    }
                }
            })

        },

        resetForm() {
            this.category_id = null,
            this.form.category = null,
            this.form.description = null
        }

    },
    mounted() {
        this.getCategory()
    }
}
</script>
