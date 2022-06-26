<template>
<div class="right_col" role="main">
    <div class="">
        <input type="file" multiple accept="image/jpeg" @change="onFileChange" />

        
      <div class="text-center" v-for="(image, key) in images" :key="key">
  <img src="preview" class="img-circle" :ref="'image'">
</div>
    </div>
</div>
</template>

<script>

export default {
    data() {
        return {
            images: [],
            form: {
                file: [],
            }
        }
    },
    methods: {
        deleteEvent(event) {
            this.images.splice(event, 1);
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
        }
    }
}
</script>
