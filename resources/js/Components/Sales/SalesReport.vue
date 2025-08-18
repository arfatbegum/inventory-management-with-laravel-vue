<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card p-4 rounded-3 shadow-sm">
                    <h5 class="fw-semibold mb-4">Sales Report</h5>

                    <div class="">
                        <input
                            type="date"
                            class="form-control mb-3"
                            v-model="form.dateFrom"
                        />
                        <input
                            type="date"
                            class="form-control mb-4"
                            v-model="form.dateTo"
                        />
                        <button
                            @click="downloadPdf"
                            class="btn bg-primary w-100 text-white"
                        >
                            Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    invoices: Array,
    summary: Object,
    dateFrom: String,
    dateTo: String,
    flash: Object,
});

const form = ref({
    dateFrom: props.dateFrom,
    dateTo: props.dateTo,
});

const downloadPdf = () => {
    window.open(
        `/sales-report/download-pdf?dateFrom=${form.value.dateFrom}&dateTo=${form.value.dateTo}`,
        "_blank"
    );
};
</script>
