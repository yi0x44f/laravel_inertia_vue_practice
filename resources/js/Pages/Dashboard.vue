<template>
    <div>
        <p class="text-center p-4 bg-green-200">{{ $page.props.flash.message }}</p>
        <h1 class="title">Welcome {{ $page.props.auth.user.name }}</h1>
    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>