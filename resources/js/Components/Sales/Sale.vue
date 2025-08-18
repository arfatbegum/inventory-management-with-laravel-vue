<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12">
                <form @submit.prevent="submit">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="fw-semibold mb-3">Billed To</h5>
                                    <p>
                                        Name:
                                        {{ selectedCustomer?.name || "-" }}
                                    </p>
                                    <p>
                                        Email:
                                        {{ selectedCustomer?.email || "-" }}
                                    </p>
                                    <p>
                                        User ID:
                                        {{ selectedCustomer?.id || "-" }}
                                    </p>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-3">Point Of Sale.</h5>
                                    <h6 class="fw-semibold mb-3">Invoice</h6>
                                    <p>
                                        Date:
                                        {{
                                            new Date()
                                                .toISOString()
                                                .slice(0, 10)
                                        }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <EasyDataTable
                                    buttons-pagination
                                    alternating
                                    :headers="InvoiceProductsHeaders"
                                    :items="invoiceProducts"
                                    :rows-per-page="10"
                                    border-cell
                                >
                                    <template #item-number="{ id }">
                                        <button
                                            class="btn btn-sm"
                                            @click="removeProduct(id)"
                                        >
                                            <i
                                                class="fa fa-trash text-danger"
                                            ></i>
                                        </button>
                                    </template>
                                </EasyDataTable>
                            </div>
                            <div class="mt-4">
                                <h3>TOTAL: $ {{ total.toFixed(2) }}</h3>
                                <h3>VAT (5%): $ {{ vat.toFixed(2) }}</h3>
                                <h3>
                                    Discount: $ {{ discountAmount.toFixed(2) }}
                                </h3>
                                <h3>PAYABLE: $ {{ payable.toFixed(2) }}</h3>

                                <div>
                                    <label class="mb-1 mt-2"
                                        >Discount (%):</label
                                    ><br />
                                    <input
                                        type="number"
                                        v-model="discount"
                                        class="form-control form-control-sm w-auto"
                                    />
                                </div>
                            </div>
                             <button type="submit" class="btn btn-sm bg-primary text-white mt-4" >
                        Create Invoice
                    </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Customer List</h5>
                        <!-- Search + Create -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-2"
                        >
                            <input
                                placeholder="Search..."
                                class="form-control form-control-sm w-auto"
                                type="text"
                                v-model="searchValue"
                            />
                            <Link
                                class="btn bg-primary text-white btn-sm"
                                href="/create-and-update-customer?id=0"
                            >
                                Create New
                            </Link>
                        </div>

                        <!-- Data Table -->
                        <EasyDataTable
                            buttons-pagination
                            alternating
                            :headers="customersHeaders"
                            :items="customers"
                            :rows-per-page="10"
                            :search-field="customersSearchField"
                            :search-value="searchValue"
                            border-cell
                        >
                            <template #item-number="{ id }">
                                <button
                                    class="btn btn-sm bg-primary text-white my-2"
                                    @click="
                                        addCustomer(
                                            customers.find((c) => c.id === id)
                                        )
                                    "
                                >
                                    Add
                                </button>
                            </template>
                        </EasyDataTable>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Product List</h5>
                        <!-- Search + Create -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-2"
                        >
                            <input
                                placeholder="Search..."
                                class="form-control form-control-sm w-auto"
                                type="text"
                                v-model="productsSearchValue"
                            />
                            <Link
                                class="btn btn-sm bg-primary text-white"
                                href="/create-and-update-customer?id=0"
                            >
                                Create New
                            </Link>
                        </div>

                        <!-- Data Table -->
                        <EasyDataTable
                            buttons-pagination
                            alternating
                            :headers="productsHeaders"
                            :items="products"
                            :rows-per-page="10"
                            :search-field="productsSearchField"
                            :search-value="productsSearchValue"
                            border-cell
                        >
                            <template #item-number="{ id }">
                                <button
                                    class="bg-primary text-white btn btn-sm my-2"
                                    @click="
                                        addProduct(
                                            products.find((p) => p.id === id)
                                        )
                                    "
                                >
                                    Add
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
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster();
const page = usePage();

// Table Headers
const customersHeaders = [
    { text: "Name", value: "name" },
    { text: "Pick", value: "number" },
];

const productsHeaders = [
    { text: "Name", value: "name" },
    { text: "Price", value: "price" },
    { text: "Pick", value: "number" },
];

const InvoiceProductsHeaders = [
    { text: "No", value: "id" },
    { text: "Name", value: "name" },
    { text: "Price", value: "price" },
    { text: "Qty", value: "qty" },
    { text: "Subtotal", value: "subtotal" },
    { text: "Remove", value: "number" },
];

// Search fields and values
const customersSearchField = ["name", "email", "mobile"];
const productsSearchField = ["name", "email", "mobile"];
const searchValue = ref("");
const productsSearchValue = ref("");

// Table data
const customers = ref(
    Array.isArray(page.props.customers) ? page.props.customers : []
);
const products = ref(
    Array.isArray(page.props.products) ? page.props.products : []
);

// Invoice state
const selectedCustomer = ref(null);
const invoiceProducts = ref([]);
const discount = ref(0);

// Add customer
const addCustomer = (customer) => {
    selectedCustomer.value = customer;
};

// Add product
const addProduct = (product) => {
    const existing = invoiceProducts.value.find((p) => p.id === product.id);
    if (existing) {
        existing.qty++;
        existing.subtotal = existing.qty * Number(existing.price); // convert to number
    } else {
        invoiceProducts.value.push({
            ...product,
            qty: 1,
            price: Number(product.price), // convert to number
            subtotal: Number(product.price),
        });
    }
};

// Remove product
const removeProduct = (id) => {
    invoiceProducts.value = invoiceProducts.value.filter((p) => p.id !== id);
};

// Computed totals
// Computed totals
const total = computed(() =>
    invoiceProducts.value.reduce((sum, p) => sum + p.subtotal, 0)
);

const vat = computed(() => total.value * 0.05);
const discountAmount = computed(() => (total.value * discount.value) / 100);
const payable = computed(() => total.value + vat.value - discountAmount.value);

// Submit
function submit() {
    if (!selectedCustomer.value) {
        toaster.warning("Please select a customer first!");
        return;
    }

    if (invoiceProducts.value.length === 0) {
        toaster.warning("Please add at least one product.");
        return;
    }

    const form = useForm({
        customer_id: selectedCustomer.value.id,
        total: total.value,
        discount: discount.value,
        vat: vat.value,
        payable: payable.value,
        products: invoiceProducts.value.map((p) => ({
            product_id: p.id,
            qty: p.qty,
            sale_price: p.price,
        })),
    });

    form.post("/create-invoice", {
        onSuccess: () => {
            // Show flash message
            if (page.props.flash?.status === true) {
                toaster.success(page.props.flash.message);
            } else if (page.props.flash?.status === false) {
                toaster.warning(page.props.flash.message);
            }

            // Reset form
            selectedCustomer.value = null;
            invoiceProducts.value = [];
            discount.value = 0;
        },
        onError: (errors) => {
            toaster.error("Something went wrong while creating invoice.");
            console.log(errors);
        },
    });
}
</script>
<style scoped>
p {
    line-height: 5px;
    font-size: 12px;
    color: gray;
}

h3 {
    line-height: 13px;
    font-size: 13px;
}
label {
    font-size: 12px;
}
</style>
