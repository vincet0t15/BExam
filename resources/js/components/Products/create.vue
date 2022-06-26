<template>
<div class="right_col" role="main">
    <div class="">
        <form action="">
            <h2><span class="text-danger" v-for="error in errors">{{error}} </span></h2>

            <section v-if="step === 1">
                <h3>Step 1</h3>

                <div class="col-lg">
                    <input type="text" class="form-control" v-model="form.name" placeholder="Enter Product name">
                </div>

                <div class="col-lg mt-2">
                    <select class="form-control" required v-model="form.category_id" @change="selectedCategory">
                         <option value="" selected disabled>Select category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id" :selected="category.id == 5">
                            {{ category.category }}
                        </option>
                    </select>
                </div>

                <div class="col-lg mt-2">
                    <textarea class="form-control" v-model="form.description"></textarea>
                </div>
            </section>

            <section v-if="step === 2">
                <h3>Step 2</h3>

                <div class="col-lg">
                    <input type="file" multiple accept="image/jpeg" @change="onFileChange" />
                </div>

                <div class="row">
                    <div class="col-lg-4" v-for="(image, key) in images" :key="key">
                        <div class="card">
                            <img src="preview" class="card-img-top" alt="Waterfall" :ref="'image'"/>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg" v-if="step === 3">
                <h3>Step 3</h3>
                <input type="date" v-model="form.dateTime" class="form-control" />
            </section>

            <div class="row">
                <div class="ml-4 mt-2" v-if="step != 1">
                    <button class="btn btn-primary" @click.prevent="prevStep">Previous</button>
                </div>

                <div class="ml-4 mt-2" v-if="step != totalSteps">
                    <button class="btn btn-primary" @click.prevent="nextStep">Next</button>
                </div>

                <div class="ml-4 mt-2" v-if="step == 3">
                    <button class="btn btn-primary" @click.prevent="storeProduct">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            categories: {},
            step: 1,
            totalSteps: 3,
            images: [],
            form: {
                name: "",
                category_id: "",
                description: "",
                dateTime: "",
            }

        }
    },
    methods: {
        nextStep() {
            this.errors = [];
            if (this.step == 1) {
                if (!this.form.name) {
                    this.errors = "Please fill the product name"
                    return false
                }

                if (!this.form.category_id) {
                    this.errors = "Please select category"
                    return false
                }

                if (!this.form.description) {
                    this.errors = "Please fill the description"
                    return false
                }
            }

            if (this.step == 2) {
                if (this.images.length == 0) {
                    this.errors = "Please select image"
                    return false
                }
            }

            if (this.step == 3) {
                if (!this.dateTime) {
                    this.errors = "Please fill the data and time"
                    return false
                }
            }
            this.step++;
        },
        prevStep() {
            this.step--;
        },
        onFileChange(e) {
            let vm = this;
            var selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {

                this.images.push(selectedFiles[i]);
            }

            for (let i = 0; i < this.images.length; i++) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.$refs.image[i].src = reader.result;
                };

                reader.readAsDataURL(this.images[i]);
            }
        },
        getCategories() {
            axios.get("api/category").then((data) => {
                    this.categories = data.data.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        storeProduct() {

            const formData = new FormData();

            for (let i = 0; i < this.images.length; i++) {
                let file = this.images[i];
                formData.append("image[]", file);
            }

            formData.append("name", this.form.name);
            formData.append("description", this.form.description);
            formData.append("category_id", this.form.category_id);
            formData.append("dateTime", this.form.dateTime);

            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                },
            };


            axios.post("api/product", formData, config).then((data) => {
                    console.log(data);
                    Toast.fire({
                        icon: "success",
                        title: data.data,
                        customClass: {
                            title: "text-capitalize",
                        },
                    });
                    this.resetForm();
                    this.$router.push({
                        name: 'productList'
                    })
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        resetForm() {
            this.images = "",
                this.form.name = "",
                this.form.category_id = "",
                this.form.dateTime = "",
                this.form.description = ""
        }
    },
    mounted() {

        this.getCategories();
    }
}
</script>
