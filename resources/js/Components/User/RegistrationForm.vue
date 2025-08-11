<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-100 p-3 shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center mb-2">Sign Up</h4>
                        <div class="container-fluid m-0 p-0">
                            <div class="p-2 mb-1">
                                <label>Name</label>
                                <input
                                    id="firstName"
                                    placeholder="Enter Your Name"
                                    class="form-control"
                                    type="text"
                                />
                            </div>
                            <div class="p-2 mb-1">
                                <label>Email Address</label>
                                <input
                                    id="email"
                                    placeholder="Enter Email"
                                    class="form-control"
                                    type="email"
                                />
                            </div>
                            <div class="p-2 mb-1">
                                <label>Mobile Number</label>
                                <input
                                    id="mobile"
                                    placeholder="Enter Mobile Number"
                                    class="form-control"
                                    type="mobile"
                                />
                            </div>
                            <div class="p-2 mb-1">
                                <label>Password</label>
                                <input
                                    id="password"
                                    placeholder="Enter Password"
                                    class="form-control"
                                    type="password"
                                />
                            </div>
                            <div class="p-2">
                                <Link
                                    href="/login"
                                    class="btn mt-3 w-100 bg-primary text-white"
                                >
                                    Registration</Link
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
