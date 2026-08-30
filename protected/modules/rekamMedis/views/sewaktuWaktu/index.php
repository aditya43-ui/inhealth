<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>EMR Sewaktu-Waktu</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pemakaian Bahan berhasil disimpan !");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'kunjungan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data Kunjungan
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body">
                <fieldset class="" id="form-datakunjungan">
                    <div class="row-fluid">
                        <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                    </div>
                </fieldset>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <div>
            <iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll; min-height:1000px;"></iframe>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>
<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'detailPengkajian',
    'options' => array(
        'title' => 'Detail Pengkajian Keperawatan Kesehatan Jiwa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="framePengkajian" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
//=======================================================================
?>