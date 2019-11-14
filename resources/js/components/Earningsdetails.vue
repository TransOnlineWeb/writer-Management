<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">Payment Report</div>

                    <div class="card-body">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Completed date</th>
                                    <th>Order ID</th>
                                    <th>N.O Pages</th>
                                    <th>Amount payable</th>
                                    <th>Penalty</th>
                                    <th>Earnings</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="earn in earns" :key="earn.id">
                                    <td>{{ earn['completed_time'] | myDatetime }}</td>
                                    <td>{{ earn['orderId'] }}</td>
                                    <td>{{ earn['pages'] }}</td>
                                    <td>Ksh{{ earn['amount_payable'] }}</td>
                                    <td><span class="badge badge-pill badge-danger">Ksh{{ earn['penalty'] }}</span></td>
                                    <td>Ksh{{ earn['earning'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                userId : this.$route.params.userId,
                earns : {},

            }
        },
        methods : {
            getMyEarning(){
                axios.get("/api/myearnings/" + this.userId).then(({data})=>([this.earns = data['myearnings']]));
            },
        },
        created() {
           this. getMyEarning();
        }
    }
</script>
