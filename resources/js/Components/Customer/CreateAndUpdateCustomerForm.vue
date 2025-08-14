<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <h4 class="fw-semibold mb-3">
                                {{ id === 0 ? 'Create Customer' : 'Update Customer' }}
                            </h4>
                            <input id="name" name="name" v-model="form.name" placeholder="Customer Name" class="form-control mb-2" type="text" />
                            <input id="email" name="email" v-model="form.email" placeholder="Customer Email" class="form-control mb-2" type="email" />
                            <input id="mobile" name="mobile" v-model="form.mobile" placeholder="Customer Mobile" class="form-control mb-3" type="text" />
                            <button type="submit" class="btn bg-primary text-white">
                                {{ id === 0 ? 'Create' : 'Update' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm, router, usePage } from '@inertiajs/vue3'
import { createToaster } from '@meforma/vue-toaster'
import { ref } from 'vue'

const toaster = createToaster()
const page = usePage()

// Get ID from query string
const urlParams = new URLSearchParams(window.location.search)
const id = ref(parseInt(urlParams.get('id')))

// Form
const form = useForm({
    name: '',
    email: '',
    mobile: '',
    id: id.value
})

// Decide API URL and pre-fill if editing
let URL = '/create-customer'
if (id.value !== 0 && page.props.list) {
    URL = '/update-customer'
    form.name = page.props.list.name
    form.email = page.props.list.email
    form.mobile = page.props.list.mobile
    form.id = page.props.list.id
}

// Submit
function submit() {
    if (!form.name || !form.email || !form.mobile) {
        toaster.error('All fields are required')
        return
    }

    form.post(URL, {
        onSuccess: () => {
            if (page.props.flash.status) {
                toaster.success(page.props.flash.message)
                router.get('/customer')
            } else {
                toaster.error(page.props.flash.message)
            }
        },
        onError: () => {
            toaster.error('Something went wrong')
        }
    })
}
</script>
