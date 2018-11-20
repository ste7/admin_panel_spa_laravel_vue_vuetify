<template>
    <div class="text-xs-center">
        <v-dialog v-model="visible" width="500">

            <v-card>
                <v-card-title class="headline grey lighten-2" primary-title>Message</v-card-title>

                <v-card-text>{{ message }}</v-card-text>

                <v-divider>dfadfdsf</v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" flat @click="visible = false">Ok</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                visible: false
            }
        }
    }
</script>