<script  setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="content mx-[5px]">
        <section class="top-section">
            <div class="right-section">
                <h2>Credits</h2>
            </div>
        </section>
        <section>
            <div class="card-display">
                <article>
                    <label for="">Credit Balance</label>
                    <p>Ksh 5,000</p>
                </article>
                <article>
                    <label for="">Pending Deposit</label>
                    <p>Ksh 5,000</p>
                </article>
                <article>
                    <label for="">Pending Withdrawal</label>
                    <p>Ksh 5,000</p>
                </article>
                <article>
                    <label for="">Total Balance</label>
                    <p>Ksh 5,000</p>
                </article>
            </div>
            <div class="actions-tab">
                <button>Add Credits</button>
                <button>Withdraw</button>
                <!-- <button>View Transactions</button> -->
            </div>
        </section>
    </div>
</template>

<style lang="scss" scoped>
.content {
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0 0 6px rgb(212, 212, 212);
    margin-bottom: 40px;

    &>section {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;

        h2 {
            font-weight: bolder;
            padding: 10px;
        }
    }

    &>section:nth-of-type(2) {
        display: block;

        .card-display {
            display: flex;
            justify-content: space-evenly;
            margin-bottom: 20px;
            flex-wrap:wrap;


            article {
                width: 350px;
                height: 150px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;

                label {
                    margin-bottom: 30px;
                }

                p {
                    font-size: 1.3em;
                    font-weight: bolder;
                }
            }

            article:nth-of-type(1) {
                border: none;
            }
        }


        .actions-tab{
            padding-left:20px;
            button{
                padding:10px 20px;
                border:1px solid orange;
                color:orange;
                border-radius: 3px;
                margin:0px 10px;
            }
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

    article{
        border-left: 1px solid rgb(231, 231, 231);
    }
}

@media only screen and (min-width: 849px) {}</style>