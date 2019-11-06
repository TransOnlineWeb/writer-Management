<template>
    <div class="container" v-if="$gate.isAdmin()">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Writers Categories</h3>

                        <div class="card-tools">
                            <button class="btn btn-sm btn-primary" @click="newModal">Add Category</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4" v-for="cat in categories.data" :key="cat.id">
                                <div class="info-box mb-3 bg-success">
                                    <span class="info-box-icon"><i class="fas fa-2x fa-chalkboard-teacher"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{cat.title}}</span>
                                        <span class="info-box-number">Ksh. {{cat.amount}}</span>
                                    </div>
                                    <span class="info-box-icon" @click="editCategory(cat)"><i
                                            class="fas fa-edit"></i></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnewLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!this.editMode">Add Category of Writer(s)</h5>
                        <h5 class="modal-title" v-if="this.editMode">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title</label>
                                <input v-model="form.title" type="text" name="name"
                                       placeholder="Enter Title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Amount Per Page</label>
                                <input v-model="form.amount" type="number" name="amount"
                                       placeholder="Amount Per Page"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('amount') }">
                                <has-error :form="form" field="amount"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" @click="addCategory" v-if="!this.editMode">
                                Create
                            </button>
                            <button type="button" class="btn btn-success" @click="updateCategory" v-if="this.editMode">
                                Update
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
        name: "WritersCategory",
        data() {
            return {
                categories: '',
                editMode: '',
                form: new Form({
                    id: '',
                    title: '',
                    amount: '',
                })
            }
        },
        methods: {
            updateCategory() {
                this.form.put('api/category/' + this.form.id)
                    .then(() => {
                        $('#addnew').modal('hide');
                        Swal.fire({
                            title: 'Updated!',
                            text: 'The Category has been updated.',
                            type: 'success'
                        })
                        Fire.$emit('entry');
                    })
                    .catch(() => {

                    })
            },
            editCategory(cat) {
                this.editMode = true;
                $('#addnew').modal('show');
                this.form.fill(cat);
            },
            getCategories() {
                axios.get("/api/category").then(({data}) => ([this.categories = data]));
            },
            addCategory() {
                this.form.post('api/category')
                    .then(() => {
                        Fire.$emit('entry');
                        toast.fire({
                            type: 'success',
                            title: 'Category created successfully'
                        });
                        this.form.reset();
                        $('#addnew').modal('hide');
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                        Swal.fire({
                            type: 'error',
                            title: 'Error!!',
                            text: error.response.data.msg,

                        })
                    })
            },
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addnew').modal('show');
            },
        }
        ,
        created() {
            this.getCategories();
            Fire.$on('entry', () => {
                this.getCategories();
            })
        }
    }
</script>

<style scoped>

</style>