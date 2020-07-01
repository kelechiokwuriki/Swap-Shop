<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title header-text-color">Create an Event</h4>
            </div>
            <div class="card-body">
                <form role="form" prevent-default>
                    <div class="form-group">
                        <label for="event-name">Event Name</label>
                        <input type="text" v-model="event.name" class="form-control" id="event-name" placeholder="E.g my birthday meet up">
                    </div>
                    <div class="form-group">
                        <label for="event-when">When is the event?</label>
                        <DateTimePicker id="event-when" v-model="event.when" format="YYYY-MM-DD HH:mm"/>
                    </div>
                    <div class="form-group">
                        <label for="event-information">Give some information about the event</label>
                        <textarea type="text" v-model="event.information" class="form-control" id="event-information" placeholder="" />
                    </div>
                    <div class="form-group">
                        <label for="contact-information">Contact information</label>
                        <input type="text" v-model="event.contact_info" class="form-control" id="contact-information" placeholder="">
                    </div>
                </form>
                <div class="text-center">
                    <button type="button" class="btn btn-success btn-lg" @click="createEvent">Create Event</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                event: {
                    name: null,
                    when: null,
                    information: null,
                    contact_info: null
                },
                eventsApi: this.$helper.getEventsApi()
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
            createEvent() {
                axios.post(this.eventsApi, this.event).then(response => {
                    if(response.status === 201) {
                        this.feedBack('Success', 'Your event has been created', 'success');
                    } else {
                        this.feedBack('Oops...', 'Something went wrong please try again!', 'error')
                    }
                })
            }
        },
        mounted() {

        }
    }
</script>
