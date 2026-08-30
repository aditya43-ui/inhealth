<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Pasien Janji Poli</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<div class="white-container">-->
        <!--<legend class="rim2">Ubah Pasien <b>Janji Poli</b></legend>-->
        <?php
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_formUpdate', array('modPPBuatJanjiPoli' => $modPPBuatJanjiPoli)); ?>
        <!--</div>-->
    </div>
</div>