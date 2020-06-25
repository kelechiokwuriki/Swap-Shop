<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title header-text-color">Create a listing</h4>
            </div>
            <div class="card-body">
                <form role="form" prevent-default>
                    <div class="form-group">
                        <label for="listing-type">Type</label>
                        <select class="form-control" id="listing-type" v-model="listing.type">
                            <option>Select an option</option>
                            <option>Want</option>
                            <option>Offer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="listing-item">What would you like to offer or request for?</label>
                        <input type="text" v-model="listing.item" class="form-control" id="listing-item" placeholder="E.g the painting of Monalissa">
                    </div>

                    <div class="form-group">
                        <label for="listing-information">Give us some information about the item</label>
                        <textarea type="text" v-model="listing.information" class="form-control" id="listing-information" placeholder="" />
                    </div>

                    <div class="form-group">
                        <label for="listing-deal">What would you like the deal to be?</label>
                        <input type="text" v-model="listing.deal" class="form-control" id="listing-deal" placeholder="E.g I am offering £5 for the painting">
                    </div>

                </form>
                <div class="text-center">
                    <button type="button" class="btn btn-success btn-lg" @click="createListing">Create Listing</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listing: {
                    type: null,
                    item: null,
                    information: null,
                    deal: null
                }
            }
        },
        methods: {
            deleteListing(listingId) {

            },
            moment(date) {
                return moment(date);
            },
            feedBack(title, text, icon) {
                 return Swal.fire({
                     title: title,
                     text: text,
                     icon: icon
                 })
             },
            createListing() {
                axios.post('/api/listings', this.listing).then(response => {
                    if(response.status === 201) {
                        this.feedBack('Success', 'Your listing has been created', 'success');
                    } else {
                        this.feedBack('Oops...', 'Something went wrong please try again!', 'error')
                    }
                })
            }
        },
        mounted() {
            axios.get('/api/listings').then(response => {
                this.listings = response.data;
            })
        }
    }
</script>
