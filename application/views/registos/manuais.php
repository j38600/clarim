<div class="container-fluid">
    <div class="row">
        <ul class="nav nav-tabs nav-justified">
            <li role="presentation"><a href="automaticos">Toques automáticos</a></li>
            <li role="presentation" class="active"><a href="manuais">Toques manuais</a></li>
            <li role="presentation"><a href="agendamentos">Agendamentos e feriados</a></li>
        </ul>
    </div>
    <div classe="row">
        <h2>Histórico dos toques manuais efetuados</h2>
        <table class="table table-striped table-condensed table-hover">
            <thead>
            <tr>
                <th>GDH</th>
                <th>Username</th>
                <th>Computador</th>
                <th>Ação efetuada</th>
            </tr>
            </thead>
            <tbody class="text-left">
                <?php foreach ($registos as $registo):?>
                    <tr>
                        <td><?php echo $registo['gdh'];?></td>
                        <td><?php echo $registo['username'];?></td>
                        <td><?php echo $registo['ip_maquina'];?></td>
                        <td><?php echo $registo['accao'];?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
