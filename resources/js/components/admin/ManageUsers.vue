<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title pt-2">{{ users.length }} Users</h5>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">Register a user</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body text-center">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" v-bind:key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ moment(user.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerUserModal">Register a new User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="user-name">Name</label>
                                <input type="text" v-model="user.name" class="form-control" id="user-name" placeholder="John Wick">
                            </div>

                            <div class="form-group">
                                <label for="user-email">Email</label>
                                <input type="email" v-model="user.email" class="form-control" id="user-email" placeholder="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="registerUser">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
            <!--end modal-->

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                usersApi: this.$helper.getUsersApi(),
                user: {
                    name: null,
                    email: null
                }
            }
        },
        methods: {
            feedBack(title, text, icon) {
                return Swal.fire({
                    title: title,
                    text: text,
                    icon: icon
                });
            },
            registerUser() {
                axios.post(this.usersApi, this.user).then(response => {
                    if(response.status === 201) {
                        this.users.push(response.data);

                        this.feedBack('Success', 'Successfully registered ' + this.user.name, 'success');
                    } else {
                        this.feedBack('Oops...', 'Something went wrong please try again!', 'error')
                    }
                })
            },
            moment(date) {
                return moment(date);
            },
            getUsers() {
                axios.get(this.usersApi).then(response => {
                    this.users = response.data;
                });
            }
        },
        computed: {

        },
        mounted() {
            this.getUsers();
        }
    }
</script>
