<template>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Announcements</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" @click="newModal">
                                <i class="fas fa-pen"></i>
                                Compose Message
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Message</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="mes in messages" :key="mes.id">
                                <td>{{ mes.title | upText }}</td>
                                <td>{{ mes.created_at | myDate }}</td>
                                <td><span class="tag tag-success">{{ mes.status }}</span></td>
                                <td>{{ mes.message | upText | truncate('30') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" @click="editModal(mes)">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" @click="deleteMessage(mes.id)">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="modal fade" id="CommunicationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editMode" class="modal-title">Compose Message</h5>
                        <h5 v-show="editMode" class="modal-title">Edit Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? editMessage() :postMessage()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input v-model="form.title" type="text" class="form-control" name="title" id="title"
                                       placeholder="Title" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea v-model="form.message" class="form-control" id="message" rows="3"
                                          :class="{ 'is-invalid': form.errors.has('message') }"></textarea>
                                <has-error :form="form" field="message"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select v-model="form.status" class="form-control" name="status" id="status"
                                        :class="{ 'is-invalid': form.errors.has('status') }">
                                    <option selected value="">--Select Status--</option>
                                    <option value="Complete">Complete</option>
                                    <option value="Draft">Draft</option>
                                </select>
                                <has-error :form="form" field="status"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button v-show="!editMode" type="submit" class="btn btn-success">
                                <i class="fa fa-send"></i>
                                Post
                            </button>
                            <button v-show="editMode" type="submit" class="btn btn-primary">
                                <i class="fa fa-edit"></i>
                                Edit
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
        name: "Announcement",
        data() {
            return {
                editMode: false,
                messages: {},
                form: new Form({
                    id: '',
                    title: '',
                    status: '',
                    message: '',
                })
            }
        },
        methods: {
            editMessage() {
                this.$Progress.start();
                this.form.put('/api/Announcement/' + this.form.id).then(() => {
                    Fire.$emit('AfterCreate');
                    $('#CommunicationModal').modal('hide');
                    swal.fire(
                        'Updated!',
                        'The message has been updated.',
                        'success'
                    )
                    his.$Progress.finish();
                }).catch(() => {
                    this.$Progress.fail();
                })
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#CommunicationModal').modal('show');
            },
            editModal(mes) {
                this.editMode = true;
                this.form.reset();
                $('#CommunicationModal').modal('show');
                this.form.fill(mes);
            },
            deleteMessage(id) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('api/Announcement/' + id).then(() => {
                            swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');

                        }).catch(() => {
                            swal.fire(
                                'Failed!',
                                'An error occurred.',
                                'warning'
                            )
                        });
                    }
                })
            },
            loadMessages() {
                axios.get("api/announce").then(({data}) => (this.messages = data.data));
            },
            postMessage() {
                this.$Progress.start();
                this.form.post('api/Announcement')
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        $('#CommunicationModal').modal('hide');
                        toast.fire({
                            type: 'success',
                            title: 'Posted Successfully'
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {

                    })
            }
        },
        created() {
            this.loadMessages();
            Fire.$on('AfterCreate', () => {
                this.loadMessages();
            });
        }
    }
</script>

<style scoped>

</style>
