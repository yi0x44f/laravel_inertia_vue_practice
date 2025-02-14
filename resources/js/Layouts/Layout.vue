<template>
    <Head>
        <meta 
            head-key="description"
            name="description" 
            content="This is a default description.">
    </Head>
    <div>
        <header>
            <nav class="">
                <div class="sm:flex hidden mx-auto  items-center justify-between" id="menu">
                    <div class="space-x-4">
                    <Link :href="route('home')" class="nav-link" :class="{'text-white':$page.component==='Home'}">Home</Link>
                    <Link :href="route('download')" class="nav-link" :class="{ 'text-white': $page.component==='Download' }" >Youtube Downloader</Link>
                    <Link :href="route('about')" class="nav-link" :class="{'text-white':$page.component==='About'}">About</Link>
                    </div>

                    <div class="flex space-x-4" v-if="$page.props.auth.user">
                        <img class="avatar" :src=" $page.props.auth.user.avatar?'storage/'+$page.props.auth.user.avatar:'/default.webp'" alt="" >
                        <Link :href="route('dashboard')" class="nav-link" :class="{'text-white':$page.component==='Dashboard'}">Dashboard</Link>
                        <Link :href="route('logout')" method="post" as="button" type="button" class="nav-link">Logout</Link>
                    </div>
                    <div v-else class="space-x-4">
                        <Link :href="route('register')" class="nav-link" :class="{'text-white':$page.component==='Auth/Register'}">Register</Link>
                        <Link :href="route('login')" class="nav-link" :class="{'text-white':$page.component==='Auth/Login'}">Login</Link>
                    </div>
                </div>
                <div class="sm:hidden wrapper">
                    <svg @click="wrap=(!wrap)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 p-1  bg-slate-600 cursor-pointer rounded-2xl">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </div>
                <div v-show="wrap" class="sm:hidden mt-1 bg-slate-900  rounded-2xl ">
                    <Link :href="route('home')" class="nav-link block" :class="{'text-white':$page.component==='Home'}">Home</Link>
                    <Link :href="route('download')" class="nav-link block" :class="{ 'text-white': $page.component==='Download' }" >Youtube Downloader</Link>
                    <Link :href="route('about')" class="nav-link block" :class="{'text-white':$page.component==='About'}">About</Link>
                    <div v-if="$page.props.auth.user">
                        <div class="flex">
                            <Link :href="route('dashboard')" class="nav-link block" :class="{'text-white':$page.component==='Dashboard'}">Dashboard</Link>
                            <img class="avatar inline" :src=" $page.props.auth.user.avatar?'storage/'+$page.props.auth.user.avatar:'/default.webp'" alt="" >
                        </div>
                        <Link :href="route('logout')" method="post" as="button" type="button" class="nav-link block">Logout</Link>
                    </div>
                    <div v-else>
                        <Link :href="route('register')" class="nav-link block" :class="{'text-white':$page.component==='Auth/Register'}">Register</Link>
                        <Link :href="route('login')" class="nav-link block" :class="{'text-white':$page.component==='Auth/Login'}">Login</Link>
                    </div>
                </div>
            </nav>
        </header>
        <main class="min-h-screen">
            <slot></slot>
        </main>
        <footer>
            <p class=" bg-slate-600 text-white">Copyright</p>
        </footer>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});

const handleClickOutside = (event) => {
  if (!event.target.closest('.wrapper')) {
    wrap.value = false;
  }
};

let wrap = ref(false);
</script>

<style lang="scss" scoped>

</style>