<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5 center-screen">
        <div class="card animated fadeIn w-100 shadow-sm p-4">
          <form @submit.prevent="submit">
            <div class="card-body">
              <h4 class="text-center mb-3">ENTER OTP CODE</h4>

              <!-- OTP Input -->
              <div class="mb-3">
                <label>4 Digit Code Here</label>
                <input
                  v-model="form.otp"
                  type="text"
                  placeholder="Enter OTP"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.otp }"
                />
                <div v-if="form.errors.otp" class="invalid-feedback">
                  {{ form.errors.otp }}
                </div>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="form.processing"
                class="btn w-100 bg-primary text-white"
              >
                Next
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { getCurrentInstance } from 'vue'
import { usePage } from '@inertiajs/vue3'

const { proxy } = getCurrentInstance()
const toaster = proxy.$toast
const page = usePage()

// Form setup
const form = useForm({
  otp: ''
})

// Client-side validation
function validate() {
  form.errors = {}
  let valid = true

  if (!form.otp) {
    form.errors.otp = 'OTP is required'
    valid = false
  } else if (!/^\d{4}$/.test(form.otp)) {
    form.errors.otp = 'OTP must be a 4-digit number'
    valid = false
  }

  return valid
}

// Submit handler
function submit() {
  if (!validate()) {
    toaster.error('Please fix the validation errors before submitting.')
    return
  }

  form.post('/verify-otp', {
    onSuccess: () => {
      if (page.props.flash?.status === true) {
        toaster.success(page.props.flash.message || 'OTP verified successfully')
        router.get('/reset-password')
      } else {
        toaster.error(page.props.flash.message || 'OTP verification failed')
      }
    },
    onError: () => {
      toaster.error('Validation failed. Please check the OTP.')
    }
  })
}
</script>
