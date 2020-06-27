<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title pt-2">All Users</h5>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <button class="btn btn-primary" @click="registerUser">Register a user</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
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
            <!-- <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEventModal">Edit your event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="event-name">Event Name</label>
                                <input type="text" v-model="editEventModalData.name" class="form-control" id="event-name" placeholder="E.g my birthday meet up">
                            </div>

                            <div class="form-group">
                                <label for="event-when">When is the event?</label>
                                <DateTimePicker id="event-when" v-model="editEventModalData.when" format="YYYY-MM-DD HH:mm"/>
                            </div>

                            <div class="form-group">
                                <label for="event-information">Give some information about the event</label>
                                <textarea type="text" v-model="editEventModalData.information" class="form-control" id="event-information" placeholder="" />
                            </div>

                            <div class="form-group">
                                <label for="contact-information">Contact information</label>
                                <input type="text" v-model="editEventModalData.contact_info" class="form-control" id="contact-information" placeholder="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveEvent()">Save changes</button>
                    </div>
                    </div>
                </div>
            </div> -->
            <!--end modal-->

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                usersApi: this.$helper.getUsersApi()
            }
        },
        methods: {
            registerUser() {

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
