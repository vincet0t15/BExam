<template>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
             <li><a><i class="fa fa-home"></i> Categories <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li>
                        <router-link :to="{ name: 'CategoryList'}">Category List</router-link>
                        <router-link :to="{ name: 'createCategory'}">Add Category</router-link>
                    </li>
                </ul>
            </li>
             <li><a><i class="fa fa-home"></i> Products <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li>
                        <router-link :to="{ name: 'productList'}">Products List</router-link>
                        <router-link :to="{ name: 'createProduct'}">Add Products</router-link>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</template>
