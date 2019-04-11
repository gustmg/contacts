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
        </div>
    </div>
    <br>
    <div class="row justify-content-center" align="center">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary">Agregar contacto</button>
        </div>
    </div>
</div>
@endsection
