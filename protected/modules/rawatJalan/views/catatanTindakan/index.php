<?php 
if(!empty($pendaftaran)) {
    if($pendaftaran->validasiRekamMedis()) {
       echo CustomFunction::alertRekamMedis();
    }
}
?>
<?php 
// pengkondisian user login 
$visibility = '';
// jika bukan dokter dan bukan sysadmin yang login maka di hidden beberapa element
if(Yii::app()->user->getState('kelompokpegawai_id') !== Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP && Yii::app()->user->getState('loginpemakai_id') !== Params::LOGINPEMAKAI_ID_ADMIN || isset($_GET['lihat'])) {
    $visibility = 'hidden';
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_END);
?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Catatan Tindakan Dokter
        </div>
    </div>
    <div class="panel-body">
        <?php
        
        $modRiwayat = new CatatantindakanT;
        $modRiwayat->unsetAttributes();
        $modRiwayat->pendaftaran_id = $pendaftaran->pendaftaran_id;

        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'tabel-riwayat-catatan-dokter',
            'content' => array(
                'content-detailanamnesa' => array(
                    'header' => '<b>Tabel Catatan Tindakan Dokter</b>',
                    'isi' => $this->renderPartial($this->path_view . '_riwayat', array(
                        'modRiwayat' => $modRiwayat,
                        'format' => new MyFormatter(),
                    ), true),
                    'active' => true,
                ),
            ),
        ));





        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'catatan-tindakan-dokter-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('class'=>'form-iframe','onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'requiredCheck(this);'),
            // 'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
        ));
        
        
        ?>

        <?= $form->hiddenField($model, 'pegawai_id') ?>
        <?php echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData(DokterV::model()->findAll('pegawai_aktif = true order by nama_pegawai'), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
        <?php // echo $form->dropDownListRow($modAnamnesa, 'paramedis_nama', CHtml::listData(ParamedisV::model()->findAll("ruangan_id = ".Yii::app()->user->getState('ruangan_id')), 'nama_pegawai', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); 
        ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_catatantindakan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_catatantindakan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'span3', //hapus class 'realtime' RSCMS-4640
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="control-group redactor-left">
            <?php echo $form->labelEx($model, 'catatantindakan_detail', array('class' => 'control-label')) ?>
            <div class="controls" style="min-width: 500px; max-width:700px;">
                <?php 
                    if($visibility == 'hidden') {
                        echo $form->textArea($model, 'catatantindakan_detail', ['id' => 'catatantindakan_detail_text']);
                    } else {
                        $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'catatantindakan_detail', 'toolbar' => 'mini', 'height' => '200px'));
                    }
                ?>
                <?php echo $form->error($model, 'catatantindakan_detail'); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
                if($visibility == '') {
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'enabled' => true)
                    );
                }
                $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
                $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>


        <?php $this->endWidget(); ?>
    </div>
</div>

<?php 

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailCatatan',
    'options' => array(
        'title' => 'Detail Catatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameDetailCatatan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();

?>

<script>
    $(function(){
        CKEDITOR.replace('catatantindakan_detail_text', {
            extraPlugins: 'colorbutton,colordialog',
            toolbarGroups: [
                {
                    "name": "basicstyles",
                    "groups": ["basicstyles", "align", "spacings", "colors"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                }
            ],
            readOnly: true
        });
    })
</script>