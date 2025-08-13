<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5 center-screen">
        <div class="card animated fadeIn w-100 shadow-sm p-4">
          <form @submit.prevent="submit">
            <div class="card-body">
              <h4 class="text-center mb-4">EMAIL ADDRESS</h4>

              <!-- Email Input -->
              <div class="mb-4">
                <label>Enter Your Email Address</label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="Email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.email }"
                />
                <div v-if="form.errors.email" class="invalid-feedback">
                  {{ form.errors.email }}
                </div>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="form.processing"
                class="btn w-100 bg-primary text-white"
              >
                Verify
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
  email: ''
})

// Client-side validation
function validate() {
  form.errors = {}
  let valid = true

  if (!form.email) {
    form.errors.email = 'Email is required'
    valid = false
  } else if (!/\S+@\S+\.\S+/.test(form.email)) {
    form.errors.email = 'Email is invalid'
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

  form.post('/send-otp', {
    onSuccess: () => {
      if (page.props.flash?.status === true) {
        toaster.success(page.props.flash.message || 'OTP sent successfully')
        router.get('/verify-otp')
      } else {
        toaster.error(page.props.flash.message || 'Failed to send OTP')
      }
    },
    onError: (errors) => {
      toaster.error('Validation failed. Check your input.')
    }
  })
}
</script>
