<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title header-text-color">Your Profile</h4>
                    </div>
                    <div class="card-body">
                        <form role="form" prevent-default>
                            <div class="form-group">
                                <label for="profile-name">Name</label>
                                <input type="text" v-model="profile.name" class="form-control" id="profile-name">
                            </div>
                            <div class="form-group">
                                <label for="profile-email">Email</label>
                                <input type="text" v-model="profile.email" class="form-control" id="profile-email">
                            </div>
                            <div class="form-group">
                                <label for="profile-password">Password</label>
                                <input type="text" v-model="password"  class="form-control" id="profile-password" placeholder="">
                            </div>
                            <div class="form-group row mt-4 mb-4">
                                <div class="col">
                                    <h4>You have created <span class="badge badge-primary">{{profile.events_count}}</span> events</h4>
                                </div>
                                <div class="col">
                                    <h4>You have created <span class="badge badge-primary">{{profile.listings_count}}</span> listings</h4>
                                </div>
                            </div>
                        </form>
                        <div class="text-center">
                            <button type="button" class="btn btn-primary btn-lg" @click="updateProfile">Update Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                profile: {},
                password: ''
            }
        },
        methods: {
            feedBack(title, text, icon) {
                 return Swal.fire({
                     title: title,
                     text: text,
                     icon: icon
                 })
             },
            updateProfile() {

                this.profile.password = this.password;

                axios.put('/api/profiles/' + this.user_id, this.profile).then(response => {
                    if(response.data === 1) {
                        return this.feedBack('Success', 'Your profile has been updated', 'success');
                    }

                    return this.feedBack('Error', 'An error occured, please try again', 'error');

                })
            }
        },
        props: {
            user_id: {
                type: Number
            }
        },
        mounted() {
            axios.get('/api/profiles/' + this.user_id).then(response => {
                this.profile = response.data;
            })
        }
    }
</script>
