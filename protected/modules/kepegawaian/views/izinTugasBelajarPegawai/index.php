<style>
    .panel-success .panel-heading,
    .accordion-group .accordion-toggle {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }

    div.box {
        margin-bottom: 10px;
    }
</style>

<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Izin Tugas Belajar berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'data-riwayat',
    'content' => array(
        'content-datariwayat' => array(
            'header' => '<b>Riwayat Izin Tugas Belajar</b>',
            'isi' => $this->renderPartial('_riwayat', array(), true),
            'active' => false,
        ),
    ),
));
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<?php echo $form->errorSummary($model); ?>
<fieldset class="box" id="tableIjintugasbelajar">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="fas fa-book"></i> Izin Tugas Belajar <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body table-responsive">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $modIzintugasbelajar->pegawai_id)), array('readonly' => TRUE)); ?>
                        <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                        <?php echo $form->labelEx($modIzintugasbelajar, 'tglmulaibelajar', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modIzintugasbelajar,
                                'attribute' => 'tglmulaibelajar',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modIzintugasbelajar, 'tglselesaibelajar', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modIzintugasbelajar,
                                'attribute' => 'tglselesaibelajar',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modIzintugasbelajar, 'nomorkeputusan', array('placeholder' => 'Nomor Keputusan', 'class' => 'span3', 'onkeypress' => '$(this).focusNextInputField(event)')); ?>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modIzintugasbelajar, 'tglditetapkan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modIzintugasbelajar,
                                'attribute' => 'tglditetapkan',
                                'mode' => 'date',
                                'options' => array(
                                    'showOn' => false,
                                    // 'maxDate' => 'd',
                                    'yearRange' => "-150:+0",
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                    <?php echo $form->textAreaRow($modIzintugasbelajar, 'keteranganizin', array('placeholder' => 'Keterangan', 'rows' => 1, 'class' => 'span3', 'onkeypress' => '$(this).focusNextInputField(event)')); ?>
                    <?php echo $form->dropDownListRow($modIzintugasbelajar, 'pejabatmemutuskan', CHtml::listData($modIzintugasbelajar->getPegawaiItems(), 'nama_pegawai', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => '$(this).focusNextInputField(event)')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitIzintugasbelajar')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            '#',
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
</fieldset>

<?php
$this->endWidget();
$urlGetIjintugasbelajar = $this->createUrl('GetIzintugasbelajar');
$pegawai_id = $_GET['pegawai_id'];
$js = <<< JS

function Ijintugasbelajardata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetIjintugasbelajar}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatIjintugasbelajar").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewIjintugasbelajar() {
    
    if ($("#cekRiwayatIjintugasbelajar").is(":checked")) {
        Ijintugasbelajardata();
        $("#tableRiwayatIjintugasbelajar").slideDown(60);
    } else {
        $("#tableRiwayatIjintugasbelajar").children("tbody").children("tr").remove();
        $("#tableRiwayatIjintugasbelajar").slideUp(60);
    }
}

$(document).ready(function(){
    Ijintugasbelajardata();
});
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function hapus(obj) {
        myConfirm('Anda yakin akan menghapus item ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    url = $(obj).attr('href');
                    $(location).attr('href', url);
                }
            });

    }
</script>