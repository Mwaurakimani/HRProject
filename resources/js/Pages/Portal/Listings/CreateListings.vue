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
            <section>
            </section>
            <section>
                <button @click.prevent="saveOpening">Save</button>
            </section>
        </div>

        <div class="flex" style="gap:10px">
            <section class="w-[70%]">
                <form @submit.prevent="">
                    <div class="input-group">
                        <label>Title</label>
                        <div><input type="text" v-model="Opening.title"></div>
                    </div>
                    <div class="input-group">
                        <label>Job Description</label>
                        <div><textarea v-model="Opening.description"></textarea></div>
                    </div>
                    <div class="input-group">
                        <label>Qualification</label>
                        <div>
                            <article>
                                <input type="text" v-model="temp_qualification">
                                <button @click.prevent="addPill('Qualification')">Add</button>
                            </article>
                            <ul>
                                <li v-for="(item,index) in Opening.qualifications"
                                    @click.prevent="removePill('Qualification',index)">{{ item }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>About</label>
                        <div><textarea v-model="Opening.about"></textarea></div>
                    </div>
                    <div class="input-group">
                        <label>Responsibilities</label>
                        <div>
                            <article>
                                <input type="text" v-model="temp_responsibility">
                                <button @click.prevent="addPill('Responsibilities')">Add</button>
                            </article>
                            <ul>
                                <li v-for="(item,index) in Opening.responsibility"
                                    @click.prevent="removePill('Responsibilities',index)">{{ item }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>

                <form>
                    <h5 class="h5">Aptitude Questions</h5>
                    <div class="mb-[30px]">
                        <ul>
                            <li class="mb-[20px]">
                                <input type="text" class=" w-[100%]" v-model="temp_question.Question">
                            </li>
                            <li class="flex justify-between">
                                <div class="flex gap-2">
                                    <select v-model="temp_question.TestType">
                                        <option value="1">True/False</option>
                                        <option value="2">Agree/Disagree (3) options</option>
                                        <option value="3">Agree/Disagree (5) options</option>
                                    </select>
                                    <select v-model="temp_question.ModelTest">
                                        <option value="Openness">Openness</option>
                                        <option value="conscientiousness">conscientiousness</option>
                                        <option value="extroversion">extroversion</option>
                                        <option value="agreeableness">agreeableness</option>
                                        <option value="neuroticism">neuroticism</option>
                                    </select>
                                </div>
                                <button @click.prevent="addPill('Questions')">Add Question</button>
                            </li>
                        </ul>
                    </div>
                    <ul>
                        <li v-for="(question,index) in Opening.Questions" @click.prevent="removePill('Questions',index)"
                            class="mb-[20px]">
                            <p>{{ question.Question }}</p>
                            <ul v-if="question.TestType == 1" style="list-style: square" class="ml-[30px]">
                                <li>True</li>
                                <li>False</li>
                            </ul>
                            <ul v-else-if="question.TestType == 2" style="list-style: square" class="ml-[30px]">
                                <li>Agree</li>
                                <li>Neutral</li>
                                <li>Disagree</li>
                            </ul>
                            <ul v-else-if="question.TestType == 3" style="list-style: square" class="ml-[30px]">
                                <li>Strongly Agree</li>
                                <li>Agree</li>
                                <li>Neutral</li>
                                <li>Disagree</li>
                                <li>Strongly disagree</li>
                            </ul>
                        </li>
                    </ul>
                </form>
            </section>
            <section class="w-[30%]">
                <form @submit.prevent="" class="card-shadow p-[10px] bg-white ">
                    <h5 class=" h6 mb-[10px]">Education Requirements</h5>
                    <div class="flex flex-col">
                        <div class="w-[100%] flex mb-[10px]" style="gap: 5px">
                            <input class="form-input" type="text" v-model="temp_education">
                            <button @click.prevent="addPill('Eduction')">Add</button>
                        </div>
                        <ul class="flex flex-wrap gap-[5px]">
                            <li v-for="(item,index) in Opening.EducationRequirement"
                                @click.prevent="removePill('Eduction',index)" class="pill">{{ item }}
                            </li>
                        </ul>
                    </div>
                </form>
                <form @submit.prevent="" class="card-shadow p-[10px] bg-white ">
                    <h5 class=" h6 mb-[10px]">Skill Requirements</h5>
                    <div class="flex flex-col">
                        <div class="w-[100%] flex mb-[10px]" style="gap: 5px">
                            <input class="form-input" type="text" v-model="temp_skill">
                            <button @click.prevent="addPill('Skills')">Add</button>
                        </div>
                        <ul class="flex flex-wrap gap-[5px]">
                            <li v-for="(item,index) in Opening.SkillRequirement"
                                @click.prevent="removePill('Skills',index)" class="pill">{{ item }}
                            </li>
                        </ul>
                    </div>
                </form>
                <form @submit.prevent="" class="card-shadow p-[10px] bg-white ">
                    <h5 class=" h6 mb-[10px]">Ocean Model Requirements</h5>
                    <div class="flex flex-col">
                        <div class="mb-[5px]"><input class="inline-block m-[10px]" type="radio"
                                                     v-model="Opening.OceanModel" name="model" value="Openness"> <label>Openness</label>
                        </div>
                        <div class="mb-[5px]"><input class="inline-block m-[10px]" type="radio"
                                                     v-model="Opening.OceanModel" name="model"
                                                     value="conscientiousness"> <label>conscientiousness</label></div>
                        <div class="mb-[5px]"><input class="inline-block m-[10px]" type="radio"
                                                     v-model="Opening.OceanModel" name="model" value="extroversion">
                            <label>extroversion</label></div>
                        <div class="mb-[5px]"><input class="inline-block m-[10px]" type="radio"
                                                     v-model="Opening.OceanModel" name="model" value="agreeableness">
                            <label>agreeableness</label></div>
                        <div class="mb-[5px]"><input class="inline-block m-[10px]" type="radio"
                                                     v-model="Opening.OceanModel" name="model" value="neuroticism">
                            <label>neuroticism</label></div>
                    </div>
                </form>
            </section>
        </div>
    </AdminLayout>
</template>

<script>
import {router, useForm} from "@inertiajs/vue3";
import route from "ziggy-js/src/js";

export default {
    props: ['users', 'tag'],
    methods: {
        addPill(collection) {
            switch (collection) {
                case 'Skills':
                    this.Opening.SkillRequirement.unshift(this.temp_skill);
                    this.temp_skill = null
                    break;
                case 'Eduction':
                    this.Opening.EducationRequirement.unshift(this.temp_education);
                    this.temp_education = null
                    break;
                case 'Qualification':
                    this.Opening.qualifications.unshift(this.temp_qualification);
                    this.temp_qualification = null
                    break;
                case 'Responsibilities':
                    this.Opening.responsibility.unshift(this.temp_responsibility);
                    this.temp_responsibility = null
                    break;
                case 'Questions':
                    this.Opening.Questions.push({
                        Question: this.temp_question.Question,
                        TestType: this.temp_question.TestType,
                        ModelTest: this.temp_question.ModelTest
                    });
                    this.temp_question.Question = null;
                    this.temp_question.TestType = null;
                    this.temp_question.ModelTest = null;
                    break;
                default:
                    console.log("Unknown")
            }
        },
        removePill(collection, item) {
            switch (collection) {
                case 'Skills':
                    this.Opening.SkillRequirement.splice(item, 1);
                    break;
                case 'Eduction':
                    this.Opening.EducationRequirement.splice(item, 1);
                    break;
                case 'Qualification':
                    this.Opening.qualifications.splice(item, 1);
                    break;
                case 'Responsibilities':
                    this.Opening.responsibility.splice(item, 1);
                    break;
                case 'Questions':
                    this.Opening.Questions.splice(item, 1);
                    break;
                default:
                    console.log("Unknown")
            }
        },
        saveOpening() {
            axios.post(route('apiSaveOpening', this.Opening)).then((response) => {
                router.visit(route('ViewListings'))
            }).catch((error) => {
                console.log("Error: " + error)
            })
        }
    },
    data() {
        return {
            Opening: useForm({
                title: "title",
                description: "description",
                qualifications: [
                    'lorem iprum',
                    'lorem iprum',
                    'lorem iprum',
                ],
                about: "about",
                responsibility: [
                    'lorem iprum',
                    'lorem iprum',
                    'lorem iprum',
                    'lorem iprum',
                ],
                EducationRequirement: [
                    "Bachelors Degree in Information Technology"
                ],
                SkillRequirement: [
                    'Python',
                    'Excel',
                    'Photoshop',
                ],
                OceanModel: "conscientiousness",
                Questions: [
                    {
                        Question: "loreminpsun lorem ipsum lorem ipsum",
                        TestType: 1,
                        ModelTest: "openness"
                    },
                    {
                        Question: "loreminpsun lorem ipsum lorem ipsum",
                        TestType: 2,
                        ModelTest: "openness"
                    },
                    {
                        Question: "loreminpsun lorem ipsum lorem ipsum",
                        TestType: 3,
                        ModelTest: "openness"
                    },
                ]
            }),
            temp_qualification: null,
            temp_responsibility: null,
            temp_education: null,
            temp_skill: null,
            temp_question: {
                Question: null,
                TestType: null,
                ModelTest: null,
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import "./../theme";

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




