<template>
    <div>
        <v-container grid-list-md text-xs-center fluid fill-height>
            <v-layout row wrap>

                <v-flex xs12>
                    <v-card>
                        <v-breadcrumbs divider="/">
                            <v-breadcrumbs-item to="/" :disabled="false">home</v-breadcrumbs-item>
                        </v-breadcrumbs>
                    </v-card>
                </v-flex>

            </v-layout>
        </v-container>
    </div>
</template>

<script>
    export default {
        //
    }
</script>