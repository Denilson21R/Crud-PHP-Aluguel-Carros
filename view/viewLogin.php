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
	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

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

          body{
            background: rgb(165,164,185);
background: linear-gradient(90deg, rgba(165,164,185,1) 0%, rgba(150,150,218,1) 50%, rgba(141,178,185,1) 100%);
            height: 100vh;
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
                            <input type="hidden" name="action" value="login">
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
                            <button class="btn btn-dark btn-block mb-4" type="submit">Login</button>
                            <button class="btn btn-primary btn-block mb-4" style="margin-right: 10px;" id="btnNovoUsuario">Cadastrar Novo Usuário</button>
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
                        <button class="btn btn-dark btn-block mb-4" type="submit">Salvar</button>
                        <button class="btn btn-dark btn-block mb-4" id="btnVoltarCadastro">Voltar</button>
                    </form>
                    <div class="alert alert-dark" role="alert" id="alerta" style="display: none;">
                        Usuário não encontrado!
                    </div>
                    <div class="alert alert-dark" role="alert" id="alerta-cadastro" style="display: none;">
                        Não foi possível realizar o cadastro!
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    </body>
</html>
<script type="text/javascript">

$("#formLogin").submit(function(e){
    e.preventDefault();
	$.ajax({
        url: '/aluguel_carros/controller/controllerUsuario.php',
        type: 'post',
        data: $(this).serialize(),
        success: function(data) {
            if(data){
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
        url: '/aluguel_carros/controller/controllerUsuario.php',
        type: 'post',
        data: $(this).serialize(),
        success: function(data) {
            if(data == ""){
                document.location.href = "<?= $path; ?>"
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