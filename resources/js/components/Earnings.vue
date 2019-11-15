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
                                    <button type="button" class="btn btn-sm btn-success" @click="newModal(earn.user_id)">
                                        <i class="fab fa-amazon-pay"></i>
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
        <div class="modal fade " id="PayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5  class="modal-title">Make Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="pay()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input v-model="form.amount" type="text" class="form-control" name="amount" id="amount"
                                       :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
                            </div>
                            <div class="form-group">
                                <select v-model="form.Paymethod" class="form-control" name="Paymethod" id="Paymethod"
                                        :class="{ 'is-invalid': form.errors.has('Paymethod') }">
                                    <option selected value="">--Select payment Method--</option>
                                    <option value="mpesa">Mpesa</option>
                                    <option value="bank account">Bank Account</option>
                                    <option value="cash">Cash</option>
                                </select>
                                <has-error :form="form" field="Paymethod"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fab fa-amazon-pay"></i></button>
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
                    id:'',
                    amount: '',
                    Paymethod: '',

                })
            }
        },
        methods : {
            newModal(userId) {
                this.form.id = userId;
                $('#PayModal').modal('show');
            },

            pay(){
                this.form.post('api/pay/')
                    .then(() => {
                        Fire.$emit('entry');
                        Swal.fire(
                            'Paid!',
                            'Payment !!',
                            'success'
                        )
                        this.form.reset();
                        $('#PayModal').modal('hide');
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                        swal.fire({
                            type: 'error',
                            title: 'Error!!',
                            text: error.response.data.msg,

                        })
                    })
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
