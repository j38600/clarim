<div class="container-fluid">
    <div class="row">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation"><a href="normal">Horário Normal</a></li>
            <li role="presentation"><a href="reduzido">Horário Reduzido</a></li>
            <li role="presentation" class="active"><a href="feriado">Feriados</a></li>
        </ul>
    </div>
    <div classe="row">
        <h2>Listagem dos feriados</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>Ano</th>
                <th>Mês</th>
                <th>Dia</th>
                <th>Descrição</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($feriados as $feriado):?>
                    <tr>
                        <td>
                            <?php
                            $datetime = explode(" ",$feriado['data']);
                            $date = $datetime[0];
                            $month = date('F', strtotime($date));
                            $mes = $this->lang->line('cal_'.strtolower($month));
                            echo date('Y', strtotime($date));
                            ?>
                        </td>
                        <td><?php echo $mes;?></td>
                        <td><?php echo date('d', strtotime($date));?></td>
                        <td><?php echo $feriado['descricao'];?></td>
                        <td>
                            <?php
                            if ($admin){
                                echo anchor(
                                    'agenda/feriado/'.$feriado['id'],
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
                        <td></td>
                        <td>
                            <?php
                            if ($admin){
                                echo anchor(
                                    'agenda/feriado/novo',
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
