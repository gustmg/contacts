@extends('layouts.app')
@section('content')
<contacts-component :contacts="{{$contacts}}"></contacts-component>
@endsection