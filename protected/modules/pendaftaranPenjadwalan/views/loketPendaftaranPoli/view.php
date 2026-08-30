
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Lihat <b>Loket Pendaftaran Poli</b>
        </div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
        'Loket Pendaftaran Poli'=>array('admin'),            
    );

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <table class="table table-condensed table-stripped table-bordered">
        <tr>
            <th>Nama Loket</th>
            <th>Poli Klinik</th>
        </tr>
        <?php
            $ruangan = LoketpendaftaranpoliM::model()->findAll(" loket_id = ".$model->loket_id);
            if (!empty($ruangan)){
                foreach($ruangan as $key => $val){
                    echo "<tr>";
                    echo "<td>".(($key == 0)?$model->loket_nama:'')."</td>";
                    echo "<td>".$val->ruangan_nama."</td>";
                    echo "</tr>";
                }
            }
        ?>
    </table>
    
        <div class="form-actions">
    <?= $this->renderPartial('_buttonPengaturan',['model'=>$model],true); ?>    
    <?php $this->widget('UserTips',array('type'=>'view'));?>
        </div>
</div>