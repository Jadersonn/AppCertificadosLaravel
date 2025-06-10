@extends('professor.baseprofessor')

@push('head')
  <link rel="stylesheet" href="{{ asset('css/layouts/professor.css') }}">
@endpush

@section('right-panel')
  <div class="usuario-oi-esquerda">
    Oi, {{ Auth::user()->name }}


  </div>

@endsection