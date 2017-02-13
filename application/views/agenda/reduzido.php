<div class="container-fluid">
    <div class="row">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation"><a href="normal">Horário Normal</a></li>
            <li role="presentation" class="active"><a href="reduzido">Horário Reduzido</a></li>
            <li role="presentation"><a href="feriado">Feriados</a></li>
        </ul>
    </div>
    <div classe="row">
        <h2>Listagem dos agendamentos em horário reduzido</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Hora</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($agendamentos as $agendamento):?>
                    <tr>
                        <td>
                            <?php
                            $datetime = explode(" ",$agendamento['gdh']);
                            //$date = $datetime[0];
                            $time = $datetime[1];
                            echo $time;
                            ?>
                        </td>
                        <td><?php echo $agendamento['nome_curto'];?></td>
                        <td><?php echo $agendamento['descricao'];?></td>
                        <td>
                            <?php
                            if ($admin){
                                echo anchor(
                                    'agenda/apagarAgendamento/'.$agendamento['id'],
                                    '<span class="glyphicon glyphicon-remove"></span> Apagar',
                                    array(
                                        'title' => 'Novo',
                                        'class' => 'btn-block btn btn-danger',
                                        'role' => 'button'
                                    )
                                );
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach;?>
                <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php
                            if ($admin){
                                echo anchor(
                                    'agenda/novo/reduzido',
                                    '<span class="glyphicon glyphicon-plus"></span> Novo',
                                    array(
                                        'title' => 'Novo',
                                        'class' => 'btn-block btn btn-success',
                                        'role' => 'button'
                                    )
                                );
                            }
                            ?>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>
