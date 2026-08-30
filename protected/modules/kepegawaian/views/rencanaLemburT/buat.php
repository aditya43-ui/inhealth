<style>
    tr td .add-on,
    tr td label,
    tr td input {
        margin: 0 !important;
    }
</style>
<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-time"></i> Transaksi <b>Rencana Lembur</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($sukses)) {
            Yii::app()->user->setFlash('success', "Data " . $modRencanaLembur->norencana . " berhasil disimpan!");
        }
        $this->breadcrumbs = array(
            'Transaksi Rencana Lembur',
        );
        $arrMenu = array();
        //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Buat Rencana Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_form', array('modRencanaLembur' => $modRencanaLembur, 'rencana' => $rencana, 'sukses' => $sukses,)); ?>
        <!--/div-->
    </div>
</div>