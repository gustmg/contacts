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
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <img :src="getImageUrl(contactId, contactProfilePicture)" width="180" height="180">
                        </div>
                        <div class="col-md-7" v-if="contactGender==0">
                            <p><i class="material-icons align-bottom">person</i> {{contactName}}</p>
                            <p><i class="material-icons align-bottom">mail</i> {{contactEmail}}</p>
                            <p><i class="material-icons align-bottom">phone</i> {{contactPhone}}</p>
                            <p><i class="material-icons align-bottom">wc</i> Hombre</p>
                            <p><i class="material-icons align-bottom">home</i> {{contactAddress}}</p>
                        </div>
                        <div class="col-md-7" v-else>
                            <p><i class="material-icons align-bottom">person</i> {{contactName}}</p>
                            <p><i class="material-icons align-bottom">mail</i> {{contactEmail}}</p>
                            <p><i class="material-icons align-bottom">phone</i> {{contactPhone}}</p>
                            <p><i class="material-icons align-bottom">wc</i> Mujer</p>
                            <p><i class="material-icons align-bottom">home</i> {{contactAddress}}</p>
                        </div>
                    </div>
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

        props: {
            contactId: String,
            contactName: String,
            contactEmail: String,
            contactPhone: String,
            contactAddress: String,
            contactGender: Number,
            contactProfilePicture: Number
        },

        methods: {
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