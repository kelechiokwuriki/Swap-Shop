<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="card-title pt-2" v-if="bulletin.events.length !== 0 || bulletin.listings.length !== 0">Data from last 7 days</p>
                            </div>
                            <div class="col-sm-6 text-center">
                                <template v-if="bulletin.events.length !== 0 || bulletin.listings.length !== 0">
                                    <h4 class="card-title pt-2" v-show="step === 1">Filter items to be included in Bulletin</h4>
                                    <h4 class="card-title pt-2" v-show="step === 2">Include Bulletin header and footer</h4>
                                    <h4 class="card-title pt-2" v-show="step === totalSteps">Preview and send Bulletin</h4>
                                </template>
                                <template v-else>
                                    <h4 class="card-title pt-2">No bulletin from the last 7 days</h4>
                                </template>

                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <template v-if="bulletin.events.length !== 0 || bulletin.listings.length !== 0">
                                        <button class="btn btn-secondary" @click="previousStep" v-show="step !== 1">Go Back</button>
                                        <button class="btn btn-primary ml-1" @click="nextStep" v-show="step !== totalSteps">Next Step</button>
                                        <button class="btn btn-primary ml-1" @click="sendBulletin" v-show="step === totalSteps"
                                        :disabled="sendingBulletin">
                                            <template v-if="sendingBulletin">
                                                 <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    Sending...
                                            </template>
                                            <template v-else>
                                                Send Bulletin
                                            </template>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>


                        <div class="card-body">
                            <template v-if="step === 1">
                                <div class="row">
                                    <!--events bulletin-->
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h4 class="card-title text-center">Events</h4>
                                            </div>
                                            <div class="col-sm-6">
                                                 <div class="form-check">
                                                    <input type="checkbox" v-model="selectAllEvents" class="form-check-input" id="defaultCheck2">
                                                    <label class="h5 form-check-label" for="defaultCheck2">
                                                        <span v-if="selectAllEvents">Un-select all Events</span>
                                                        <span v-else>Select all Events</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="card mb-4" v-for="event in bulletin.events" v-bind:key="event.id">
                                                <div class="card-header">
                                                    <div class="form-check">
                                                        <input type="checkbox" v-model="event.included_in_bulletin" class="form-check-input" id="defaultCheck2">
                                                        <label class="h5 form-check-label" for="defaultCheck2">
                                                            <span v-if="event.included_in_bulletin">
                                                                Un-mark
                                                            </span>
                                                            <span v-else>Mark</span>
                                                            event for
                                                            <span v-if="event.included_in_bulletin">
                                                                exclusion
                                                            </span>
                                                            <span v-else>inclusion</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <div class="col-4">
                                                            <p>Name:</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <p>{{event.name}}</p>
                                                        </div>

                                                        <div class="col-4">
                                                            <p>When:</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <p>
                                                                {{ event.when }}
                                                            </p>
                                                        </div>

                                                        <div class="col-4">
                                                            <p>Information:</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <p>{{event.information}}</p>
                                                        </div>

                                                        <div class="col-4">
                                                            <p>Contact info:</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <p>{{event.contact_info}}</p>
                                                        </div>

                                                        <div class="col-4">
                                                            <p>Date created:</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <p>
                                                                {{ moment(event.created_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                            </p>
                                                        </div>

                                                        <div class="col-4">
                                                            <p>Date updated:</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <p>
                                                                {{ moment(event.updated_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!--end events bulletin-->

                                    <!--listings bulletin-->
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h4 class="card-title text-center">Listings</h4>
                                            </div>
                                            <div class="col-sm-6">
                                                 <div class="form-check">
                                                    <input type="checkbox" v-model="selectAllListings" class="form-check-input" id="defaultCheck3">
                                                    <label class="h5 form-check-label" for="defaultCheck3">
                                                        <span v-if="selectAllListings">Un-select all Listings</span>
                                                        <span v-else>Select all Listings</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-4" v-for="listing in bulletin.listings" v-bind:key="listing.id">
                                            <div class="card-header">
                                                    <div class="form-check">
                                                        <input type="checkbox" v-model="listing.included_in_bulletin" class="form-check-input" id="defaultCheck1">
                                                        <label class="h5 form-check-label" for="defaultCheck1">
                                                            <span v-if="listing.included_in_bulletin">
                                                                    Un-mark
                                                                </span>
                                                                <span v-else>Mark</span>
                                                                listing for
                                                                <span v-if="listing.included_in_bulletin">
                                                                    exclusion
                                                                </span>
                                                                <span v-else>inclusion</span>
                                                        </label>
                                                    </div>

                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-4">
                                                        <p>Type:</p>

                                                    </div>
                                                    <div class="col-8">
                                                        <p>{{listing.type}}</p>
                                                    </div>

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

                                                    <div class="col-4">
                                                        <p>Date created:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p>
                                                            {{ moment(listing.created_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                        </p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p>Date updated:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p>
                                                            {{ moment(listing.updated_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end listings bulletin-->
                                </div>
                            </template>
                            <template v-if="step === 2">
                                <form role="form" prevent-default>
                                    <!--bulletin number-->
                                    <div class="form-group">
                                        <h5><label for="number">Current Bulletin Number</label></h5>
                                        <input type="number" v-model="bulletinToSend.number" min="1" class="form-control">
                                    </div>
                                    <!--end bulletin number-->

                                    <!--bulletin header-->
                                    <div class="form-group">
                                        <h5>
                                            <label for="header" class="mt-3">
                                                <template v-if="bulletinToSend.header !== ''">
                                                We retrieved the last bulletin header and updated the number. Update the header as you please
                                                </template>
                                                <template v-else>Bulletin Header</template>
                                            </label>
                                        </h5>
                                        <textarea-autosize
                                        id="header"
                                        class="form-control"
                                        ref="footerTextArea"
                                        v-model="bulletinToSend.header"
                                        />
                                    </div>
                                    <!--end bulletin header-->

                                    <!--bulletin footer-->
                                    <div class="form-group">
                                        <h5>
                                            <label for="footer" class="mt-3">
                                                <template v-if="bulletinToSend.swap_shop_info !== ''">
                                                    We retrieved the last Swap Shop information. Update the information as you please
                                                </template>
                                                <template v-else>Bulletin Information/Footer</template>
                                            </label>
                                        </h5>
                                        <textarea-autosize
                                        id="footer"
                                        class="form-control"
                                        ref="headerTextArea"
                                        v-model="bulletinToSend.swap_shop_info"
                                        :min-height="30"
                                        />
                                    </div>
                                    <!--end bulletin footer-->
                                </form>
                            </template>
                            <template v-if="step === 3">

                                    <p class="keep-whitespace">{{ bulletinToSend.header }}</p>

                                    <p>
                                    =============================
                                        Wanted
                                    =============================
                                    </p>

                                    <div v-for="listing in wantedListings" v-bind:key="'li'+listing.id">
                                        Wanted: {{listing.item}} <br>
                                        Info: {{listing.information}} <br>
                                        Deal: {{listing.deal}} <br>
                                        Contact: {{listing.user.email}} <br>
                                        Name: {{listing.user.name}} <br><br><br>
                                    </div>

                                    <p>
                                    =============================
                                        Offered
                                    =============================
                                    </p>

                                    <div v-for="listing in offeredListings" v-bind:key="'li'+listing.id">
                                        Offered: {{listing.item}} <br>
                                        Info: {{listing.information}} <br>
                                        Deal: {{listing.deal}} <br>
                                        Contact: {{listing.user.email}} <br>
                                        Name: {{listing.user.name}} <br><br><br>
                                    </div>

                                    <br>
                                    <br>


                                    <p>
                                        =============================
                                        Events
                                        =============================
                                    </p>

                                    <div v-for="event in bulletinToSend.events" v-bind:key="'ev'+event.id">
                                        <br>
                                        Event: {{event.name}} <br>
                                        Info: {{event.information}} <br>
                                        When: {{event.when}} <br>
                                        Contact: {{event.contact_info}} <br>
                                    </div>

                                    <br>
                                    <br>
                                    =============================
                                    Swap Shop Information
                                    =============================
                                    <p class="keep-whitespace">{{ bulletinToSend.swap_shop_info }}</p>

                            </template>
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
                selectAllListings: false,
                selectAllEvents: false,
                sendingBulletin: false,
                bulletin: [],
                step: 1,
                totalSteps: 3,
                regexMatch: '/\d+/',
                bulletinToSend: {
                    number: null,
                    header: '',
                    swap_shop_info: '',
                    listings: [],
                    events: []
                }
            }
        },
        methods:{
            previousStep() {
                this.step--;
            },
            nextStep() {
                this.step++;

                if(this.step === this.totalSteps) {
                    let listingResult = this.sortListingByWantFirst(this.bulletin.listings, 'type');

                    //return items included for bulletin
                    this.bulletinToSend.listings = listingResult.filter(listing => {
                        return listing.included_in_bulletin !== false;
                    })

                    this.bulletinToSend.events = this.bulletin.events.filter(event => {
                        return event.included_in_bulletin !== false;
                    })
                }
            },
            moment(date) {
                return moment(date);
            },
            getBulletin() {
                axios.get('/api/bulletindata').then(response => {
                    this.bulletin = response.data;
                })
            },
            sendBulletin() {
                this.sendingBulletin = true;

                axios.post('/api/bulletin', this.bulletinToSend).then(response => {
                    if(response.data === 'Done') {
                        this.sendingBulletin = false;
                        this.feedBack('Bulletin number ' + this.bulletinToSend.number, 'Successfully sent your bulletin for the week!', 'success');
                    }
                })
            },
            feedBack(title, text, icon) {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon
                }).then(function() {
                    window.location.href = '/admin';
                })
            },
            sortListingByWantFirst(array, key) {
                return array.sort(function(a, b) {
                    var x = a[key];
                    var y = b[key];
                    return ((x < y) ? 1 : ((x > y) ? -1 : 0));
                });
            },
            getBulletinForLastSevenDays() {
                axios.get('/api/latestBulletinData').then(response => {
                    this.bulletinToSend.number = response.data.number;

                    //replace the number on header with the number from database
                    this.bulletinToSend.header = response.data.header.replace(response.data.header.match(/\d+/), response.data.number);

                    this.bulletinToSend.swap_shop_info = response.data.swap_shop_info;
                })
            }
        },
        mounted() {
            this.getBulletin();
            this.getBulletinForLastSevenDays();
        },
        watch: {
            selectAllEvents (value) {
                    this.bulletin.events.forEach(event => {
                        event.included_in_bulletin = !event.included_in_bulletin;
                    })
            },
            selectAllListings (value) {
                this.bulletin.listings.forEach(listing => {
                    listing.included_in_bulletin = !listing.included_in_bulletin;
                })
            }
        },
        computed: {
            sortListingsPlaceWantFirst() {
                let listingResult = this.sortListingByWantFirst(this.bulletin.listings, 'type');

                //return items included for bulletin
                return listingResult.filter(listing => {
                    return listing.included_in_bulletin !== 1;
                })
            },
            wantedListings() {
                return this.bulletinToSend.listings.filter(listing => listing.type === 'Want');
            },
            offeredListings() {
                return this.bulletinToSend.listings.filter(listing => listing.type === 'Offer');
            }
        }
    }
</script>

<style scoped>
    .keep-whitespace {
    white-space: pre-wrap;
    }

</style>
