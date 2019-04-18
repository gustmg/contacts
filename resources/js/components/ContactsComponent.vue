<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newContactModal">Agregar contacto</button>
                <button type="button" class="btn btn-success">Exportar agenda</button>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <input type="text" id="searchControlInput" placeholder="Buscar..." class="form-control">
                    </div>
                </form>
            </div>
        </div>
        <contacts-list-component :contacts="contacts" :key="componentKey"></contacts-list-component><br>
        <new-contact-modal-component></new-contact-modal-component>
    </div>
</template>
<script>
    export default {
        props: {
            contacts: {
                type: Array
            },
            searchValue:String,
        },

        data() {
            return {
                searchContact: '',
                componentKey: 0
            }
        },

        mounted() {
            console.log('Contacts component mounted');
        },

        methods: {
            forceRerender() {
                this.componentKey += 1;  
            }
        }
    }
</script>