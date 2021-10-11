function validaraddlivro(theForm){
    var titulo = addlivro.txtTituloADD;
    var autor = addlivro.txtAutorADD;
    var editora = addlivro.txtEditoraADD;
    var categoria = addlivro.categorialivroADD;
    var sinopse = addlivro.txtSinopseADD;
    var quanttotal = addlivro.txtQtdtotalADD;
    var quantdisp = addlivro.txtQtddispADD;
    if (titulo.value == ""){
        alert("Titulo não informado!");
        titulo.focus();
        return false;
    };
    if (autor.value == ""){
        alert("Autor não informado!");
        autor.focus();
        return false;
    };
    if (editora.value == ""){
        alert("Editora não informada!");
        editora.focus();
        return false;
    };
    if (categoria.value == "-"){
        alert("Categoria não informada!");
        categoria.focus();
        return false;
    };
    if (sinopse.value == ""){
        alert("Sinopse não informada!");
        sinopse.focus();
        return false;
    };
    if (quanttotal.value == ""){
        alert("Quantidade Total não informada!");
        quanttotal.focus();
        return false;
    };
    if (quantdisp.value == ""){
        alert("Quantidade Disponível não informada!");
        quantdisp.focus();
        return false;
    };
    adicionarLivroBD();
}