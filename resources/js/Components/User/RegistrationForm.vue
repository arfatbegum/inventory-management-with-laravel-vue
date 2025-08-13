<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5 center-screen">
                <div class="card animated fadeIn w-100 p-3 shadow-sm">
                    <form @submit.prevent="submit">
                        <div class="card-body">
                            <h4 class="text-center mb-2">Sign Up</h4>
                            <div class="container-fluid m-0 p-0">
                                <div class="p-2 mb-1">
                                    <label>Name</label>
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        placeholder="Enter Your Name"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.name,
                                        }"
                                        type="text"
                                    />
                                    <div
                                        v-if="form.errors.name"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.name }}
                                    </div>
                                </div>
                                <div class="p-2 mb-1">
                                    <label>Email Address</label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        placeholder="Enter Email"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.email,
                                        }"
                                        type="email"
                                    />
                                    <div
                                        v-if="form.errors.email"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.email }}
                                    </div>
                                </div>
                                <div class="p-2 mb-1">
                                    <label>Mobile Number</label>
                                    <input
                                        id="mobile"
                                        v-model="form.mobile"
                                        placeholder="Enter Mobile Number"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.mobile,
                                        }"
                                        type="tel"
                                    />
                                    <div
                                        v-if="form.errors.mobile"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.mobile }}
                                    </div>
                                </div>
                                <div class="p-2 mb-1">
                                    <label>Password</label>
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        placeholder="Enter Password"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': form.errors.password,
                                        }"
                                        type="password"
                                    />
                                    <div
                                        v-if="form.errors.password"
                                        class="invalid-feedback"
                                    >
                                        {{ form.errors.password }}
                                    </div>
                                </div>
                                <div class="p-2">
                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="btn mt-3 w-100 bg-primary text-white"
                                    >
                                        Registration
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="mt-3 text-center">
                        Already have an account?
                        <Link href="/login" class="text-violet">Login</Link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, router, Link } from "@inertiajs/vue3";
import { getCurrentInstance } from "vue";
import { usePage } from "@inertiajs/vue3";
const page = usePage();
const { proxy } = getCurrentInstance();
const toaster = proxy.$toast;

const form = useForm({
    name: "",
    email: "",
    mobile: "",
    password: "",
});

// Simple client-side validation
function validate() {
    form.errors = {};
    let valid = true;

    if (!form.name) {
        form.errors.name = "Name is required";
        valid = false;
    }
    if (!form.email) {
        form.errors.email = "Email is required";
        valid = false;
    } else if (!/\S+@\S+\.\S+/.test(form.email)) {
        form.errors.email = "Email is invalid";
        valid = false;
    }
    if (!form.mobile) {
        form.errors.mobile = "Mobile number is required";
        valid = false;
    }
    if (!form.password) {
        form.errors.password = "Password is required";
        valid = false;
    } else if (form.password.length < 6) {
        form.errors.password = "Password must be at least 6 characters";
        valid = false;
    }

    return valid;
}

function submit() {
    if (!validate()) {
        toaster.error(
            "Please correct the validation errors before submitting."
        );
        return;
    } else {
        form.post("/user-registration", {
            onSuccess: () => {
                if (page.props.flash.status === true) {
                    toaster.success(page.props.flash.message);
                    router.get("/login");
                } else {
                    toaster.error(page.props.flash.message);
                }
            },
            onError: (errors) => {
                if (Object.keys(errors).length > 0) {
                    toaster.error(
                        "Please correct the validation errors below."
                    );
                }
            },
        });
    }
}
</script>
