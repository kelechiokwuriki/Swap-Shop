<template>
    <div class="container">

        <!--search bar-->
        <searchbar v-on:search="setSearchText" :searchPlaceHolder="searchPlaceHolder" v-show="listings.length !== 0"></searchbar>
        <!--search bar-->

        <div class="row justify-content-center content-container">

            <div class="text-center" v-show="listings.length === 0">
                <h1 class="mb-3">You have not made any listing</h1>
                <a role="button" href="/listings/create" class="btn btn-success btn-lg">Create a Listing</a>
            </div>

            <div class="col-md-8 topnow">
                <div class="card mb-4" v-for="listing in listingsToShow" v-bind:key="listing.id">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title pt-2">
                                    <template v-if="listing.type === 'Offer'">Offered</template>
                                    <template v-else>Wanted</template> on {{moment(listing.created_at).format('MMMM Do YYYY, h:mm:ss a')}}
                                </h5>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <button class="btn btn-primary" data-toggle="modal" @click="showEditListingModal(listing)">Edit</button>
                                    <button class="btn btn-danger" @click="deleteListing(listing.id)">Delete</button>
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

                    <div class="card-footer text-muted">
                        <template v-if="listing.updated_at !== listing.created_at">
                            Updated {{moment(listing.updated_at).fromNow()}}
                        </template>
                    </div>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="editListingModal" tabindex="-1" role="dialog" aria-labelledby="editListingModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editListingModal">Edit your listing</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                        <label for="listing-type">Type</label>
                        <select class="form-control" id="listing-type" v-model="editListingModalData.type">
                            <option>Select an option</option>
                            <option>Want</option>
                            <option>Offer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="listing-item">What would you like to offer or request for?</label>
                        <input type="text" v-model="editListingModalData.item" class="form-control" id="listing-item" placeholder="E.g the painting of Monalissa">
                    </div>

                    <div class="form-group">
                        <label for="listing-information">Give us some information about the item</label>
                        <textarea type="text" v-model="editListingModalData.information" class="form-control" id="listing-information" placeholder="" />
                    </div>

                    <div class="form-group">
                        <label for="listing-deal">What would you like the deal to be?</label>
                        <input type="text" v-model="editListingModalData.deal" class="form-control" id="listing-deal" placeholder="E.g I am offering £5 for the painting">
                    </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateListing()">Save changes</button>
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
                listings: [],
                editListingModalData: {
                    id: null,
                    type: null,
                    item: null,
                    information: null,
                    deal: null
                },
                searchListingText: '',
                searchPlaceHolder: "Search for a listing item",
                listingsApi: this.$helper.getlistingsApi()
            }
        },
        methods: {
            setSearchText(value) {
                this.searchListingText = value;
            },
            updateListing() {
                axios.put(this.listingsApi + this.editListingModalData.id, this.editListingModalData).then(response => {
                    if(response.data === 1) {
                        let localListingIndex = this.getListingIndexFromArray();
                        //update front end data
                        this.listings[localListingIndex].type = this.editListingModalData.type;
                        this.listings[localListingIndex].item = this.editListingModalData.item;
                        this.listings[localListingIndex].information = this.editListingModalData.information;
                        this.listings[localListingIndex].deal = this.editListingModalData.deal;
                        this.listings[localListingIndex].updated_at = moment().toDate();
                    }
                });
            },
            getListingIndexFromArray() {
                return this.listings.findIndex(listing => listing.id === this.editListingModalData.id);
            },
            showEditListingModal(listing) {
                this.editListingModalData.id = listing.id;
                this.editListingModalData.type = listing.type;
                this.editListingModalData.item = listing.item;
                this.editListingModalData.deal = listing.deal;
                this.editListingModalData.information = listing.information;

                $("#editListingModal").modal('show');
            },
            deleteListing(listingId) {
                axios.delete(this.listingsApi + listingId).then(response => {
                    if(response.data === 1) {

                        //delete front end data
                        let localListingIndex = this.getListingIndexFromArray();
                        this.listings.splice(localListingIndex, 1);
                    }
                })
            },
            moment(date) {
                return moment(date);
            },
            getListings() {
                axios.get(this.listingsApi).then(response => {
                    this.listings = response.data;
                })
            }
        },
        computed: {
            listingsToShow() {
                return this.listings.filter(listing => {
                    return listing.item.toLowerCase().includes(this.searchListingText.toLowerCase());
                })
            }
        },
        mounted() {
            this.getListings();
        }
    }
</script>

<style scoped>

</style>
