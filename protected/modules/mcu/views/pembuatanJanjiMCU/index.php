<?php $linkHalaman = CustomFunction::getUrlByMenuID(3581); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Buat <b>Janji MCU</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Pembuatan Janji MCU',
        );
        ?>
        <!--<div class="rim2">Buat <b>Janji MCU</b></div>-->
        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view . '_jsFunction', array('model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)); ?>