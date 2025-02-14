<template>
    <Head>
        <title> | {{ $page.component }}</title>
    </Head>
    <div class="mt-5 flex justify-center">
        <div class="sm:w-3/4 w-2/4">
            <div class="flex justify-center">
                <img src="/public/Youtube.png" class=" w-1/2 " alt="">
            </div>
            <form class="flex justify-between items-center" @submit.prevent="submit">
                <input class="my-5" type="text" placeholder="Enter the URL" name="url" id="url" v-model="form.url">
                <button class="btn ring-1 ring-blue-500 bg-blue-500 text-white rounded-4xl h-1/2 p-2 mx-1">Send</button>
            </form>
            <div v-if="form.processing">Please wait...</div>
            <div v-else :class="{ 'text-red-500': !downloadable }">{{ filename }}</div>
            <a class="primary-btn" v-if="downloadable" :href="`/download/${encodeURI(filename.trim())}`">Download</a>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';


const props = defineProps( {
    filename:{
        type: String,
        default: "",
    },
    downloadable:{
        type: Boolean,
        default: false,
    }
});

const form = useForm({
    url: null,
});
const submit = ()=>{
    form.post('/download');
    handling.value = true;
}

</script>

<style lang="scss" scoped>

</style>