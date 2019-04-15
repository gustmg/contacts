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
                                        <div class="col-md-6 text-center">
                                            <img src="" width="80"><br>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <input type="file" name="file" id="file" class="upload" />
                                            <label for="file">Choose a file</label>
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
    
</style>
<script>
    export default {
        mounted() {
            console.log('Update Contact Modal Component Mounted');
        },

        props: {
            contactId: String,
            contactName: String,
            contactPhone: String,
            contactEmail: String,
            contactGender: String,
            contactAddress: String
        },

        data(){
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                updateContactName:'',
                updateContactPhone:'',
                updateContactEmail:'',
                updateContactGender:'',
                updateContactAddress:'',
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
	    		axios.put('http://localhost:8000/contacts/'+this.contactId,{
	    			contact_name: this.updateContactName,
	    			contact_phone: this.updateContactPhone,
	    			contact_email: this.updateContactEmail,
                    contact_gender: this.updateContactGender,
                    contact_address: this.updateContactAddress
	    		})
	    		.then(function(res){
	    			console.log(res);
	    		})
	    		.catch(function(err){
	    			console.log(err.response);
	    		});
	    		this.$parent.contacts[this.$parent.contactIndex].contact_name=this.updateContactName;
	    		this.$parent.contacts[this.$parent.contactIndex].contact_phone=this.updateContactPhone;
	    		this.$parent.contacts[this.$parent.contactIndex].contact_email=this.updateContactEmail;
	    		this.$parent.$parent.forceRerender();
	    		$('#updateContactModal').modal('hide');
	    	},
        }
    }
</script>