<template>
    <v-app id="inspire">

        <side-bar v-if="signedIn"></side-bar>

        <v-content>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                signedIn: 'signedIn'
            })
        }
    }
</script>