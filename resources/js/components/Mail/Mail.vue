<template>
  <div class="row inbox-wrapper">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-3 email-aside border-lg-right">
              <div class="aside-content">
                <div class="aside-header">
                  <button
                    class="navbar-toggle"
                    data-target=".aside-nav"
                    data-toggle="collapse"
                    type="button"
                  >
                    <span class="icon"
                      ><i data-feather="chevron-down"></i
                    ></span>
                  </button>
                  <span class="title text-muted font-weight-bold"
                    >Mail Service</span
                  >
                  <p class="text-muted">amiahburton@gmail.com</p>
                </div>
                <div class="aside-compose">
                  <router-link
                    class="btn btn-primary btn-block"
                    :to="{ name: 'Compose' }"
                    >Compose Email</router-link
                  >
                </div>
                <div class="aside-nav collapse">
                  <ul class="nav">
                    <li>
                      <router-link :to="{ name: 'Inbox' }"
                        ><span class="icon"><i data-feather="inbox"></i></span
                        >Inbox<span
                          class="
                            badge badge-danger-muted
                            text-white
                            font-weight-bold
                            float-right
                          "
                          >2</span
                        ></router-link
                      >
                    </li>
                    <li class="active">
                      <a href="#"
                        ><span class="icon"><i data-feather="mail"></i></span
                        >Sent Mail</a
                      >
                    </li>
                    <li>
                      <a href="#"
                        ><span class="icon"
                          ><i data-feather="briefcase"></i></span
                        >Important<span
                          class="
                            badge badge-info-muted
                            text-white
                            font-weight-bold
                            float-right
                          "
                          >4</span
                        ></a
                      >
                    </li>
                    <li>
                      <a href="#"
                        ><span class="icon"><i data-feather="file"></i></span
                        >Drafts</a
                      >
                    </li>
                    <li>
                      <a href="#"
                        ><span class="icon"><i data-feather="star"></i></span
                        >Tags</a
                      >
                    </li>
                    <li>
                      <a href="#"
                        ><span class="icon"><i data-feather="trash"></i></span
                        >Trash</a
                      >
                    </li>
                  </ul>
                  <span class="title">Labels</span>
                  <ul class="nav nav-pills nav-stacked">
                    <li>
                      <a href="#"
                        ><i data-feather="tag" class="text-warning"></i>
                        Important
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i data-feather="tag" class="text-primary"></i>
                        Business
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i data-feather="tag" class="text-info"></i>
                        Inspiration
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-9 email-content">
              <router-view></router-view>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
