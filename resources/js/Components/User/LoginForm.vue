<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
                <div class="card w-100 p-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center">SIGN IN</h4>
                        <br/>
                        <input id="email" placeholder="User Email" class="form-control" type="email"/>
                        <br/>
                        <input id="password" placeholder="User Password" class="form-control" type="password"/>
                        <br/>
                        <Link href="/DashboardPage"  class="btn w-100 bg-primary text-white">Login</Link>
                        <div class="float-end mt-3 text-secondary">
                        <span>
                            <Link class="text-center h6" href="/registration">Sign Up </Link>
                            <span class="mx-2">|</span>
                            <Link class="text-center h6" href="/send-otp">Forget Password</Link>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { Link } from '@inertiajs/vue3'
</script>
