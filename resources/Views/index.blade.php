@extends('layouts.main')
@section('title')
    Home
@endsection
@section('content')
    <section id="main">
        Loading Assets...
    </section>
    @include('jsTemplates.loginForm')
    @include('jsTemplates.index')
    @include('jsTemplates.products')
    @include('jsTemplates.customers')
    @include('jsTemplates.productLines')
    @include('jsTemplates.payments')
    @include('jsTemplates.employees')
    @include('jsTemplates.orderDetails')
    @include('jsTemplates.offices')
    @include('jsTemplates.orders')
    @include('jsTemplates.error')
@endsection

@section('postFooterJs')
@endsection