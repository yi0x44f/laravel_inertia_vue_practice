<template>
    <Head :title="`${ $page.component }`"></Head>

    <h1 class="title">Login</h1>

    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">

            <div class="mb-6">
                
                <TextInput name="Email" v-model="form.email" :message="form.errors.email" type="email"></TextInput>
                <TextInput name="Password" v-model="form.password" :message="form.errors.password" type="password"></TextInput>
                <div class="flex justify-between mb-5">
                    <div class="flex items-center">
                        <input id="remember"  class="mx-1" type="checkbox" v-model="form.remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <div>
                        <p class="text-slate-600">Need a new account?
                            <a :href="route('register')" class="text-link">Register</a>
                        </p>
                    </div>
                </div>
                <button class="primary-btn" :disabled="form.processing">Login</button>
            </div>
        </form>

    </div>


</template>

<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import TextInput from '../Components/TextInput.vue';
const form = useForm({
    email: null,
    password: null,
    remember: null,
});

const submit = function(){
    console.log(form);
    form.post('/login',{
        onError: ()=>{
            form.reset('password');
        }
    });
};


</script>

<style lang="scss" scoped>

</style>