<template>
    <div class="container">
        <div class="card">
            <div class="card-header navbar-custom-dark">
                <h4 class="card-title header-text-color">Create an Event</h4>
            </div>
            <div class="card-body">
                <form role="form" prevent-default>


                </form>
                <div class="text-center">
                    <button type="button" class="btn btn-success btn-lg">Create Listing</button>
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
