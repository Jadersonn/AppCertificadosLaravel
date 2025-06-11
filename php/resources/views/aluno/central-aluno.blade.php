@extends('aluno.basealuno')

@push('head')
  <link rel="stylesheet" href="{{ asset('css/layouts/aluno.css') }}">
@endpush

@section("central-aluno")

<div class="categorias-container">
    <div class="categoria-box" style="top: 83px;">Categoria 1</div>
    <div class="categoria-box" style="top: 196px;">Categoria 2</div>
    <div class="categoria-box" style="top: 309px;">Categoria 3</div>
    <div class="categoria-box" style="top: 422px;">Categoria 4</div>

    <div class="barra barra1" style="top: 137px;"></div>
    <div class="barra barra2" style="top: 249px;"></div>
    <div class="barra barra3" style="top: 365px;"></div>
    <div class="barra barra4" style="top: 475px;"></div>

    <div class="status status1" style="top: 137px;">50%</div>
    <div class="status status2" style="top: 249px;">90%</div>
    <div class="status status3" style="top: 365px;">0%</div>
    <div class="status status4" style="top: 475px; color: #003C0B;">Concluído</div>

    <button class="enviar-btn" style="top: 98px;">Enviar</button>
    <button class="enviar-btn" style="top: 208px;">Enviar</button>
    <button class="enviar-btn" style="top: 324px;">Enviar</button>
    <button class="enviar-btn" style="top: 438px;">Enviar</button>

    <div class="titulo-categorias">CATEGORIAS</div>
    <div class="titulo-geral">GERAL</div>
</div>
@endsection