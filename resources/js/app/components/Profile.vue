<template>
    <div>
        <v-container grid-list-md text-xs-center fluid fill-height>
            <v-layout row wrap>

                <v-flex xs12>
                    <v-card>
                        <v-breadcrumbs divider="/">
                            <v-breadcrumbs-item to="/" :disabled="false">home</v-breadcrumbs-item>
                            <v-breadcrumbs-item items="items" :disabled="true">profile</v-breadcrumbs-item>
                        </v-breadcrumbs>
                    </v-card>
                </v-flex>

            </v-layout>
        </v-container>



        <v-container grid-list-md fluid fill-height>
            <v-layout row wrap>

                <v-flex xs4>
                    <v-card>

                    </v-card>
                    <v-tabs light color="white" show-arrows>
                        <v-tabs-slider color="grey"></v-tabs-slider>

                        <v-tab>Photo</v-tab>

                        <v-tabs-items>
                            <v-tab-item value="">
                                <v-card flat class="tab-wrapp">

                                    <div class="in"></div>

                                    <!-- Uploader -->
                                    <input type="file" name="image" id="file" accept="image/*" @change="setImage"/>
                                    <label for="file" class="uploader-wrap">
                                        <img v-if="avatar" :src="avatar" class="cropped-image"/>

                                        <span v-else class="uploader-icon-wrap">
                                            <v-icon class="uploader-icon">photo</v-icon>
                                        </span>
                                    </label>
                                    <!-- Uploader -->

                                    <!-- Modal Box -->
                                    <v-dialog v-model="modal" persistent width="500">
                                        <v-card>
                                            <v-btn fab dark small color="primary">
                                                <v-icon dark @click.prevent="modal = false">remove</v-icon>
                                            </v-btn>

                                            <!-- Cropper -->
                                            <v-card-text>
                                                <vue-cropper ref='cropper'
                                                             :guides="true"
                                                             :view-mode="2"
                                                             drag-mode="crop"
                                                             :auto-crop-area="0.5"
                                                             :min-container-width="250"
                                                             :min-container-height="180"
                                                             :background="true"
                                                             :rotatable="true"
                                                             :src="imgSrc"
                                                             alt="Source Image"
                                                             :img-style="{ 'width': '400px', 'height': '300px' }">
                                                </vue-cropper>
                                            </v-card-text>
                                            <!-- Cropper -->

                                            <v-divider></v-divider>

                                            <v-card-text>
                                                <img :src="cropped_img" class="cropped-img"/>
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn v-if="cropped_img" color="primary" flat @click="saveImg">Save</v-btn>
                                                <v-btn color="primary" flat @click="cropImage">Crop</v-btn>
                                                <v-btn color="primary" flat @click="rotate">Rotate</v-btn>
                                                <v-btn color="link" flat @click="cancelCrop()">Cancel</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <!-- Modal Box -->

                                </v-card>
                            </v-tab-item>
                        </v-tabs-items>
                    </v-tabs>
                </v-flex>


                <!-- Tabs -->
                <v-flex xs8>
                    <v-card>
                        <v-tabs light color="white" show-arrows>
                            <v-tabs-slider color="grey"></v-tabs-slider>

                            <v-tab href="#info">Info</v-tab>
                            <v-tab href="#settings">Settings</v-tab>

                            <!-- Info -->
                            <v-tabs-items>
                                <v-tab-item value="info">
                                    <v-card flat>
                                        <v-card-text>
                                            <v-form v-if="data">
                                                <v-text-field label="name"
                                                              required
                                                              v-model="data.name"
                                                              :error="errors.name == false"
                                                              :error-messages="errors.name"
                                                              @keyup.enter="submit()">
                                                </v-text-field>
                                                <v-text-field label="email"
                                                              required
                                                              v-model="data.email"
                                                              readonly
                                                              :error="errors.email == false"
                                                              :error-messages="errors.email"
                                                              @keyup.enter="submit()">
                                                </v-text-field>

                                                <v-card-actions>
                                                    <v-btn @click="changeInfo()">save</v-btn>
                                                </v-card-actions>
                                            </v-form>
                                        </v-card-text>
                                    </v-card>
                                </v-tab-item>
                                <!-- Info -->

                                <!-- Settings -->
                                <v-tab-item value="settings">
                                    <v-card-text>
                                        <v-form v-if="data">
                                            <v-text-field label="Old password"
                                                          required
                                                          v-model="password.old_password"
                                                          type="password"
                                                          :error="errors.old_password == false"
                                                          :error-messages="errors.old_password"
                                                          @keyup.enter="submit()">
                                            </v-text-field>
                                            <v-text-field label="New password"
                                                          required
                                                          v-model="password.password"
                                                          type="password"
                                                          :error="errors.password == false"
                                                          :error-messages="errors.password"
                                                          @keyup.enter="submit()">
                                            </v-text-field>
                                            <v-text-field label="Confirm password"
                                                          required
                                                          v-model="password.password_confirmation"
                                                          type="password"
                                                          :error="errors.password_confirmation == false"
                                                          :error-messages="errors.password_confirmation"
                                                          @keyup.enter="submit()">
                                            </v-text-field>

                                            <v-btn @click="changePassword()">save</v-btn>
                                        </v-form>
                                    </v-card-text>
                                </v-tab-item>
                                <!-- Settings -->

                                </v-tab-item>
                            </v-tabs-items>
                        </v-tabs>
                    </v-card>
                </v-flex>
                <!-- Tabs -->

            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import VueCropper from 'vue-cropperjs'

    export default {
        data() {
            return {
                fillable: ['username', 'password', 'client_id', 'client_secret', 'grant_type'],
                hidden: ['old_password', 'password', 'password_confirmation'],
                avatar: null,
                password: {},
                errors: [],

                modal: false,
                current_photo: {},
                imgSrc: '',
                cropped_img: null
            }
        },

        computed: {
            ...mapGetters({
                data: 'getUser'
            })
        },

        methods: {
            ...mapActions({
                updatePassword: 'updatePassword',
                updateUser: 'updateUser'
            }),
            changeInfo() {
                console.log(this.data)
            },
            changePassword() {
                let data = fillForm(this.hidden, this.password)

                this.updatePassword(data).then(response => {
                    console.log(response.data)
                }).catch(err => {
                    this.errors = err.response.data.errors
                    console.log(this.errors)
                })
            },


            setImage(e) {
                const file = e.target.files[0]

                let formData = new FormData()

                formData.append('photo', e.target.files[0])

                if (typeof FileReader === 'function') {
                    this.modal = true
                    const reader = new FileReader()
                    reader.onload = (event) => {
                        // cropped image
                        this.imgSrc = event.target.result

                        this.$refs.cropper.replace(event.target.result)
                    };
                    reader.readAsDataURL(file)

                    this.$refs.cropper.value = null
                    document.getElementById('file').value = null
                } else {
                    alert('Sorry, FileReader API not supported')
                }

                this.current_photo = {}
            },
            cropImage() {
                this.cropped_img = this.$refs.cropper.getCroppedCanvas().toDataURL()

                if (Object.keys(this.current_photo).length !== 0) {
                    // this.photos.splice(this.current_photo.index, 1)
                }

                this.description = null
            },
            rotate() {
                this.$refs.cropper.rotate(90)
            },
            saveImg() {
                this.avatar = this.cropped_img
                this.cropped_img = null
                this.modal = false
            },
            cancelCrop() {
                this.modal = false
                this.cropped_img = null
            }
        }
    }
</script>

<style scoped>
    .uploader-wrap {
        display: inline-block;
        width: 170px;
        height: 170px;
        margin-top: 20px;
        border-radius: 50%!important;
        padding: 5px;
        cursor: pointer;
        border: 1px dashed gray;
        position: relative;
        text-align: center;
    }
    #file {
        display: none;
    }

    .uploader-icon-wrap {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .uploader-wrap:hover .uploader-icon {
        opacity: 0.8;
    }

    .uploader-icon {
        font-size: 55px!important;
    }

    .cropped-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%!important;
    }

    .cropped-img {
        max-width: 100%;
        max-height: 100%;
    }


    .tab-wrapp {
        text-align: center!important;
    }
</style>