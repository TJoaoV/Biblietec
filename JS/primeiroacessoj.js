function validarprimeiro(theForm){
    var rm = cadastro.txtrm;
    var nome = cadastro.txtnome;
    var CPF = cadastro.txtCPF;
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
        alert("Nome não informada!");
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