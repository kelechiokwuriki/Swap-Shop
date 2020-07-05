<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Swap Shop Terms of Service</h4></div>

                    <div class="card-body">
                        Swap Shop needs your permission to store your data such as your listings, events,
                        user profile in order for you to use this website correctly.
                        Swap Shop will never share your data with any Third Party entity.
                    </div>

                    <div class="card-footer text-center">
                        <button class="btn btn-primary mr-3" @click="acceptTermsOfService">Accept</button>
                        <button class="btn btn-secondary" @click="logUserOut">I do not want to use this platform</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods:{
            acceptTermsOfService() {
                axios.post('/api/accept-terms-of-service').then(response => {
                    if(response.data === 1) {
                        if(this.path !== '') {
                            window.location.href = '/' + this.path;
                        }
                    }
                })
            },
            logUserOut() {
                //send to logout
            }
        },
        props: {
            path: {
                type: String,
                default: ''
            }
        }
    }
</script>
