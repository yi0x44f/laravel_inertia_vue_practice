<template>


    <div class="grid grid-cols-4 gap-4 p-2 text-sm">
      <div class="text-slate-500 font-medium uppercase col-span-1  ">Email:</div>
      <div class="text-slate-800 font-semibold col-span-3">{{ user.email }}</div>
      <div class="text-slate-500 font-medium uppercase col-span-1">Date:</div>
      <div class="text-slate-800 font-semibold col-span-3">{{ getDate(user.created_at) }}</div>
    </div>



</template>

<script setup>

const getDate = (date)=>{
    return new Date(date).toLocaleDateString('zh-tw',{
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

defineProps({
    user: Object
});

</script>

<style lang="scss" scoped>

</style>