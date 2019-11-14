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
                                <th>View Report</th>
                                <th>pay</th>
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
                                <td>
                                    <button type="button" class="btn btn-sm btn-success" @click="newModal(earn)">
                                    <i class="fas fa-eye"></i>
                                   Pay
                                     </button>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade " id="CommunicationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5  class="modal-title">Pay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Amount</label>
                                <input v-model="form.amount" type="text" class="form-control" name="amount" id="amount"
                                       :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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
                form: new Form({
                    amount: '',
                })
            }
        },
        methods : {
            newModal(earn) {
                $('#CommunicationModal').modal('show');
                this.form.fill(earn);
            },
            getEarnings(){
                axios.get("api/earnings").then(({data})=>(this.earnings = data['earning']));
            },
        },
        created() {
            this.getEarnings();
        },
    }
</script>
