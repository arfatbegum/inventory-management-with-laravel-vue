
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-100 p-4 shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center">SET NEW PASSWORD</h4>
                        <br/>
                        <label>New Password</label>
                        <input id="password" placeholder="New Password" class="form-control" type="password"/>
                        <br/>
                        <label>Confirm Password</label>
                        <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                        <br/>
                        <Link href="/login" class="btn w-100 text-white bg-primary">Reset Password</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { Link } from '@inertiajs/vue3'
</script>
