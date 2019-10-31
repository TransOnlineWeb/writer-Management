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
                  <th>Modify</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>11-7-2014</td>
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

        return {
          users : {},
        }
      },

      methods: {
        getUsers(){
          axios.get("api/user").then(({ data })=>(this.users = data));
        }
      },
        mounted() {
            this.getUsers();
        }
    }
</script>
