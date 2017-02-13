<?php
if(validation_errors()){
?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo validation_errors() ?>
    </div>
<?php
}
echo form_open('agenda/novo/'.$horario, ['class' => 'form-horizontal',
                                      'role' => 'form']); ?>
<div class="form-group">
    <label for="id_ficheiro" class="col-xs-offset-3 col-xs-2 control-label">Toque</label>
    <div class="col-xs-4">
    <?php $options = array();
            foreach ($ficheiros as $i => $ficheiro) {
                $options[$ficheiro['id']] = $ficheiro['id'].' - '.$ficheiro['nome_curto'];
            }
    echo form_dropdown('id_ficheiro',$options,'','class="form-control"');?>
    </div>
</div>
<div class="form-group">
    <label for="gdh" class="col-xs-offset-3 col-xs-2 control-label">Hora do toque</label>
    <div class="col-xs-4">
    <?php echo form_input([ 'name' => 'gdh',
                            'id' => 'gdh',
                            'type' => 'time',
                            'value' => set_value('data'),
                            'placeholder' => 'hh:mm',
                            'class' => 'form-control']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-xs-offset-2">
        <button class="btn btn-primary" type="submit" name="submit">Adicionar</button>
    </div>
</div>
<?php
echo form_close();
?>