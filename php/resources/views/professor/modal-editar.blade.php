<div id="modal-editar" style="display: none;">
    <form id="form-editar" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="titulo" id="edit-titulo">
        <input type="text" name="descricao" id="edit-descricao">
        <!-- outros campos -->
        <button type="submit">Salvar</button>
    </form>
</div>
