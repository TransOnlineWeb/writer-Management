<template>
    <div class="container-fluid" v-if="$gate.isAdmin()">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Bids List</h3>

                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="bid in bids" :key="bid.id">
                                <td>{{bid.name}}</td>
                                <td>{{bid.email}}</td>
                                <td>{{bid.phone}}</td>
                                <td>
                                    <span class="badge badge-primary" v-if="bid.level == 1">Starter</span>
                                    <span class="badge badge-success" v-if="bid.level == 2">Intermediate</span>
                                    <span class="badge badge-dark" v-if="bid.level == 3">Senior</span>
                                </td>
                                <td>
                                    <span v-if="bid.status == 0" style="color: orange">Pending</span>
                                    <span v-if="bid.status == 1" style="color: green">Accepted</span>
                                    <span v-if="bid.status == 2" style="color: red">Rejected</span>
                                    <span v-if="bid.status == 3" style="color: #ff079c">Cancelled</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">
                                        Accept
                                    </button>
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
        name: "Bids",
        data() {
            return {
                orderId: this.$route.params.orderId,
                bids: {}
            }
        },
        methods: {
            getBids() {
                axios.get("/api/bid/" + this.orderId).then(({data}) => ([this.bids = data]));
            }
        },
        created() {
            this.getBids();
        }
    }
</script>

<style scoped>

</style>