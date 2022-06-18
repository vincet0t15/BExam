<template>
  <div class="email-head">
    <div class="email-head-title d-flex align-items-center">
      <span data-feather="edit" class="icon-md mr-2"></span>
      New message
    </div>
  </div>

  <div class="email-compose-fields">
    <div class="to">
      <div class="form-group row py-0">
        <label class="col-md-2 control-label">To:</label>
        <div class="col-md-10">
          <div class="form-group">
            <select
              class="js-example-basic-single w-100"
              v-model="form.distination"
              @change="selectedDistination"
            >
              <option
                v-for="office in offices"
                :key="office.id"
                :value="office.id"
              >
                {{ office.office_name }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="documentType">
      <div class="form-group row py-0">
        <label class="col-md-2 control-label">Document type:</label>
        <div class="col-md-10">
          <div class="form-group">
            <select
              class="js-example-basic-single w-100"
              required
              v-model="form.documentType"
              @change="selectedDocumentType"
            >
              <option
                v-for="documentType in documentTypes"
                :key="documentType.id"
                :value="documentType.id"
              >
                {{ documentType.document_type }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="subject">
      <div class="form-group row py-0">
        <label class="col-md-2 control-label">Subject</label>
        <div class="col-md-10">
          <input
            class="form-control"
            type="text"
            required
            v-model="form.subject"
          />
        </div>
      </div>
    </div>

    <div class="status mt-3">
      <div class="form-group row py-0">
        <label class="col-md-2 control-label">Status</label>
        <div class="col-md-10">
          <input class="form-control" type="text" v-model="form.status" />
        </div>
      </div>
    </div>
  </div>
  <div class="email editor">
    <div class="col-md-12">
      <div class="form-group row">
        <label class="col-md-12 control-label">Description/Remark</label>
        <div class="col-md-12">
          <textarea
            class="form-control"
            v-model="form.description"
            rows="10"
          ></textarea>
        </div>
      </div>
      <input type="file" v-on:change="onChange" multiple class="border" />
    </div>
    <div class="email action-send">
      <div class="col-md-12">
        <div class="form-group mb-0">
          <button class="btn btn-primary btn-space" @click="storeDocument">
            <i class="icon s7-mail"></i> Send
          </button>
          <button class="btn btn-secondary btn-space" type="button">
            <i class="icon s7-close"></i> Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
export default {
  setup() {
    const offices = ref([]);
    const documentTypes = ref([]);

    const form = reactive({
      file: [],
      distination: "",
      documentType: "",
      subject: "",
      status: "",
      description: "",
    });

    const onChange = (e) => {
      let selected_attachment = e.target.files;

      for (let i = 0; i < selected_attachment.length; i++) {
        form.file.push(selected_attachment[i]);
      }
    };
    const getOffices = async () => {
      try {
        axios
          .get("/api/getoffice")
          .then((result) => {
            offices.value = result.data;
            console.log(result);
          })
          .catch((err) => {
            console.log(err);
          });
      } catch (error) {
        console.log(error);
      }
    };

    const getDocumentTypes = async () => {
      try {
        axios
          .get("/api/get-document-type")
          .then((result) => {
            documentTypes.value = result.data;
          })
          .catch((err) => {
            console.log(err);
          });
      } catch (error) {
        console.log(error);
      }
    };

    const selectedDistination = () => {
      console.log(form.distination);
    };

    const selectedDocumentType = () => {
      console.log(form.documentType);
    };

    const storeDocument = async () => {
      const formData = new FormData();

      for (let i = 0; i < form.file.length; i++) {
        let file = form.file[i];
        formData.append("image[]", file);
      }

      formData.append("distination", form.distination);
      formData.append("documentType", form.documentType);
      formData.append("subject", form.subject);
      formData.append("description", form.description);

      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      try {
        await axios
          .post("/api/document", formData, config)
          .then((result) => {
            Toast.fire({
              icon: "success",
              title: result.data.message,
            });
          })
          .catch((err) => {
            console.log(err);
          });
      } catch (error) {
        console.log(error);
      }
    };

    onMounted(getOffices(), getDocumentTypes());

    return {
      selectedDistination,
      selectedDocumentType,
      storeDocument,
      onChange,
      offices,
      documentTypes,
      form,
    };
  },
};
</script>
