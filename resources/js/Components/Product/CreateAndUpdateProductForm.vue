<template>
      <div class="container-fluid">
            <div class="row">
                  <div class="col-md-6">
                        <div class="card">
                              <div class="card-body">
                                    <form @submit.prevent="submit">
                                          <h4 class="fw-semibold mb-3">
                                                {{ id === 0 ? 'Create Product' : 'Update Product' }}
                                          </h4>

                                          <input v-model="form.name" placeholder="Product Name"
                                                class="form-control mb-2" type="text" />
                                          <input v-model="form.price" placeholder="Price" class="form-control mb-2"
                                                type="number" />
                                          <input v-model="form.unit" placeholder="Unit" class="form-control mb-2"
                                                type="text" />
                                          <input v-model="form.img_url" placeholder="Image URL"
                                                class="form-control mb-2" type="text" />

                                          <!-- Category Dropdown -->
                                          <select v-model="form.category_id" class="form-control form-select mb-3">
                                                <option value="">Select Category</option>
                                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                                      {{ cat.name }}
                                                </option>
                                          </select>
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

const id = ref(parseInt(new URLSearchParams(window.location.search).get('id')))
const categories = ref(page.props.categories || [])

const form = useForm({
      name: '',
      price: '',
      unit: '',
      img_url: '',
      category_id: '',
      id: id.value
})

let URL = '/create-product'
if (id.value !== 0 && page.props.product) {
      URL = '/update-product'
      Object.assign(form, {
            name: page.props.product.name,
            price: page.props.product.price,
            unit: page.props.product.unit,
            img_url: page.props.product.img_url,
            category_id: page.props.product.category_id,
            id: page.props.product.id
      })
}

function submit() {
      if (!form.name || !form.price || !form.unit || !form.category_id) {
            toaster.error('All fields are required')
            return
      }

      form.post(URL, {
            onSuccess: () => {
                  if (page.props.flash.status) {
                        toaster.success(page.props.flash.message)
                        router.get('/product')
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
