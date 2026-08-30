<fieldset class="box">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'sapegawai-m-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
    )); ?>
    <div class="block-tabel">
        <h6>Data <b>Penggajian Pegawai</b></h6>
        <div class="row">
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, '<b>Tanggal Penggajian :</b>', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::encode($model->tglpenggajian); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, '<b>No Penggajian :</b>', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::encode($model->nopenggajian); ?>
                    </div>
                </div>
            </div>
            <div class="span8">
                <div class="control-group">
                    <?php echo $form->labelEx($model, '<b>Keterangan :</b>', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::encode(($model->keterangan) ? $model->keterangan : "-"); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="control-group">
                    <table class='table table-striped table-bordered table-condensed'>
                        <thead>
                            <tr>
                                <th>
                                    Deskripsi
                                </th>
                                <th>
                                    Gaji (Rp)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modDetail as $i => $detail) {
                            ?>
                                <tr>
                                    <th><?php echo $detail->komponen->komponengaji_nama; ?></th>
                                    <th style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($detail->jumlah); ?></th>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align: right">Total Gaji</th>
                                <th style="text-align: right">
                                    <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalterima)); ?>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: right">Total Pajak</th>
                                <th style="text-align: right">
                                    <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalpajak)); ?>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: right">Penerimaan Bersih</th>
                                <th style="text-align: right">
                                    <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->penerimaanbersih)); ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, '<b>Mengetahui :</b>', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::encode(($model->mengetahui) ? $model->mengetahui : "-"); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, '<b>Menyetujui :</b>', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::encode(($model->menyetujui) ? $model->menyetujui : "-"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        ?>
    </div>
</fieldset>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintPenggajian&id=' . $modelpegawai->pegawai_id . '&gaji_id=' . $model->penggajianpeg_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

?>

<?php $this->endWidget(); ?>