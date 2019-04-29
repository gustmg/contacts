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
                        <input v-model="updateUserName" type="text" class="form-control" id="userName" placeholder="Ingresa tu nombre...">
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Correo electrónico</label>
                        <input v-model="updateUserEmail" type="email" class="form-control" id="userEmail" placeholder="Ingresa tu correo electrónico...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Teléfono</label>
                        <input v-model="updateUserPhone" type="tel" class="form-control" id="exampleInputEmail1" placeholder="Ingresa tu número telefónico...">
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
                <button v-on:click="updateUser" type="button" class="btn btn-primary">Guardar cambios</button>
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
                userProfilePictureFile: null
            }
        },

        methods: {            
            updateUser: function(){
                this.onChangeFileUpload();
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
                    return "storage/users/"+user_id+".jpg";
                }
                else{
                    return "img/profile_picture.png";
                }
            }
        }
    }
</script>