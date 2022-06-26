<template>

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Create Categories</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form @submit.prevent="store_category" class="form-horizontal form-label-left">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Category<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" class="form-control" v-model="form.category">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            form: {
                category: ""
            }
        }
    },
    methods: {
        store_category() {
            axios
                .post("api/category", this.form)
                .then((response) => {
                    Toast.fire({
                        icon: "success",
                        title: response.data,
                        customClass: {
                            title: "text-capitalize",
                        },
                    });
                    this.$router.push({
                        name: 'CategoryList'
                    })
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>
