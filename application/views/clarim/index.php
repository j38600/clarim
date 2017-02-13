<div class="container-fluid">
    <div class="row">
        <?php
        foreach ($ficheiros as $i => $ficheiro){
            ?>
            <div class="col-sm-6 col-md-4">
                <div class="btn-block btn-group btn-block">
                    <?php
                    $disabled = ($ficheiro['ativo']) ? '' : 'disabled ';
                    $class = ($admin) ? 'btn btn-primary col-xs-8 ' : 'btn btn-primary col-xs-12 ';
                    $pressed = ($toque == $ficheiro['id']) ? 'active' : '';
                    echo anchor(
                            'clarim/toque/'.$ficheiro['id'],
                            $ficheiro['id'].' - '.$ficheiro['nome_curto'],
                            array(
                                'title' => 'Esconder',
                                'class' => $class.$disabled.$pressed,
                                'role' => 'button'
                            )
                        );
                    
                    if ($admin){
                        $span = ($ficheiro['ativo']) ? '<span class="glyphicon glyphicon-eye-close"></span>'
                                                    : '<span class="glyphicon glyphicon-eye-open"></span>';
                        $ativo = ($ficheiro['ativo']) ? 'Esconder' : 'Mostrar';
                        echo anchor(
                                'clarim/visivel/'.$ficheiro['id'],
                                $span,
                                array(
                                    'title' => $ativo,
                                    'class' => 'btn btn-info  col-xs-2',
                                    'role' => 'button'
                                )
                            );
                        echo anchor(
                                'clarim/apagar/'.$ficheiro['id'],
                                '<span class="glyphicon glyphicon-remove"></span>',
                                array(
                                    'title' => 'Apagar',
                                    'class' => 'btn btn-danger  col-xs-2',
                                    'role' => 'button'
                                )
                            );
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
        <?php
        if ($admin){
        ?>
            <div class="col-sm-6 col-md-4">
                <?php
                echo anchor(
                    'clarim/novo',
                    '<span class="glyphicon glyphicon-plus"></span> Novo toque',
                    array(
                        'title' => 'Novo',
                        'class' => 'btn-block btn btn-success',
                        'role' => 'button'
                    )
                );
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>