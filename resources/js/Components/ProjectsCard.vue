<script setup>
import { Link } from '@inertiajs/vue3';
import convertDate from "../Helpers/convertDate";


const props = defineProps([
    'project',
    'owner'
])

</script>

<template>
    <Link as="div" :href="props.owner ? route('ViewOwnedProject',[props.project.id]) : route('ViewProject',[props.project.id])" class="mobile-view">
        <div class="details-section">
            <div class="heading">
                <h3>{{ props.project.title }}</h3>
                <p style="color: orange;">{{ props.project.bids.length }} Bids</p>
            </div>
            <p class="mb-[10px]">{{ props.project.description }}</p>
            <ul v-for="platform in props.project.platforms">

                <li>{{platform.name}} : {{platform.pivot.influencer_data.name}}</li>
            </ul>
        </div>
        <div class="sub-details-section">
            <p>Posted on: {{ convertDate(props.created_at) }} </p>
            <h3 class="price-tag">Ksh 1,500</h3>
        </div>
    </Link>
</template>

<style lang="scss" scoped>
.desktop-view {
    display: none;
}

.mobile-view {
    border-radius: 8px;
    box-shadow: 0 0 6px rgb(180, 180, 180);
    padding: 15px;
    margin-bottom: 20px;
    cursor: pointer;
    transition:all ease 250ms;


    .details-section {
        .heading {
            padding: 0px 10px 10px 0px;
            display: flex;
            justify-content: space-between;

            h3 {
                max-width: 210px;
                font-size: large;
                font-weight: 800;
                margin-right: 10px;
            }
        }

        &>p {
            font-size: smaller;
            color: grey;
        }

        ul {
            display: flex;
            flex-wrap: wrap;
            li {
                padding: 3px 5px;
                border-radius: 15px;
                margin: 3px 3px 3px 0px;
                width: fit-content;
                color: rgb(75, 75, 75);
                border: 1px solid grey;
                background-color: rgb(230, 230, 230);
                font-size: 0.6em;
            }
        }
    }
    .sub-details-section{
        margin-top: 10px;
        font-size: 0.9em;

        .price-tag{
            text-align: right;
            font-weight: 800;
        }
    }
}

@media only screen and (min-width: 849px) {
    .mobile-view{
        &:hover{
            box-shadow: 0 0 8px rgb(211, 211, 211);
            transform: scale(1.015);
        }
    }
    .details-section {
        .heading {
            padding: 0px 10px 10px 0px;
            display: flex;
            justify-content: space-between;

            h3 {
                max-width: 210px;
                font-size: large;
                font-weight: 800;
                margin-right: 10px;
            }
        }

        &>p {
            color:red;
            font-size: medium !important;
            color: grey;
        }

        ul {
            display: flex;
            flex-wrap: wrap;
            li {
                padding: 3px 5px;
                border-radius: 15px;
                margin: 3px 3px 3px 0px;
                width: fit-content;
                color: rgb(75, 75, 75);
                border: 1px solid grey;
                background-color: rgb(230, 230, 230);
                font-size: 0.75em !important;
            }
        }
    }

    .price-tag{
        font-size:1.2em;
        text-align: right;
        font-weight: 800;
    }
}
</style>
