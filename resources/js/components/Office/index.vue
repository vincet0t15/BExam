<template>
  <!-- Button trigger modal -->
  <div class="row">
    <div class="col-md-9">
      <button
        type="button"
        class="btn btn-primary"
        data-toggle="modal"
        data-target="#AddOfficeModal"
      >
        Add Office/Department
      </button>
    </div>
    <div class="col-md-3">
      <input
        class="form-control mb-1"
        type="search"
        placeholder="Search"
        aria-label="Search"
        v-model="search"
        @keyup="getOffices"
      />
    </div>

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Office List</h6>
          <div class="table-responsive">
            <table id="OfficeTable" class="table">
              <thead>
                <tr>
                  <th>Office Name</th>
                  <th>Office Code</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="office in offices.data" :key="office.id">
                  <td class="text-uppercase">{{ office.office_name }}</td>
                  <td class="text-uppercase">{{ office.office_code }}</td>
                  <td class="text-center">
                    <button
                      type="button"
                      class="btn btn-sm btn-success"
                      data-toggle="modal"
                      data-target="#UpdateOfficeModal"
                      @click="editOffice(office)"
                    >
                      Edit
                    </button>
                    <button
                      type="button"
                      class="btn btn-sm btn-danger ml-2"
                      @click="deleteOffice(office.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
              <Pagination
                :data="offices"
                @pagination-change-page="getOffices"
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
    id="AddOfficeModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-0" id="exampleModalLabel">
            ADD OFFICE/DEPARTMENT
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
            <label for="exampleInputUsername1">Office Name</label>
            <input
              type="text"
              class="form-control text-capitalize"
              v-model="form.office_name"
              autocomplete="off"
              placeholder="OFFICE NAME"
            />
            <div class="text-danger" v-if="errors && errors.office_name">
              {{ errors.office_name[0] }}
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Office Code</label>
            <input
              type="text"
              class="form-control text-uppercase"
              v-model="form.office_code"
              placeholder="Office Code"
            />
            <div class="text-danger" v-if="errors && errors.office_code">
              {{ errors.office_code[0] }}
            </div>
          </div>
          <button
            type="submit"
            class="btn btn-primary mr-2"
            @click="storeOffice()"
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
            UPDATE OFFICE/DEPARTMENT
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
            <label for="exampleInputUsername1">Office Name</label>
            <input
              type="text"
              class="form-control text-capitalize"
              v-model="form.office_name"
              autocomplete="off"
              placeholder="OFFICE NAME"
            />
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Office Code</label>
            <input
              type="text"
              class="form-control text-uppercase"
              v-model="form.office_code"
              placeholder="Office Code"
            />
          </div>
          <button
            type="submit"
            class="btn btn-primary mr-2"
            id="btnAddOiffce"
            @click="updateOffice"
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
import { reactive, ref, onMounted } from "vue";
import axios from "axios";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  components: {
    Pagination: LaravelVuePagination,
  },
  setup() {
    const offices = ref({});
    const office_id = ref([]);
    const errors = ref([]);
    const search = ref([]);
    const form = reactive({
      office_name: "",
      office_code: "",
    });

    const getUser = async () => {
      let res = await axios.get("api/user");
    };

    //get all offices
    const getOffices = async (page = 1) => {
      let res = await axios.get(
        "api/office?page=" + page + "&search=" + search.value
      );
      offices.value = res.data;
    };
    //end get all offices

    //store Office
    const storeOffice = async () => {
      try {
        await axios.post("api/office", form).then((response) => {
          Toast.fire({
            icon: "success",
            title: response.data.message,
            customClass: {
              title: "text-capitalize",
            },
          });
          $("#AddOfficeModal").modal("hide");
          getOffices();
          resetForm();
        });
      } catch (error) {
        errors.value = error.response.data.errors;
      }
    };
    //End store Office

    //delete Office
    const deleteOffice = async (id) => {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          try {
            axios.delete("api/office/" + id).then((response) => {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              getOffices();
            });
          } catch (error) {
            Swal.fire("Error!", "Someting went wrong.", "error");
          }
        }
      });
    };
    //End delete Office

    //open modal for Update Office
    const editOffice = (office) => {
      office_id.value = office.id;
      form.office_name = office.office_name;
      form.office_code = office.office_code;
    };
    //end open modal for Update Office

    //update Office
    const updateOffice = async () => {
      try {
        await axios
          .patch("api/office/" + office_id.value, form)
          .then((response) => {
            Toast.fire({
              icon: "success",
              title: response.data.message,
            });
            $("#UpdateOfficeModal").modal("hide");
            getOffices();
            resetForm();
          });
      } catch (error) {
        //
      }
    };
    //end update Office

    //reset form
    const resetForm = () => {
      office_id.value = null;
      form.office_name = null;
      form.office_code = null;
      errors.value = null;
    };
    //end reset form

    const document = async () => {
      let res = await axios.get("api/document");
      console.log(res.data);
    };
    onMounted(getOffices(), getUser(), document());

    return {
      offices,
      form,
      errors,
      search,
      storeOffice,
      resetForm,
      deleteOffice,
      editOffice,
      updateOffice,
      getOffices,
    };
  },
};
</script>
