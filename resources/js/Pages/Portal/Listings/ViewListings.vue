<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import {provide} from "vue";
import PageTitle from "@PortalComponent/PageTitle.vue";
import {Link} from '@inertiajs/vue3'


provide('activeSideNavigationLink', 'Users')

</script>

<template>
    <AdminLayout>
        <PageTitle :title="'Listings'">
        </PageTitle>
        <div class="flex justify-between mb-[30px] p-[10px]">
        </div>

        <div class="flex flex-wrap" style="gap:10px">
            <section class="w-[69%]">
                <div class="main-card mb-[30px] card-shadowed bg-white p-[20px]">
                    <h5 class="text-grey-200">{{ job.Title }}</h5>
                    <div class="pl-[20px]">
                        <p>{{ job.Description }}</p>
                        <h6>Qualifications</h6>
                        <ul class="pl-[20px]">
                            <li v-for="item in JSON.parse(job.Qualification)">{{ item }}</li>
                        </ul>
                        <h6>About Job</h6>
                        <ul class="pl-[20px]">
                            <p>{{ job.About }}</p>
                        </ul>
                        <h6>Responsibilities</h6>
                        <ul class="pl-[20px]">
                            <li v-for="item in JSON.parse(job.Responsibilities)">{{ item }}</li>
                        </ul>
                    </div>
                </div>
            </section>
            <section class="w-[30%]">
                <div class="card-shadowed bg-white p-[15px]">
                    <h5 class="mb-[10px] text-grey-200 ">Stats</h5>
                    <ul class="pl-[20px]">
                        <li class="mb-[10px]">Total Applications : {{ data.stats.totalApplications }}</li>
                        <li class="mb-[10px]">Considered Applications : {{ data.stats.consideredApplications }}</li>
                        <li class="mb-[10px]">Rejected Applications : {{ data.stats.unconsideredApplications }}</li>
                    </ul>
                </div>
            </section>

            <section class="w-[100%]" >
                <h5 class="mb-[20px] text-grey-200 ">Considered Applications</h5>
                <ul class="flex flex-wrap mb-[30px] gap-[10px]">
                    <li v-for="application in data.data.consideredApplications" class="card-shadowed p-[20px] bg-white">
                        <div>
                            <label>Name : </label>
                            <p>{{ application.name }}</p>
                        </div>
                        <div>
                            <label>Email : </label>
                            <p>{{ application.email }}</p>
                        </div>
                        <div>
                            <label>ID : </label>
                            <p>{{ application.national_id }}</p>
                        </div>
<!--                        <h6 class="mb-[10px]">Matched Skill</h6>-->
<!--                        <ul class="mb-[20px] flex flex-wrap gap-[5px]">-->
<!--                            <li class="pill">Test</li>-->
<!--                            <li class="pill">Test</li>-->
<!--                        </ul>-->
                        <div>
                            <button @click.prevent="downloadCV(application.cv_path)">Download CV</button>
                            <button v-if="application.status != 'Approved'" style="background-color: limegreen" @click="approveApplication(application.id)">Approve</button>
                            <button v-if="application.status != 'Rejected'" style="background-color: red" @click="rejectApplication(application.id)" >Reject</button>
                        </div>
                    </li>
                </ul>
                <h5 class="mb-[20px] text-grey-200 ">Rejected Applications</h5>
                <ul class="flex flex-wrap mb-[30px] gap-[10px]">
                    <li v-for="application in data.data.unconsideredApplications" class="card-shadowed p-[20px] bg-white">
                        <div>
                            <label>Name : </label>
                            <p>{{ application.name }}</p>
                        </div>
                        <div>
                            <label>Email : </label>
                            <p>{{ application.email }}</p>
                        </div>
                        <div>
                            <label>ID : </label>
                            <p>{{ application.national_id }}</p>
                        </div>
                        <div>
                            <button @click.prevent="downloadCV(application.cv_path)">Download CV</button>
                            <button v-if="application.status != 'Approved'" style="background-color: limegreen" @click="approveApplication(application.id)">Approve</button>
                            <button v-if="application.status != 'Rejected'" style="background-color: red" @click="rejectApplication(application.id)" >Reject</button>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
    </AdminLayout>
</template>

<script>
import {router} from "@inertiajs/vue3";

export default {
    props: ['job','data'],
    methods:{
        downloadCV(path){
            const filePath = path;
            const cleanedPath = filePath.replace("public/", "/storage/");

            const link = document.createElement("a");
            link.href = cleanedPath;
            link.download = cleanedPath.split("/").pop(); // Set the downloaded file name

            link.click();
        },
        approveApplication(id){
            axios.post(route('apiApproveApplication',[id])).then((resp) => {
                alert(resp.data.message)
                window.location.href = window.location.href
            }).catch((err) => {
                alert(err.data.message)
            })

        },
        rejectApplication(id){
            axios.post(route('apiRejectApplication',[id])).then((resp) => {
                alert(resp.data.message)
                window.location.href = window.location.href
            }).catch((err) => {
                alert(err.data.message)
            })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "./../theme";

ul>.card-shadowed{
    width: 400px;
    &>div{
        display: flex;
        margin-bottom: 10px;
        label{
            width: 80px;
        }
    }
}

.main-card {
    * {
        margin-bottom: 10px;
    }
}

.card-shadowed {
    button {
        display: block;
        margin: auto;
        background-color: dodgerblue;
        color: white;
        padding: 5px 20px;
    }
}

.pill {
    padding: 5px 10px;
    border-radius: 30px;
    border: 1px solid dodgerblue;
    color: dodgerblue;

    &:hover {
        background-color: dodgerblue;
        color: white;
    }
}

form {
    .input-group {
        flex-wrap: nowrap;
        margin-bottom: 20px;

        div {
            width: 100%;

            input, textarea {
                width: 100% !important;
            }
        }

        article {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;

            input {
                width: 100% !important;
            }
        }

        ul {
            li {
                margin-bottom: 10px;
            }
        }
    }

    label {
        width: 200px;
    }
}
</style>




