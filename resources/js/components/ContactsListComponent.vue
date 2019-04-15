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
                        <tr v-for="(contact, index) in filteredContacts">
                            <th>#</th>
                            <td>{{contact.contact_name}}</td>
                            <td>{{contact.contact_email}}</td>
                            <td>{{contact.contact_phone}}</td>
                            <td>
                                <a class="selectable"><i class="material-icons">person</i></a>
                                <a class="selectable" v-on:click="updateContact(contact, index)" data-toggle="modal" data-target="#updateContactModal"><i class="material-icons">edit</i></a>
                                <a class="selectable" data-toggle="modal" data-target="#deleteContactModal"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2 v-show="filteredContacts.length == 0 && this.$parent.searchContact != '' " class="text-center">Búsqueda sin resultados :(</h2>
            <h2 v-show="contacts.length == 0 && this.$parent.searchContact == ''" class="text-center">No hay contactos registrados :(</h2>
            <update-contact-modal-component :contact-id="contactId.toString()" :contact-name="contactName" :contact-phone="contactPhone" :contact-email="contactEmail" :contact-address="contactAddress"></update-contact-modal-component>
            <delete-contact-modal-component :contact-id="contactId.toString()"></delete-contact-modal-component>
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
                contactGender: '',
                contactAddress: ''
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