<template>
    <div class="flex justify-center rounded-md overflow-hidden shadow-lg">
        <div v-for="link in paginator.links" :key="link.url">
            <component
                v-html="makeLabel(link.label)" 
                :is="link.url?'Link':'span'"
                :href="link.url"
                class="grid border-x border-slate-100 w-12 h-12  place-items-center bg-white"
                :class="{
                    'hover:bg-slate-300':link.url,
                    'text-zinc-400':!link.url,
                    'font-bold text-blue-500': link.active,
                }"
            ></component>
        </div>
    </div>
    <small class="text-slate-500">Showing users {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} results</small>

</template>

<script setup>
defineProps({
    paginator:{
        required: true,
        type: Object,
    }
});

const makeLabel = (label)=>{
    if(label.includes("Previous")){
        return "<<";
    } else if (label.includes("Next")){
        return ">>";
    } else{
        return label;
    }
}

</script>

<style lang="scss" scoped>

</style>