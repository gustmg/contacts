<template>
    <div class="modal fade" id="newContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="newContactForm" method="POST" action="/contacts" data-toggle="validator">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <img id="preview_contact_profile_picture" src="img/profile_picture.png" width="80" height="80"><br>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="custom-file">
                                                <input type="file" name="contact_profile_picture" id="contactProfilePicture" class="custom-file-input" ref="file" v-on:change="onChangeFileUpload"/>
                                                <label class="custom-file-label" for="contactProfilePicture">Choose file</label>
                                            </div>
                                        </div>
                                    </div><br>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <label for="contactName">Nombre *</label>
                                        <input v-model="newContactName" v-on:blur="validateContactName" v-bind:class="{'is-valid': validContactName, 'is-invalid': invalidContactName}" name="contact_name" type="text" class="form-control" id="contactName" placeholder="Ingresar nombre..." maxlength="50" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <label for="contactMail">E-mail *</label>
                                        <input v-model="newContactEmail" v-on:blur="validateContactEmail" v-bind:class="{'is-valid': validContactEmail, 'is-invalid': invalidContactEmail}" name="contact_email" type="email" class="form-control" id="contactEmail" placeholder="Ingresar e-mail..." maxlength="40" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label for="contactPhone">Teléfono *</label>
                                        <input v-model="newContactPhone" v-on:blur="validateContactPhone" v-bind:class="{'is-valid': validContactPhone, 'is-invalid': invalidContactPhone}" name="contact_phone" type="tel" class="form-control" id="contactPhone" placeholder="Ingresar teléfono..." data-length="10" minlength="10" maxlength="10" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label for="contactGender">Sexo</label>
                                        <select v-model="newContactGender" class="custom-select" name="contact_gender">
                                            <option value="0">Masculino</option>
                                            <option value="1">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <label for="contactAddress">Dirección</label>
                                        <input v-model="newContactAddress" name="contact_address" type="text" class="form-control" id="contactAddress" placeholder="Ingresar dirección...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="saveContact" :disabled="validateForm"  type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .upload {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
    }

    .upload + label {
        width: 200px;
        height:40px;
        font-size: 1em;
        font-weight: 500;
        color: white;
        line-height: 2.6em;
        text-transform: uppercase;
        text-align: center;
        background-color: #ef494f;
        display: inline-block;
        border-radius: 10px;
        box-shadow: 0px 3px 0px #a73337;
        transition: 150ms;
    }

    .upload:focus + label,
    .upload + label:hover {
        background-color: #ff6c71;
        box-shadow: 0px 5px 0px #d03338;
        cursor:pointer;
    }
</style>

<script>
    export default {
        mounted() {
            console.log('New contact modal component.')
        },

        props: {
            userId: Number
        },

        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newContactName:null,
                newContactEmail:null,
                newContactPhone:null,
                newContactGender:0,
                newContactAddress:null,
                newContactProfilePicture:0,
                contactProfilePictureFile: null,
                validContactName: false,
                invalidContactName: false,
                validContactPhone: false,
                invalidContactPhone: false,
                validContactEmail: false,
                invalidContactEmail: false
            }
        },

        computed: {
            validateForm: function() {
                if(!this.validContactName || !this.validContactPhone || !this.validContactEmail){
                    return true;
                }
                else{
                    return false;
                }
            }
        },

        methods: {
            

            saveContact: function() {
                var newContact = {
                    contact_id: 0,
                    contact_name: this.newContactName,
                    contact_email: this.newContactEmail,
                    contact_phone: this.newContactPhone,
                    contact_gender: this.newContactGender,
                    contact_address: this.newContactAddress,
                    contact_profile_picture: this.newContactProfilePicture
                };

                var contactData = {
                    "contact_name" : this.newContactName,
                    "contact_email" : this.newContactEmail,
                    "contact_phone" : this.newContactPhone,
                    "contact_gender" : this.newContactGender,
                    "contact_address" : this.newContactAddress,
                    "has_contact_profile_picture" : this.newContactProfilePicture,
                    "contact_profile_picture" : this.contactProfilePictureFile,
                    "user_id": this.userId
                };

                var json=JSON.stringify(contactData);
                var self=this;

                $.ajax({
                    url: "http://localhost/prueba/soap.php",
                    type: "POST",
                    dataType: 'text',
                    data: {contact : json},
                    success: function(data) {
                        newContact.contact_id = data; 
                        self.$parent.contacts.push(newContact);
                        self.$parent.forceRerender();
                        $('#newContactModal').modal('hide');
                        self.resetForm();
                    },
                    error: function() {
                        console.log("Error");
                    }
                });
            },

            onChangeFileUpload(){
                this.file = this.$refs.file.files[0];
                if(this.file){
                    this.newContactProfilePicture=1;
                    var reader = new FileReader();
                    var self=this;

                    reader.onload = function(e) {
                        $('#preview_contact_profile_picture').attr('src', e.target.result);
                        self.setImageFile(reader.result);//Necesary for json request
                    }

                    reader. readAsDataURL(this.file);
                }
            },

            setImageFile: function(reader_result) {
                this.contactProfilePictureFile = reader_result;
                // console.log(this.contactProfilePictureFile);
            },

            resetForm: function() {
                $('#preview_contact_profile_picture').attr('src', 'img/profile_picture.png');
                $('#newContactForm').get(0).reset();
                this.newContactName=null,
                this.newContactEmail=null,
                this.newContactPhone=null,
                this.newContactGender=0,
                this.newContactAddress=null,
                this.newContactProfilePicture=0,
                this.contactProfilePictureFile= null,
                this.validContactName= false,
                this.invalidContactName= false,
                this.validContactPhone= false,
                this.invalidContactPhone= false,
                this.validContactEmail= false,
                this.invalidContactEmail= false
            },

            validateContactName: function(e) {
                if(!this.newContactName){
                    this.validContactName = false;
                    this.invalidContactName = true;
                }
                else{
                    this.validContactName = true;
                    this.invalidContactName = false;
                }
            },

            validateContactPhone: function(e) {
                const PHONE_REGEXP = /^[0-9]*$/gm;

                if(this.newContactPhone ==null || this.newContactPhone.length == 0){
                    this.validContactPhone = false;
                    this.invalidContactPhone = true;
                }
                else if(!PHONE_REGEXP.test(this.newContactPhone) || this.newContactPhone.length < 10){
                    this.validContactPhone = false;
                    this.invalidContactPhone = true;
                }
                else{
                    this.validContactPhone = true;
                    this.invalidContactPhone = false;
                }
            },

            validateContactEmail: function(e) {
                const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

                if(this.newContactEmail ==null || this.newContactEmail.length == 0){
                    this.validContactEmail = false;
                    this.invalidContactEmail = true;
                }
                else if(!MAIL_REGEXP.test(this.newContactEmail)){
                    this.validContactEmail = false;
                    this.invalidContactEmail = true;
                }
                else{
                    this.validContactEmail = true;
                    this.invalidContactEmail = false;
                }
            }
        }
    }
</script>