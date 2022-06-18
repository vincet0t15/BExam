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
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Role</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cursor-hand" v-for="user in users.data" :key="user.id">
                                        <td class="text-capitalize">{{user.name}}</td>
                                        <td class="text-capitalize">{{user.email}}</td>
                                        <td class="text-capitalize">{{user.role.display_name}}</td>
                                        <td>{{ moment(user.created_at).format("YYYY-MM-DD") }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" @click="modalUpdate(user)">Edit</button>
                                            <button class="btn btn-sm btn-danger" @click="deleteUser(user.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary float-right btn-sm font-weight-bold" data-toggle="modal" data-target="#addUser">
                        ADD ROLE
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="staticEmail" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Email Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" v-model="form.password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" v-model="form.password_confirmation">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-control" required v-model="form.role" @change="selectRole">
                                <option v-for="role in roles.data" :key="role.id" :value="role.id">
                                    {{ role.display_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="Register">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="staticEmail" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Email Address</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" v-model="form.password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" v-model="form.password_confirmation">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select class="form-control" required v-model="form.role" @change="selectRole">
                                <option v-for="role in roles.data" :key="role.id" :value="role.id">
                                    {{ role.display_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updateUser">Save</button>
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
            users: {},
            user_id: "",
            roles: {},
            form: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                role: "",
            }
        }
    },
    methods: {
        getUser() {
            axios
                .get('api/users', this.form)
                .then(response => (
                    this.users = response,
                    console.log(this.users)
                ))
                .catch(err => console.log(err))
        },
        getRoles() {
            axios
                .get('api/role', this.form)
                .then(response => (
                    this.roles = response
                ))
                .catch(err => console.log(err))
        },
        selectRole() {
            console.log(this.form.role);
        },

        Register() {
            axios
                .post("api/register", this.form)
                .then(response => (
                    console.log(response),
                    this.getUser()
                ))
                .catch(err => console.log(err))
        },
        modalUpdate(value) {
            this.user_id = value.id
            this.form.name = value.name
            this.form.email = value.email
            this.form.password = ""
            this.form.password_confirmation = ""
            this.form.role = value.role.id
            $("#updateUser").modal("show")
        },
        updateUser() {
            axios
                .post("api/update-user/" + this.user_id, this.form)
                .then(response => (
                    console.log(response),
                    this.getUser()
                ))
                .catch(err => console.log(err))
        },
        deleteUser(id) {
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
                        axios.delete("api/remove-user/" + id).then((response) => {
                            console.log(response)
                            Swal.fire(response.data.message);
                            this.getUser();
                        });
                    } catch (error) {
                        Swal.fire("Error!", "Someting went wrong.", "error");
                    }
                }
            })
        },
    },
    mounted() {
        this.getUser();
        this.getRoles();
    }

}
</script>
