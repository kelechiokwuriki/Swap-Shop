<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title pt-2">Bulletin for last 7 days</h5>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">Register a user</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h4 class="card-title text-center">Events</h4>
                                <div class="card" v-for="event in bulletin.events" v-bind:key="event.id">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <h5 class="card-title">Mark for exclusion</h5>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="float-right">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">Name:</p>
                                            </div>
                                            <div class="col-8">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">{{event.name}}</p>
                                            </div>

                                            <div class="col-4">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">When:</p>
                                            </div>
                                            <div class="col-8">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">{{ moment(event.when).format('MMMM Do YYYY, h:mm:ss a') }}</p>
                                            </div>

                                            <div class="col-4">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">Information:</p>
                                            </div>
                                            <div class="col-8">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">{{event.information}}</p>
                                            </div>

                                            <div class="col-4">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">Contact info:</p>
                                            </div>
                                            <div class="col-8">
                                                <p :class="{ strikeThrough: shouldStrikeThrough }">{{event.contact_info}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <h4 class="card-title text-center">Listings</h4>
                                <div class="card" v-for="listing in bulletin.listings" v-bind:key="listing.id">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <h5 class="card-title">Mark for exclusion</h5>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="float-right">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <p>Item:</p>
                                            </div>
                                            <div class="col-8">
                                                <p>{{listing.item}}</p>
                                            </div>

                                            <div class="col-4">
                                                <p>Information:</p>
                                            </div>
                                            <div class="col-8">
                                                <p>{{listing.information}}</p>
                                            </div>

                                            <div class="col-4">
                                                <p>Deal:</p>
                                            </div>
                                            <div class="col-8">
                                                <p>{{listing.deal}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                bulletin: [],
                bulletinToSend: [],
                shouldStrikeThrough: false
            }
        },
        methods:{
            moment(date) {
                return moment(date);
            },
            linkToEventCreation() {
                window.location = '/events/create';
            },
            linkToListingCreation() {
                window.location = '/listings/create';
            },
            getBulletin() {
                axios.get('/api/bulletins').then(response => {
                    this.bulletin = response.data;
                    this.bulletinToSend = response.data;
                })
            }
        },
        mounted() {
            this.getBulletin();
        }
    }
</script>

<style scoped>
    .strikeThrough{
        text-decoration: line-through;
    }
</style>
