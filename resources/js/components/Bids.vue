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
                                    <button type="button" class="btn btn-primary btn-sm" @click="acceptBid(bid.id)" v-if="bid.status == 0">
                                        Accept
                                    </button>
                                    <span><i class="fas fa-certificate" style="color: green;" v-if="bid.status == 1"></i> </span>
                                    <span><i class="fas fa-ban" style="color: red;" v-if="bid.status == 2"></i> </span>
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
            acceptBid(bidId){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Accept this bid? Please, note that this will reject all the other bids",
                    //type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, accept bid!'
                }).then((result) => {
                    if (result.value) {
                        axios.patch("/api/bid/" + bidId).then(() => {
                            Fire.$emit('entry');
                            Swal.fire(
                                'Placed!',
                                'Bid accepted!!',
                                'success'
                            )
                            Fire.$emit('entry');
                        }).catch(error => {
                            this.errors = error.response.data.errors;
                            Swal.fire({
                                type: 'error',
                                title: 'Error!!',
                                text: error.response.data.msg,

                            })
                        });
                    }
                })
            },
            getBids() {
                axios.get("/api/bid/" + this.orderId).then(({data}) => ([this.bids = data]));
            }
        },
        created() {
            this.getBids();
            Fire.$on('entry', () =>{
                this.getBids();
            })
        }
    }
</script>

<style scoped>

</style>