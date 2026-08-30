<?php
$this->breadcrumbs = array(
    'Radiologi',
);
$this->widget('bootstrap.widgets.BootAlert');

?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'radiologi-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));
?>

<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> Tabel <b> Riwayat Pemeriksaan Radiologi</b> </div>
    </div>
    <div class="panel-body"  style="overflow-x: auto; max-width: 100%;">
        <?php //$this->renderPartial($this->path_view_rad .'/_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain));
        ?>
    </div>
</div>-->

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> Tabel <b> Pemeriksaan Radiologi </b> </div>
    </div>
    <div class="panel-body table-responsive">
        <div class="formInputTab">
            <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
            <table id="form-pemeriksaan-mcu" class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>NAMA PEMERIKSAAN</th>
                        <th>HASIL EKSPERTISE</th>
                        <th>KESAN</th>
                        <th>KESIMPULAN</th>
                        <th>HASIL RADIOLOGI</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <!--</div>-->
            <div class="form-actions">
                <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); 
                ?>
                <?php
                if ($modHasilPemeriksaanRad->isNewRecord) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event)')); //formSubmit(this,event)
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                }

                ?>
                <?php
                $pemeriksaanrad_id = isset($_GET['pemeriksaanrad_id']) ? $_GET['pemeriksaanrad_id'] : null;
                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id . '&pemeriksaanrad_id=' . $pemeriksaanrad_id);
                $urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printRiwayat&id=' . $modPendaftaran->pendaftaran_id);
                $urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print&id=' . $modPendaftaran->pendaftaran_id);

                $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
}
function printRiwayat(caraPrint)
{
    window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printPermintaan(pemeriksaanrad_id)
{
    window.open("${urlPrintPermintaan}&pemeriksaanrad_id="+pemeriksaanrad_id+"&caraPrint="+"PRINT","",'location=_new, width=460px');
}

JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPendaftaran' => $modPendaftaran, 'modKirimKeUnitLain' => $modKirimKeUnitLain)); ?>