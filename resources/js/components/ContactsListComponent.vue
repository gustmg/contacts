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
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(contact, index) in filteredContacts" v-on:click="updateContact(contact, index)" class="selectable" data-toggle="modal" data-target="#updateContactModal">
                            <th>#</th>
                            <td>{{contact.contact_name}}</td>
                            <td>{{contact.contact_email}}</td>
                            <td>{{contact.contact_phone}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2 v-show="filteredContacts.length == 0 && this.$parent.searchContact != '' " class="text-center">Búsqueda sin resultados :(</h2>
            <h2 v-show="contacts.length == 0 && this.$parent.searchContact == ''" class="text-center">No hay contactos registrados :(</h2>
            <update-contact-modal-component :contact-id="contactId.toString()" :contact-name="contactName" :contact-phone="contactPhone" :contact-email="contactEmail" :contact-gender="contactGender.toString()" :contact-address="contactAddress"></update-contact-modal-component>
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
                this.contactGender = contact.contact_gender;
                this.contactAddress = contact.contact_address;
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