<template>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a><i class="fa fa-home"></i> User Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li>
                        <router-link :to="{ name: 'Roles'}">Roles</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'Users'}">Users</router-link>
                    </li>
                </ul>
            </li>
            <li><a><i class="fa fa-edit"></i> Expense Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><router-link :to="{name: 'ExpenseCategory'}">Expense Categories</router-link></li>
                    <li><router-link :to="{name:'Expenses'}">Expenses</router-link></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</template>
