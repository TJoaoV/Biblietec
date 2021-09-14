function validarprimeiro(theForm) {	
    var CPF = cadastro.txtCPF;
    var cpf = document.getElementById('txtCPF').value;
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
    var rm = cadastro.txtrm;
    var nome = cadastro.txtnome;
    
    var telefone = cadastro.txttelefone;
    var celular = cadastro.txtcelular;
    var email = cadastro.txtemail;
    var datanascimento = cadastro.txtdtnascimento;
    var senha1 = cadastro.txtsenha;
    var senha2 = cadastro.txtsenha2;
    var curso = cadastro.txtcurso;
    if (rm.value == ""){
        alert("RM não informado!");
        rm.focus();
        return false;
    };
    if (nome.value == ""){
        alert("Nome não informado!");
        nome.focus();
        return false;
    }; 
    if (CPF.value == ""){
        alert("CPF não informado!");
        CPF.focus();
        return false;
    }; 
    if (email.value == ""){
        alert("Email não informado!");
        email.focus();
        return false;
    }; 
    if (datanascimento.value == ""){
        alert("Data de Nascimento não informada!");
        datanascimento.focus();
        return false;
    }; 
    if (curso.value == "-"){
        alert("Curso não selecionado!");
        curso.focus();
        return false;
    }; 
    if (senha1.value == ""){
        alert("Senha não informada!");
        senha1.focus();
        return false;
    };
    if (senha2.value == ""){
        alert("Senha não digitada novamente!");
        senha2.focus();
        return false;
    };
    if (senha1.value != senha2.value){
        alert("As senhas não conferem!");
        senha1.focus();
        return false;
    };
    
    return true;
}
