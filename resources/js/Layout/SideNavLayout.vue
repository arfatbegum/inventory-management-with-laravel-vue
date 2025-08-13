<template>
    <div>
        <nav id="topNav" class="navbar fixed-top shadow-sm top-navbar">
            <div class="container-fluid">
                <a id="MenuBar" @click="NavOpenClose" class="icon-nav mx-0 my-1 h5">
                    <i class="fa text-violet fa-bars"></i>
                </a>
            </div>
        </nav>
        <div id="sideNav" class="side-nav-open bg-white text-black" >
            <div class="side-nav-top text-center mt-3">
                <h3>Coffee.</h3>
            </div>

            <Link href="/dashboard" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-tachometer-alt text-violet"/></span>
                <span class="side-bar-item-caption">Dashboard</span>
            </Link>

            <Link href="/category" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-th-list text-violet"/></span>
                <span class="side-bar-item-caption">Category</span>
            </Link>

            <Link href="/customer" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-users text-violet"/></span>
                <span class="side-bar-item-caption">Customer</span>
            </Link>

            <Link href="/product" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-box text-violet"/></span>
                <span class="side-bar-item-caption">Product</span>
            </Link>

            <Link href="/sale" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-shopping-cart text-violet"/></span>
                <span class="side-bar-item-caption">Create Sale</span>
            </Link>

            <Link href="/invoice" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-file-invoice-dollar text-violet"/></span>
                <span class="side-bar-item-caption">Invoice</span>
            </Link>

            <Link href="/profile" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-user-circle text-violet"/></span>
                <span class="side-bar-item-caption">Profile</span>
            </Link>

            <Link href="/" class="side-bar-item">
                <span class="side-bar-item-icon"><i class="fa fa-sign-out-alt text-violet"/></span>
                <span class="side-bar-item-caption">Logout</span>
            </Link>





        </div>
        <div id="content" class="content">
            <div class="container-fluid">
                <main>
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>


<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
</style>
