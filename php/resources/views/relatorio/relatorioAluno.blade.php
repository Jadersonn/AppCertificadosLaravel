@extends('administrador.baseadministrador')
<body>
    <div class="container">
        <div class="relatorio-aluno">RELATÓRIO ALUNO</div>
        <div class="nome">JADERSON DA SILVA PILLAR MARTINS</div>
        <div class="identidade">052.xxx.xxx-xx</div>
        <div class="status">Status: Em curso.</div>
        <div class="turma">Turma: 32215</div>
        <div class="concluido">Concluido: 80%</div>

        <div class="cabecalho">
            <div>DATA DE ENVIO</div>
            <div>NOME</div>
            <div>PONTOS</div>
            <div>CATEGORIA</div>
            <div>STATUS</div>
            <div>JUSTIFICATIVA</div>
            <div>EDITAR/BAIXAR</div>
        </div>

        <div class="quadro-pontos"></div>

        <div class="semestre">SEMESTRE</div>

        <div class="categoria">
            <div class="item">
                <div class="circulo"></div>
                <div class="texto">TOTAL</div>
                <div class="percentual">%</div>
            </div>
            <div class="item">
                <div class="circulo"></div>
                <div class="texto">CATEGORIA 1</div>
                <div class="percentual">%</div>
            </div>
            <div class="item">
                <div class="circulo"></div>
                <div class="texto">CATEGORIA 2</div>
                <div class="percentual">%</div>
            </div>
            <div class="item">
                <div class="circulo"></div>
                <div class="texto">CATEGORIA 3</div>
                <div class="percentual">%</div>
            </div>
            <div class="item">
                <div class="circulo"></div>
                <div class="texto">CATEGORIA 4</div>
                <div class="percentual">%</div>
            </div>
        </div>
    </div>
</body>
</html>
