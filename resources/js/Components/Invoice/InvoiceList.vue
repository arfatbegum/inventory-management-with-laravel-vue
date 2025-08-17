<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Invoice List</h5>
                        <div>
                            <div
                                class="d-flex justify-content-between align-items-center mb-2"
                            >
                                <input
                                    placeholder="Search..."
                                    class="form-control mb-2 w-auto form-control-sm"
                                    type="text"
                                    v-model="searchValue"
                                />
                                <Link
                                    class="btn btn-sm bg-primary text-white"
                                    href="/sale"
                                >
                                    Create New
                                </Link>
                            </div>
                            <EasyDataTable
                                buttons-pagination
                                alternating
                                :headers="Header"
                                :items="Items"
                                :rows-per-page="10"
                                :search-field="searchField"
                                :search-value="searchValue"
                                border-cell
                            >
                                <template #item-number="{ id }">
                                    <Link
                                        :href="`/invoice-details?inv_id=${id}`"
                                        class="border-0 bg-transparent"
                                    >
                                        <i class="fa fa-eye text-violet"></i>
                                    </Link>
                                    <button
                                        class="border-0 bg-transparent"
                                        @click="printInvoice(id)"
                                    >
                                        <i class="fa fa-print text-violet"></i>
                                    </button>
                                    <button
                                        class="border-0 bg-transparent"
                                        @click="deleteInvoice(id)"
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
    </div>
</template>

<script setup>
import { ref } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

let page = usePage();

const Header = [
    { text: "No", value: "id" },
    { text: "Customer", value: "customer.name" },
    { text: "Phone", value: "customer.mobile" },
    { text: "Total", value: "total" },
    { text: "Discount", value: "discount" },
    { text: "Vat", value: "vat" },
    { text: "Payable", value: "payable" },
    { text: "Action", value: "number" },
];

const Items = ref(page.props.list);

const deleteInvoice = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to permanently delete this invoice.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#8e4dff",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/delete-invoice?inv_id=${id}`, {
                onSuccess: () => {
                    // Corrected line: Update the local array directly.
                    Items.value = Items.value.filter((item) => item.id !== id);
                    Swal.fire(
                        "Deleted!",
                        "The invoice has been removed.",
                        "success"
                    );
                },
                onError: () => {
                    Swal.fire("Error!", "Failed to delete invoice.", "error");
                },
            });
        }
    });
};

const printInvoice = (id) => {
    const printWindow = window.open(`/invoice-details?inv_id=${id}`, "_blank");
    printWindow.onload = () => {
        printWindow.print();
    };
};
</script>