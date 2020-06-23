<template>
    <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4"><i class="fas fa-times"></i>Hi {{ user.name }}, please</h1>
                <a href="/listings/create" type="button" class="btn btn-primary btn-lg">Create a listing</a>
                <a href="/events/create" type="button" class="btn btn-secondary btn-lg">Create an event</a>
            </div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
            }
        },
        props: {
            user: {
                type: Object
            }
        }
    }
</script>
