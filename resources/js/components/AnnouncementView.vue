<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Announcements</div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Message</th>
                                    <th>view</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="ann in announcement" :key="ann.id">
                                    <td>{{ ann.title | upText }}</td>
                                    <td><span><i class="fas fa-clock"></i></span>{{ ann.created_at | myDatetime }}</td>
                                    <td>{{ ann.message | upText | truncate('30')}}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" @click="newModal(ann)">
                                            <i class="fas fa-eye"></i>
                                            view
                                        </button>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="CommunicationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5  class="modal-title">Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input v-model="form.title" type="text" class="form-control" name="title" id="title" disabled
                                       placeholder="Title" >
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea v-model="form.message" class="form-control" id="message" rows="3" readonly></textarea>
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
        data(){
            return{
                announcement : {},
                form: new Form({
                    id: '',
                    title: '',
                    status: '',
                    message: '',
                })
            }
        },
        methods : {
           getAnnouncement(){
               axios.get("api/Announcement").then(({data}) =>(this.announcement = data.data));
            },
            newModal(ann) {
                $('#CommunicationModal').modal('show');
                this.form.fill(ann);
            },
        },
        created(){
            this.getAnnouncement();
        }
    }
</script>
