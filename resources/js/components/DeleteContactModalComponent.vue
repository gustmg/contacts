<template>
    <div class="modal fade" id="deleteContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Eliminar contacto?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>La información de este contacto se perderá al eliminar.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button v-on:click="deleteContact" type="button" class="btn btn-primary">Aceptar</button>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Delete Contact Modal Component Mounted');
        },

        props: {
            contactId: String,
            contactIndex: Number
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },

        methods: {
            deleteContact: function() {
                var self=this;

                var contactData = {
                    "contact_id" : this.contactId
                };

                var json=JSON.stringify(contactData);
                
                $.ajax({
                    url: "http://localhost/prueba/soapDelete.php",
                    type: "POST",
                    data: {contact: json},
                    dataType: "html",
                    success: function() {
                        $('#deleteContactModal').modal('hide');
                        self.$parent.$parent.contacts.splice(self.contactIndex, 1);
                        self.$parent.$parent.forceRerender();
                    },
                    error: function() {
                        console.log('Error.');
                    }
                });                   
            }
        }
    }
</script>


