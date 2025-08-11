
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-100 shadow-sm p-4">
                    <div class="card-body">
                        <h4 class="text-center">EMAIL ADDRESS</h4>
                        <br/>
                        <label>Enter Your Email Address</label>
                        <input id="email" placeholder="Email" class="form-control" type="email"/>
                        <br/>
                        <Link href="/verify-otp" class="btn w-100 bg-primary text-white">Verify</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script setup>
import { Link } from '@inertiajs/vue3'
</script>


