<script setup>
import { Link } from '@inertiajs/vue3';
import MobileNavigationComponent from '../../Components/MobileNavigationComponent.vue'
import DesktopNavigationVue from '../../Components/DesktopNavigation.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

</script>

<template>
    <nav>
        <MobileNavigationComponent :activeNavButton="'Projects'"></MobileNavigationComponent>
        <DesktopNavigationVue :activeNavButton="'Projects'"></DesktopNavigationVue>
    </nav>
    <header>
        <div class="modile-header">
            <div class="container">
                <section>
                    <h1>Join Comunity</h1>
                </section>
            </div>
        </div>
    </header>
    <div class="content-area">
        <div class="container" style="box-shadow:none">

            <p style="text-align: center;font-weight: 700;">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Odit asperiores ea neque quae eaque possimus vel amet quisquam fugiat sequi repudiandae ex, perferendis minus illum. Sit autem nesciunt totam deserunt!</p>
            <Link :href="route('SignUpAsInfluencer')" as="button" >An Influencer</Link>
            <Link :href="route('SignUpAsEmployer')" as="button" >A Marketer</Link>
        </div>
    </div>
    <footer>

    </footer>
</template>

<style lang="scss" scoped>
*{
    font-size: 0.96em;
}
header {
    width: 100%;
    box-shadow: 0 0 6px rgb(182, 182, 182);
    margin-bottom: 20px;
    min-height: 80px;

    section {
        padding: 10px 10px;
        display: flex;
        justify-content: space-between;

        h1 {
            font-weight: 800;
            font-size: 1.3em;
        }

        .actions {
            button {
                border-radius: 3px;
                font-size: 0.9em;
                padding: 2px;
                border: 1px solid rgb(201, 201, 201);
                background-color: rgb(226, 226, 226);
                margin: 0px 5px;
            }
        }

        p {
            color: grey;
        }
    }
}

.container{
    display: flex;
    flex-wrap: wrap;

    button{
        min-width: 200px;
        border: 1px solid purple;
        margin: 20px auto;
        padding: 20px 30px;
        border-radius: 4px;
        font-weight: 700;
        color:purple;

        &:active,&:hover{
            background-color: purple;
            color:white;
        }
    }
}

.content-area{
    margin: auto;
    max-width: 700px;
    min-height: calc(100vh - 60px - 400px);
}


@media only screen and (min-width: 980px) {
    header {
        section {
            padding: 20px 10px;

            h1 {
                font-size: 2em;
            }
        }
    }
}

@media only screen and (min-width: 849px) {}
</style>
