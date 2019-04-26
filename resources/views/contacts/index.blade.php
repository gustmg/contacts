@extends('layouts.app')
@section('content')
<contacts-component :contacts="{{$contacts}}" :user-id="{{Auth::id()}}"></contacts-component>
@endsection