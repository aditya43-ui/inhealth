<?php
$this->breadcrumbs = array(
    'Informasi Pasien Pulang'
);
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
Yii::app()->clientScript->registerScript('cari wew', "
        $('#daftarPasienPulang-form').submit(function(){
                $.fn.yiiGridView.update('daftarPasienPulang-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
    ");
//echo Yii::app()->user->getState('ruangan_id');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Pulang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_formPencarian', array('modPasienYangPulang' => $modPasienYangPulang)); ?>
                <?php
                // Dialog untuk batal Rawat Darurat =========================
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'dialogBatalPulang',
                    'options' => array(
                        'title' => 'Pembatalan Pulang Pasien',
                        'autoOpen' => false,
                        'modal' => true,
                        'minWidth' => 800,
                        'height' => 500,
                        'resizable' => true,
                    ),
                ));
                ?>
                <iframe src="" name="iframeBatalPulang" width="100%" height="550">
                </iframe>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Pulang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <?php echo $this->renderPartial('_tablePasienPulang', array('modPasienYangPulang' => $modPasienYangPulang)); ?>
                <!--/div-->
            </div>
        </div>
    </div>
</div>