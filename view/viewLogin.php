<?php
$path = $_SESSION["path"];
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v3.8.5">
        <title>Fazer Login</title>

        <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/checkout/">

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="<?php echo $_SESSION["path"]; ?>view/css/home.css" rel="stylesheet">
        <style>
          .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
          }

          @media (min-width: 768px) {
            .bd-placeholder-img-lg {
              font-size: 3.5rem;
            }
          }
        </style>
        <!-- Custom styles for this template -->
    </head>
    <body>
        <div class="container">
            <div class="py-5 text-center">
                <h2>Aluguel de Carros</h2>
            </div>
            <div class="row">
                <div class="col-md-12 order-md-1">
                    
                    <form method="post" id="formLogin">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="login" style="font-weight: bolder;">Login</label>
                                <input type="text" class="form-control" name="login" id="login" placeholder="" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="senha" style="font-weight: bolder;">Senha</label>
                                <input type="password" class="form-control" name="senha" id="senha" placeholder="" value="" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-principal btn-block mb-4" type="submit">Login</button>    
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-secondary btn-block mb-4" style="margin-right: 10px;" id="btnNovoUsuario">Cadastrar Novo Usuário</button>
                            </div>
                        </div>                        
                    </form>
                    <form method="post" id="formCadastro" style="display: none;">
                        <input type="hidden" name="action" value="cadastro">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="login" style="font-weight: bolder;">Login</label>
                                <input type="text" class="form-control" name="login-cadastro" id="login-cadastro" placeholder="" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="senha" style="font-weight: bolder;">Senha</label>
                                <input type="password" class="form-control" name="senha-cadastro" id="senha-cadastro" placeholder="" value="" required>
                            </div>
                        </div>
                        <button class="btn btn-principal btn-block mb-4" type="submit">Salvar</button>
                        <button class="btn btn-secondary btn-block mb-4" id="btnVoltarCadastro">Voltar</button>
                    </form>
                    <div class="alert alert-dark" role="alert" id="alerta" style="display: none;">
                        Usuário não encontrado!
                    </div>
                    <div class="alert alert-dark" role="alert" id="alerta-cadastro" style="display: none;">
                        Não foi possível realizar o cadastro!
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cadastro realizado com Sucesso!</h5>
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
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
<script type="text/javascript">

$("#formLogin").submit(function(e){
    e.preventDefault();
	$.ajax({
        url: '<?= $path; ?>login',
        type: 'post',
        data: $(this).serialize(),
        success: function(data) {
            console.log(data);
            if(data === ""){
                document.location.href = "<?= $path; ?>home/"
            }else{
                $("#login").val("");
                $("#senha").val("");
                $("#alerta").css("display","block")
                var counter = 0;
                var interval = setInterval(function() {
                    counter++;
                    if (counter == 5) {
                        $("#alerta").css("display","none")
                        clearInterval(interval);
                    }
                }, 1000);
            }
        }
    });
});

$("#btnNovoUsuario").click(function(e){
    e.preventDefault()
    $("#formLogin").css("display","none");
    $("#formCadastro").css("display","block")
});

$("#formCadastro").submit(function(e){
    e.preventDefault();
	$.ajax({
        url: '<?= $path; ?>cadastro',
        type: 'post',
        data: $(this).serialize(),
        success: function(data) {
            console.log(data);
            if(data == ""){
                $("#exampleModal").modal("show");
            }else{
                $("#login-cadastro").val("");
                $("#senha-cadastro").val("");
                $("#alerta-cadastro").css("display","block")
                var counter = 0;
                var interval = setInterval(function() {
                    counter++;
                    if (counter == 5) {
                        $("#alerta-cadastro").css("display","none")
                        clearInterval(interval);
                    }
                }, 1000);
            }
        }
    });
});

$("#btnVoltarCadastro").click(function(e){
    e.preventDefault()
    $("#formLogin").css("display","block");
    $("#formCadastro").css("display","none")
});
</script>