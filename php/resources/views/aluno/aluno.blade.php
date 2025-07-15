@extends('aluno.basealuno')
@push('scripts')
    <script src="{{ asset('js/aluno/aluno.js') }}"></script>
    <script src="{{ asset('js/aluno/modal.js') }}"></script>
@endpush

@push('head')
    <link rel="stylesheet" href="{{ asset('css/layouts/aluno.css') }}">
    <link rel="icon" href="{{ asset('imagens/favicon.ico') }}" type="image/x-icon">
@endpush

@section('right-panel')
    <div class="card-container">
        <div class="progress-circle" data-percentage="{{ $aluno->pontosRecebidos }}" data-radius="60">
            <svg class="progress-ring" viewBox="0 0 130 130" preserveAspectRatio="xMidYMid meet">
                <circle class="progress-ring-bg" cx="65" cy="65" r="60" />
                <circle class="progress-ring-bar" cx="65" cy="65" r="60" stroke-dasharray="220" />
            </svg>
            <div class="progress-text">{{ $aluno->pontosRecebidos }} pontos</div>
        </div>
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
