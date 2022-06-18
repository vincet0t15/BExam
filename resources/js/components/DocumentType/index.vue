  <template>
  <!-- Button trigger modal -->
  <div class="row">
    <div class="col-md-9">
      <button
        type="button"
        class="btn btn-primary"
        data-toggle="modal"
        data-target="#AddDocumentModal"
      >
        Add Document Type
      </button>
    </div>
    <div class="col-md-3">
      <input
        class="form-control mb-1"
        type="search"
        placeholder="Search"
        aria-label="Search"
        v-model="search"
      />
    </div>

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Document Type List</h6>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Document Name</th>
                  <th>Document Code</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="document in documents.data" :key="document.id">
                  <td class="text-uppercase">{{ document.document_type }}</td>
                  <td class="text-uppercase">{{ document.document_code }}</td>
                  <td class="text-center">
                    <button
                      type="button"
                      class="btn btn-sm btn-success"
                      data-toggle="modal"
                      data-target="#UpdateOfficeModal"
                      @click="editDocument(document)"
                    >
                      Edit
                    </button>
                    <button
                      type="button"
                      class="btn btn-sm btn-danger ml-2"
                      @click="deleteDocument(document.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
              <Pagination
                :data="documents"
                @pagination-change-page="getDocuments"
                :limit="5"
              />
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Modal -->
  <div
    class="modal fade"
    id="AddDocumentModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-0" id="exampleModalLabel">
            ADD DOCUMENT TYPE
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputUsername1">Document Type</label>
            <input
              type="text"
              class="form-control text-capitalize"
              v-model="form.document_type"
              autocomplete="off"
              placeholder="DOCUMENT NAME"
            />
            <div class="text-danger" v-if="errors && errors.document_type">
              {{ errors.document_type[0] }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Document Code</label>
            <input
              type="text"
              class="form-control text-uppercase"
              v-model="form.document_code"
              placeholder="Document Code"
            />
            <div class="text-danger" v-if="errors && errors.document_code">
              {{ errors.document_code[0] }}
            </div>
          </div>
          <button
            type="submit"
            class="btn btn-primary mr-2"
            @click="storeDocument()"
          >
            Submit
          </button>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>
  <!--End Add Modal -->

  <!-- Update Modal -->
  <div
    class="modal fade"
    id="UpdateOfficeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-0" id="exampleModalLabel">
            UPDATE DOCUMENT
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputUsername1">Document Type</label>
            <input
              type="text"
              class="form-control text-capitalize"
              v-model="form.document_type"
              autocomplete="off"
              placeholder="DOCUMENT NAME"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Document Code</label>
            <input
              type="text"
              class="form-control text-uppercase"
              v-model="form.document_code"
              placeholder="Document Code"
            />
          </div>
          <button
            type="submit"
            class="btn btn-primary mr-2"
            id="btnAddOiffce"
            @click="updateDocument"
          >
            Submit
          </button>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>
  <!-- End Update Modal -->
</template>
<script>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import LaravelVuePagination from "laravel-vue-pagination";
export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  setup() {
    const documents = ref({});
    const search = ref([]);
    const errors = ref([]);
    const documentID = ref([]);
    const form = reactive({
      document_type: "",
      document_code: "",
    });

    const storeDocument = async () => {
      await axios
        .post("api/document-type", form)
        .then(({ data }) => {
          Toast.fire({
            icon: "success",
            title: data.message,
            customClass: {
              title: "text-capitalize",
            },
          });
          $("#AddDocumentModal").modal("hide");
          getDocuments();
          formReset();
        })
        .catch((err) => {
          console.log(err);
        });
    };

    const getDocuments = async (page = 1) => {
      await axios
        .get("api/document-type")
        .then((data) => {
          documents.value = data.data;
          console.log(data);
        })
        .catch((err) => {
          console.log(err);
        });
    };

    const editDocument = (value) => {
      documentID.value = value.id;
      form.document_type = value.document_type;
      form.document_code = value.document_code;
    };
    const formReset = () => {
      documentID.value = null;
      form.document_type = null;
      form.document_code = null;
      errors.value = null;
    };

    onMounted(getDocuments());

    return {
      storeDocument,
      getDocuments,
      editDocument,
      documents,
      form,
      search,
      errors,
    };
  },
};
</script>

