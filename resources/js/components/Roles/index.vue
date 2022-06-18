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
                                    <tr class="cursor-hand" v-for="role in roles.data" :key="role.id">
                                        <td class="text-capitalize">{{role.display_name}}</td>
                                        <td class="text-capitalize">{{role.description}}</td>
                                        <td>{{ moment(role.created_at).format("YYYY-MM-DD") }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" @click="openModal(role)">Edit</button>
                                            <button class="btn btn-sm btn-danger" @click="deleteRole(role.id)">Delete</button>
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
    <!-- Modal -->
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
                        <label for="staticEmail" class="col-sm-3 col-form-label">Display Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.display_name">
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
                    <button type="button" class="btn btn-primary" @click="storeRole">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!--Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Display Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.display_name">
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
                    <button type="button" class="btn btn-primary" @click="updateRole">Save changes</button>
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
            errors: [],
            moment: moment,
            role_id: "",
            roles: {},
            form: {
                display_name: "",
                description: ""
            }
        }
    },

    methods: {
        openModal(value) {
            if (value.id == 1) {
                alert('Access denied')
            } else {
                this.role_id = value.id;
                this.form.display_name = value.display_name;
                this.form.description = value.description;

                $("#updateModal").modal("show");
            }

        },
        getRoles() {
            axios
                .get('api/role', this.form)
                .then(response => (
                    this.roles = response
                ))
                .catch(err => console.log(err))
        },

        storeRole() {
            axios
                .post('api/role', this.form)
                .then(response => (
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                        customClass: {
                            title: "text-capitalize",
                        },
                    }),
                    this.role = response.data,
                    this.getRoles(),
                    this.resetForm(),
                    $("#exampleModal").modal("hide")
                ))
                .catch(err => console.log(err))
        },

        updateRole() {
            axios
                .patch('api/role/' + this.role_id, this.form)
                .then(response => (
                    console.log(this.form),
                    console.log(response),
                    this.resetForm(),
                    $("#updateModal").modal("hide"),
                    this.getRoles()
                ))
                .catch(err => console.log(err))
        },

        deleteRole(id) {
            if (id == 1) {
                alert('Access denied!')
            } else {

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
                            axios.delete("api/role/" + id).then((response) => {
                                Swal.fire("Deleted!", response.data.messate, "success");
                                this.getRoles();
                            });
                        } catch (error) {
                            Swal.fire("Error!", "Someting went wrong.", "error");
                        }
                    }
                })
            }
        },

        resetForm() {
            this.role_id = null,
            this.form.display_name = null,
            this.form.description = null
        }

    },
    mounted() {
        this.getRoles()
    }
}
</script>
