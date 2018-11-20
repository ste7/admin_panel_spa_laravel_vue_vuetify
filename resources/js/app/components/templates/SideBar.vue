<template>
    <div>
        <v-toolbar color="blue-grey"
                   dark
                   fixed
                   app
                   clipped-right>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Dashboard</v-toolbar-title>
            <v-spacer></v-spacer>

            <v-btn icon>
                <v-icon>apps</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>notifications</v-icon>
            </v-btn>


            <v-menu offset-y>
                <div class="dropdown-right" slot="activator">
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <img class="a" src="https://cdn3.iconfinder.com/data/icons/avatars-15/64/_Ninja-2-512.png">
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                            <v-list-tile-title v-if="user">{{ user.name }}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </div>

                <v-list>
                    <v-list-tile v-for="(item, index) in drop" :key="index" @click="out()">
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>


        <v-navigation-drawer fixed v-model="drawer" app dark>
            <v-toolbar flat class="transparent">
                <v-list class="pa-0">
                    <v-list-tile avatar>
                        <v-list-tile-avatar>
                            <img src="https://cdn3.iconfinder.com/data/icons/avatars-15/64/_Ninja-2-512.png">
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                            <v-list-tile-title v-if="user">{{ user.name }}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-toolbar>



            <v-list class="pt-0" dense>
                <v-divider></v-divider>

                <v-list-tile to="/">
                    <v-list-tile-action>
                        <v-icon>home</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-title>Home</v-list-tile-title>
                </v-list-tile>

                <v-list-group prepend-icon="group">
                    <v-list-tile slot="activator">
                        <v-list-tile-title>Users</v-list-tile-title>
                    </v-list-tile>

                    <v-list-tile v-for="(user, i) in users"
                                 :key="i"
                                 :to="user[2]">
                        <v-list-tile-action>
                            <v-icon v-text="user[1]"></v-icon>
                        </v-list-tile-action>

                        <v-list-tile-title v-text="user[0]"></v-list-tile-title>
                    </v-list-tile>
                </v-list-group>


                <v-list-group prepend-icon="gesture">
                    <v-list-tile slot="activator">
                        <v-list-tile-title>Web</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile v-for="(item, i) in web"
                                 :key="i"
                                 :to="item[2]">
                        <v-list-tile-action>
                            <v-icon v-text="item[1]"></v-icon>
                        </v-list-tile-action>

                        <v-list-tile-title v-text="item[0]"></v-list-tile-title>
                    </v-list-tile>
                </v-list-group>
            </v-list>

        </v-navigation-drawer>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        data(){
            return {
                loading: false,
                drawer: true,
                users: [
                    ['Profile', 'person', '/profile'],
                ],
                web: [
                    ['Articles', 'description', '/articles'],
                    ['Ads', 'center_focus_strong', '/ads'],
                    ['Questions', 'question_answer', '/questions'],
                    ['Tags', 'local_offer', '/tags'],
                ],
                drop: [
                    { title: 'Sign Out' }
                ]
            }
        },

        computed: {
            ...mapGetters({
                user: 'getUser'
            })
        },

        methods: {
            ...mapActions({
                signOut: 'signOut'
            }),
            out() {
                this.signOut()
                this.$router.push('/signin')
            }
        }
    }
</script>

<style scoped>
    .dropdown-right {
        cursor: pointer;
    }
</style>