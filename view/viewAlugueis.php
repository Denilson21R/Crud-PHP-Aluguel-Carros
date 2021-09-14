<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/controller/ControllerVeiculo.php";
$controllerVeiculo = new ControllerVeiculo();
$veiculos = $controllerVeiculo->getVeiculos();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Painel</title>
        <!-- CSS home-->
        <link href="<?php echo $_SESSION["path"]; ?>view/css/home.css" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            
            <header class="navbar" style="justify-content: flex-end;">
                <div style="margin-right: 20px; font-weight: bolder"><?php echo strtoupper($_SESSION["login_usuario"]); ?></div>
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalLogoff">Sair</button>
            </header>
            <div class="py-5 text-center">
                <h2>Veículos</h2>
                
            </div>
            <button class="btn btn-dark" style="margin-bottom: 5px;" data-bs-toggle="modal" data-bs-target="#modalAddVeiculo" id="btnModalAddVeiculo" >Adicionar Veículo</button>
            
            <table class="table table-dark">
                <thead>
                    <tr>
                    <th class="text-center" scope="col">Id</th>
                    <th class="text-center" scope="col">Veículos</th>
                    <th class="text-center" scope="col">Situação</th>
                    <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($veiculos as $veiculo){ ?>
                    <tr>
                        <td class="text-center"><?= $veiculo["id"] ?></td>
                        <td class="text-center"><?= $veiculo["nome"] ?></td>
                        <td class="text-center"><?php if($veiculo["alugado"]){ echo "Alugado";}else{echo "Disponível";} ?></td>
                        <td class="text-center">
                            <?php if($veiculo["usando"] == $_SESSION["id_usuario"]){ ?>
                            <button type="button" class="btn btn-secondary" onclick='devolverVeiculo("<?= $veiculo["id"]; ?>")'>Devolver</button>
                            <?php }else if($veiculo["id_dono"] != $_SESSION["id_usuario"] && !$veiculo["alugado"]){ ?>
                            <button type="button" class="btn btn-primary" onclick='alugarVeiculo("<?= $veiculo["id"]; ?>")'>Alugar</button>  
                            <?php }else if($veiculo["id_dono"] == $_SESSION["id_usuario"] && !$veiculo["alugado"]){ ?>                          
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEditVeiculo" onclick='editVeiculo("<?= $veiculo["id"]; ?>","<?= $veiculo["nome"]; ?>")'>Editar</button>
                            <button type="button" class="btn btn-danger" onclick='excluirVeiculo("<?= $veiculo["id"]; ?>")'>Excluir</button>
                            <?php }else if($veiculo["id_dono"] == $_SESSION["id_usuario"] && $veiculo["alugado"]){ ?>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalEditVeiculo" onclick='editVeiculo("<?= $veiculo["id"]; ?>","<?= $veiculo["nome"]; ?>")'>Editar</button>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Modal Logoff-->
            <div class="modal fade" id="modalLogoff" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header  text-center">
                        <h5 class="modal-title" id="exampleModalLabel">Deseja sair?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer" style="justify-content: space-evenly;">
                        <button type="button" class="btn btn-primary" id="btnSair">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Logoff--> 

            <!-- Modal addVeiculo-->
            <div class="modal fade" id="modalAddVeiculo" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar Veículo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="Nome">Nome do Veículo</label>
                        <input type="text" class="form-control" id="Nome" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnAddVeiculo">Salvar</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- End Modal addVeiculo-->
            
            <!-- Modal editVeiculo-->
            <div class="modal fade" id="modalEditVeiculo" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Veículo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formEditaVeiculo">
                        <input type="hidden" name="id_veiculo_edit" id="id_veiculo_edit">
                        <div class="modal-body">
                            <label for="Nome">Nome do Veículo</label>
                            <input type="text" class="form-control" name="nome_veiculo_edit" id="nome_veiculo_edit" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btnSalvaVeiculo">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- End Modal editVeiculo-->

            <!-- Modal Concluido -->
            <div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">OK!</h3>
                </div>
                <div class="modal-body"><p>Cadastro realizado com sucesso!</p>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                    </div>
                </div>
            </div>
            <!-- End Modal Concluido -->
        </div>
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>

var myModal = document.getElementById('myModal')
myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})

$("#btnSair").click(function(){
    $.ajax({
        url: '<?= $path; ?>controller/controllerUsuario.php',
        type: 'post',
        data: {'action':'logoff'},
        success: function(data) {
            if(data){
                document.location.href = "/aluguel_carros/"
            }
        }
    });
});

$("#btnModalAddVeiculo").click(function(){
    $("#Nome").val("");
});

$("#btnAddVeiculo").click(function(){
    var nome = $("#Nome").val();
    if(nome != ""){
        $.ajax({
            url: '<?= $path; ?>addVeiculo',
            type: 'post',
            data: {'nomeVeiculo':nome},
            success: function(data) {
                if(data == ""){
                    myModal.toggle();
                    document.location.reload();
                }
            }
        });
    }
});

function excluirVeiculo(id){
    $.ajax({
        url: '<?= $path; ?>excluirVeiculo',
        type: 'post',
        data: {'id':id},
        success: function(data) {
            if(data == ""){
                document.location.reload();
            }
        }
    });
}

function editVeiculo(id, nome){
    $("#id_veiculo_edit").val(id)
    $("#nome_veiculo_edit").val(nome)
}

$("#formEditaVeiculo").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '<?= $path; ?>updateVeiculo',
        type: 'post',
        data: $(this).serialize(),
        success: function(data) {
            if(data == ""){
                document.location.reload();
            }
        }
    });
});

function alugarVeiculo(id){
    $.ajax({
        url: '<?= $path; ?>alugarVeiculo',
        type: 'post',
        data: {'id':id},
        success: function(data) {
            if(data == ""){
                document.location.reload();
            }
        }
    });
}

function devolverVeiculo(id){
    $.ajax({
        url: '<?= $path; ?>devolverVeiculo',
        type: 'post',
        data: {'id':id},
        success: function(data) {
            if(data == ""){
                document.location.reload();
            }
        }
    });
}

</script>