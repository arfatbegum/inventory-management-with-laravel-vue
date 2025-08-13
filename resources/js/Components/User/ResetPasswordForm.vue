<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5 center-screen">
        <div class="card animated fadeIn w-100 p-4 shadow-sm">
          <form @submit.prevent="submit">
            <div class="card-body">
              <h4 class="text-center mb-3">SET NEW PASSWORD</h4>

              <!-- New Password -->
              <div class="mb-3">
                <label>New Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  placeholder="New Password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.password }"
                />
                <div v-if="form.errors.password" class="invalid-feedback">
                  {{ form.errors.password }}
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="mb-3">
                <label>Confirm Password</label>
                <input
                  v-model="form.cpassword"
                  type="password"
                  placeholder="Confirm Password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.cpassword }"
                />
                <div v-if="form.errors.cpassword" class="invalid-feedback">
                  {{ form.errors.cpassword }}
                </div>
              </div>

              <!-- Submit Button -->
              <button
                type="submit"
                :disabled="form.processing"
                class="btn w-100 text-white bg-primary"
              >
                Reset Password
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
import { usePage } from '@inertiajs/vue3'
import { getCurrentInstance } from 'vue'

const page = usePage()
const { proxy } = getCurrentInstance()
const toaster = proxy.$toast

// Form state
const form = useForm({
  password: '',
  cpassword: ''
})

// Client-side validation
function validate() {
  form.errors = {}
  let valid = true

  if (!form.password) {
    form.errors.password = 'Password is required'
    valid = false
  } else if (form.password.length < 6) {
    form.errors.password = 'Password must be at least 6 characters'
    valid = false
  }

  if (!form.cpassword) {
    form.errors.cpassword = 'Confirm password is required'
    valid = false
  } else if (form.password !== form.cpassword) {
    form.errors.cpassword = 'Passwords do not match'
    valid = false
  }

  return valid
}

// Submit handler
function submit() {
  if (!validate()) {
    toaster.error('Please correct the errors before submitting.')
    return
  }

  form.post('/reset-password', {
    onSuccess: () => {
      if (page.props.flash?.status === true) {
        toaster.success(page.props.flash.message || 'Password reset successfully')
        router.get('/login')
      } else {
        toaster.error(page.props.flash.message || 'Password reset failed')
      }
    },
    onError: () => {
      toaster.error('Validation failed. Please check your inputs.')
    }
  })
}
</script>
