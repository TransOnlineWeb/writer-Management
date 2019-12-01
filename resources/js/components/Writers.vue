<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Orders</div>

                    <div class="card-body">
                        <h3>New Orders</h3>
                        <div class="row details">
                            <div class="col-md-6" v-for="order in orders" :key="order.id">
                                <div class="info-box" v-if="order.viewers.includes(level)">
                                    <span class="info-box-icon bg-aqua"><i class="fas fa-envelope" style="color: green;"></i></span>
                                    <div class="info-box-content">
                                        <button class="btn btn-light info-box-number" @click="orderDetails(order)">Order
                                            Number: {{ order.order_number }}
                                        </button>
                                        <span class="info-box-text">Title: {{ order.title }}</span>
                                        <span class="info-box-text">Deadline: {{ order.deadline | myDatetime}}</span>
                                        <span class="info-box-text">Discipline: {{ order.discipline }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="OrderDetails" tabindex="-1" role="dialog" aria-labelledby="AddNewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="row justify-content-center mt-4 ml-auto mr-auto">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Order Details<span class="badge badge-dark"
                                                                              style="margin-left: 4px;"
                                                                              v-if="details.urgency == 0">Urgent</span>
                                    </h3>
                                </div>

                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-10">
                                            <div class="box">
                                                <!-- /.box-header -->
                                                <div class="box-body no-padding table-responsive p-0">
                                                    <table class="table table-striped">
                                                        <tbody>
                                                        <tr>
                                                            <th>Title</th>
                                                            <th style="width: 40px">Details</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Order Number</td>
                                                            <td><span>#{{details.order_number}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Document's Title</td>
                                                            <td><span>{{details.title}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Level</td>
                                                            <td><span>{{details.academic_level}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Discipline</td>
                                                            <td><span>{{details.discipline}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. of Pages</td>
                                                            <td><span>{{details.pages}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Deadline</td>
                                                            <td><span style="color: red;">{{details.deadline|myDatetime}}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Spacing</td>
                                                            <td><span>{{details.spacing}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Paper Format</td>
                                                            <td><span>{{details.paper_format}}</span></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                            <!-- /.box -->
                                        </div>
                                        <div class="col-md-12">
                                            <div class="box d-flex">
                                                <div class="box-header">
                                                    <h5 class="box-title">Description</h5>
                                                </div>
                                                <div class="box-body">
                                                    <p>
                                                        <a class="btn btn-primary btn-sm" data-toggle="collapse"
                                                           href="#collapseExample" role="button" aria-expanded="false"
                                                           aria-controls="collapseExample">
                                                            <i class="fas fa-eye"></i>
                                                            View
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="collapse" id="collapseExample">
                                                <div class="card card-body">
                                                    <div v-html="details.description"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h4 class="box-title">Files</h4>
                                                </div>
                                                <div class="box-body" v-if="this.filesCount > 0">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12" v-for="file in files"
                                                             :key="file.id">
                                                            <a @click.prevent="download(file.id, file.path)">
                                                                <div class="info-box">
                                                                    <span class="info-box-icon"
                                                                          style="background-color: green;"><i
                                                                            class="fas fa-download"
                                                                            style="color: white;"></i></span>

                                                                    <div class="info-box-content">
                                                                        <span class="info-box-text">Download</span>
                                                                    </div>
                                                                    <!-- /.info-box-content -->
                                                                </div>
                                                            </a>
                                                            <!-- /.info-box -->
                                                        </div>
                                                        <!--                                            <button type="button" class="btn btn-primary" @click="downloadAll">Download all files</button>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-warning alert-dismissible" v-if="this.filesCount == 0">
                                            <h5><i class="icon fa fa-ban"></i> Alert!</h5>
                                            No files attached!!
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <button type="button" class="btn btn-success" @click="placeBid()"
                                                v-if="this.ifBid == 0">
                                            <i class="fas fa-thumbs-up"></i>
                                            Place Bid
                                        </button>
                                        <span style="color: red;"
                                              v-if="this.ifBid > 0">You already placed a bid!!</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                id: '',
                level: '',
                orders: [],
                message: '',
                typing: '',
                users: {},
                messages: [],
                orderId: '',
                details: [],
                filesCount: '',
                ifBid: '',
                files: {},
                attachments: [],
                formf: new FormData(),
                form: new Form({})
            }
        },
        methods: {
            isVisible(){

            },
            getLevel(){
                axios.get("api/getLevel").then(({data}) => ([this.level = data.title]));
            },
            checkBid() {
                axios.get("api/checkbid/" + this.orderId).then(({data}) => ([this.ifBid = data]));
            },
            placeBid() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Place this bid??",
                    //type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, place it!'
                }).then((result) => {
                    if (result.value) {
                        axios.post("api/makebid/" + this.orderId).then(() => {
                            Fire.$emit('entry');
                            Swal.fire(
                                'Placed!',
                                'Bid successfully placed!!',
                                'success'
                            );
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

            getFilesCount(order) {
                axios.get("api/filescount/" + order.id).then(({data}) => ([this.filesCount = data]));
            },
            download(id, path) {
                axios.get("api/download/" + id, {responseType: 'blob'})
                    .then((response) => {
                        var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                        var fileLink = document.createElement('a');
                        console.log(fileLink);
                        fileLink.href = fileURL;
                        fileLink.setAttribute('download', path.substring(8));
                        document.body.appendChild(fileLink);

                        fileLink.click();
                    });
            },
            orderDetails(order) {
                $('#OrderDetails').modal('show');
                this.orderId = order.id;
                window.axios.get("api/order/" + order.id).then(({data}) => ([this.details = data]));
                window.axios.get("api/getfiles/" + order.id).then(({data}) => ([this.files = data]));
                window.axios.get("api/filescount/" + order.id).then(({data}) => ([this.filesCount = data]));
                this.checkBid();

            },
            getOrders() {
                window.axios.get("api/order").then(({data}) => ([this.orders = data.data]));
            },
        },
        created() {
            this.getLevel();
            this.getOrders();
            // // this.getDetails();
            // this.getFiles();
            // this.getFilesCount();
            Fire.$on('entry', () => {
                this.checkBid();
            })
        }
    }
</script>

