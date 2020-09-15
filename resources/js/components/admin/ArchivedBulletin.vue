<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <h5 class="card-title pt-2">Archived Bulletins</h5>
                            </div>
                            <div class="col-sm-3">
                                <div class="float-right">
                                    <a class="btn btn-primary" href="/admin/bulletin" role="button">Create new bulletin</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="data-table_wrapper" class="dataTables_wrapper no-footer">
                                <table id="usersTable" class="table display table-hover text-center" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Bulletin Number</th>
                                            <th scope="col">Header</th>
                                            <th scope="col">Information</th>
                                            <th scope="col">Created</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="bulletin in bulletins" v-bind:key="bulletin.id">
                                           <td>{{ bulletin.number }}</td>
                                            <td>{{ bulletin.header }}</td>
                                            <td>{{ bulletin.swap_shop_info }}</td>
                                            <td>{{ moment(bulletin.created_at).format('MMMM Do YYYY, h:mm a') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                bulletins: [],
            }
        },
        methods: {
            getAllBulletin() {
                axios.get('/api/bulletin').then(response => {
                    this.bulletins = response.data;
                })
            },
            feedBack(title, text, icon) {
                return Swal.fire({
                    title: title,
                    text: text,
                    icon: icon
                });
            },

            moment(date) {
                return moment(date);
            },

        },
        mounted() {
            this.getAllBulletin();
        }
    }
</script>
