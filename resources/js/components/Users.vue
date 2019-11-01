<template>
    <div class="container">
        <div class="row mt-4">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users</h3>

              <div class="box-tools">

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
                  <td><span class="label label-success">{{user.role}}</span></td>
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
                      <a href="">
                          <i class="fa fa-edit blue"></i>
                      </a>
                      &nbsp;
                      <a href="">
                          <i class="fa fa-trash red"></i>
                      </a>
                  </td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </div>
</template>


<script>
    export default {
        data(){
            return{
                users: {},
            }
        },
        methods: {
            getUsers(){
              window.axios.get('api/user').then(({ data }) => (this.users = data.data));
            }
        },
        mounted() {
          this.getUsers();
        }
    }
</script>
