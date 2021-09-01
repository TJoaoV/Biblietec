function validarprimeiro(theForm){
    var rm = esquecisenha.txtRM;
    var nome = esquecisenha.txtnome;
    var CPF = esquecisenha.txtCPF;
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
    if (rm.value == ""){
        alert("RM não informado!");
        rm.focus();
        return false;
    };
    return true;
}