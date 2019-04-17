<template>
    <div class="modal fade" id="showContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{contactName}}
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    
</style>
<script>
    export default {
        mounted(){
            console.log('Show contact modal component mounted!');
        },

        props:{
            contactName: String,
            contactEmail: String,
            contactPhone: String,
            // contactGender: String,
            contactAddress: String
        }
    }
</script>