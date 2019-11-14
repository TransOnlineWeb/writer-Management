<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Writers Earning</div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Amount payable</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="earn in earnings" :key="earn.id">
                                <td>{{ earn['writer_name'] }}</td>
                                <td>Ksh{{ earn['amount'] }}</td>
                                <td>
                                    <router-link :to="{path:'/earningsdetails/'+ earn['user_id']}" type="button"
                                                 class="btn btn-primary btn-sm">View Earnings
                                    </router-link>

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
        name : "earnings",
        data(){
            return{
                earnings: {},
            }
        },
        methods : {
            getEarnings(){
                axios.get("api/earnings").then(({data})=>(this.earnings = data['earning']));
            },
        },
        created() {
            this.getEarnings();
        },
    }
</script>
