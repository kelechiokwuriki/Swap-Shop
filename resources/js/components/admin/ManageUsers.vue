<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- <div class="col-md-8"> -->
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

                    <div class="card-body">
                        <div id="data-table_wrapper" class="dataTables_wrapper no-footer">
                                <table id="usersTable" class="table display table-hover text-center" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                           <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Total Events</th>
                                            <th scope="col">Total Listings</th>
                                            <th scope="col">Date Registered</th>
                                            <th scope="col">Details Updated</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" v-bind:key="user.id">
                                           <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>{{ user.events_count }}</td>
                                            <td>{{ user.listings_count }}</td>
                                            <td>{{ moment(user.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</td>
                                            <td>{{ moment(user.updated_at).format('MMMM Do YYYY, h:mm:ss a') }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" @click="showEditUserModal(user)">Edit User</button>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal">Deactivate User</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        <!-- <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Total Events</th>
                                <th scope="col">Total Listings</th>
                                <th scope="col">Date Registered</th>
                                <th scope="col">Details Updated</th>
                                <th scope="col">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" v-bind:key="user.id">
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.events_count }}</td>
                                <td>{{ user.listings_count }}</td>
                                <td>{{ moment(user.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</td>
                                <td>{{ moment(user.updated_at).format('MMMM Do YYYY, h:mm:ss a') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" @click="showEditUserModal(user)">Edit User</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal">Deactivate User</button>
                                </td>
                                </tr>
                            </tbody>
                        </table> -->
                    </div>
                </div>
            <!-- </div> -->

             <!--Edit user Modal -->
            <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editListingModal">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="listing-deal">New Name</label>
                                <input type="text" v-model="editUserModalData.name" class="form-control" id="listing-deal">
                            </div>
                            <div class="form-group">
                                <label for="listing-deal">New Email Address</label>
                                <input type="text" v-model="editUserModalData.email" class="form-control" id="listing-deal">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateUserDetails()">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
            <!--end edit user modal-->

            <!-- Register User Modal -->
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
            <!--end register user modal-->

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
                },
                editUserModalData: {
                    id: null,
                    name: null,
                    email: null
                }
            }
        },
        methods: {
            updateUserDetails() {
                axios.put(this.usersApi + this.editUserModalData.id, this.editUserModalData).then(response => {
                    if(response.data === 1) {
                        let index = this.getUserIndexFromUsersArray();

                        this.users[index].name = this.editUserModalData.name;
                        this.users[index].email = this.editUserModalData.email;
                        this.users[index].events_count = 0;
                        this.users[index].listings_count = 0;
                        this.users[index].updated_at = moment().toDate();
                    }
                })
            },
            getUserIndexFromUsersArray() {
                return this.users.findIndex(user => user.id === this.editUserModalData.id);
            },
            showEditUserModal(user) {
                this.editUserModalData.id = user.id;
                this.editUserModalData.name = user.name;
                this.editUserModalData.email = user.email;

                $("#editUserModal").modal('show');
            },
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
                }).catch(error => {

                }).finally(() => {
                    $('#usersTable').DataTable({
                        // "ordering": [[2, "desc"]],
                        // stateSave: true,
                        "aaSorting": [[1, "desc"]],
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                    });
                })
            }
        },
        computed: {

        },
        mounted() {
            this.getUsers();
        }
    }
</script>
