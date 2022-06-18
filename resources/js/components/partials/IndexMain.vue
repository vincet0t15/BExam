<template>
   <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <router-link :to="{ name: 'Dashboard'}" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></router-link>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="row">
              <div class="profile_pic">
                <img :src="'images/img.jpg'" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                 <h2 class="text-capitalize">{{user.name}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <sidebar_></sidebar_>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!-- <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <topnav_></topnav_>
        <!-- /top navigation -->

        <!-- page content -->
        <router-view></router-view>
        <!-- /page content -->

        <!-- footer content -->
        <footer_></footer_>
        <!-- /footer content -->
</template>
<script>
import sidebar_ from "./_sidebar.vue";
import topnav_ from "./_topnav.vue";
import footer_ from "./_footer.vue";
import { reactive, ref, onMounted } from "vue";
import axios from "axios";
export default {
  components: {
    sidebar_,
    footer_,
    topnav_,
  },
  setup() {
    const userLogin = ref({});
    const token = localStorage.getItem("token");
    const user = ref({});
    const getUserLogin = async () => {
      axios
        .get("api/user", { withCredentials: true })
        .then((result) => {
          user.value = result.data;
        })
        .catch((err) => {
          console.log(err);
        });
    };
    axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    onMounted(getUserLogin);
    return {
      userLogin,
      user
    };
  },
};
</script>
