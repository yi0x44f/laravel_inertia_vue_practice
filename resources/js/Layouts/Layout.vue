<template>
    <Head>
        <meta 
            head-key="description"
            name="description" 
            content="This is a default description.">
    </Head>
    <div>
        <header >
            <nav>
                <div class="space-x-4">
                    <Link :href="route('home')" class="nav-link" :class="{'bg-slate-700':$page.component==='Home'}">Home</Link>
                    <Link :href="route('about')" class="nav-link" :class="{'bg-slate-700':$page.component==='About'}">About</Link>
                </div>

                <div class="flex space-x-4" v-if="$page.props.auth.user">
                    <img class="avatar" :src=" $page.props.auth.user.avatar?'storage/'+$page.props.auth.user.avatar:'/default.webp'" alt="" >
                    <Link :href="route('dashboard')" class="nav-link" :class="{'bg-slate-700':$page.component==='Dashboard'}">Dashboard</Link>
                    <Link :href="route('logout')" method="post" as="button" type="button" class="nav-link">Logout</Link>
                </div>
                <div v-else class="space-x-4">
                    <Link :href="route('register')" class="nav-link" :class="{'bg-slate-700':$page.component==='Auth/Register'}">Register</Link>
                    <Link :href="route('login')" class="nav-link" :class="{'bg-slate-700':$page.component==='Auth/Login'}">Login</Link>
                </div>

            </nav>
        </header>
        <main class="p-4">
            <slot></slot>
        </main>
    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>