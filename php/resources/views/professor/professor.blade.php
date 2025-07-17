@extends('professor.baseprofessor')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/layouts/professor.css') }}">
@endpush

@section('main')
    {{-- CERTIFICADOS RECEBIDOS --}}
    @include('professor.certificadosRecebidos')
    
    <div class="professor-cards-row">
        <!-- GERAR RELATÓRIO -->
        @include('professor.geraRelatorio')

        <!-- BUSCAR ALUNO -->
        @include('professor.buscaAluno')


        <!-- ALUNOS APROVADOS -->
        @include('professor.alunosAprovados')
    </div>
@endsection
