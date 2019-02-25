<?php
require __DIR__ . "/source/autoload.php";
define("BASE", "http://localhost/estudo/RedBelt");
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Controle de Incidentes</title>

    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="alert alert-dark mt-5 text-center" role="alert">
        SISTEMA DE CONTROLE DE INCIDENTES
    </div>

    <div class="mt-3 mb-3">
        <a href="<?= BASE; ?>/pages/form/new.php" class="btn btn-lg btn-success">Novo Incidente</a>
    </div>

    <?php
    $getNew = filter_input(INPUT_GET, 'register', FILTER_VALIDATE_BOOLEAN);
    $getUpdate = filter_input(INPUT_GET, 'update', FILTER_VALIDATE_BOOLEAN);
    $getDelete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_BOOLEAN);
    $getId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($getNew) {
        $getData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $save = new \Source\Classes\Incidents();
        $save->exeCreate($getData);
        echo $save->getError();
    }

    if ($getUpdate){
        $getData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $update = new \Source\Classes\Incidents();
        $update->exeUpdate($getId, $getData);
        echo $update->getError();
    }

    if ($getDelete){
        $delete = new \Source\Classes\Incidents();
        $delete->exeDelete($getId);
        echo $delete->getError();
    }
    ?>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Criticidade</th>
            <th scope="col">Tipo</th>
            <th scope="col">Status</th>
            <th scope="col" colspan="2" class="text-center">Ações</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $getAll = \Source\Database\Connect::getInstance()->query("select i.id, i.title, i.criticity_id, 
                    i.type_id, i.status_id, c.criticity, t.`type`, s.status from incidents i
                    inner join criticities c
                    on i.criticity_id = c.id
                    inner join types t
                    on i.type_id = t.id
                    inner join status s
                    on i.status_id = s.id
                    order by i.id");

        if ($getAll->rowCount()) {
            foreach ($getAll as $incident) {
                ?>
                <tr>
                    <th><?= $incident->id; ?></th>
                    <td><?= $incident->title; ?></td>
                    <td><?= $incident->criticity; ?></td>
                    <td><?= $incident->type; ?></td>
                    <td><?= $incident->status; ?></td>
                    <td>
                        <a href="<?= BASE ?>/pages/form/update.php?incidentId=<?= $incident->id; ?>"
                           class="btn btn-info">Ver | Editar</a>
                    </td>
                    <td>
                        <a href="<?= BASE ?>/index.php?id=<?= $incident->id; ?>&delete=true"
                           class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
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