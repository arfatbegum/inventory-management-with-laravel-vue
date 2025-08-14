<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                                <h5 class="fw-semibold mb-3">Category List</h5>
                        <!-- Search + Create -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <input 
                                placeholder="Search..."
                                class="form-control form-control-sm w-auto"
                                type="text"
                                v-model="searchValue"
                            />
                            <Link 
                                class="btn bg-primary text-white"
                                href="/create-and-update-category?id=0"
                            >
                                Create New
                            </Link>
                        </div>

                        <!-- Data Table -->
                        <EasyDataTable
                            buttons-pagination
                            alternating
                            :headers="headers"
                            :items="items"
                            :rows-per-page="10"
                            :search-field="searchField"
                            :search-value="searchValue"
                            border-cell
                        >
                            <template #item-number="{ id }">
                                <Link 
                                    class=" me-2"
                                    :href="`/create-and-update-category?id=${id}`"
                                >
                                    <i class="fa fa-edit text-violet"></i>
                                </Link>
                                <button 
                                    class="border-0 bg-transparent"
                                    @click="deleteCategory(id)"
                                >
                                    <i class="fa fa-trash text-danger"></i>
                                </button>
                            </template>
                        </EasyDataTable>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router, Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { createToaster } from "@meforma/vue-toaster";
import Swal from "sweetalert2";
const toaster = createToaster();
const page = usePage();

// Table Headers
const headers = [
    { text: "No", value: "id" },
    { text: "Name", value: "name" },
    { text: "Action", value: "number" },
];

// Search fields and values
const searchField = ["name"];
const searchValue = ref("");

// Table data
const items = ref(Array.isArray(page.props.list) ? page.props.list : []);

// Flash messages
if (page.props.flash?.status === true) {
    toaster.success(page.props.flash.message);
} else if (page.props.flash?.status === false) {
    toaster.warning(page.props.flash.message);
}

// Delete category with instant UI update
const deleteCategory = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to permanently delete this category.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#8e4dff",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/delete-category/${id}`, {
                onSuccess: () => {
                    items.value = items.value.filter(item => item.id !== id);
                    Swal.fire("Deleted!", "The category has been removed.", "success");
                },
                onError: () => {
                    Swal.fire("Error!", "Failed to delete category.", "error");
                }
            });
        }
    });
};
</script>
