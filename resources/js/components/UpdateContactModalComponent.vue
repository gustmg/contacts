<template>
    <div class="modal fade" id="updateContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/contacts">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <img id="update_preview_contact_profile_picture" :src="getImageUrl(contactId, contactProfilePicture)" width="180" height="180"><br>
                                            <button v-if="contactProfilePicture" v-on:click="removeProfilePicture" type="button" class="close remove-image" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="col-md-12"><br>
                                            <div class="custom-file">
                                                <input type="file" name="contact_profile_picture" id="updateContactProfilePicture" class="custom-file-input" ref="file" v-on:change="onChangeFileUpload"/>
                                                <label class="custom-file-label" for="updateContactProfilePicture">Choose file</label>
                                            </div>
                                        </div>
                                    </div><br>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <label for="updateContactName">Nombre *</label>
                                        <input v-model="updateContactName" name="contact_name" type="text" class="form-control" id="updateContactName" placeholder="Ingresar nombre...">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <label for="updateContactMail">E-mail *</label>
                                        <input v-model="updateContactEmail" name="contact_email" type="email" class="form-control" id="updateContactEmail" placeholder="Ingresar e-mail...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label for="updateContactPhone">Teléfono *</label>
                                        <input v-model="updateContactPhone" name="contact_phone" type="tel" class="form-control" id="updateContactPhone" placeholder="Ingresar teléfono...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label for="updateContactGender">Sexo</label>
                                        <select v-model="updateContactGender" class="custom-select" name="contact_gender" id="updateContactGender">
                                            <option value="0">Masculino</option>
                                            <option value="1">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <label for="updateContactAddress">Dirección</label>
                                        <input v-model="updateContactAddress" name="contact_address" type="text" class="form-control" id="updateContactAddress" placeholder="Ingresar dirección...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button v-on:click="updateContact" type="button" class="btn btn-primary">Guardar</button>
                </div>
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
            console.log('Update Contact Modal Component Mounted');
        },

        props: {
            contactIndex: Number,
            contactId: String,
            contactName: String,
            contactPhone: String,
            contactEmail: String,
            contactGender: String,
            contactAddress: String,
            contactProfilePicture: Number
        },

        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                updateContactName:'',
                updateContactPhone:'',
                updateContactEmail:'',
                updateContactGender:'',
                updateContactAddress:'',
                updateContactProfilePicture:0,
                contactProfilePictureFile: null
            }
        },

        watch: {
            contactName(newVal) {
                this.updateContactName = newVal;
            },
            contactPhone(newVal) {
                this.updateContactPhone = newVal;
            },
            contactEmail(newVal) {
                this.updateContactEmail = newVal;
            },
            contactGender(newVal) {
                this.updateContactGender = newVal;
            },
            contactAddress(newVal) {
                this.updateContactAddress = newVal;
            }
        },

        methods: {
            emitContactName(newInputValue) {
                this.$emit('contact-name', newInputValue);
            },

            emitContactPhone(newInputValue) {
                this.$emit('contact-phone', newInputValue);
            },
            
            emitContactEmail(newInputValue) {
                this.$emit('contact-email', newInputValue);
            },

            emitContactGender(newInputValue) {
                this.$emit('contact-gender', newInputValue);
            },

            emitContactAddress(newInputValue) {
                this.$emit('contact-address', newInputValue);
            },
            
            updateContact: function(){
                var contactData = {
                    "contact_id" : this.contactId,
                    "contact_name" : this.updateContactName,
                    "contact_email" : this.updateContactEmail,
                    "contact_phone" : this.updateContactPhone,
                    "contact_gender" : this.updateContactGender,
                    "contact_address" : this.updateContactAddress,
                    "has_contact_profile_picture" : this.updateContactProfilePicture,
                    "contact_profile_picture" : this.contactProfilePictureFile
                };

                var json=JSON.stringify(contactData);
                var self=this;
                $.ajax({
                    url: "http://localhost/prueba/soapUpdate.php",
                    type: "POST",
                    data: {contact : json},
                    dataType: "html",
                    success: function() {
                        self.$parent.contacts[self.$parent.contactIndex].contact_name=self.updateContactName;
                        self.$parent.contacts[self.$parent.contactIndex].contact_email=self.updateContactEmail;
                        self.$parent.contacts[self.$parent.contactIndex].contact_phone=self.updateContactPhone;
                        self.$parent.contacts[self.$parent.contactIndex].contact_address=self.updateContactAddress;
                        self.$parent.contacts[self.$parent.contactIndex].contact_gender=self.updateContactGender;
                        self.$parent.contacts[self.$parent.contactIndex].contact_profile_picture=self.updateContactProfilePicture;
                        self.$parent.$parent.forceRerender();
                        location.reload();
                        $('#updateContactModal').modal('hide');
                    },
                    error: function() {
                        console.log('Error.');
                    }
                });             
            },
            
            onChangeFileUpload(){
                this.file = this.$refs.file.files[0];
                if(this.file){
                    this.updateContactProfilePicture=1;
                    var reader = new FileReader();
                    var self=this;

                    reader.onload = function(e) {
                        $('#update_preview_contact_profile_picture').attr('src', e.target.result);
                        self.setImageFile(reader.result);//Necesary for json request
                    }

                    reader. readAsDataURL(this.file);
                }
            },

            setImageFile: function(reader_result) {
                this.contactProfilePictureFile = reader_result;
                // console.log(this.contactProfilePictureFile);
            },

            removeProfilePicture: function() {
                this.updateContactProfilePicture=0;
                $('#update_preview_contact_profile_picture').attr('src', 'img/profile_picture.png');
            },

            getImageUrl: function(contact_id, contact_profile_picture) {
                if(contact_profile_picture){
                    return "storage/contacts/"+contact_id+".jpg";
                }
                else{
                    return "img/profile_picture.png";
                }
            }
        }
    }
</script>