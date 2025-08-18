<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold ps-3" href="#">COFFEE.</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarOffcanvas"
                    aria-controls="sidebarOffcanvas"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <Link class="nav-link" href="#">
                                <span class="side-bar-item-caption"
                                    >Logout</span
                                >
                                <span class="side-bar-item-icon"
                                    ><i class="fa fa-sign-out-alt text-violet"
                                /></span>
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div
                    class="col-md-3 col-lg-2 d-none d-md-block sidebar-container"
                >
                    <div class="sidebar">
                        <h5 class="sidebar-heading">Menu</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{
                                        active: $page.url.startsWith(
                                            '/dashboard'
                                        ),
                                    }"
                                    href="/dashboard"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i
                                            class="fa fa-tachometer-alt text-violet"
                                    /></span>
                                    <span class="side-bar-item-caption"
                                        >Dashboard</span
                                    >
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{
                                        active: $page.url.startsWith(
                                            '/category'
                                        ),
                                    }"
                                    href="/category"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i class="fa fa-th-list text-violet"
                                    /></span>
                                    <span class="side-bar-item-caption"
                                        >Category</span
                                    >
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{
                                        active: $page.url.startsWith(
                                            '/customer'
                                        ),
                                    }"
                                    href="/customer"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i class="fa fa-users text-violet"
                                    /></span>
                                    <span class="side-bar-item-caption"
                                        >Customer</span
                                    >
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{
                                        active: $page.url.startsWith(
                                            '/product'
                                        ),
                                    }"
                                    href="/product"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i class="fa fa-box text-violet"
                                    /></span>
                                    <span class="side-bar-item-caption"
                                        >Product</span
                                    >
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{ active: $page.url === '/sale' }"
                                    href="/sale"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i
                                            class="fa fa-shopping-cart text-violet"
                                    /></span>
                                    <span class="side-bar-item-caption"
                                        >Create Sale</span
                                    >
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{
                                        active: $page.url.startsWith(
                                            '/invoice'
                                        ),
                                    }"
                                    href="/invoice"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i
                                            class="fa fa-file-invoice-dollar text-violet"
                                    /></span>
                                    <span class="side-bar-item-caption"
                                        >Invoice</span
                                    >
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{
                                        active: $page.url === '/sales-report',
                                    }"
                                    href="/sales-report"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i
                                            class="fa fa-file-alt text-violet"
                                        ></i>
                                    </span>
                                    <span class="side-bar-item-caption"
                                        >Sales Report</span
                                    >
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link
                                    class="nav-link"
                                    :class="{
                                        active: $page.url.startsWith(
                                            '/profile'
                                        ),
                                    }"
                                    href="/profile"
                                >
                                    <span class="side-bar-item-icon"
                                        ><i
                                            class="fa fa-user-circle text-violet"
                                    /></span>
                                    <span class="side-bar-item-caption"
                                        >Profile</span
                                    >
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                    <slot />
                </main>
            </div>
        </div>

        <div
            class="offcanvas offcanvas-start bg-white border-left"
            tabindex="-1"
            id="sidebarOffcanvas"
            aria-labelledby="sidebarOffcanvasLabel"
        >
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Menu</h5>
                <button
                    type="button"
                    class="btn-close text-reset"
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <Link
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/dashboard'),
                            }"
                            href="/dashboard"
                        >
                            <span class="side-bar-item-icon"
                                ><i class="fa fa-tachometer-alt text-violet"
                            /></span>
                            <span class="side-bar-item-caption">Dashboard</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/category'),
                            }"
                            href="/category"
                        >
                            <span class="side-bar-item-icon"
                                ><i class="fa fa-th-list text-violet"
                            /></span>
                            <span class="side-bar-item-caption">Category</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/customer'),
                            }"
                            href="/customer"
                        >
                            <span class="side-bar-item-icon"
                                ><i class="fa fa-users text-violet"
                            /></span>
                            <span class="side-bar-item-caption">Customer</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/product'),
                            }"
                            href="/product"
                        >
                            <span class="side-bar-item-icon"
                                ><i class="fa fa-box text-violet"
                            /></span>
                            <span class="side-bar-item-caption">Product</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/sale'),
                            }"
                            href="/sale"
                        >
                            <span class="side-bar-item-icon"
                                ><i class="fa fa-shopping-cart text-violet"
                            /></span>
                            <span class="side-bar-item-caption"
                                >Create Sale</span
                            >
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/invoice'),
                            }"
                            href="/invoice"
                        >
                            <span class="side-bar-item-icon"
                                ><i
                                    class="fa fa-file-invoice-dollar text-violet"
                            /></span>
                            <span class="side-bar-item-caption">Invoice</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/profile'),
                            }"
                            href="/profile"
                        >
                            <span class="side-bar-item-icon"
                                ><i class="fa fa-user-circle text-violet"
                            /></span>
                            <span class="side-bar-item-caption">Profile</span>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link" href="#">
                            <span class="side-bar-item-icon"
                                ><i class="fa fa-sign-out-alt text-violet"
                            /></span>
                            <span class="side-bar-item-caption">Logout</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style scoped>
.sidebar-container {
    height: 100vh;
    position: sticky;
    top: 0;
    background-color: #f8f9fa;
    padding-top: 1rem;
    overflow-y: auto;
    border: 1px solid #dcdcdc;
}

.sidebar {
    height: 100%;
}

.sidebar-heading {
    font-size: 1.25rem;
    padding: 0 1rem;
    margin-bottom: 0.5rem;
}

.nav-link.active {
    background-color: #e9ecef;
    border-radius: 0.25rem;
}
</style>
