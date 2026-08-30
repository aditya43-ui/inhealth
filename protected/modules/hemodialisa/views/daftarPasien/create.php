<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i>
            <?php
             echo 'Tambah <b>PPDS</b>';
        
            ?>
        </div>
    </div>
    <div class="panel-body">
        <?php
                $this->breadcrumbs = array(
                    'PPDS' => array('index'),
                    'Tambah',
                );
   

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
   
        <?php echo $this->renderPartial($this->path_view . '_formPPDSRJ', array('sukses'=>0, 'modPasien'=>$modPasien,'modRuangan'=>$modRuangan, 'model' => $model, 'model' => $model,'modPendaftaran' => $modPendaftaran, 'modDetail' => $modDetail)); ?>
    </div>
</div>