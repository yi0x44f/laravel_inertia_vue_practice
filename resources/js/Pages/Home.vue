<template>
    <Head>
        <title> | {{ $page.component }}</title>
        <meta 
            head-key="description"
            name="description" 
            content="This is a home description.">
    </Head>

    <!-- <p>{{ $page.props.auth.user }}</p> -->

    <h1 class=" m-3 text-6xl text-center">User List</h1>

    <!-- Search  -->
    <div class="m-5 flex justify-end">
        <div class="sm:w-2/4" >
            <input type="search" placeholder="search" v-model="search">
        </div>
    </div>

    <!-- User Table -->
    <div class="p-5">
        <table>
            <thead>
                <tr>
                    <th class="flex justify-center">Avatar</th>
                    <th>Name</th>
                    <th class="sm:hidden flex justify-center">Detail</th>
                    <th class="sm:table-cell hidden">Email</th>
                    <th class="sm:table-cell hidden">Registration Date</th>
                    <th class="sm:table-cell hidden text-center justify-center" v-if="can.delete_user">Delete</th>
                </tr>
            </thead>

            <tbody>
                <template v-for="user in users.data" :key="user.id">
                    <!-- User Row -->
                    <tr>
                        <td class="flex justify-center"><img :src="user.avatar ? 'storage/' + user.avatar : 'default.webp'" class="avatar" alt="" /></td>
                        <td>{{ user.name }}</td>
                        <td class="sm:hidden flex justify-center cursor-pointer" @click="showDetail(user.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </td>
                        <td class="sm:table-cell hidden">{{ user.email }}</td>
                        <td class="sm:table-cell hidden">{{ getDate(user.created_at) }}</td>
                        <td class="sm:flex hidden  justify-center " v-if="can.delete_user">
                            <button class="bg-red-600 cursor-pointer text-white p-5 rounded-2xl " @click="delete_user(user.id)">Delete user</button>
                        </td>
                    </tr>

                    <!-- Detail Row (Only Shows for Selected User) -->
                    <tr class="sm:hidden hidden" :id="user.id+'detail'">
                        <td colspan="6" class="p-4 bg-gray-100">
                            <Detail :user="user" />
                        </td>
                    </tr>
                </template>
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
import Detail from './Components/Detail.vue';
import { computed, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
// import { throttle } from 'lodash';
import { debounce } from 'lodash';
import { onMounted } from 'vue'


defineOptions( {layout: Layout} );
const props = defineProps({
    users: Object,
    searchTerm: String,
    can: Object,
});


const showDetail = (id) =>{
    let target = document.getElementById(id+'detail');
    target.classList.contains('hidden')?target.classList.remove('hidden'):target.classList.add('hidden');
}

const getDate = (date)=>{
    return new Date(date).toLocaleDateString('zh-tw',{
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const search = ref(props.searchTerm);

let selectedUserId = ref(null);

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