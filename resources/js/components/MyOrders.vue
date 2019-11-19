<template>
    <div class="container-fluid pl-0 pr-0 ml-0 mr-0">
        <div class="row justify-content-center pl-0 pr-0 ml-0 mr-0">
            <div class="col-md-12 mt-4 pl-0 pr-0 ml-0 mr-0">
                <div class="card pl-0 pr-0 ml-0 mr-0">
                    <div class="card-header">
                        <h3 class="card-title">My Orders</h3>

                        <div class="card-tools">

                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Order#</th>
                                <th>Title</th>
                                <th>Deadline</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Urgency</th>
                                <th>More</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="order in orders.data" :key="order.id">
                                <td>{{order.order_number}}</td>
                                <td>{{order.title}}</td>
                                <td>
                                    <small style="color: red;">{{order.deadline|myDatetime}}</small>
                                </td>
                                <td>{{order.academic_level}}</td>
                                <td>
                                    <span class="badge badge-pill badge-warning"
                                          v-if="order.status == 1">Pending..</span>
                                    <span class="badge badge-pill badge-info" v-if="order.status == 3">Uploaded</span>
                                    <span class="badge badge-pill badge-danger"
                                          v-if="order.status == 4">Revision</span>
                                    <span class="badge badge-pill badge-dark" v-if="order.status == 5">Completed</span>
                                    <span class="badge badge-pill badge-success" v-if="order.status == 6">Edited</span>
                                </td>
                                <td>
                                    <span class="badge badge-dark" v-if="order.urgency == 1">Urgent</span>
                                </td>
                                <td>
                                    <router-link :to="{path:'/orderdetails/'+ order.id}" type="button"
                                                 class="btn btn-primary btn-sm">More
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
        name: "MyOrders",
        data(){
            return{
                 orders: {}
            }
        },
        methods:{
            getMyOrders(){
                axios.get("/api/myorders").then(({data}) => ([this.orders = data]));
            },
        },
        created() {
            this.getMyOrders();
        }
    }
</script>

<style scoped>

</style>
