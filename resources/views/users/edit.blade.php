@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 text-center">
            <img src="{{ asset('img/profile_picture.png') }}" width="200"><br><br>
            <input type="file" name="file" id="file" class="upload" />
            <label for="file">Choose a file</label>
        </div>
        <div class="col-md-4">
            <form>
                <div class="form-group">
                    <label for="userName">Nombre</label>
                    <input type="text" class="form-control" id="userName" placeholder="Ingresa tu nombre..." value="{{Auth::user()->name}}">
                </div>
                <div class="form-group">
                    <label for="userEmail">Correo electrónico</label>
                    <input type="email" class="form-control" id="userEmail" placeholder="Ingresa tu correo electrónico..." value="{{Auth::user()->email}}">
                </div>
                <div class="form-group">
                    <label for="userPassword">Contraseña</label>
                    <input type="password" class="form-control" id="userPassword" placeholder="Ingresa tu contraseña..." value="{{Auth::user()->password}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Teléfono</label>
                    <input type="tel" class="form-control" id="exampleInputEmail1" placeholder="Ingresa tu número telefónico..." value="{{Auth::user()->phone}}">
                </div>
                <div class="form-group">
                    <label for="userGender">Sexo</label>
                    <select class="form-control" id="userGender">
                        <option>Masculino</option>
                        <option>Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="userAddress">Dirección</label>
                    <input type="text" class="form-control" id="userAddress" placeholder="Ingresa tu dirección..." value="{{Auth::user()->address}}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
