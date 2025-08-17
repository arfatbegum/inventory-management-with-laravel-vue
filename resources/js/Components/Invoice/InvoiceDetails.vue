<template>
  <div class="container-fluid">
      <div class="d-flex justify-content-end">
              <!-- Print Button -->
        <button class="btn btn-sm bg-primary text-white mb-3" @click="printInvoice">
          Print  <i class="fa fa-print text-white ms-1"></i>
        </button>
      </div>
    <div class="card" ref="printArea">
      <div class="card-body">
        <h5 class="fw-semibold mb-3">Invoice Details</h5>
        <hr/>

        <!-- Customer & Invoice Info -->
        <div class="d-flex justify-content-between">
          <div>
            <h5 class="fw-semibold mb-3">Billed To</h5>
            <p>Name: {{ invoice.customer?.name || "-" }}</p>
            <p>Email: {{ invoice.customer?.email || "-" }}</p>
            <p>Phone: {{ invoice.customer?.mobile || "-" }}</p>
          </div>
          <div>
            <h5 class="fw-semibold mb-3">COFFEE.</h5>
            <h6 class="fw-semibold mb-3">Invoice</h6>
            <p>Date: {{ invoice.invoice?.created_at?.slice(0, 10) || "-" }}</p>
            <p>Invoice ID: {{ invoice.invoice?.id || "-" }}</p>
          </div>
        </div>

        <!-- Invoice Products -->
        <EasyDataTable
          buttons-pagination
          alternating
          :headers="InvoiceProductsHeaders"
          :items="invoice.product || []"
          :rows-per-page="10"
          border-cell
        />

        <!-- Totals -->
        <div class="mt-4">
          <h3>Total: $ {{ invoice.invoice?.total || 0 }}</h3>
          <h3>VAT (5%): $ {{ invoice.invoice?.vat || 0 }}</h3>
          <h3>Discount: $ {{ invoice.invoice?.discount || 0 }}</h3>
          <h3>Payable: $ {{ invoice.invoice?.payable || 0 }}</h3>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster();
const page = usePage();
const invoice = ref(page.props.invoice || {});
const printArea = ref(null);

onMounted(() => {
  if (page.props.flash?.status === true) {
    toaster.success(page.props.flash.message);
  } else if (page.props.flash?.status === false) {
    toaster.warning(page.props.flash.message);
  }
});

// Table headers
const InvoiceProductsHeaders = [
  { text: "Name", value: "product.name" },
  { text: "Price", value: "sale_price" },
  { text: "Qty", value: "qty" },
];

// Print function
const printInvoice = () => {
  const printContents = printArea.value.innerHTML;
  const originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
  window.location.reload(); // reload to restore Vue bindings
};
</script>



<style scoped>
p {
  font-size: 12px;
  color: gray;
}
h3 {
  font-size: 13px;
}
</style>
