<template>

    <nav class="navbar justify-content-center search-bar fixed-top navbar-light bg-light w-50">
        <form class="form-inline">
            <input type="text" size="30" class="form-control mr-sm-2 border border-dark" v-model="searchText" :placeholder="searchPlaceHolder" aria-label="Search">
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
    margin: 0 auto;
    margin-top: 55px;
    }
</style>
