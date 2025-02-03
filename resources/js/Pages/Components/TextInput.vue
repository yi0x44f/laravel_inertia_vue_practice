<template>
    <label for="">{{ name }}</label>
    <input :type="type" v-model="model" :class="{'ring-red-500':message}">
    <small class="error" v-if="message">{{ message }}</small>
</template>

<script setup>
defineProps({
    name: { type: String, required: true },
    type: { type: String, default: "text" },
    message: { type: String },
});

const model = defineModel({
    type: null,
    required: true
});
</script>

<style lang="scss" scoped>

</style>