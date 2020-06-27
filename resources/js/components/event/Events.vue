<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4" v-for="event in events" v-bind:key="event.id">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title pt-2">Event created on {{moment(event.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</h5>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <button class="btn btn-primary" data-toggle="modal" @click="showEditEventModal(event)">Edit</button>
                                    <button class="btn btn-danger" @click="deleteEvent(event.id)">Delete</button>
                                </div>
                            </div>
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
                                <p>{{ moment(event.when).format('MMMM Do YYYY, h:mm:ss a') }}</p>
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
                        </div>
                    </div>

                      <div class="card-footer text-muted">
                        <template v-if="event.updated_at !== event.created_at">
                            Updated {{moment(event.updated_at).fromNow()}}
                        </template>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="editEventModal" aria-hidden="true">
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
            </div>
            <!--end modal-->

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                events: [],
                editEventModalData: {
                    id: null,
                    name: null,
                    when: null,
                    information: null,
                    contact_info: null
                },
                eventsApi: this.$helper.getEventsApi()
            }
        },
        methods: {
            saveEvent() {
                axios.put(this.eventsApi + this.editEventModalData.id, this.editEventModalData).then(response => {
                    if(response.data === 1) {
                        let localEventIndex = this.getEventIndexFromArray();
                        //update front end data
                        this.events[localEventIndex].name = this.editEventModalData.name;
                        this.events[localEventIndex].when = this.editEventModalData.when;
                        this.events[localEventIndex].information = this.editEventModalData.information;
                        this.events[localEventIndex].contact_info = this.editEventModalData.contact_info;
                        this.events[localEventIndex].updated_at = moment().toDate();
                    }
                });
            },
            getEventIndexFromArray() {
                return this.events.findIndex(event => event.id === this.editEventModalData.id);
            },
            showEditEventModal(event) {
                this.editEventModalData.id = event.id;
                this.editEventModalData.name = event.name;
                this.editEventModalData.when = event.when;
                this.editEventModalData.information = event.information;
                this.editEventModalData.contact_info = event.contact_info;

                $("#editEventModal").modal('show');
            },
            deleteEvent(eventId) {
                axios.delete(this.eventsApi + eventId).then(response => {
                    if(response.data === 1) {

                        //delete front end data
                        let localEventIndex = this.getEventIndexFromArray();
                        this.events.splice(localEventIndex, 1);
                    }
                })
            },
            moment(date) {
                return moment(date);
            },
            getEvents() {
                axios.get(this.eventsApi).then(response => {
                    this.events = response.data;
                });
            }
        },
        mounted() {
            this.getEvents();
        }
    }
</script>
