<template>


    <div class="grid grid-cols-2 gap-4 p-2 text-sm">
      <div class="text-slate-500 font-medium uppercase">Email:</div>
      <div class="text-slate-800 font-semibold">{{ user.email }}</div>
      <div class="text-slate-500 font-medium uppercase">Registration Date:</div>
      <div class="text-slate-800 font-semibold">{{ getDate(user.created_at) }}</div>
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