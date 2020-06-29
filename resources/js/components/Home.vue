<template>
    <div class="container">
        <div class="text-center">
            <div class="card">
                <div class="card">

                </div>
            </div>
            <h1>Hi, {{ user.name }}</h1>
            <div class="card-deck justify-content-center text-center">
                <div class="card text-white bg-primary" style="max-width: 18rem;">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-clipboard-list pr-2"></i>Listings</h4>
                    </div>
                    <div class="card-body">
                        <h1>{{ user.totalListings }}</h1>
                    </div>
                    <div class="card-footer listing-footer">
                        <h3>Create a Listing</h3>
                    </div>
                </div>

                <div class="card text-white bg-success" style="max-width: 18rem;">
                    <div class="card-header">
                        <h4 class="card-title"><i class="far fa-calendar-alt pr-2"></i>Events</h4>
                    </div>
                    <div class="card-body">
                        <h1>{{ user.totalEvents }}</h1>
                        </div>
                    <div class="card-footer event-footer" @click="linkToEventCreation">
                        <h3>Create an Event</h3>
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
            }
        },
        methods:{
            linkToEventCreation() {
                window.location = '/events/create';
            }
        },
        props: {
            user: {
                type: Object
            }
        }
    }
</script>

<style scoped>
    .listing-footer, .event-footer{
        cursor: pointer;
    }
</style>
