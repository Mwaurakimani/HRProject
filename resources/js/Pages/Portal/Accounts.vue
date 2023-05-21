<script setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import {Link} from '@inertiajs/vue3'


provide('activeSideNavigationLink', 'Users')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Accounts'">
        </PageTitle>
        <div class="flex justify-between mb-[30px] p-[10px]">
            <section>
                <ul class="flex" style="gap: 10px">
                    <li>Available Accounts 20</li>
                </ul>
            </section>
            <section>
                <Link as="button" :href="route('CreateJob')">Add Account</Link>
            </section>
        </div>
        <section class="flex" style="gap: 10px">
            <div class="card-shadowed w-[69%] p-[20px] bg-white">
                <table v-if="users.length > 0" class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Designation</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" >
                        <th scope="row">{{ user.id }}</th>
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.designation }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <form @submit.prevent="addUser" class=" card-shadowed bg-white p-[20px] w-[29%]">
                <h5 class="mb-[20px]" >Add New User</h5>
                <div class="input-group mb-[10px]">
                    <label>Name</label>
                    <input class="w-[100%]" type="text" v-model="user.name">
                </div>
                <div class="input-group mb-[10px]">
                    <label>Email</label>
                    <input class="w-[100%]" type="text" v-model="user.email">
                </div>
                <div class="input-group mb-[10px]">
                    <label>Phone</label>
                    <input class="w-[100%]" type="text" v-model="user.phone">
                </div>
                <div class="input-group mb-[10px]">
                    <label>ID Number</label>
                    <input class="w-[100%]" type="text" v-model="user.id_number">
                </div>
                <div class="input-group mb-[10px]">
                    <label>Designation</label>
                    <select class="w-[100%]" v-model="user.designation">
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div>
                    <button type="submit">Save</button>
                </div>

            </form>
        </section>

    </AdminLayout>
</template>

<script>
import {useForm} from "@inertiajs/vue3";

export default {
    props: ['users', 'tag'],
    data(){
      return {
          user:useForm({
              name:null,
              email:null,
              phone:null,
              id_number:null,
              designation:null
          })
      }
    },
    methods:{
        addUser(){
            axios.post(route('apiAddUser'),this.user).then((resp) => {
                window.location.href = window.location.href
            }).catch((err) => {
                alert("Error: Adding User.Ensure no field was left empty")
            })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "./theme";

tbody {
    tr {
        height: 50px !important;
    }
}
</style>




