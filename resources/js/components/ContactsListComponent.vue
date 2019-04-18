<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card table-responsive" v-show="contacts.length > 0">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Teléfono</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(contact, index) in filteredContacts" v-bind:index="index">
                            <th>#</th>
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
            <show-contact-modal-component :contact-id="contactId" :contact-name="contactName" :contact-phone="contactPhone" :contact-email="contactEmail" :contact-address="contactAddress" :contact-gender="contactGender" :contact-profile-picture="contactProfilePicture"></show-contact-modal-component>
            <update-contact-modal-component :contact-id="contactId.toString()" :contact-name="contactName" :contact-phone="contactPhone" :contact-email="contactEmail" :contact-address="contactAddress"></update-contact-modal-component>
            <delete-contact-modal-component :contact-id="contactId.toString()" :contact-index="contactIndex"></delete-contact-modal-component>
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
                contactId: 0,
                contactName: '',
                contactPhone: '',
                contactEmail: '',
                contactAddress: '',
                contactGender: 0,
                contactProfilePicture: 0
            }
        },

        methods: {
            updateContact: function(contact, index) {
                this.contactId = contact.contact_id;
                this.contactName = contact.contact_name;
                this.contactPhone = contact.contact_phone;
                this.contactEmail = contact.contact_email;
                this.contactAddress = contact.contact_address;

                $('#updateContactModal').find('#updateContactGender').val(contact.contact_gender);
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
                    return "storage/contacts/"+contact_id+".jpg";
                }
                else{
                    return "img/profile_picture.png";
                }
            }


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