<template>
    <div class="container">
        <div class="card">
            <div class="card-header navbar-custom-dark">
                <h4 class="card-title header-text-color">Create an Event</h4>
            </div>
            <div class="card-body">
                <form role="form" prevent-default>
                    <div class="form-group">
                        <label for="listing-type">Event Name</label>
                        <input type="text" v-model="event.name" class="form-control" id="listing-item" placeholder="E.g my birthday meet up">
                    </div>
                    <div class="form-group">
                        <label for="listing-item">When is the event?</label>
                        <DateTimePicker v-model="event.when" format="YYYY-MM-DD hh:mm"/>
                    </div>
                </form>
                <div class="text-center">
                    <button type="button" class="btn btn-success btn-lg" @click="createEvent">Create Listing</button>
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
                    when: null
                }
            }
        },
        methods: {
            createEvent() {

            }
        },
        mounted() {
            axios.get('/api/listings').then(response => {
                this.listings = response.data;
            })
        }
    }
</script>
