@extends('aluno.basealuno')
@push('scripts')
  <script src="{{ asset('js/aluno/aluno.js') }}"></script>
  <script src="{{ asset('js/aluno/modal.js') }}"></script>
@endpush

@push('head')
  <link rel="stylesheet" href="{{ asset('css/layouts/aluno.css') }}">
@endpush

@section('right-panel')
  <div class="card-container">
    <div class="progress-circle" data-percentage="{{ $aluno->pontosRecebidos }}" data-radius="55">
        <svg class="progress-ring" width="130" height="130">
            <circle class="progress-ring-bg" cx="60" cy="60" r="55" />
            <circle class="progress-ring-bar" cx="60" cy="60" r="55" stroke-dasharray="220" />
        </svg>
        <div class="progress-text">{{ $aluno->pontosRecebidos }} pontos</div>
    </div>
    <div class="card">
    <div class="card-body">
      <h1 class="card-title">Status</h1>
      <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
      <p class="card-text">mensagem de status</p>
    </div>
    </div>
    <div class="card">
    <div class="card-body">
      <h1 class="card-title">Regulamento de cargas horárias</h1>
      <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
      <p class="card-text">mensagem aqui</p>
    </div>
    </div>
    <div class="card">
    <div class="card-body">
      <h1 class="card-title">Dicas</h1>
      <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
      <p class="card-text">mensagem aqui</p>
    </div>
    </div>
</div>


@stack('scripts')

@endsection
