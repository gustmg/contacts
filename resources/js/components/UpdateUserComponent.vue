<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img id="update_preview_user_profile_picture" :src="getImageUrl(users[0].id, users[0].profile_picture)" width="180" height="180"><br>
                    </div>
                    <div class="col-md-12"><br>
                        <div class="custom-file">
                            <input type="file" name="user_profile_picture" id="updateUserProfilePicture" class="custom-file-input" ref="file" v-on:change="onChangeFileUpload"/>
                            <label class="custom-file-label" for="updateUserProfilePicture">Choose file</label>
                        </div>
                    </div>
                </div><br>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <label for="userName">Nombre</label>
                        <input v-model="updateUserName" v-on:blur="validateUserName" v-bind:class="{'is-valid': validUserName, 'is-invalid': invalidUserName}" type="text" class="form-control" id="userName" placeholder="Ingresa tu nombre..." required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Correo electrónico</label>
                        <input v-model="updateUserEmail" v-on:blur="validateUserEmail" v-bind:class="{'is-valid': validUserEmail, 'is-invalid': invalidUserEmail}" type="email" class="form-control" id="userEmail" placeholder="Ingresa tu correo electrónico..." required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Teléfono</label>
                        <input v-model="updateUserPhone" v-on:blur="validateUserPhone" v-bind:class="{'is-valid': validUserPhone, 'is-invalid': invalidUserPhone}" type="tel" class="form-control" id="exampleInputEmail1" placeholder="Ingresa tu número telefónico..." data-length="10" minlength="10" maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label for="userGender">Sexo</label>
                        <select v-model="updateUserGender" class="form-control" id="userGender">
                            <option value="0">Masculino</option>
                            <option value="1">Femenino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userAddress">Dirección</label>
                        <input v-model="updateUserAddress" type="text" class="form-control" id="userAddress" placeholder="Ingresa tu dirección...">
                    </div>
                </form>
                <button v-on:click="updateUser" :disabled="validateForm" type="button" class="btn btn-primary">Guardar cambios</button>
            </div>
        </div>
    </div>
</template>
<style>
    .remove-image{
        float: none !important;
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Update User Modal Component Mounted');
        },

        props: {
            users: {
                type: Array
            }
        },

        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                updateUserName:this.users[0].name,
                updateUserPhone:this.users[0].phone,
                updateUserEmail:this.users[0].email,
                updateUserGender:this.users[0].gender,
                updateUserAddress:this.users[0].address,
                updateUserProfilePicture:this.users[0].profile_picture,
                userProfilePictureFile: null,
                validUserName: false,
                invalidUserName: false,
                validUserPhone: false,
                invalidUserPhone: false,
                validUserEmail: false,
                invalidUserEmail: false
            }
        },

        computed: {
            validateForm: function() {
                if(this.invalidUserName || this.invalidUserPhone || this.invalidUserEmail){
                    return true;
                }
                else{
                    return false;
                }
            }
        },

        methods: {            
            updateUser: function(){
                var userData = {
                    "user_id" : this.users[0].id,
                    "user_name" : this.updateUserName,
                    "user_email" : this.updateUserEmail,
                    "user_phone" : this.updateUserPhone,
                    "user_gender" : this.updateUserGender,
                    "user_address" : this.updateUserAddress,
                    "has_user_profile_picture" : this.updateUserProfilePicture,
                    "user_profile_picture" : this.userProfilePictureFile
                };

                // console.log(userData);

                var json=JSON.stringify(userData);

                var self=this;
                $.ajax({
                    url: "http://localhost/prueba/soapUserUpdate.php",
                    type: "POST",
                    data: {user : json},
                    dataType: "html",
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        console.log('Error.');
                    }
                });             
            },
            
            onChangeFileUpload(){
                this.file = this.$refs.file.files[0];
                if(this.file){
                    this.updateUserProfilePicture=1;
                    var reader = new FileReader();
                    var self=this;

                    reader.onload = function(e) {
                        $('#update_preview_user_profile_picture').attr('src', e.target.result);
                        self.setImageFile(reader.result);//Necesary for json request
                    }

                    reader. readAsDataURL(this.file);
                }
            },

            setImageFile: function(reader_result) {
                this.userProfilePictureFile = reader_result;
                // console.log(this.userProfilePictureFile);
            },

            removeProfilePicture: function() {
                this.updateUserProfilePicture=0;
                $('#update_preview_user_profile_picture').attr('src', 'img/profile_picture.png');
            },

            getImageUrl: function(user_id, user_profile_picture) {
                if(user_profile_picture){
                    return "storage/users/"+user_id+".png";
                }
                else{
                    return "img/profile_picture.png";
                }
            },

            validateUserName: function(e) {
                if(!this.updateUserName){
                    this.validUserName = false;
                    this.invalidUserName = true;
                }
                else{
                    this.validUserName = true;
                    this.invalidUserName = false;
                }
            },

            validateUserPhone: function(e) {
                const PHONE_REGEXP = /^[0-9]*$/gm;

                if(this.updateUserPhone ==null || this.updateUserPhone.length == 0){
                    this.validUserPhone = false;
                    this.invalidUserPhone = true;
                }
                else if(!PHONE_REGEXP.test(this.updateUserPhone) || this.updateUserPhone.length < 10){
                    this.validUserPhone = false;
                    this.invalidUserPhone = true;
                }
                else{
                    this.validUserPhone = true;
                    this.invalidUserPhone = false;
                }
            },

            validateUserEmail: function(e) {
                const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

                if(this.updateUserEmail ==null || this.updateUserEmail.length == 0){
                    this.validUserEmail = false;
                    this.invalidUserEmail = true;
                }
                else if(!MAIL_REGEXP.test(this.updateUserEmail)){
                    this.validUserEmail = false;
                    this.invalidUserEmail = true;
                }
                else{
                    this.validUserEmail = true;
                    this.invalidUserEmail = false;
                }
            }
        }
    }
</script>