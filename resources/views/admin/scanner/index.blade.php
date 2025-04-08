@extends('layouts.admin.app')
@section('title', 'Enhance Security School | Admin - Scanner')

@section('content')
    @if ($type['page'] == 'scan')
        @include('admin.scanner.scan')
        @else
        @include('admin.scanner.face')
    @endif
@endsection
