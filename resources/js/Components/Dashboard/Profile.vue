<template>
    <div class="container-fluid">
        <div class="col-4 shadow-sm">
            <div class="card animated fadeIn">
                <form @submit.prevent="submit">
                    <div class="card-body">
                        <h4>Profile Update</h4>
                        <hr />
                        <div class="container-fluid m-0 p-0">
                            <div class="row m-0 p-0">
                                <div class="p-2">
                                    <label>Name</label>
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        placeholder="First Name"
                                        class="form-control"
                                        type="text"
                                    />
                                </div>

                                <div class="p-2">
                                    <label>Email Address</label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        placeholder="User Email"
                                        class="form-control"
                                        type="email"
                                    />
                                </div>

                                <div class="p-2">
                                    <label>Mobile Number</label>
                                    <input
                                        id="mobile"
                                        v-model="form.mobile"
                                        placeholder="Mobile"
                                        class="form-control"
                                        type="mobile"
                                    />
                                </div>
                                <div class="p-2">
                                    <label>Password</label>
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        placeholder="User Password"
                                        class="form-control"
                                        type="password"
                                    />
                                </div>
                            </div>
                            <div class="row m-0 p-0">
                                <div class="col-md-4 p-2">
                                    <button
                                        type="submit"
                                        class="btn mt-3 w-100 bg-primary text-white"
                                    >
                                        Update
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
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

// Initialize form safely
const form = useForm({
    email: page.props.list?.email || "",
    name: page.props.list?.name || "",
    mobile: page.props.list?.mobile || "",
    password: "",
});

function submit() {
    if (!form.email) {
        alert("Email Required");
        return;
    }
    if (!form.name) {
        alert("Name Required");
        return;
    }
    if (!form.mobile) {
        alert("Mobile Required");
        return;
    }
    if (!form.password) {
        alert("Password Required");
        return;
    }

    form.post("/user-update", {
        onSuccess: () => {
            alert(page.props.flash.message || "Profile updated");
        },
    });
}
</script>
