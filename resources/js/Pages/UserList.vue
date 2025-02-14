<template>
    <Head>
        <title> | {{ $page.component }}</title>
        <meta 
            head-key="description"
            name="description" 
            content="This is a home description.">
    </Head>

    <!-- <p>{{ $page.props.auth.user }}</p> -->

    <!-- Search  -->
    <div class="mb-5 flex justify-end">
        <div class="w-1/4">
            <input type="search" placeholder="search" v-model="search">
        </div>
    </div>

    <!-- User Table -->
    <div>
        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                    <th class="text-center" v-if="can.delete_user">Delete</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="user in users.data">
                    <td><img :src="user.avatar? 'storage/'+user.avatar:'default.webp'" class="avatar" alt=""></td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ getDate(user.created_at) }}</td>
                    <td class="flex justify-center" v-if="can.delete_user">
                        <button class="shadow  rounded-full bg-red-600 w-6 h-6" @click="delete_user(user.id)"></button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <!-- Pagination Links -->
    <PaginationLinks :paginator="users"></PaginationLinks>

<!-- <Link class="mt-10 block" href="/" preserve-scroll >Refresh</Link> -->

</template>

<script setup>
import Layout from '../Layouts/Layout.vue';
import PaginationLinks from './Components/PaginationLinks.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
// import { throttle } from 'lodash';
import { debounce } from 'lodash';
defineOptions( {layout: Layout} );
const props = defineProps({
    users: Object,
    searchTerm: String,
    can: Object,
});

const getDate = (date)=>{
    return new Date(date).toLocaleDateString('zh-tw',{
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const search = ref(props.searchTerm);

watch(search, debounce( (new_val, old_val)=>{
        router.get('/',{search: new_val}, {preserveState: true});
    }, 500)
);

const delete_user = (id)=>{
    router.post('/delete',{id: id},{
        onBefore: () => confirm('Are you sure you want to delete this user?'),
    });
};

</script>

<style  scoped>
    input:focus-visible{
        outline:none;
    }
</style>