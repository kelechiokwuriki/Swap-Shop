<template>

    <nav class="navbar justify-content-center search-bar fixed-top navbar-light bg-light">
        <form class="form-inline">
            <input type="text" size="30" class="form-control mr-sm-2" v-model="searchText" :placeholder="searchPlaceHolder" aria-label="Search">
        </form>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            searchText: ''
        }
    },
    props: {
        searchPlaceHolder: {
            type: String
        }
    },
    watch: {
        searchText: function(oldText, newText) {
           this.$emit('search', this.searchText);
        }
    }

}
</script>

<style scoped>
 .search-bar{
        margin-top: 55px;
    }
</style>
