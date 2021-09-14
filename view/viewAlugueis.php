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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            
            <header class="navbar" style="justify-content: flex-end;">
                <div style="margin-right: 20px; font-weight: bolder"><?php echo strtoupper($_SESSION["login_usuario"]); ?></div>
                <button class="btn btn-dark" id="btnLogoff">Sair</button>
            </header>
            <div class="py-5 text-center">
                <h2>Veículos</h2>
                
            </div>
            <button class="btn btn-dark" style="margin-bottom: 5px;" id="btnModalAddVeiculo" >Adicionar Veículo</button>
            
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
                            <button type="button" class="btn btn-success" onclick='editVeiculo("<?= $veiculo["id"]; ?>","<?= $veiculo["nome"]; ?>")'>Editar</button>
                            <button type="button" class="btn btn-danger" onclick='excluirVeiculo("<?= $veiculo["id"]; ?>")'>Excluir</button>
                            <?php }else if($veiculo["id_dono"] == $_SESSION["id_usuario"] && $veiculo["alugado"]){ ?>
                                <button type="button" class="btn btn-success" onclick='editVeiculo("<?= $veiculo["id"]; ?>","<?= $veiculo["nome"]; ?>")'>Editar</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer" style="justify-content: space-evenly;">
                        <button type="button" class="btn btn-primary" id="btnSair">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="Nome">Nome do Veículo</label>
                        <input type="text" class="form-control" id="Nome" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formEditaVeiculo">
                        <input type="hidden" name="id_veiculo_edit" id="id_veiculo_edit">
                        <div class="modal-body">
                            <label for="Nome">Nome do Veículo</label>
                            <input type="text" class="form-control" name="nome_veiculo_edit" id="nome_veiculo_edit" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" id="btnSalvaVeiculo">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-- End Modal editVeiculo-->

            <!-- Modal Concluido -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Concluído com Sucesso!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="window.location.reload();">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Concluido -->
        </div>
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>

$("#btnLogoff").click(function(){
    $("#modalLogoff").modal('show');
});

$("#btnSair").click(function(){
    $.ajax({
        url: '<?= $path; ?>sair',
        type: 'post',
        data: null,
        success: function(data) {
            if(data === ""){
                document.location.href = "/aluguel_carros/"
            }else{
                $("#modalLogoff").modal('hide');
            }
        }
    });
});
$("#btnModalAddVeiculo").click(function(){
    $("#Nome").val("");
    $("#modalAddVeiculo").modal('show');
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
                    $("#modalAddVeiculo").modal('hide');
                    $("#exampleModal").modal('show');
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
                $("#exampleModal").modal('show');
            }
        }
    });
}

function editVeiculo(id, nome){
    $("#id_veiculo_edit").val(id);
    $("#nome_veiculo_edit").val(nome);
    $("#modalEditVeiculo").modal('show');
}

$("#formEditaVeiculo").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '<?= $path; ?>updateVeiculo',
        type: 'post',
        data: $(this).serialize(),
        success: function(data) {
            if(data == ""){
                $("#modalEditVeiculo").modal('hide');
                $("#exampleModal").modal('show');
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
                $("#exampleModal").modal('show');
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
                $("#exampleModal").modal('show');
            }
        }
    });
}

</script>