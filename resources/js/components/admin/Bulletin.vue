<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="card-title pt-2">Data from last 7 days</p>
                            </div>
                            <div class="col-sm-6 text-center">
                                <h4 class="card-title pt-2" v-show="step === 1">Select items not to be included in bulletin</h4>
                                <h4 class="card-title pt-2" v-show="step === 2">Include Bulletin header and footer</h4>
                                <h4 class="card-title pt-2" v-show="step === totalSteps">Preview and send email</h4>

                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <button class="btn btn-secondary" @click="previousStep" v-show="step !== 1">Go Back</button>
                                    <button class="btn btn-primary ml-1" @click="nextStep" v-show="step !== totalSteps">Next Step</button>
                                </div>
                            </div>
                        </div>
                    </div>


                        <div class="card-body">
                            <template v-if="step === 1">
                                <div class="row">
                                    <!--events bulletin-->
                                    <div class="col">
                                        <h4 class="card-title text-center">Events</h4>
                                        <div class="card mb-4" v-for="event in bulletin.events" v-bind:key="event.id">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <h5 class="card-title">Mark event for exclusion</h5>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="float-right">
                                                            <div class="form-check">
                                                                <input type="checkbox" @change="excludeEventFromBulletin(event.id)" class="form-check-input" id="exampleCheck1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">Name:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">{{event.name}}</p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">When:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">
                                                            {{ moment(event.when).format('MMMM Do YYYY, h:mm:ss a') }}
                                                        </p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">Information:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">{{event.information}}</p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">Contact info:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">{{event.contact_info}}</p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">Date created:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">
                                                            {{ moment(event.created_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                        </p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">Date updated:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: event.excluded_from_bulletin }">
                                                            {{ moment(event.updated_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end events bulletin-->

                                    <!--listings bulletin-->
                                    <div class="col">
                                        <h4 class="card-title text-center">Listings</h4>
                                        <div class="card mb-4" v-for="listing in bulletin.listings" v-bind:key="listing.id">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <h5 class="card-title">Mark listing for exclusion</h5>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="float-right">
                                                            <div class="form-check">
                                                                <input type="checkbox" @change="excludeListingFromBulletin(listing.id)" class="form-check-input" id="exampleCheck1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">Type:</p>

                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">{{listing.type}}</p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">Item:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">{{listing.item}}</p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">Information:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">{{listing.information}}</p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">Deal:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">{{listing.deal}}</p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">Date created:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">
                                                            {{ moment(listing.created_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                        </p>
                                                    </div>

                                                    <div class="col-4">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">Date updated:</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p :class="{ strikeThrough: listing.excluded_from_bulletin }">
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
                                    <div class="form-group">
                                        <h5><label for="header">Include your header in Bulletin</label></h5>
                                        <textarea-autosize
                                        id="header"
                                        class="form-control"
                                        ref="footerTextArea"
                                        v-model="bulletin.header"
                                        />
                                    </div>

                                    <div class="form-group">
                                        <h5><label for="footer">Include your footer in Bulletin</label></h5>
                                        <textarea-autosize
                                        id="footer"
                                        class="form-control"
                                        ref="headerTextArea"
                                        v-model="bulletin.footer"
                                        :min-height="30"
                                        />
                                    </div>
                                </form>
                            </template>
                            <template v-if="step === 3">
                                    <p class="keep-whitespace">{{ bulletin.header }}</p>

                                    <div v-for="listing in sortListingsPlaceWantFirst" v-bind:key="listing.id">

                                        <p v-if="listing.type === 'Want'">
                                        =============================
                                            Wanted
                                        =============================
                                        </p>
                                        <p v-else-if="listing.type === 'Offer'">
                                        =============================
                                            Offered
                                        =============================
                                        </p>
                                        <!-- <hr> -->

                                        <template v-if="listing.type === 'Want'">Wanted: {{listing.item}}</template>
                                        <template v-else-if="listing.type === 'Offer'">Offered: {{listing.item}}</template>
                                        Item: {{listing.item}} <br>
                                        Info: {{listing.information}} <br>
                                        Deal: {{listing.deal}} <br>
                                        Contact: {{listing.contact_info}} <br>
                                        Name: {{listing.user.name}} <br>
                                    </div>
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
                bulletin: [],
                step: 1,
                totalSteps: 3,
                shouldStrikeThrough: false,
                bulletin: {
                    header: '',
                    footer: ''
                }
            }
        },
        methods:{
            previousStep() {
                this.step--;
            },
            nextStep() {
                this.step++;

                if(this.step === 3) {
                    let res = this.sortByKey(this.bulletin.listings, 'type');
                    console.log(res);

                }

            },
            excludeEventFromBulletin(eventId) {
                let eventIndex = this.bulletin.events.findIndex((event => event.id == eventId));
                this.bulletin.events[eventIndex].excluded_from_bulletin = !this.bulletin.events[eventIndex].excluded_from_bulletin;
            },
            excludeListingFromBulletin(listingId) {
                let listingIndex = this.bulletin.listings.findIndex((listing => listing.id == listingId));
                this.bulletin.listings[listingIndex].excluded_from_bulletin = !this.bulletin.listings[listingIndex].excluded_from_bulletin;
            },
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
                    // this.bulletinToSend = response.data;
                })
            },
            compare( a, b ) {
                if ( a.type === 'Want' ){
                    return -1;
                }
                if ( a.type === 'Offer' ){
                    return 1;
                }
                return 0;
            },
            sortByKey(array, key) {
                return array.sort(function(a, b) {
                    var x = a[key]; var y = b[key];
                    return ((x < y) ? 1 : ((x > y) ? -1 : 0));
                });
            },
        },
        mounted() {
            this.getBulletin();
        },
        computed: {
            sortListingsPlaceWantFirst() {
                return this.sortByKey(this.bulletin.listings, 'type');
            }
        }
    }
</script>

<style scoped>
    .strikeThrough{
        text-decoration: line-through;
    }

    .keep-whitespace {
    white-space: pre-wrap;       /* Since CSS 2.1 */
    }

</style>
