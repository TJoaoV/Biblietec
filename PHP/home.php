<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    session_start();
    try{
        $idRecebido = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    } catch (Exception $e){
    };
    $nome = $_SESSION['nome'];
    $rm = $_SESSION['rm'];
    require("conexao.php");
    $sql = "SELECT * FROM livros WHERE liv_qtdd<>0";
    $sql_pre = "SELECT * FROM preemprestimo WHERE alu_rm='$rm'";
    $sql_emprestimoprogresso = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$rm' and emp_devo='NÃO Devolvido'";
    $sql_emprestimofinalizado = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$rm' and emp_devo='Devolvido'";
    $sqlalunos = "SELECT * FROM alunos WHERE alu_rm='$rm'";
    $sqlcurso = "SELECT * FROM cursos";
    $resultado_pre = mysqli_query($conn, $sql_pre);
    $resultado_pre2 = mysqli_query($conn, $sql_pre);
    $resultado_pre3 = mysqli_query($conn, $sql_pre);
    $resultado_pre4 = mysqli_query($conn, $sql_pre);
    $resultado_pre5 = mysqli_query($conn, $sql_pre);
    $resultado = mysqli_query($conn, $sql);
    $resultado_emprestimoprogresso = mysqli_query($conn, $sql_emprestimoprogresso);
    $resultado_emprestimofinalizado = mysqli_query($conn, $sql_emprestimofinalizado);
    $resultadoalunos = mysqli_query($conn, $sqlalunos);
    $resultadocurso = mysqli_query($conn, $sqlcurso);
    $exibiralunos = mysqli_fetch_assoc($resultadoalunos);
    $oioi = 5;
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Alunos</title>
    <?php include('imports.php'); ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
    window.addEventListener("load", () => {
        var idrecebidoreload = document.getElementById('variavelid').value;
        if (idrecebidoreload == "") {
            carregou();
        };
        if (idrecebidoreload == "2") {
            btnCarrinho();
        };
        if (idrecebidoreload == "3") {
            btnProcurar();
        };
        if (idrecebidoreload == "4") {
            btnNome();
        };
        if (idrecebidoreload == "5") {
            btnEmprestimos();
            EmpEmProgresso();
        };
        if (idrecebidoreload == "99") {
            validarfinalizacao();
        };
    });

    function btnNome() {
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML = `
        <h3 class="corpoTitle"> Configurações </h3><br>
        <hr class="hrTitle"><br>
        <div class="corpoCadastro">
        <br>
            <h3> Nome: </h3>
            <input type='text' value='<?php echo $exibiralunos['alu_nome']?>' readonly disabled>
            <h3> RM: </h3>
            <input type='text' value='<?php echo $exibiralunos['alu_rm']?>' readonly disabled>
            <h3> CPF: </h3>
            <input type='text' value='<?php echo $exibiralunos['alu_cpf']?>' readonly disabled>
            <?php
                $ano= substr($exibiralunos['alu_dtna'], 0,4);
                $mes= substr($exibiralunos['alu_dtna'], 5,2);
                $dia= substr($exibiralunos['alu_dtna'], 8,2);
            ?>
            <h3> Data de Nascimento: </h3>
            <input type='text' value='<?php echo $dia."/".$mes."/".$ano?>' readonly disabled><br>
            <h3> Telefone: </h3>
            <input type='text' id='telefonenovo' maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value='<?php echo $exibiralunos['alu_tele']?>'>
            <h3> Celular: </h3>
            <input type='text' id='celularnovo' maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value='<?php echo $exibiralunos['alu_celu']?>'>
            <h3> Email: </h3>
            <input type='email' id='emailnovo' maxlength="150" value='<?php echo $exibiralunos['alu_emai']?>'>
            <h3> Curso: </h3>
            <?php
                
                echo "<select id='cursonovo' name='cursonovo'>";
                echo "<option value='-'> Selecione o Curso </option>";
                while ($exibircurso = mysqli_fetch_assoc($resultadocurso)) {
                    if($exibircurso['cur_codi'] == $exibiralunos['cur_codi']){
                        echo "<option value='$exibircurso[cur_codi]' selected> $exibircurso[cur_nome] - Duração $exibircurso[cur_dura] - Período $exibircurso[cur_peri]</option>";
                    } else {
                        echo "<option value='$exibircurso[cur_codi]'> $exibircurso[cur_nome] - Duração $exibircurso[cur_dura] - Período $exibircurso[cur_peri]</option>";
                    }
                } 
                echo "</select>";
                echo "<br><br> <input class='botVerm pointer' type='button' href='home.php' onclick='atualizarcadastro($exibiralunos[alu_rm])' value='Salvar Alterações'>";
            ?><br><br>
            <hr class="hrMain" style="width: 90%;">
            <h2> Alterar Senha </h2>
            <h3> Senha Antiga: </h3>
            <input type='password' id='senhaantiga' maxlength="150" placeholder="Digite sua senha antiga"'>
            <h3> Senha Nova: </h3>
            <input type='password' id='senhanova1' maxlength="150" placeholder="Digite sua nova senha"'>
            <h3> Confirmação Senha Nova: </h3>
            <input type='password' id='senhanova2' maxlength="150" placeholder="Digite sua nova senha novamente"'>
            <?php echo "<br><br> <input class='botVerm pointer' type='button' href='home.php' onclick='atualizarsenha($exibiralunos[alu_rm])' value='Alterar Senha'>"; ?>
            <br>`;
    };

    function atualizarsenha(rmdoaluno) {
        var senhaantiga = document.getElementById('senhaantiga').value;
        var senhanova1 = document.getElementById('senhanova1').value;
        var senhanova2 = document.getElementById('senhanova2').value;
        if (senhaantiga == "") {
            alert("Senha antiga não preenchida!");
            senhaantiga.focus();
        } else if (senhanova1 == "") {
            alert("Nova senha não preenchida!");
            senhanova1.focus();
        } else if (senhanova2 == "") {
            alert("Confirmação de senha não preenchido!");
            senhanova2.focus();
        } else if (senhanova2 != senhanova1) {
            alert("As senhas não coincidem!");
        } else {
            $.ajax({
                url: 'others/alterarsenhaalunos_config.php',
                type: 'POST',
                data: {
                    rmdoaluno: rmdoaluno,
                    senhaantiga: senhaantiga,
                    senhanova1: senhanova1,
                    senhanova2: senhanova2,
                },
                success: function(retornomudancasenha) {
                    alert(retornomudancasenha);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        };
    };

    function atualizarcadastro(rmaluno) {
        var newtelefone = document.getElementById('telefonenovo').value;
        var newcelular = document.getElementById('celularnovo').value;
        var newemail = document.getElementById('emailnovo').value;
        var newcurso = document.getElementById('cursonovo').value;
        if (newtelefone == "" && newcelular == "") {
            alert('Preencher pelo menos um telefone!');
        } else if (newemail == "") {
            alert('Preencher email!');
            newemail.focus();
        } else if (newcurso == "-") {
            alert('Selecionar Curso!');
            newcurso.focus();
        } else {
            $.ajax({
                url: 'others/atualizarcadastroaluno.php',
                type: 'POST',
                data: {
                    rmaluno: rmaluno,
                    newtelefone: newtelefone,
                    newcelular: newcelular,
                    newemail: newemail,
                    newcurso: newcurso
                },
                success: function(retornoatualização) {
                    alert(retornoatualização);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function validarfinalizacao() {
        const now = new Date();
        var tabelaempcodi = "";
        var rmaluno = document.getElementById('rmdoaluno').value;
        var dataagora = document.getElementById('dataemprestimo').value;

        var livro1;
        var livro2;
        var livro3;
        try {
            var livro1 = document.getElementById('livro1').value;
            var idlivro = document.getElementById('livro1').name;
            const past1 = new Date(livro1);
            const diff1 = Math.abs(now.getTime() - past1.getTime());
            const days1 = Math.ceil(diff1 / (1000 * 60 * 60 * 24));
            if (days1 <= 30) {
                document.getElementById("btnContinuarEmprestimo").disabled = true;
                $.ajax({
                    url: 'others/checkpendencia.php',
                    type: 'POST',
                    data: {
                        devolucao: livro1,
                        rmaluno: rmaluno,
                        idlivro: idlivro,
                        now: now
                    },
                    success: function(retornovalida) {
                        alert("Aguarde!");
                        if (retornovalida == "0") {
                            $.ajax({
                                url: 'others/concluirreserva1.php',
                                type: 'POST',
                                data: {
                                    rmaluno: rmaluno,
                                    now: dataagora,
                                },
                                success: function(tabelaempcodigo) {
                                    $.ajax({
                                        url: 'others/concluirreserva2.php',
                                        type: 'POST',
                                        data: {
                                            devolucao: livro1,
                                            rmaluno: rmaluno,
                                            idlivro: idlivro,
                                            now: now,
                                        },
                                        success: function(mensagemretorno) {
                                            alert(mensagemretorno);
                                            document.location.reload(true);
                                        },
                                        error: function(jqXHR, textStatus) {
                                            console.log('error ' + textStatus +
                                                " " + jqXHR);
                                        }
                                    });
                                },
                                error: function(jqXHR, textStatus) {
                                    console.log('error ' + textStatus + " " + jqXHR);
                                }

                            });
                        } else {
                            alert("Você deve devolver o livro com empréstimo em atraso primeiro!");
                        }

                    },
                    error: function(jqXHR, textStatus) {
                        console.log('error ' + textStatus + " " + jqXHR);
                    }
                });

            } else {
                alert('O Prazo máximo para devolução do livro é de 30 dias!');
            }
        } catch {
            //document.location.reload(true);
        };
        try {
            var livro2 = document.getElementById('livro2').value;
            var idlivro2 = document.getElementById('livro2').name;
            const past2 = new Date(livro2);
            const diff2 = Math.abs(now.getTime() - past2.getTime());
            const days2 = Math.ceil(diff2 / (1000 * 60 * 60 * 24));
            if (days2 <= 30) {
                $.ajax({
                    url: 'others/concluirreserva2.php',
                    type: 'POST',
                    data: {
                        devolucao: livro2,
                        rmaluno: rmaluno,
                        idlivro: idlivro2,
                        now: now
                    },
                    success: function(mensagemretorno) {
                        alert(mensagemretorno);
                        document.location.reload(true);
                    },
                    error: function(jqXHR, textStatus) {
                        console.log('error ' + textStatus + " " + jqXHR);
                    }
                });
            } else {
                alert('O Prazo máximo para devolução do livro é de 30 dias!');
            }

        } catch {
            //document.location.reload(true);
        };
        try {
            var livro3 = document.getElementById('livro3').value;
            var idlivro3 = document.getElementById('livro3').name;
            const past3 = new Date(livro3);
            const diff3 = Math.abs(now.getTime() - past3.getTime());
            const days3 = Math.ceil(diff3 / (1000 * 60 * 60 * 24));
            if (days3 <= 30) {
                $.ajax({
                    url: 'others/concluirreserva2.php',
                    type: 'POST',
                    data: {
                        devolucao: livro3,
                        rmaluno: rmaluno,
                        idlivro: idlivro3,
                        now: now
                    },
                    success: function(mensagemretorno) {
                        alert(mensagemretorno);
                        document.location.reload(true);
                    },
                    error: function(jqXHR, textStatus) {
                        console.log('error ' + textStatus + " " + jqXHR);
                    }
                });
            } else {
                alert('O Prazo máximo para devolução do livro é de 30 dias!');
            }
        } catch {
            //document.location.reload(true);
        };
    };

    function carregou() {
        document.getElementById('main1').innerHTML = `
        <h3 class="corpoTitle"> Introdução </h3><br>
        <hr class="hrTitle"><br>
        <div class="corpoCadastro" style="width: 95%;">
            <div class="alinharmeio">
                <p class="intTitle"><b>Intuito</b></p>
                    <p> O objetivo é que seja possível reservar livros pelo site e retirá-los na biblioteca.</h4>
                <p class="intTitle"><b>Guia</b></p>
            </div>
            <ul class="intLista">
                <li><p><b> Aluno: </b>Ao clicar no seu próprio nome, irá para a página de configurações do seu perfil.</p></li>
                <li><p><b> Procurar: </b>Para procurar dentre os títulos e adicionar no carrinho o(s) livro(s) selecionado(s).</p></li>
                <li><p><b> Carrinho: </b>Onde é possível visualizar os livros no carrinho e concluir a reserva.</p></li>
                <li><p><b> Empréstimos: </b>Onde é possível verificar todos seus empréstimos feitos, em andamento e Finalizados.</p></li>
                <li><p><b> Sair: </b>Volta para a página de login.</p>
            </ul>
        </div>`;
    };

    function btnCarrinho() {
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML = `
        <h3 class="corpoTitle"> Carrinho</h3><br>
        <hr class="hrTitle"><br>
        <div class="empTableDiv">
        <table name='carrinhotable' id='carrinhotable'>
            <tr>
                <th width="5%">ID</th>
                <th width="35%">Titulo</th>
                <th width="25%">Autor</th>
                <th width="15%">Data Reserva</th>
                <th width="5%"></th>
            </tr>
            <?php 
                while ($exibir_pre = mysqli_fetch_assoc($resultado_pre)) {
                    $sql_buscalista = "SELECT * FROM livros WHERE liv_codi='$exibir_pre[liv_codi]'";
                    $resultado_buscalista = mysqli_query($conn, $sql_buscalista);
                    $exibir_buscalista = mysqli_fetch_assoc($resultado_buscalista);
                    echo "<tr>";
                    echo "<td>$exibir_pre[liv_codi]</td>";
                    echo "<td>$exibir_buscalista[liv_titu]</td>";
                    echo "<td>$exibir_buscalista[liv_auto]</td>";
                    $ano= substr($exibir_pre['pre_data'], 0,4);
                    $mes= substr($exibir_pre['pre_data'], 5,2);
                    $dia= substr($exibir_pre['pre_data'], 8,2);
                    echo "<td>$dia/$mes/$ano</td>";
                    echo "<td>
                    <a class='btnsidenav' id='$exibir_pre[pre_codi]' onclick='remover_livro($exibir_pre[pre_codi], $exibir_pre[liv_codi])'>
                    <img src=../img/botao_excluir.png width='20px' height='20px'>
                    </a></td></tr>";
                }
                if ($exibir_pre5 = mysqli_fetch_assoc($resultado_pre5)){
                    echo "</table>";
                    echo "</div>";
                    echo "<div class='alinharmeio botpage'>";
                    echo "<button tabindex='0' href='#' class='botVerm botinpage pointer' onclick='btnContinuarEmprestimo()'> Continuar com a reserva </button>";
                    echo "</div>";
                }
            ?>
        `;
    };

    function btnContinuarEmprestimo() {
        document.getElementById('main2').innerHTML = `
        <div class='alinharmeio fundoBranco' style='border-radius: 1vh 1vh;'>
        <h3 style='padding-top: 3vh; margin-bottom: -1vh;'> Selecione as datas para devolução (máximo 30 dias): </h3><br>
        <?php

            $datadehoje = date('Y-m-d');
            $a = 1;
            while ($exibir_pre2 = mysqli_fetch_assoc($resultado_pre2)){
                $sql_buscalista2 = "SELECT * FROM livros WHERE liv_codi='$exibir_pre2[liv_codi]'";
                $resultado_buscalista2 = mysqli_query($conn, $sql_buscalista2);
                $exibir_buscalista2 = mysqli_fetch_assoc($resultado_buscalista2);
                echo "<label><b> $exibir_buscalista2[liv_titu] </b></label><br>";
                echo "<input style='margin-bottom: 2vh; width: 30%;' name='$exibir_pre2[liv_codi]' type='date' min='$datadehoje' id='livro$a'><br>";
                $a++;
            }
        ?>
        <button tabindex="0" href='#' class='botVerm textdecor botinpage' onClick='validarfinalizacao();' id='btnContinuarEmprestimo'> Finalizar Reserva </button>
        </div>`;
    };

    function remover_livro(id, livro) {
        var idtable = id;
        var idlivro = livro;
        $.ajax({
            url: 'others/removerlivro.php',
            type: 'POST',
            data: {
                idtable: idtable,
                idlivro: idlivro
            },
            success: function(removerlivromsg) {
                window.location.reload();
                alert(removerlivromsg);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function btnProcurar() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Livros </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Selecione o Livro que deseja saber mais!</b></p>
            <input class="form-control pesquisa corpoInputtxt" type="text" id="inlineFormInputGroup" placeholder="Digite o nome aqui!" >
            <table>
            <ul class="lista" style="list-style-type:none;  ">
            <?php 
                while ($exibir3 = mysqli_fetch_assoc($resultado)) {
                    $exibir4 = strtolower($exibir3['liv_titu']);
                    echo "<li class='listaOpcao pointer' onClick='VerLivro($exibir3[liv_codi])' nome='$exibir4' id='$exibir3[liv_codi]'> $exibir3[liv_titu]</li>";
                }
            ?>
            </ul>
            </table>`;
        // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
        pesquisa_input = document.querySelectorAll(".pesquisa");
        for (i in pesquisa_input) {
            pesquisa_input[i].onkeyup = function(e) {
                document.getElementById('main2').innerHTML = "";
                reg = new RegExp(this.value.toLowerCase(), "g");
                lis = this.parentElement.querySelector(".lista");
                //console.log(lis);
                for (j of lis.children) {
                    if (!j.getAttribute("nome").match(reg))
                        j.style.display = "none";
                    else
                        j.removeAttribute("style");
                };
            };
        };
    };

    function btnEmprestimos() {

        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Empréstimos </h3><br>
            <hr class="hrTitle"><br>
            <div class="horNav">
                <ul>
                    <li id="empLi"><a onClick="EmpEmProgresso()"> Em Progresso </a></li>
                    <li id="comLi"><a onClick="EmpCompleto()"> Completo </a></li>
                </ul>
            </div>`;

    };

    function EmpEmProgresso() {
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th style="width:10%;">ID</th>
                    <th style="width:50%;">Título</th>
                    <th style="width:20%;">Data Empréstimo</th>
                    <th style="width:20%;">Previsão Devolução</th>
                </tr>
                <?php 
                    
                    while ($exibir_emp_progresso = mysqli_fetch_assoc($resultado_emprestimoprogresso)) {
                        $sql_emprestimoprogresso2 = "SELECT * FROM livros WHERE liv_codi = $exibir_emp_progresso[liv_codi]";
                        $resultado_produtos_sql_emprestimoprogresso2 = mysqli_query($conn, $sql_emprestimoprogresso2);
                        $exibir_sql_emprestimoprogresso2 = mysqli_fetch_assoc($resultado_produtos_sql_emprestimoprogresso2);
                        $sql_emprestimoprogresso3 = "SELECT * FROM emprestimo WHERE emp_codi = $exibir_emp_progresso[emp_codi]";
                        $resultado_produtos_sql_emprestimoprogresso3 = mysqli_query($conn, $sql_emprestimoprogresso3);
                        $exibir_sql_emprestimoprogresso3 = mysqli_fetch_assoc($resultado_produtos_sql_emprestimoprogresso3);
                        echo "<tr>";
                        echo "<td nome='1' id='1'> $exibir_emp_progresso[emp_codi]</td>";
                        echo "<td nome='1' id='1'> $exibir_sql_emprestimoprogresso2[liv_titu]</td>";
                        $ano= substr($exibir_sql_emprestimoprogresso3['emp_data'], 0,4);
                        $mes= substr($exibir_sql_emprestimoprogresso3['emp_data'], 5,2);
                        $dia= substr($exibir_sql_emprestimoprogresso3['emp_data'], 8,2);
                        echo "<td nome='1' id='1'> $dia/$mes/$ano</td>";
                        $ano2= substr($exibir_emp_progresso['emp_dtde'], 0,4);
                        $mes2= substr($exibir_emp_progresso['emp_dtde'], 5,2);
                        $dia2= substr($exibir_emp_progresso['emp_dtde'], 8,2);
                        echo "<td nome='1' id='1'> $dia2/$mes2/$ano2</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        `;
        document.getElementById("empLi").classList.add('navActive');
        document.getElementById("comLi").classList.remove('navActive');
    };

    function EmpCompleto() {
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th style="width:10%;">ID</th>
                    <th style="width:60%;">Título</th>
                    <th style="width:15%;">Data Empréstimo</th>
                    <th style="width:15%;">Data Devolução</th>
                </tr>
                <?php 
                    while ($exibir_emp_finalizado = mysqli_fetch_assoc($resultado_emprestimofinalizado)) {
                        $sql_emprestimofinalizado2 = "SELECT * FROM livros WHERE liv_codi = $exibir_emp_finalizado[liv_codi]";
                        $resultado_produtos_sql_emprestimofinalizado2 = mysqli_query($conn, $sql_emprestimofinalizado2);
                        $exibir_sql_emprestimofinalizado2 = mysqli_fetch_assoc($resultado_produtos_sql_emprestimofinalizado2);
                        $sql_emprestimofinalizado3 = "SELECT * FROM emprestimo WHERE emp_codi = $exibir_emp_finalizado[emp_codi]";
                        $resultado_produtos_sql_emprestimofinalizado3 = mysqli_query($conn, $sql_emprestimofinalizado3);
                        $exibir_sql_emprestimofinalizado3 = mysqli_fetch_assoc($resultado_produtos_sql_emprestimofinalizado3);
                        echo "<tr>";
                        echo "<td nome='1' id='1'> $exibir_emp_finalizado[emp_codi]</td>";
                        echo "<td nome='1' id='1'> $exibir_sql_emprestimofinalizado2[liv_titu]</td>";
                        $ano= substr($exibir_sql_emprestimofinalizado3['emp_data'], 0,4);
                        $mes= substr($exibir_sql_emprestimofinalizado3['emp_data'], 5,2);
                        $dia= substr($exibir_sql_emprestimofinalizado3['emp_data'], 8,2);
                        echo "<td nome='1' id='1'> $dia/$mes/$ano</td>";
                        $ano2= substr($exibir_emp_finalizado['cor_dtde'], 0,4);
                        $mes2= substr($exibir_emp_finalizado['cor_dtde'], 5,2);
                        $dia2= substr($exibir_emp_finalizado['cor_dtde'], 8,2);
                        echo "<td nome='1' id='1'> $dia2/$mes2/$ano2 </td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        `;
        document.getElementById("comLi").classList.add('navActive');
        document.getElementById("empLi").classList.remove('navActive');
    };

    function VerLivro(id) {
        var idlivro = id;
        if (idlivro == "-") {
            document.getElementById('main2').innerHTML = "";
            alert("Selecione um livro!");
        } else {
            $.ajax({
                url: 'others/verlivro.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idlivro: idlivro,
                    tabela: 'livros'
                },
                success: function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<div class="result">
                            <hr class='hrMain'>
                            <div class="corpoCadastro">
                            <div class="livrDetail">
                            <br>
                                <span><b>Código do Livro:</b></span>
                                <label> ` + dados.codigo + ` </label> <br>
                                <label><b> Título do Livro: </b></label>
                                <label> ` + dados.nome + ` </label> <br>
                                <label><b> Autor: </b></label>
                                <label> ` + dados.autor + ` </label><br>
                                <label><b> Editora: </b></label>
                                <label> ` + dados.editora + ` </label><br>
                                <label><b> Categoria: </b></label>
                                <label> ` + dados.categoria + ` </label><br>
                                <label><b> Sinopse: </b></label>
                                <label> ` + dados.sinopse + ` </label>
                                <input class='botVerm pointer' type='button' onClick ='fazerReserva(` + dados
                        .codigo + `)' value=' Adicionar ao Carrinho ' id='btnAddCarrinho'><br>
                            </div></div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function fazerReserva(codigo) {
        var idlivr = codigo;
        var alunorm = document.getElementById('rmcontent').value;
        $.ajax({
            url: 'others/prereserva.php',
            type: 'POST',
            data: {
                idlivro: idlivr,
                alunorm: alunorm,
            },
            success: function(dados) {
                alert(dados);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };
    </script>

</head>

<body>
    <div class="sidenav">
        <input hidden type='text' id='datahoje' value='<?php echo date('Y-m-d');?>'>
        <input hidden type='text' id='rmdoaluno' value='<?php echo $rm;?>'>
        <input hidden type='date' id='dataemprestimo' value='<?php echo date('Y-m-d');?>'>
        <a href='home.php' class="textdecor" style="margin-top: -1.8vh;">
            <h1 tabindex="0" class='titulo' style='text-align: center;'>
                <span class="cor1">Bibli</span><span class="cor2">e</span><span class="cor3">tec</span>
            </h1>
        </a>
        <hr class='full'>
        <a tabindex="1" href='home.php?id=4'>
            <p class="big"><?php echo $nome ?> <br> - Aluno -</p>
            <img class="small" src="../img/botao_pessoa.png" style="height:3rem; width:auto;">

        </a><br>
        <input type="text" id='rmcontent' name='rmcontent' value='<?php echo $rm ?>' hidden>
        <hr class='full'>

        <?php echo '<a tabindex="2"  href="home.php?id=3" class="btnsidenav" id="btnProcurar">
            <p class="big">Procurar</p>
            <img class="small" src="../img/botao_procurar.png" style="height:3rem; width:auto;">
            </a>' ?>

        <hr>
        <?php echo '<a tabindex="5" href="home.php?id=2" class="btnsidenav" id="btnCarrinho">
            <p class="big">Carrinho</p>
            <img class="small" src="../img/botao_carrinho.png" style="height:3rem; width:auto;">
            </a>' ?>
        <hr>

        <a tabindex="3" href='home.php?id=5' class="btnsidenav" id='btnEmprestimos'>
            <p class="big">Empréstimos</p>
            <img class="small" src="../img/botao_emprestimo.png" style="height:3rem; width:auto;">
        </a>
        <hr>
        <a tabindex="6" class="btnsidenav" style="text-decoration:none;" href='../index.php' id='btnSair'>Sair</a>
    </div>
    <div class="corpoMain" id='main1'>
        <input hidden type='text' id='variavelid' value='<?php echo $idRecebido ?>'>
        <!-- FUNÇÃO DOS BOTÕES -->
        <!-- NÃO APAGAR! -->
    </div>
    <div class="corpoMain" id='main2' style='overflow-y: hidden;'>
        <input hidden type='date' id='livro1'><br>
        <input hidden type='date' id='livro2'><br>
        <input hidden type='date' id='livro3'><br>
        <!-- SOBRE O LIVRO -->
        <!-- NÃO APAGAR! -->
    </div>
    <div class="corpoMain" id='main3'>
        <!-- EXTRA - NÃO APAGAR -->
    </div>
</body>

</html>