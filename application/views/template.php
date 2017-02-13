<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <?php
            echo link_tag('css/bootstrap.min.css');
            echo link_tag('css/styles.css');
            echo link_tag('imgs/logo.ico', 'shortcut icon');
        ?>
        <script src='<?php echo base_url()?>js/jquery-2.1.1.min.js' > </script>
        <script src='<?php echo base_url()?>js/bootstrap.min.js'> </script>
    </head>
    
    <body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href='<?php echo base_url()?>' >SecCSI</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href='<?php echo base_url()?>clarim/parar'>
                            <span class="glyphicon glyphicon-volume-off"></span> Stop
                            </a>
                        </li>
                        <li class='<?php if ($nav == 'clarim') {echo 'active';}?>'>
                            <a href='<?php echo base_url()?>clarim' >
                            <span class="glyphicon glyphicon-volume-up"></span> Toques
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $user?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php if ($admin) { ?>
                                    <li><a href="<?php echo base_url()?>auth">Utilizadores</a></li>
                                    <li><a href="<?php echo base_url()?>registo/automaticos">Histórico</a></li>
                                <?php }?>
                                <li><a href="<?php echo base_url()?>agenda/normal">Agendamentos</a></li>
                                <li class="divider"></li>
                                <li><a href='<?php echo base_url()?>auth/logout'>Logout</a></li>
                            </ul>
                        </li>
                      </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo $contents ?>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('.tooltip_listas').tooltip({container: 'body'});
                $('.popover_listas').popover({container: 'body'});
            })
        </script>
    </body>
</html>