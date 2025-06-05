
@extends('aluno.basealuno')

@push('head')
<link rel="stylesheet" href="{{ asset('css/layouts/aluno.css') }}">
@endpush

@section('content')
    <h1 class="text-3xl font-bold text-green-custom text-center mb-2">aluno</h1>
    <!-- Coloque aqui o conteúdo específico do aluno -->
@endsection