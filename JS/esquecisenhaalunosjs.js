function validarprimeiro(theForm){
    var rm = esquecisenha.txtRM;
    var CPF = esquecisenha.txtCPF;
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