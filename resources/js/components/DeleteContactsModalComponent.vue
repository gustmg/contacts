<template>
    <div class="modal fade" id="deleteContactsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Eliminar contactos?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>La información de {{contactsToDelete.length}} contactos se perderá al eliminar.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button v-on:click="deleteContacts" type="button" class="btn btn-primary">Aceptar</button>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted(){
            console.log('Delete contacts button component mounted!');
        },

        props: {
            contactsToDelete: {
                type: Array
            }
        },

        methods: {
            deleteContacts: function() {
                this.contactsToDelete.forEach(function(contact_id) {
                    axios.delete('http://localhost:8000/contacts/'+contact_id, {contact_id: contact_id})
                    .then(function(res){
                        console.log(res);
                    })
                    .catch(function(err){
                        console.log(err.response);
                    });
                });
                
                $('#deleteContactModal').modal('hide');
                
                this.$parent.$parent.forceRerender();
            },
        }
    }
</script>


