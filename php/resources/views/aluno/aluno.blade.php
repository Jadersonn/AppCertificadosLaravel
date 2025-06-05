
@extends('aluno.basealuno')

@push('head')
<link rel="stylesheet" href="{{ asset('css/layouts/aluno.css') }}">
@endpush

@section('content')

<div class="card-container">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Status</h5>
      <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
      <p class="card-text">mensagem de status</p>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Regulamento de cargas horárias</h5>
      <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
      <p class="card-text">mensagem aqui</p>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Dicas</h5>
      <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
      <p class="card-text">mensagem aqui</p>
    </div>
  </div>
</div>

<div class="conteudo-centralizado">

</div>
    
@endsection
