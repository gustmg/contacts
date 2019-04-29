<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card table-responsive" v-show="contacts.length > 0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkAll" v-on:click="checkAll">
                                    <label class="custom-control-label" for="checkAll"></label>
                                </div>
                            </th>
                            <th scope="col">Nombre</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Teléfono</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(contact, index) in filteredContacts" v-bind:index="index" >
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input check" v-bind:id="index" v-on:change="countCheckedInputs(contact.contact_id)">
                                    <label class="custom-control-label" v-bind:for="index"></label>
                                </div>
                            </th>
                            <td>
                                <img :src="getImageUrl(contact.contact_id, contact.contact_profile_picture)" width="32" height="32">&nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="align-middle">{{contact.contact_name}}</span>
                            </td>
                            <td>{{contact.contact_email}}</td>
                            <td>{{contact.contact_phone}}</td>
                            <td>
                                <a class="selectable" v-on:click="showContact(contact)" data-toggle="modal" data-target="#showContactModal"><i class="material-icons">person</i></a>
                                <a class="selectable" v-on:click="updateContact(contact, index)" data-toggle="modal" data-target="#updateContactModal"><i class="material-icons">edit</i></a>
                                <a class="selectable" v-on:click="setDeleteContactId(contact.contact_id, index)" data-toggle="modal" data-target="#deleteContactModal"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2 v-show="filteredContacts.length == 0 && this.$parent.searchContact != '' " class="text-center">Búsqueda sin resultados :(</h2>
            <h2 v-show="contacts.length == 0 && this.$parent.searchContact == ''" class="text-center">No hay contactos registrados :(</h2>
            <show-contact-modal-component :contact-id="contactId.toString()" :contact-name="contactName" :contact-phone="contactPhone" :contact-email="contactEmail" :contact-address="contactAddress" :contact-gender="contactGender.toString()" :contact-profile-picture="contactProfilePicture"></show-contact-modal-component>
            <update-contact-modal-component :contact-index="contactIndex" :contact-id="contactId.toString()" :contact-name="contactName" :contact-phone="contactPhone" :contact-email="contactEmail" :contact-address="contactAddress" :contact-gender="contactGender.toString()" :contact-profile-picture="contactProfilePicture"></update-contact-modal-component>
            <delete-contact-modal-component :contact-id="contactId.toString()" :contact-index="contactIndex"></delete-contact-modal-component>
            <delete-contacts-modal-component :contacts-to-delete="contactsToDelete"></delete-contacts-modal-component>
        </div>
        <div v-if="totalCheckedInputs > 0" class="col-md-12" align="center"><br>
            <button type="button" class="btn btn-secondary" v-on:click="exportAsDoc">Exportar contactos seleccionados como DOC</button>
            <button type="button" class="btn btn-secondary" v-on:click="exportAsPdf">Exportar contactos seleccionados como PDF</button>
            <button type="button" class="btn btn-secondary" v-on:click="exportAsExcel">Exportar contactos seleccionados como XLS</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteContactsModal">Eiminar contactos seleccionados</button>
        </div>
    </div>
</template>
<style>
    .selectable{
        cursor: pointer;
    }
</style>
<script>
    export default {
        mounted(){
            console.log('Contacts list component mounted!');
        },

        props:{
            contacts: {
                type: Array
            },
        },

        data() {
            return {
                contactIndex: null,
                contactId: '',
                contactName: '',
                contactPhone: '',
                contactEmail: '',
                contactAddress: '',
                contactGender: '',
                contactProfilePicture: 0,
                totalCheckedInputs: 0,
                contactsToDelete: []
            }
        },

        methods: {
            updateContact: function(contact, index) {
                this.contactIndex= index;
                this.contactId = contact.contact_id;
                this.contactName = contact.contact_name;
                this.contactPhone = contact.contact_phone;
                this.contactEmail = contact.contact_email;
                this.contactAddress = contact.contact_address;
                this.contactGender = contact.contact_gender;
                this.contactProfilePicture = contact.contact_profile_picture;

                // $('#updateContactModal').find('#updateContactGender').val(contact.contact_gender);
            },

            setDeleteContactId: function(contact_id, index) {
                this.contactIndex= index;
                this.contactId = contact_id;
            },

            showContact: function(contact) {
                this.contactId = contact.contact_id;
                this.contactName = contact.contact_name;
                this.contactPhone = contact.contact_phone;
                this.contactEmail = contact.contact_email;
                this.contactAddress = contact.contact_address;
                this.contactGender = contact.contact_gender;
                this.contactProfilePicture = contact.contact_profile_picture;
            },

            getImageUrl: function(contact_id, contact_profile_picture) {
                if(contact_profile_picture){
                    return "storage/contacts/"+contact_id+".png";
                }
                else{
                    return "img/profile_picture.png";
                }
            },

            checkAll: function() {
                $(".check").prop('checked', $('#checkAll').prop('checked'));
                //Llena o vacía el array de id de contactos a eliminar dependiendo de si el checbox este activado o no.
                this.contactsToDelete=[];
                var idArray=[];
                if($('#checkAll').is(':checked')){
                    this.contacts.forEach(function(contact){
                        idArray.push(contact.contact_id);
                    })
                }
                this.contactsToDelete=idArray;
                this.totalCheckedInputs = $('.check:checked').length;
            },

            addContactIdToArray: function(contact_id) {
                this.contactsToDelete.push(contact_id);
            },

            countCheckedInputs: function(contact_id) {
                if(this.contactsToDelete.includes(contact_id)){
                    var index_to_delete = this.contactsToDelete.indexOf(contact_id);
                    this.contactsToDelete.splice(index_to_delete, 1);
                }
                else{
                    this.contactsToDelete.push(contact_id);
                }                
                this.totalCheckedInputs = $('.check:checked').length;
            },

            exportAsDoc: function() {
                axios.post('http://localhost:8000/exports/', {format: 'doc', contacts: this.contactsToDelete})
                .then(function(res){
                    window.location.href = res.data;
                })
                .catch(function(err){
                    console.log(err.response);
                });
                
            },

            exportAsPdf: function() {
                axios.post('http://localhost:8000/exports/', {format: 'pdf', contacts: this.contactsToDelete})
                .then(function(res){
                    // window.location.href = res.data;
                    window.open(res.data, "_blank");
                })
                .catch(function(err){
                    console.log(err.response);
                });

            },

            exportAsExcel: function() {
                axios.post('http://localhost:8000/exports/', {format: 'xls', contacts: this.contactsToDelete})
                .then(function(res){
                    window.location.href = res.data;
                })
                .catch(function(err){
                    console.log(err.response);
                });

            },
        },

        computed: {
            filteredContacts: function() {
                return this.contacts.filter((contact)=>{
                    return contact.contact_name.toLowerCase().indexOf(this.$parent.searchContact.toLowerCase()) >= 0;
                    // || contact.contact_phone.indexOf(this.searchContact) >= 0
                    // || contact.contact_email.indexOf(this.searchContact) >= 0;
                });   		
            }
        }
    }
</script>