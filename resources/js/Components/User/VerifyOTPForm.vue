<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6 center-screen">
                <div class="card animated fadeIn w-100 shadow-sm p-4">
                    <div class="card-body">
                        <h4 class="text-center">ENTER OTP CODE</h4>
                        <br/>
                        <label>4 Digit Code Here</label>
                        <input id="otp" placeholder="Code" class="form-control" type="text"/>
                        <br/>
                        <Link href="/reset-password"  class="btn w-100 text-white bg-primary">Next</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>



<script setup>
import { Link } from '@inertiajs/vue3'
</script>


