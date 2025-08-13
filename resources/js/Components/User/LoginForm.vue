<template>
  <div class="container">
    <div class="row center-screen">
      <div class="col-md-7 col-lg-5">
        <div class="card w-100 p-4 shadow-sm animated fadeIn">
          <form @submit.prevent="submit">
            <div class="card-body">
              <h4 class="text-center mb-4">SIGN IN</h4>

              <!-- Email -->
              <div class="mb-3">
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="User Email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.email }"
                />
                <div v-if="form.errors.email" class="invalid-feedback">
                  {{ form.errors.email }}
                </div>
              </div>

              <!-- Password -->
              <div class="mb-3">
                <input
                  v-model="form.password"
                  type="password"
                  placeholder="User Password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.password }"
                />
                <div v-if="form.errors.password" class="invalid-feedback">
                  {{ form.errors.password }}
                </div>
              </div>

              <!-- Login Button -->
              <button
                type="submit"
                :disabled="form.processing"
                class="btn w-100 bg-primary text-white"
              >
                Login
              </button>

              <!-- Links -->
              <div class="d-flex justify-content-end mt-3">
                <Link href="/registration" class="mx-2">Sign Up</Link>
                <span>|</span>
                <Link href="/send-otp" class="mx-2">Forgot Password</Link>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, router, Link } from '@inertiajs/vue3'
import { getCurrentInstance } from 'vue'
import { usePage } from '@inertiajs/vue3'
const { proxy } = getCurrentInstance()
const toaster = proxy.$toast
const page = usePage()

const form = useForm({
  email: '',
  password: ''
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

  if (!form.password) {
    form.errors.password = 'Password is required'
    valid = false
  }

  return valid
}

// Submit form
function submit() {
  if (!validate()) {
    toaster.error('Please correct the validation errors before submitting.')
    return
  }

  form.post('/login', {
    onSuccess: () => {
      if (page.props.flash.status === true) {
        toaster.success(page.props.flash.message || 'Login successful')
        router.get('/dashboard')
      } else {
        toaster.error(page.props.flash.message || 'Login failed')
      }
    },
    onError: (errors) => {
      toaster.error('Validation failed. Please check the form fields.')
    }
  })
}
</script>
