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
                    <form id="newContactForm" method="POST" action="/contacts">
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
                                        <input v-model="newContactName" name="contact_name" type="text" class="form-control" id="contactName" placeholder="Ingresar nombre..." required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-left">
                                        <label for="contactMail">E-mail *</label>
                                        <input v-model="newContactEmail" name="contact_email" type="email" class="form-control" id="contactEmail" placeholder="Ingresar e-mail..." required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label for="contactPhone">Teléfono *</label>
                                        <input v-model="newContactPhone" name="contact_phone" type="tel" class="form-control" id="contactPhone" placeholder="Ingresar teléfono..." required>
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
                    <button v-on:click="saveContact" type="button" class="btn btn-primary">Guardar</button>
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

        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newContactName:null,
                newContactEmail:null,
                newContactPhone:null,
                newContactGender:0,
                newContactAddress:null,
                newContactProfilePicture:0
            }
        },

        methods: {
            saveContact: function() {
                var newContact = {
                    contact_id: '',
                    contact_name: this.newContactName,
                    contact_email: this.newContactEmail,
                    contact_phone: this.newContactPhone,
                    contact_gender: this.newContactGender,
                    contact_address: this.newContactAddress,
                    contact_profile_picture: this.newContactProfilePicture
                };

                let formData = new FormData();
                formData.append('contact_profile_picture', this.file);
                formData.append('contact_name', this.newContactName);
                formData.append('contact_email', this.newContactEmail);
                formData.append('contact_phone', this.newContactPhone);
                formData.append('contact_gender', this.newContactGender);
                formData.append('contact_address', this.newContactAddress);

                axios.post('http://localhost:8000/contacts', formData)
                .then((res)=>{
                    newContact.contact_id = res.data.contact_id; 
                    this.$parent.contacts.push(newContact);
                    this.$parent.forceRerender();
                    $('#newContactModal').modal('hide');
                    this.resetForm();
                })
                .catch(function(err){
                    console.log(err);
                });
            },

            onChangeFileUpload(){
                this.file = this.$refs.file.files[0];
                if(this.file){
                    this.newContactProfilePicture=1;
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#preview_contact_profile_picture').attr('src', e.target.result);
                    }

                    reader. readAsDataURL(this.file);
                }
            },

            resetForm: function() {
                $('#preview_contact_profile_picture').attr('src', 'img/profile_picture.png');
                $('#newContactForm').get(0).reset();
            }
        }
    }
</script>