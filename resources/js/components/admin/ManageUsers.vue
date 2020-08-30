<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- <div class="col-md-8"> -->
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title pt-2">{{ users.length }} User<span v-if="users.length > 1">s</span></h5>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">Register a new user</button>
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
                                            <th scope="col">Registered</th>
                                            <th scope="col">Verified</th>
                                            <th scope="col">Updated On</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" v-bind:key="user.id">
                                           <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>{{ user.events_count }}</td>
                                            <td>{{ user.listings_count }}</td>
                                            <td>{{ moment(user.created_at).format('MMMM Do YYYY, h:mm a') }}</td>
                                            <td>
                                                <span v-if="user.email_verified_at !== null">{{ moment(user.email_verified_at).format('MMMM Do YYYY, h:mm a') }}</span>
                                                <span v-else>Not Verified</span>
                                            </td>
                                            <td>{{ moment(user.updated_at).format('MMMM Do YYYY, h:mm a') }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" @click="showEditUserModal(user)">Edit User</button>
                                                <template v-if="user.name !== loggedinuser">
                                                    <button class="btn btn-danger btn-sm" v-if="user.email_verified_at === null" @click="showDeleteUserModal(user)">Delete Unverified User</button>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

             <!--Delete user Modal -->
            <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editListingModal">Delete Unverified User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Delete user <span class="font-weight-bold text-uppercase">{{ deleteUserModalData.name }}</span> from the platform?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" @click="deleteUser">Delete User</button>
                    </div>
                    </div>
                </div>
            </div>
            <!--end delete user modal-->

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
                },
                deleteUserModalData: {
                    id: null,
                    name: null
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
            deleteUser() {
                axios.delete(this.usersApi + this.deleteUserModalData.id).then(response => {
                    if(response.data === 1) {
                        let index = this.getUserIndexFromUsersArray();

                        this.users.splice(index, 1);

                        return this.feedBack('Success', 'Successfully deleted ' + this.deleteUserModalData.name, 'success');
                    }

                    return this.feedBack('Oops...', 'Something went wrong please try again!', 'error')
                });
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
            showDeleteUserModal(user) {
                this.deleteUserModalData.id = user.id;
                this.deleteUserModalData.name = user.name;

                $("#deleteUserModal").modal('show');
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
                    console.log(response);
                    if(response.status === 201) {
                        response.data.email_verified_at = null;

                        this.users.push(response.data);

                        setTimeout(function() {
                            $('#usersTable').DataTable({
                                // "ordering": [[2, "desc"]],
                                // stateSave: true,
                                "aaSorting": [[4, "asc"]],
                                pageLength: 10,
                                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                            });
                        }, );

                        this.feedBack('Success', 'Successfully registered ' + this.user.name, 'success');
                    } else {
                        this.feedBack('Oops...', 'Something went wrong please try again!', 'error')
                    }
                }).catch(error => {

                    switch(error.response.status) {
                        case 422:
                            this.feedBack('Oops...', 'User already exists!', 'error');
                            break;

                        case 500:
                            this.feedBack('Oops...', 'Something went wrong please try again!', 'error');
                            break;

                        default:
                            this.feedBack('Oops...', 'Something went wrong please try again!', 'error');
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
                        "aaSorting": [[4, "asc"]],
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                    });
                })
            }
        },
        props: {
            loggedinuser: {
                type: String
            }
        },
        mounted() {
            this.getUsers();
        }
    }
</script>
