<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4" v-for="listing in listings" v-bind:key="listing.id">
                <div class="card">
                    <div class="card-header">
                        <template v-if="listing.type === 'offer'">Offered</template>
                        <template v-else>Wanted</template> on {{moment(listing.created_at).format('MMMM Do YYYY, h:mm:ss a')}}

                        <div class="float-right">
                            <button class="btn btn-primary">Edit</button>
                            <button class="btn btn-danger" @click="deleteListing(listing.id)">Delete</button>
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
</template>

<script>
    export default {
        data() {
            return {
                listings: []
            }
        },
        methods: {
            deleteListing(listingId) {

            },
            moment(date) {
                return moment(date);
            },
        },
        mounted() {
            axios.get('/api/listings').then(response => {
                this.listings = response.data;
            })
        }
    }
</script>
