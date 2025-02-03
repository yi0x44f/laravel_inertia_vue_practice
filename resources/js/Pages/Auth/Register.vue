<template>
    <Head :title="`${ $page.component }`"></Head>

    <h1 class="title">Register a new account</h1>

    <div class="w-2/4 mx-auto">
        <form @submit.prevent="submit">
            <!--Upload Avatar-->
            <div class="grid place-items-center">
                <div class="relative w-30 h-30 rounded-full overflow-hidden border border-slate-300">
                    <label for="avatar" class="absolute inset-0 grid content-end cursor-pointer">
                        <span class="bg-white/70 pb-2 text-center">Avatar</span>
                    </label>
                    <input type="file" id="avatar" @input="change" hidden>
                    <img :src="form.preview?form.preview:'default.webp'" alt="" class="object-cover">
                </div>
                <small>{{ form.errors.avatar }}</small>

            </div>

            <div class="mb-6">
                <TextInput 
                    name="Name" 
                    v-model="form.name" 
                    :message="form.errors.name">
                </TextInput>

                <TextInput 
                    name="Email" 
                    v-model="form.email" 
                    :message="form.errors.email" 
                    type="email">
                </TextInput>

                <TextInput 
                    name="Password" 
                    v-model="form.password" 
                    :message="form.errors.password"
                    type="password">
                </TextInput>

                <TextInput 
                    name="Confirm Password" 
                    v-model="form.password_confirmation" 
                    :message="form.errors.password_confirmation"
                    type="password">
                </TextInput>
            </div>

            <div>
                <p class="text-slate-600 mb-2">Already a user?
                    <a :href="route('login')" class="text-link">Login</a>
                </p>
                <button class="primary-btn" :disabled="form.processing">Register</button>
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
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    avatar: null,
    preview: null,
});

const submit = function(){
    console.log(form);
    form.post('/register',{
        onError: ()=>{
            // Object.keys( form.errors ).forEach( (key)=>{
            //     form.reset(key);
            // } );
            if(form.errors.email){
                form.reset('email');
            }
            form.reset('password','password_confirmation');
        }
    });
};

const change = (event)=>{
    form.avatar = event.target.files[0];
    form.preview = URL.createObjectURL(event.target.files[0]);
}

</script>

<style lang="scss" scoped>

</style>