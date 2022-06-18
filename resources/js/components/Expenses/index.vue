<template>
<div>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Roles</h3>
                </div>

                <div class="title_right">
                    <div class="col-md-5 col-sm-5 form-group pull-right top_search">
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
                                        <th>Expense Category</th>
                                        <th>Amount</th>
                                        <th>Entry Date</th>
                                        <th>Create at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cursor-hand" v-for="expense in expenses.data" :key="expense.id">
                                        <td class="text-capitalize">{{expense.category}}</td>
                                        <td class="text-capitalize"><span>$</span>{{expense.amount}}</td>
                                        <td class="text-capitalize">{{expense.date}}</td>
                                         <td>{{ moment(expense.created_at).format("YYYY-MM-DD") }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success" @click="openModal(expense)">Edit</button>
                                            <button class="btn btn-sm btn-danger" @click="deleteRole(expense.id)">Delete</button>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="inputPassword" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-control" required v-model="form.expenses_category_id" @change="selectExpensesCategory">
                                <option v-for="expenses_categoy in expenses_categories.data" :key="expenses_categoy.id" :value="expenses_categoy.id">
                                    {{ expenses_categoy.category }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Entry Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" v-model="form.date">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="storeExpenses">Save</button>
                </div>
            </div>
        </div>
    </div>

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
                        <label for="inputPassword" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-control" required v-model="form.expenses_category_id" @change="selectExpensesCategory">
                                <option v-for="expenses_categoy in expenses_categories.data" :key="expenses_categoy.id" :value="expenses_categoy.id">
                                    {{ expenses_categoy.category }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="form.amount">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Entry Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" v-model="form.date">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="updateExpenses">Save</button>
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
            expenses_id: "",
            expenses: {},
            expenses_categories: {},
            form: {
                expenses_category_id: "",
                amount: "",
                date: "",
            }
        }
    },

    methods: {
        selectExpensesCategory() {

        },

        getExpensesCategory() {
            axios
                .get('api/expenses-category')
                .then(response => (
                    this.expenses_categories = response
                ))
                .catch(err => console.log(err))
        },
        openModal(value) {
            this.expenses_id = value.expenses_id;
            this.form.expenses_category_id = value.category_id;
            this.form.amount = value.amount;
            this.form.date = value.date;
            $("#updateModal").modal("show");
        },

        getExpenses() {
            axios
                .get('api/expenses')
                .then(response => (
                    this.expenses = response,
                    console.log(this.expenses)
                ))
                .catch(err => console.log(err))
        },

        storeExpenses() {
            axios
                .post('api/expenses', this.form)
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

        updateExpenses() {
            axios
                .patch('api/expenses/' + this.expenses_id, this.form)
                .then(response => (
                    $("#updateModal").modal("hide"),
                    this.getExpenses(),
                     Toast.fire({
                        icon: "success",
                        title: response.data.message,
                        customClass: {
                            title: "text-capitalize",
                        },
                    })
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
        this.getExpensesCategory()
        this.getExpenses()
    }
}
</script>
