<template>
<Head>
    <title> | {{ $page.component }}</title>
    <meta 
        head-key="description"
        name="description" 
        content="This is a home description.">
</Head>

<h1>123</h1>
<p>{{ $page.props.auth.user }}</p>

<Link class="mt-10 block" href="/" preserve-scroll >Refresh</Link>

</template>

<script setup>
import Layout from '../Layouts/Layout.vue';
defineOptions( {layout: Layout} );
</script>

<style lang="scss" scoped>

</style>