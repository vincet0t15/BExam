<template>
<div class="right_col" role="main">
    <div class="">
        <form action="">
            <h2><span class="text-danger" v-for="error in errors">{{error}} </span></h2>

            <section v-if="step === 1">
                <h3>Step 1</h3>

                <div class="col-lg">
                    <input type="text" class="form-control" v-model="products.name" placeholder="Enter Product name">
                </div>

                <div class="col-lg mt-2">
                    <select class="form-control" required v-model="products.category_id" @change="selectedCategory">
                        <option value="" selected disabled>Select category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id" :selected="category.id == 5">
                            {{ category.category }}
                        </option>
                    </select>
                </div>

                <div class="col-lg mt-2">
                    <textarea class="form-control" v-model="products.description"></textarea>
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
                            <img :src="image.path" class="card-img-top" alt="...." />
                            <button class="btn btn-danger btn-sm" @click.prevent="removeImage(image.id)">Remove</button>
                        </div>
                    </div>

                    <div class="col-lg-4" v-for="(newimage, key) in newImage" :key="key">
                        <div class="card">
                            <img src="preview" class="card-img-top" alt="...." :ref="'image'" />
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg" v-if="step === 3">
                <h3>Step 3</h3>
                <input type="date" v-model="products.dateTime" class="form-control" />
            </section>

            <div class="row">
                <div class="ml-4 mt-2" v-if="step != 1">
                    <button class="btn btn-primary" @click.prevent="prevStep">Previous</button>
                </div>

                <div class="ml-4 mt-2" v-if="step != totalSteps">
                    <button class="btn btn-primary" @click.prevent="nextStep">Next</button>
                </div>

                <div class="ml-4 mt-2" v-if="step == 3">
                    <button class="btn btn-primary" @click.prevent="updateProduct">Save</button>
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
            newImage: [],
            images: [],
            errors: [],
            step: 1,
            totalSteps: 3,
            categories: {},
            // products: {},
            products: {
                name: "",
                category_id: "",
                description: "",
                dateTime: ""
            }
        }
    },
    created() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios.get("/api/product/" + this.$route.params.id)
                .then((response) => {
                    this.images = response.data[0].image;
                    this.products.name = response.data[0].name;
                    this.products.category_id = response.data[0].category_id;
                    this.products.description = response.data[0].description;
                    this.products.dateTime = response.data[0].dateTime;
                });
        },
        removeImage(id) {
            Swal.fire({
                title: "Are you sure you want to remove this image?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        axios.delete("/api/image/" + id).then((response) => {
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
        },
        onFileChange(e) {
            let vm = this;
            var selectedFiles = e.target.files;
            for (let i = 0; i < selectedFiles.length; i++) {

                this.newImage.push(selectedFiles[i]);
            }

            for (let i = 0; i < this.newImage.length; i++) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.$refs.image[i].src = reader.result;
                };

                reader.readAsDataURL(this.newImage[i]);
            }
        },
        nextStep() {
            this.errors = [];
            if (this.step == 1) {
                if (!this.products.name) {
                    this.errors = "Please fill the product name"
                    return false
                }

                if (!this.products.category_id) {
                    this.errors = "Please select category"
                    return false
                }

                if (!this.products.description) {
                    this.errors = "Please fill the description"
                    return false
                }
            }

            if (this.step == 2) {
                // if (this.new.length == 0) {
                //     this.errors = "Please select image"
                //     return false
                // }
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
        getCategories() {
            axios.get("/api/category").then((data) => {
                    this.categories = data.data.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        updateProduct() {

            const formData = new FormData();

            formData.append("_method", "PUT");

            for (let i = 0; i < this.newImage.length; i++) {
                let file = this.newImage[i];
                formData.append("image[]", file);
            }

            formData.append("name", this.products.name);
            formData.append("description", this.products.description);
            formData.append("category_id", this.products.category_id);
            formData.append("dateTime", this.products.dateTime);

            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                },
            };

            axios.post("/api/product/" + this.$route.params.id, formData).then((data) => {
                    console.log(data);
                    Toast.fire({
                        icon: "success",
                        title: data.data,
                        customClass: {
                            title: "text-capitalize",
                        },
                    });
                    this.$router.push({
                        name: 'productList'
                    })
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        selectedCategory(value) {
            // console.log(this.form.category_id)
        },
        getProduct() {
            axios.get("/api/product/" + this.$route.params.id).then((response) => {
                    this.products = response.data.data['id'];
                    console.log(this.products);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        resetForm() {
            this.form.name = "",
                this.form.category_id = "",
                this.form.description = ""
        }
    },
    mounted() {

        this.getCategories();
        // this.getProduct();
    }
}
</script>
