@extends('layouts.app')
@section('content')
    <update-user-component :users="{{$users}}"></update-user-component>
@endsection
