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
                                        <button type="button" class="btn btn-sm btn-success" @click="editModal(mes)">
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
    </div>
</template>

<script>
    export default {
        data(){
            return{
                announcement : {},
            }
        },
        methods : {
           getAnnouncement(){
               axios.get("api/Announcement").then(({data}) =>(this.announcement = data.data));
            }
        },
        created(){
            this.getAnnouncement();
        }
    }
</script>
