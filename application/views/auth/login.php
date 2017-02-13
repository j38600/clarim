<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            Login
        </title>
        <?php
            echo link_tag('css/bootstrap.min.css');
            echo link_tag('imgs/logo.ico', 'shortcut icon');
        ?>
        <script src='<?php echo base_url()?>js/jquery-2.1.1.min.js' ></script>
        <script src='<?php echo base_url()?>js/bootstrap.min.js'></script>
    </head>
    <body>
        <div class="container text-center">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3 well">
                    <a><?php echo img('imgs/tms.png'); echo br(3);?></a>
                        <div class="row">
                            <div class="col-xs-6 col-xs-offset-3">
                                
                                <?php if(!empty($message)){?>
                                    <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $message; ?>
                                    </div>
                                    <?php
                                    } ?>
                                
                                <?php echo form_open('auth/login', [ 'class' => 'form-horizontal',
                                                                            'role' => 'form']); ?>
                                <div class="form-group">
                                    <?php echo form_input($identity); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_password($password); ?>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary col-xs-6 col-xs-offset-3" type="submit">Entrar</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="navbar navbar-fixed-bottom">
            <div class="container text-center">
                <div class="row">
                    <p class="text-muted">Exército Português @2014</p>
                </div>
            </div>
        </div>
	</body>
</html>