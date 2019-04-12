@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form>
                <div class="form-group">
                    <input type="text" id="searchControlInput" placeholder="Buscar..." class="form-control">
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if($contacts->count() != 0)
                <div class="card table-responsive">
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
                        <tr>
                            <th scope="row">#</th>
                            <td>Mark</td>
                            <td>email@email.com</td>
                            <td>2222222222</td>
                        </tr>
                        <tr>
                            <th scope="row">#</th>
                            <td>Jacob</td>
                            <td>email@email.com</td>
                            <td>2222222222</td>
                        </tr>
                        <tr>
                            <th scope="row">#</th>
                            <td>Larry</td>
                            <td>the email@email.com</td>
                            <td>2222222222</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            @else
                <h2 class="text-center">No hay contactos registrados :(</h2>
            @endif
        </div>
    </div>
    <br>
    <div class="row justify-content-center" align="center">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addContactModal">Agregar contacto</button>
        </div>
        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo contacto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group text-left">
                                <label for="contactName">Nombre</label>
                                <input name="contact_name" type="text" class="form-control" id="contactName" placeholder="Ingresar nombre...">
                            </div>
                            <div class="form-group text-left">
                                <label for="contactPhone">Teléfono</label>
                                <input name="contact_phone" type="tel" class="form-control" id="contactPhone" placeholder="Ingresar teléfono...">
                            </div>
                            <div class="form-group text-left">
                                <label for="contactMail">E-mail</label>
                                <input name="contact_email" type="email" class="form-control" id="contactMail" placeholder="Ingresar e-mail...">
                            </div>
                            <div class="form-group text-left">
                                <label for="contactAddress">Dirección</label>
                                <input name="contact_address" type="text" class="form-control" id="contactAddress" placeholder="Ingresar dirección...">
                            </div>
                            <div class="form-group text-left">
                                <label for="contactender">Sexo</label>
                                <select class="custom-select">
                                    <option value="1">Masculino</option>
                                    <option value="2">Femenino</option>
                                </select>
                            </div> 
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
