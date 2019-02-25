<?php
define("BASE", "http://localhost/estudo/RedBelt");
require __DIR__ . "/../../source/autoload.php";
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Incidentes</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <div class="alert alert-dark mt-5 text-center" role="alert">
        VER | EDITAR INCIDENTE
    </div>

    <?php

    $getId = filter_input(INPUT_GET, 'incidentId', FILTER_SANITIZE_STRIPPED);

    if (!empty($getId)) {
        $getIncident = \Source\Database\Connect::getInstance()->query("select i.id, i.title, i.description, i.criticity_id, 
                    i.type_id, i.status_id, c.criticity, t.`type`, s.status from incidents i
                    inner join criticities c
                    on i.criticity_id = c.id
                    inner join types t
                    on i.type_id = t.id
                    inner join status s
                    on i.status_id = s.id
                    where i.id = {$getId}
                    ");

        $getResult = $getIncident->fetch();
    }
    ?>

    <form action="<?= BASE; ?>/index.php?update=true&id=<?= $getId; ?>" method="post">
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Digite um título"
                   value="<?= $getResult->title; ?>">
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea class="form-control" name="description" id="description"
                      rows="3"><?= $getResult->description; ?></textarea>
        </div>
        <div class="form-group">
            <label for="criticity_id">Nível de criticidade</label>
            <select class="form-control" name="criticity_id" id="criticity">
                <option value="1" <?= ($getResult->criticity_id == 1 ? 'selected=selected' : ''); ?>>Baixa</option>
                <option value="2" <?= ($getResult->criticity_id == 2 ? 'selected=selected' : ''); ?>>Média</option>
                <option value="3" <?= ($getResult->criticity_id == 3 ? 'selected=selected' : ''); ?>>Alta</option>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Tipo</label>
            <select class="form-control" name="type_id" id="type_id">
                <option value="1" <?= ($getResult->type_id == 1 ? 'selected=selected' : ''); ?>>Brute Force</option>
                <option value="2" <?= ($getResult->type_id == 2 ? 'selected=selected' : ''); ?>>Credencial Vazada
                </option>
                <option value="3" <?= ($getResult->type_id == 3 ? 'selected=selected' : ''); ?>>DDOS</option>
                <option value="4" <?= ($getResult->type_id == 4 ? 'selected=selected' : ''); ?>>Atividade anormal de
                    usuário
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status_id" id="status_id">
                <option value="1" <?= ($getResult->status_id == 1 ? 'selected=selected' : ''); ?>>Aberto</option>
                <option value="2" <?= ($getResult->status_id == 2 ? 'selected=selected' : ''); ?>>Fechado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success btn-lg">Salvar Alterações</button>
        <a href="<?= BASE; ?>/index.php" class="btn btn-primary btn-lg">Voltar Para Listagem</a>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
</body>
</html>