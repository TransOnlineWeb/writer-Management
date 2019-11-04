<style>
  .box-header {
    display: flex;
    padding: 4px;
  }
  .swal2-icon.swal2-warning {
    font-size: 20px;
  }
</style>
<template>
    <div class="container">
        <div class="row mt-4">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users</h3>

              <div class="box-tools ml-auto">
                <button class="btn btn-success" data-toggle="modal" data-target="#AddNew">Add New User</button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Level</th>
                  <th>Modify</th>
                </tr>
                 <!-- v-for="user in users" :key="user.id" -->
                <tr v-for="user in users" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td><span class="label label-success">{{user.role | upText}}</span></td>
                  <td>
                    <span v-if="user.status_id == 1">Active</span>
                    <span v-if="user.status_id == 0">Pending</span>
                    <span v-if="user.status_id == 2">Suspended</span>
                  </td>
                  <td>
                    <span v-if="user.level_id == 1">Active</span>
                    <span v-if="user.level_id == 0">Pending</span>
                    <span v-if="user.level_id == 2">Suspended</span>
                    <span v-else>Not Rated</span>
                  </td>
                  <td>
                      <a href="" data-toggle="modal" data-target="#Edit">
                          <i class="fa fa-edit blue"></i>
                      </a>
                      &nbsp;
                      <button @click="deleteUser(user.id)">
                          <i class="fa fa-trash red"></i>
                      </button>
                  </td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="AddNew" tabindex="-1" role="dialog" aria-labelledby="AddNewLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="AddNewLabel">Add New User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="addUser()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.name" type="text" class="form-control" name="name"id="name" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.email" type="email" class="form-control" name="email"id="email" placeholder="Email" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.phone" type="number" class="form-control" name="phone"id="phone" placeholder="Phone Number" :class="{ 'is-invalid': form.errors.has('phone') }">
                  <has-error :form="form" field="phone"></has-error>
                </div>
                <div class="form-group">
                  <select v-model="form.role" class="form-control" name="role" id="role"
                          :class="{ 'is-invalid': form.errors.has('role') }">
                      <option selected value="">--Select Level--</option>
                      <option value="writer">Writer</option>
                      <option value="editor">Editor</option>
                      <option value="admin">Admin</option>
                  </select>
                  <has-error :form="form" field="role"></has-error>
                </div>
                <div class="col">
                  <div class="form-group d-flex">
                      <label>Profile-Photo</label>
                      <input type="file" multiple class="form-control-file" id="photo" name="photo">
                      <has-error :form="form" field="photo"></has-error>
                  </div>
                </div>
                <div class="form-group">
                  <select v-model="form.level" class="form-control" name="level" id="level"
                          :class="{ 'is-invalid': form.errors.has('level') }">
                      <option selected value="">--Select Level--</option>
                      <option value="1">Starter</option>
                      <option value="2">Mid</option>
                      <option value="3">Senior</option>
                  </select>
                  <has-error :form="form" field="level"></has-error>
                </div>
                <div class="form-group">
                  <select v-model="form.status" class="form-control" name="status" id="status"
                          :class="{ 'is-invalid': form.errors.has('status') }">
                      <option selected value="">--Select Account Status--</option>
                      <option value="1">Active</option>
                      <option value="0">Pending</option>
                      <option value="2">Suspended</option>
                  </select>
                  <has-error :form="form" field="status"></has-error>
                </div>
                <div class="form-group">
                  <input v-model="form.password" type="password" class="form-control" name="password"id="password" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }">
                  <has-error :form="form" field="password"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">AddUser</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="Edit" tabindex="-1" role="dialog" aria-labelledby="EditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="EditLabel">Edit User Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
          </div>
        </div>
      </div>

    </div>
</template>


<script>
    export default {
        data(){
            return{
                users: {},
                form: new Form ({
                  name: '',
                  phone: '',
                  role: '',
                  level: '',
                  status: '',
                  photo: '',
                  email: '',
                  password: '',
                })
            }
        },
        methods: {
            deleteUser(id) {
              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                  if (result.value) {
                    this.form.delete('api/user/'+id).then(() => {
                        Swal.fire(
                          'Deleted!',
                          'User has been deleted.',
                          'success'
                        )
                      Fire.$emit('AfterCreate');
                    }).catch(() => {
                      Swal.fire(
                          'Failed!',
                          'We were unable to deleted.',
                          'warning'
                        )
                    });
                  }
                })
            },
            addUser() {
              this.$Progress.start();
              this.form.post('api/user')
              .then(() => {
                Fire.$emit('AfterCreate');
                  $('#AddNew').modal('hide');
                      this.form.reset();
                      Swal.fire({
                          type: 'success',
                          title: 'User Successfully Created',
                      })
                this.$Progress.finish();

              })
              .catch(() => {

              })
            },
            getUsers(){
              window.axios.get('api/user').then(({ data }) => (this.users = data.data));
            }
        },
        mounted() {
          this.getUsers();
          Fire.$on('AfterCreate',() => {
            this.getUsers();
          });
        }
    }
</script>
