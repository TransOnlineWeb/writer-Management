<template>
    <div class="container-fluid pl-0 pr-0 ml-0 mr-0">
        <div class="row justify-content-center pl-0 pr-0 ml-0 mr-0">
            <div class="col-md-12 mt-4 pl-0 pr-0 ml-0 mr-0">
                <div class="card pl-0 pr-0 ml-0 mr-0">
                    <div class="card-header">
                        <h3 class="card-title">Transactions</h3>

                        <div class="card-tools">

                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Order#</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="trans in transactions.data" :key="trans.id">
                                <td>{{trans.created_at|myDatetime}}</td>
                                <td>
                                    <router-link :to="{path:'/orderdetails/'+ trans.order_id}">#{{trans.order_number}}
                                    </router-link>
                                </td>
                                <td>
                                    <span class="badge badge-pill badge-warning" v-if="trans.type == 1">Fine</span>
                                    <span class="badge badge-pill badge-info" v-if="trans.type == 3">PayOut</span>
                                    <span class="badge badge-pill badge-success" v-if="trans.type == 0">Awarded</span>
                                </td>
                                <td>
                                    Ksh. {{Math.trunc(trans.amount)}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "WalletTransactions",
        data(){
            return{
                transactions:{}
            }
        },
        methods:{
            getTransactions(){
                if (this.$gate.isWriter()) {
                    axios.get('api/transactions/').then(({data}) => ([this.transactions = data]));
                }
            }
        },
        created() {
            this.getTransactions();
        }
    }
</script>

<style scoped>

</style>