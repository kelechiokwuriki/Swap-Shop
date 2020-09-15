<template>
<div class="container-fluid">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Welcome Admin {{ user.name }}</h1>
            <p class="lead">You have administrative priviledges to do a lot</p>
            <hr class="my-4">
            <p>Get started below</p>
            <div class="row">
                <div class="col-sm-4">
                    <a class="btn btn-primary btn-lg" href="/admin/users" role="button">Manage Users</a>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary btn-lg" href="/admin/bulletin" role="button">Manage Bulletins</a>
                </div>
                <div class="col-sm-4">
                    <a class="btn btn-primary btn-lg" href="/admin/archivedbulletin" role="button">Archived Bulletins</a>
                </div>

                <!-- <div class="col-sm-3">
                    <a class="btn btn-primary btn-lg" href="/admin/events" role="button">Manage events</a>
                </div>  -->
            </div>
        </div>
    </div>
</div>

</template>

<script>
export default {

    props: {
            user: {
                type: Object
            }
        }

}
</script>
