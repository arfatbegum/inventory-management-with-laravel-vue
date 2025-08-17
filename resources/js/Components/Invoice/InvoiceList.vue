<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <input
                                placeholder="Search..."
                                class="form-control mb-2 w-auto form-control-sm"
                                type="text"
                                v-model="searchValue"
                            />
                            <Link
                                class="btn bg-primary text-white"
                                href="/create-invoice"
                            >
                                Create New
                            </Link>
                            <EasyDataTable
                                buttons-pagination
                                alternating
                                :headers="Header"
                                :items="Item"
                                :rows-per-page="10"
                                :search-field="searchField"
                                :search-value="searchValue"
                                border-cell
                            >
                                <template #item-number="{ id, total }">
                                    <button class="border-0 bg-transparent">
                                        <i class="fa fa-eye text-violet"></i>
                                    </button>
                                    <button class="border-0 bg-transparent">
                                        <i class="fa fa-print text-violet"></i>
                                    </button>
                                    <button class="border-0 bg-transparent">
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
import { Link, usePage } from "@inertiajs/vue3";
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

const Item = ref(page.props.list);

const itemClick = (id, total) => {
    alert(`ID is=${id} &  total is=${total}`);
};
</script>
