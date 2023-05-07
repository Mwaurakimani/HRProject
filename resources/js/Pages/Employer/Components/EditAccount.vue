<script  setup>
import { Link } from '@inertiajs/vue3';
import {defineProps} from "vue";

const props = defineProps(['user'])

</script>

<template>
    <div class="content mx-[5px]">
        <section class="top-section">
            <div class="right-section">
                <h2>Account Details</h2>
            </div>
            <div class="left-section">
                <button>Update</button>
            </div>
        </section>
        <section>
            <form action="">
                <h1>Registration Form</h1>
                <div class="form-content">
                    <section>
                        <div class="splitter">
                            <div class="input-group">
                                <label for="">First Name</label>
                                <input type="text" v-model="props.user.first_name">
                            </div>
                            <div class="input-group">
                                <label for="">Last Name</label>
                                <input type="text" v-model="props.user.last_name">
                            </div>
                        </div>
                        <div class="input-group">
                            <label for="">Email</label>
                            <input type="email" v-model="props.user.email">
                        </div>
                        <div class="input-group">
                            <label for="">Phone</label>
                            <input type="tel" v-model="props.user.phone">
                        </div>
                    </section>
                    <section>
                        <div class="input-group">
                            <label for="">Account Type</label>
                            <select v-model="props.user.account_type">
                                <option value="Single">Single</option>
                                <option value="Company" >Company</option>
                            </select>
                        </div>
                        <div v-if="props.user.account_type == 'Company'" class="input-group">
                            <label for="">Company Name</label>
                            <input type="text" v-model="props.user.company_name">
                        </div>
                    </section>
                </div>
            </form>
        </section>
    </div>
</template>

<style lang="scss" scoped>
.content {
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0 0 6px rgb(212, 212, 212);

    &>section {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;

        h2 {
            font-weight: bolder;
            padding: 10px;
        }

        .left-section {
            display: block;

            flex-direction: column;
            width: 70px;
            align-items: flex-end;

            button {
                border-radius: 5px;
                margin-bottom: 10px;
                padding: 5px 10px;
                display: block;
                border: 1px solid orange;
                color: orange;
            }
        }

        .right-section {
            width: 100%;
        }
    }
}

section:nth-of-type(2) {
    form {
        background-color: white;
        width: 100%;

        h1 {
            font-size: 1.1em;
            font-weight: 700;
            margin-bottom: 10px;
            text-decoration: underline;
        }

        .form-content {
            section:nth-of-type(1) {
                padding-bottom: 20px;
                margin-bottom: 20px;
            }

            .input-group {
                margin-bottom: 10px;
            }

            label {
                margin-bottom: 5px;
                width: 100%;
            }

            input,
            select {
                border-radius: 3px !important;
                width: 100%;
                height: 35px;
                padding: 5px;
            }
        }

        button {
            padding: 10px 15px
        }
    }
}


@media only screen and (min-width: 980px) {
    .right-section {
        width: fit-content;
        display: flex;

        .image-section {
            display: inline;
            margin-right: 20px;
        }
    }

    article {
        border: none !important;
    }

    form {
        h1 {
            font-size: 1.5em;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        section {
            padding: 30px;
            width: 40%;
            border: none;

            .input-group {
                margin: auto;
            }

        }
    }

}

@media only screen and (min-width: 849px) {}</style>
