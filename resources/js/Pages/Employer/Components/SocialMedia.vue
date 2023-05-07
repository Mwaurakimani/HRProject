<script  setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="content mx-[5px]">
        <section class="top-section">
            <div class="right-section">
                <h2>Social Accounts</h2>
            </div>
            <div class="left-section">
                <button>Edit</button>
            </div>
        </section>
        <section class="social-section">
            <article>
                <h3>Facebook:</h3>
                <div class="input-group">
                    <label for="">Username:</label>
                    <input type="text">
                </div>
                <div class="input-group">
                    <label for="">Followers:</label>
                    <input type="text">
                </div>
                <div class="input-group">
                    <label for="">Engagement:</label>
                    <p>90%</p>
                </div>
                <div class="input-group">
                    <label for="">Status:</label>
                    <p>Verified</p>
                </div>
            </article>

            <article>
                <h3>Instagram:</h3>
                <div class="input-group">
                    <label for="">Username:</label>
                    <input type="text">
                </div>
                <div class="input-group">
                    <label for="">Followers:</label>
                    <input type="text">
                </div>
                <div class="input-group">
                    <label for="">Engagement:</label>
                    <p>90%</p>
                </div>
                <div class="input-group">
                    <label for="">Status:</label>
                    <p>Verified</p>
                </div>
            </article>

            <article>
                <h3>Twitter:</h3>
                <div class="input-group">
                    <label for="">Username:</label>
                    <input type="text">
                </div>
                <div class="input-group">
                    <label for="">Followers:</label>
                    <input type="text">
                </div>
                <div class="input-group">
                    <label for="">Engagement:</label>
                    <p>90%</p>
                </div>
                <div class="input-group">
                    <label for="">Status:</label>
                    <p>Verified</p>
                </div>
            </article>
        </section>
    </div>
</template>

<style lang="scss" scoped>
.content {
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0 0 6px rgb(212, 212, 212);

    section{
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

.social-section{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    article{
        max-width: 300px;
        margin-bottom: 10px;
        padding:5px 0px;
        border-bottom: 1px solid rgb(218, 218, 218);
        h3{
            font-weight: 700;
            margin-bottom: 10px;
        }
        .input-group{
            display: flex;
            align-items: center;
            margin-bottom: 10px;

            label{
                width:100px;
            }

            input,p{
                height: 30px;
                line-height: 30px;
                padding-left: 5px;
                border-radius: 3px !important;
            }
        }
    }

    article:last-of-type{
        border:none;
    }
}


@media only screen and (min-width: 980px) {
    .right-section {
        width:fit-content;
        display: flex;
        .image-section{
            display: inline;
            margin-right: 20px;
        }
    }

    article{
        border: none !important;
    }

}

@media only screen and (min-width: 849px) {}
</style>