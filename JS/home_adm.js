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

function validaraddcurso(theForm){
    var nomeCurso = addCurso.txtNomeADD;
    var duracaoCurso = addCurso.txtDuracaoADD;
    var periodoCurso = addCurso.selectPeriodoADD;
    if (nomeCurso.value == ""){
        alert("Nome não informado!");
        nomeCurso.focus();
        return false;
    };
    if (duracaoCurso.value == ""){
        alert("Duração não informada!");
        duracaoCurso.focus();
        return false;
    };
    if (periodoCurso.value == "-"){
        alert("Período não selecionado!");
        periodoCurso.focus();
        return false;
    };
    adicionarCursoBD();
}

function validaraddcategoria(theForm){
    var CategoriaADD = addCategoria.txtCateADD;
    if (CategoriaADD.value == ""){
        alert("Nome da Categoria não informado!");
        CategoriaADD.focus();
        return false;
    };
    adicionarCategoriaBD();
}

function validaraddusuario(theForm){
    var CPF = addUsuario.txtCPFADD;
    var cpf = document.getElementById('txtCPFADD').value;
	cpf = cpf.replace(/[^\d]+/g,'');	
	if(cpf == '') {
        alert("CPF Inválido!");
        CPF.focus();
        return false;};
	// Elimina CPFs invalidos conhecidos	
    if (cpf.length != 11 ) {
        alert("CPF Inválido!");
        CPF.focus();
        return false;};
	if (cpf == "00000000000" || 
		cpf == "11111111111" || 
		cpf == "22222222222" || 
		cpf == "33333333333" || 
		cpf == "44444444444" || 
		cpf == "55555555555" || 
		cpf == "66666666666" || 
		cpf == "77777777777" || 
		cpf == "88888888888" || 
		cpf == "99999999999"){
        alert("CPF Inválido!");
        CPF.focus();
        return false;	};
	// Valida 1o digito	
	add = 0;	
	for (i=0; i < 9; i ++)		
		add += parseInt(cpf.charAt(i)) * (10 - i);	
		rev = 11 - (add % 11);	
		if (rev == 10 || rev == 11)		
			rev = 0;	
		if (rev != parseInt(cpf.charAt(9)))	{
            alert("CPF Inválido!");
            CPF.focus();
            return false;		};
	// Valida 2o digito	
	add = 0;	
	for (i = 0; i < 10; i ++)		
		add += parseInt(cpf.charAt(i)) * (11 - i);	
	rev = 11 - (add % 11);	
	if (rev == 10 || rev == 11)	
		rev = 0;	
	if (rev != parseInt(cpf.charAt(10))){
        alert("CPF Inválido!");
        CPF.focus();
        return false;	};

    var nomeUsuario = addUsuario.txtNomeUsuADD;
    var login = addUsuario.txtLoginADD;
    //var cpfUusario = addUsuario.txtCPFADD;
    var endereco = addUsuario.txtEndeADD;
    var datanasc = addUsuario.txtDtnaADD;
    var telefone = addUsuario.txtTeleADD;
    var celular = addUsuario.txtCeluADD;
    var email = addUsuario.txtEmailADD;
    var permissao = addUsuario.selectPermissaoADD;
    var ativo = addUsuario.selectAtivoADD;
    if (nomeUsuario.value == ""){
        alert("Nome não informado!");
        nomeUsuario.focus();
        return false;
    };
    if (login.value == ""){
        alert("Login não informado!");
        login.focus();
        return false;
    };
    if (endereco.value == "-"){
        alert("Endereço não informado!");
        endereco.focus();
        return false;
    };
    if (datanasc.value == ""){
        alert("Data de Nascimento não informada!");
        datanasc.focus();
        return false;
    };
    if (telefone.value == "" && celular.value == ""){
        alert("É obrigatório informar Telefone ou Celular");
        telefone.focus();
        return false;
    };
    if (email.value == ""){
        alert("E-mail não informado!");
        email.focus();
        return false;
    };
    if (permissao.value == "-"){
        alert("Permissão não selecionada!");
        permissao.focus();
        return false;
    };
    adicionarUsuarioBD();
}