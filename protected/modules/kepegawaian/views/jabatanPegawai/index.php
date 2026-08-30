<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data Jabatan Pegawai berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'data-riwayat',
    'content' => array(
        'content-datariwayat' => array(
            'header' => '<b>Riwayat Jabatan Pegawai</b>',
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
<fieldset class="box" id="tableJabatan">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Jabatan <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body">
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="row">
                <div class="col-sm-6">
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' => $model->pegawai_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                    <?php echo $form->textFieldRow($modPegawaijabatan, 'nomorkeputusanjabatan', array('class' => 'span3', 'onkeypress' => '$(this).focusNextInputField(event)')) ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPegawaijabatan, 'tglditetapkanjabatan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPegawaijabatan,
                                'attribute' => 'tglditetapkanjabatan',
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
                        <?php echo $form->labelEx($modPegawaijabatan, 'tmtjabatan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPegawaijabatan,
                                'attribute' => 'tmtjabatan',
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
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($modPegawaijabatan, 'tglakhirjabatan', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modPegawaijabatan,
                                'attribute' => 'tglakhirjabatan',
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
                    <?php echo $form->textAreaRow($modPegawaijabatan, 'keterangan', array('rows' => 1, 'class' => 'span3', 'onkeypress' => '$(this).focusNextInputField(event)')) ?>
                    <?php echo $form->dropDownListRow($modPegawaijabatan, 'pejabatygmemjabatan', CHtml::listData($modPegawaijabatan->getPegawaiItems(), 'nama_pegawai', 'nama_pegawai'), array('class' => 'span3', 'onkeypress' => '$(this).focusNextInputField(event)', 'empty' => '-- Pilih --')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton', 'onKeypress' => 'return formSubmit(this,event)', 'name' => 'submitPegawaijabatan')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-cancel"></i>')),
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
$urlGetPegawaijabatan = $this->createUrl('GetPegawaijabatan');
$pegawai_id = $_GET['pegawai_id'];
$js = <<< JS

function Pegawaijabatandata()
{
    pegawai_id = {$pegawai_id};
    if(pegawai_id==''){
        myAlert('Anda belum memilih pegawai');
        return false;
    }else{
        $.post("${urlGetPegawaijabatan}", {pegawai_id:pegawai_id,},
        function(data){
            $("#tableRiwayatJabatan").children("tbody").append(data.tr);
        }, "json");
    }   
}

function ViewRiwayatJabatan() {
    
    if ($("#cekRiwayatjabatan").is(":checked")) {
        Pegawaijabatandata();
        $("#tableRiwayatJabatan").slideDown(60);
    } else {
        $("#tableRiwayatJabatan").children("tbody").children("tr").remove();
        $("#tableRiwayatJabatan").slideUp(60);
    }
}
$(document).ready(function(){
    Pegawaijabatandata();
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