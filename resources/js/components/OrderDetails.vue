<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order Details<span class="badge badge-dark" style="margin-left: 4px;" v-if="details.urgency == 1">Urgent</span></h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box">
                                    <div class="box-header">
                                        <h4 class="box-title">Writer's Details</h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body no-padding table-responsive p-0">
                                        <table class="table">
                                            <tbody><tr>
                                                <th>Title</th>
                                                <th style="width: 40px">Details</th>
                                            </tr>
                                            <tr v-if="$gate.isAdmin()">
                                                <td><b>Name</b></td>
                                                <td>
                                                    <span>{{writer.name}}</span>
                                                    <span style="color: rebeccapurple;" v-if="!this.writer">No writer assigned</span>
                                                </td>
                                            </tr>
                                            <tr v-if="$gate.isAdmin()">
                                                <td><b>Phone</b></td>
                                                <td>
                                                    <span>{{writer.phone_number}}</span>
                                                    <span style="color: rebeccapurple;" v-if="!this.writer">No writer assigned</span>
                                                </td>
                                            </tr>
                                            <tr v-if="$gate.isAdmin()">
                                                <td><b>Email</b></td>
                                                <td>
                                                    <span>{{writer.email}}</span>
                                                    <span style="color: rebeccapurple;" v-if="!this.writer">No writer assigned</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Cost Per Page</b></td>
                                                <td><span>Ksh. {{details.amount}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Total Cost</b></td>
                                                <td><span>Ksh. {{details.total_amount}}</span></td>
                                            </tr>
                                            </tbody></table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                                <hr>
                                <div class="box">
                                    <div class="box-header">
                                        <h4 class="box-title">Order Details</h4>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body no-padding table-responsive p-0">
                                        <table class="table table-striped">
                                            <tbody>
                                            <tr>
                                                <th>Title</th>
                                                <th style="width: 40px">Details</th>
                                            </tr>
                                            <tr>
                                                <td><b>Order Number</b></td>
                                                <td><span>#{{details.order_number}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Title</b></td>
                                                <td><span>{{details.title}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Level</b></td>
                                                <td><span>{{details.academic_level}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Discipline</b></td>
                                                <td><span>{{details.discipline}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Viewers</b></td>
                                                <td><span>{{details.viewers}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>No. of Pages</b></td>
                                                <td><span>{{details.pages}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Deadline</b></td>
                                                <td><span style="color: red;">{{details.deadline|myDatetime}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Spacing</b></td>
                                                <td><span>{{details.spacing}}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Paper Format</b></td>
                                                <td><span>{{details.paper_format}}</span></td>
                                            </tr>
                                            </tbody></table>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <div class="box-header">
                                        <h4 class="box-title">Files</h4>
                                    </div>
                                    <div class="box" style="margin-bottom: 10px;">
                                        <div class="box-body">
                                            <button type="button" class="btn btn-success btn-sm" @click="newModal" v-if="$gate.isAdmin()">
                                                Add more files
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body" v-if="this.filesCount > 0">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12" v-for="file in files" :key="file.id">
                                                <a @click.prevent="download(file.id)">
                                                    <div class="info-box">
                                                        <span class="info-box-icon" style="background-color: green;"><i class="fas fa-download" style="color: white;"></i></span>

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
                                    <div class="alert alert-warning alert-dismissible" v-if="this.filesCount == 0">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h5><i class="icon fa fa-ban"></i> Alert!</h5>
                                        No files attached!!
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-header">
                                        <h5 class="box-title">Description</h5>
                                    </div>
                                    <div class="box-body">
                                        <p>
                                            <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-eye"></i>
                                                View
                                            </a>
                                        </p>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body">
                                                <div v-html="details.description"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5" v-if="$gate.isAdmin()">
                                        <h5>Rate this work</h5> <br>
                                        <div class="mt-5">
                                            <star-rating v-bind:increment="0.5" :read-only="myRate" :rating="rating" @rating-selected="setRating"></star-rating>
                                        </div>
                                    </div>
                                    <div v-if="$gate.isAdmin()">
                                        <button class="btn btn-success btn-sm"  @click="setRatting"><i class="fas fa-star"></i>Rate</button>
                                    </div>
                                </div>
                                <div class="box" v-if="$gate.isWriter()">
                                    <div class="box-body">
                                        <button type="button" class="btn btn-success btn-sm" @click="isCompleted">Upload completed task</button>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-header">
                                        <h4>Completed</h4>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12" v-for="com in completed" :key="com.id">
                                                <a @click.prevent="download(com.id)">
                                                    <div class="info-box">
                                                        <span class="info-box-icon" style="background-color: purple;"><i class="fas fa-download" style="color: white;"></i></span>

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

                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card-body composer">
                                <textarea v-model="message"  placeholder="Write your question here..."></textarea><br>
                                <div class="col-md-10">
                                    <button class="btn btn-success btn-md pull-left"  @click="sendMessage" ><i class="fas fa-paper-plane"></i>&nbsp;Send message</button>
                                </div>
                            </div>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="card-body conversation"  @new="handleIncoming">
                            <h1>Messages</h1>
                            <div class=" badge badge-pill badge-primary">{{typing}}</div>
                            <div class="card-body feed" ref="feed">
                                <ul>
                                    <li v-for="message in messages" :class="`message${message.to == users ? ' sent' : ' received'}`" :key="message.id">
                                        <div class="text">
                                            <span class="messo">{{ message.text }}</span><br/><small class="date">{{message.created_at | myDate}}</small>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnewLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addnewLabel">Add File(s)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="validate()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="files">Select File</label>
                                <input type="file" multiple class="form-control-file" @change="fieldChange" id="files">
                                <p style="color: red">{{this.e_files}}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-cloud-upload-alt"></i>
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            user: {
                type: Object,
                required: true
            }
        },
        data(){
            return{
                rating: 0,
                rated:'',
                myRate: false,
                message: '',
                typing: '',
                users : {},
                isComplete: false,
                e_files: '',
                completed: {},
                messages:[],
                orderId: this.$route.params.orderId,
                details: {},
                filesCount: '',
                files: {},
                writer: {},
                attachments:[],
                formf: new FormData(),
                form: new Form({
                })
            }
        },
        mounted() {
            Echo.private(`message.${this.user.id}`)
                .listen('ChatEvent',(e)=>{
                    this.messages.push(e.message);
                })
                .listenForWhisper('typing', (e) => {
                    if(e.name != ''){
                        this.typing = 'typing..'
                    }else{
                        this.typing = ''
                    }
                });
        },
        methods:{
            isCompleted(){
                this.isComplete = true;
                this.newModal();
            },
            setRatting(){
                if ( this.rated != 0) {
                    Swal.fire({
                        type: 'error',
                        title: 'already rated!',
                        text: 'you have already rated this work',
                    });
                    return;
                }
                axios.post('/api/rating',{
                    OrderId: this.orderId,
                    UserId: this.writer.id,
                    Rating: this.rating,
                }).then(response=>{
                    Swal.fire({
                        type: 'success',
                        title: 'Rating Submited!!',
                        text: 'Order rated successfully',

                    })
                }).catch(response=>{
                    //error
                });
            },
            getRate(){
                    axios.get("/api/myRate/" + this.orderId).then(({data})=>([this.rating = data]));
            },
            getWriter(){
                axios.get("/api/writer/" + this.orderId).then(({ data }) => ([this.writer = data]));
            },
            getRating(){
                axios.get("/api/rate/" + this.orderId).then(({data})=>([this.rated = data]));
            },
            validate(){
              if (this.attachments.length == 0){
                  this.e_files = 'This field is required';
                  return false;
              }else {
                  this.submit();
              }
            },
            downloadAll(){
                axios.post('/api/downloadAll/' + this.orderId);
            },
            submit(){
                for(let i=0; i<this.attachments.length;i++){
                    this.formf.append('files[]',this.attachments[i]);
                }

                const config = { headers: { 'Content-Type': 'multipart/form-data' } };

                if (this.isComplete){
                    axios.post('/api/uploadcomplete/' + this.orderId,this.formf,config).then(response=>{
                        Fire.$emit('entry');
                        $('#addnew').modal('hide');
                        this.form.reset();
                        Swal.fire({
                            type: 'success',
                            title: 'Submited!!',
                            text: 'File(s) sent successfully',

                        })

                    })
                        .catch(response=>{
                            //error
                        });
                } else {
                    axios.post('/api/addfiles/' + this.orderId,this.formf,config).then(response=>{
                        Fire.$emit('entry');
                        $('#addnew').modal('hide');
                        this.form.reset();
                        Swal.fire({
                            type: 'success',
                            title: 'Submited!!',
                            text: 'Files added successfully',

                        })

                    })
                        .catch(response=>{
                            //error
                        });
                }
            },
            fieldChange(e){
                let selectedFiles=e.target.files;
                if(!selectedFiles.length){
                    return false;
                }
                for(let i=0;i<selectedFiles.length;i++){
                    this.attachments.push(selectedFiles[i]);
                }
                console.log(this.attachments);
            },
            newModal(){
                this.form.reset();
                this.attachments = [];
                $('#addnew').modal('show');
            },
            handleIncoming(message) {
                this.messages.push(message);
            },
            scrollToBottom(){
                setTimeout(()=>{
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                },50);
            },
            sendMessage() {
                console.log(this.orderId);
                if ( this.message == '') {
                    return;
                }
                axios.post('/api/messenger/send', {
                    text: this.message,
                    OrderId : this.orderId,
                    contact_id : this.users,
                }).then((response) => {
                    this.messages.push(response.data);
                    this.message = '';
                })
            },
            download(id){
                axios.get("/api/download/" + id).then();
            },
            getDetails(){
                axios.get("/api/order/" + this.orderId).then(({ data }) => ([this.details = data]));
            },

            getFilesCount(){
                axios.get("/api/filescount/" + this.orderId).then(({ data }) => ([this.filesCount = data]));
            },
            getUser(){
                if (this.$gate.isAdmin()) {
                    axios.get("/api/getUser/" + this.orderId).then(({ data }) => ([this.users = data]));
                }
                if (this.$gate.isWriter()) {
                    axios.get("/api/getAdmin/").then(({ data }) => ([this.users = data]));
                }

            },

            getFiles(){
                axios.get("/api/getfiles/" + this.orderId).then(({ data }) => ([this.files = data]));
            },
            getCompletedFiles(){
                axios.get("/api/getcompleted/" + this.orderId).then(({ data }) => ([this.completed = data]));
            },
            getMessages(){
                 axios.get("/api/getMessage/" + this.orderId).then((response) => (this.messages = response.data));
            },
            setRating: function(rating){
                this.rating= rating;
            },
            hasRated(){
                if (this.rated != 0){
                    this.myRate = true;
                    console.log('ftyui');
                }else {
                    console.log('ftyui');
                }
            },
        },
        watch: {
            messages(messages){
                this.scrollToBottom();
            },
            message() {
                Echo.private(`message.${this.user.id}`)
                    .whisper('typing', {
                        name: this.message
                    });
            },
        },
        created() {
            this.getDetails();
            this.getFilesCount();
            this.getMessages();
            this.getFiles();
            this.getWriter();
            this.getRating();
            this.getRate();
            this.hasRated();
            this.getUser();
            this.getCompletedFiles();
            Fire.$on('entry', () =>{
                this.getFiles();
                this.getFilesCount();
                this.hasRated();
            })
        }
    }
</script>
<style lang="scss" scoped>
    .composer textarea {
        width: 80%;
        margin: 10px;
        border-radius: 3px;
        border: 1px solid lightgray;
        padding: 6px;
    }
    .conversation {
        overflow-y: scroll;
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        h1 {
            font-size: 20px;
            padding: 10px;
            margin: 0;
            border-bottom: 1px dashed lightgray;
        }
    }
    .messo{
        font-size: 15px;
        font-weight:700;
    }
    .date{
        color:#9e9e9e;
        font-weight:700;
    }
    .feed {
        background: #f0f0f0;
        height: 100%;
        max-height: 470px;
        overflow: scroll;
        ul {
            list-style-type: none;
            padding: 5px;
            li {
                &.message {
                    margin: 10px 0;
                    width: 100%;
                    .text {
                        max-width: 400px;
                        border-radius: 5px;
                        padding: 12px;
                        display: inline-block;
                    }
                    &.received {
                        text-align: right;
                        .text {
                            background: #00e676;
                        }
                    }
                    &.sent {
                        text-align: left;
                        .text {
                            background: #81c4f9;
                        }
                    }
                }
            }
        }
    }
</style>
