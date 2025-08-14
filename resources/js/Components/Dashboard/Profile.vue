<template>
    <div class="container-fluid">
        <div class="col-12 col-md-10 col-lg-6 shadow-sm">
            <div class="card animated fadeIn">
                <form @submit.prevent="submit">
                    <div class="card-body">
                        <h4>Profile Update</h4>
                        <hr />
                        <div class="container-fluid m-0 p-0">
                            <div class="row m-0 p-0">
                                <!-- Name -->
                                <div class="p-2">
                                    <label for="name">Name</label>
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        placeholder="First Name"
                                        class="form-control"
                                        type="text"
                                    />
                                    <small v-if="errors.name" class="text-danger">{{ errors.name }}</small>
                                </div>

                                <!-- Email -->
                                <div class="p-2">
                                    <label for="email">Email Address</label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        placeholder="User Email"
                                        class="form-control"
                                        type="email"
                                    />
                                    <small v-if="errors.email" class="text-danger">{{ errors.email }}</small>
                                </div>

                                <!-- Mobile -->
                                <div class="p-2">
                                    <label for="mobile">Mobile Number</label>
                                    <input
                                        id="mobile"
                                        v-model="form.mobile"
                                        placeholder="Mobile"
                                        class="form-control"
                                        type="text"
                                    />
                                    <small v-if="errors.mobile" class="text-danger">{{ errors.mobile }}</small>
                                </div>

                                <!-- Password -->
                                <div class="p-2">
                                    <label for="password">Password</label>
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        placeholder="User Password"
                                        class="form-control"
                                        type="password"
                                    />
                                    <small v-if="errors.password" class="text-danger">{{ errors.password }}</small>
                                </div>
                            </div>

                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <button
                                        type="submit"
                                        class="btn mt-3 w-100 bg-primary text-white"
                                        :disabled="form.processing"
                                    >
                                        <span v-if="form.processing">Updating...</span>
                                        <span v-else>Update</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { getCurrentInstance, ref } from 'vue'
const { proxy } = getCurrentInstance()
const toaster = proxy.$toast
const page = usePage();

const form = useForm({
    name: page.props.list?.name || "",
    email: page.props.list?.email || "",
    mobile: page.props.list?.mobile || "",
    password: "",
});

const errors = ref({
    name: "",
    email: "",
    mobile: "",
    password: "",
});

function validate() {
    let valid = true;
    errors.name = errors.email = errors.mobile = errors.password = "";

    if (!form.name.trim()) {
        errors.name = "Name is required";
        valid = false;
    }
    if (!form.email.trim()) {
        errors.email = "Email is required";
        valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        errors.email = "Invalid email format";
        valid = false;
    }
    if (!form.mobile.trim()) {
        errors.mobile = "Mobile number is required";
        valid = false;
    }
    if (!form.password.trim()) {
        errors.password = "Password is required";
        valid = false;
    }

    return valid;
}

function submit() {
    if (!validate()) {
        toaster.error("Please fix the validation errors before submitting.");
        return;
    }

    form.post("/update-profile", {
        onSuccess: () => {
            toaster.success(page.props.flash?.message || "Profile updated successfully!");
            form.reset("password");
        },
        onError: () => {
            toaster.error("Something went wrong. Please try again.");
        },
    });
}
</script>
