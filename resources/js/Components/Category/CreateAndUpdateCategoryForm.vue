
<template>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form @submit.prevent="submit">
                                <div class="card-body">
                                    <h4 class="fw-semibold mb-3">{{ id === 0 ? 'Create Category' : 'Update Category' }}</h4>
                                    <!-- <input id="id" name="id" v-model="form.id"  placeholder="Category ID" class="form-control" type="text"/> -->
                                    <input id="name" name="name" v-model="form.name"  placeholder="Category Name" class="form-control" type="text"/>
                                    <br/>
                                    <button type="submit"  class="btn bg-primary text-white">{{ id === 0 ? 'Create' : 'Update' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>


<script setup>
import {useForm,router} from '@inertiajs/vue3'
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster();
const urlParams=new URLSearchParams(window.location.search)
let id=ref(parseInt(urlParams.get('id')))

const form = useForm({name:'',id:id})
import { usePage } from '@inertiajs/vue3';
import {ref} from "vue";
const page = usePage()

let URL="/create-category";
let list=page.props.list
if(id.value!==0 && list!==null){
    URL="/update-category";
    // fill the form with existing
    form.name=list['name']
    form.id=list['id']
}

function submit(){
    if(form.name.length===0){
        toaster.error("Category name Required")
    }
    else  {
        form.post(URL,{
            onSuccess:()=>{
                if(page.props.flash.status===true){
                    router.get("/category")
                }
                else {
                    toaster.error(page.props.flash.message)
                }
            }
        })
    }

}

</script>
