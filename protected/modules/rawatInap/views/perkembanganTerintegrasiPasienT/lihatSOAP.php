<style>
    .disable-panel{
        margin:0;padding:0!important;cursor:not-allowed;position: absolute;z-index:99999;height:90%;width:97%;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Perkembangan Terintegrasi Pasien',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data anamnesa berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'integrasi-pasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#nama_pegawai',
        ));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Perkembangan Terintegrasi Pasien</strong></div>
    </div>
    <div class="panel-body">
        <?php
        echo $this->renderPartial($this->path_view_asesmenkep . '_dataPasien', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
                ), true);
        ?>
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Waktu Pemeriksaan <span class="required">*</span></label>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgltransaksi',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3 required',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label">Profesi <span class="required">*</span></label>
                <div class="controls">  
<?php
echo $form->dropDownList($model, 'profesi', LookupM::getItemsUrutan('profesi'), array('empty' => '--Pilih--', 'class' => 'span3 required'));
?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <label class="control-label">Pegawai <span class="required">*</span></label>
                <div class="controls">  
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'nama_pegawai',
                        'value' => !empty($model->pegawai_id) ? PegawaiM::model()->findByPk($model->pegawai_id)->nama_pegawai : "",
                        'sourceUrl' => Yii::app()->createUrl('rawatInap/PerkembanganTerintegrasiPasienT/GetPegawai'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            $("#RIPerkembanganTerintegrasiPasienT_pegawai_id").val(ui.item.pegawai_id);
                            return false;
                        }',
                            'select' => 'js:function( event, ui ) {
                            $("#RIPerkembanganTerintegrasiPasienT_pegawai_id").val(ui.item.pegawai_id);
                            return false;
                        }',
                        ),
                        'tombolDialog' => array("idDialog" => 'dialogPegawai'),
                        'htmlOptions' => array('class' => 'span3 required', 'placeholder' => 'Ketik nama pegawai'),
                    ));
                    echo CHtml::activeHiddenField($model, 'pegawai_id', array('readonly' => true));
                    ?>
                </div>
            </div>
        </div>
        <br>
        <div id="disableDiv" >                 
        </div>
<?php
echo $this->renderPartial($this->path_view . '_formInput', array('model' => $model));
?>        
        <br>
        <div class="form-actions">
<?php
echo CHtml::link(Yii::t('mds', '{icon} Informasi Integrasi', array('{icon}' => '<i class="entypo-add"></i>')), $this->createUrl('index', array('id' => $modPendaftaran->pendaftaran_id)), array('class' => 'btn btn-success')) . "&nbsp";
?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    $(document).ready(function () {
        $("input, select, textarea").attr("disabled", true);
        $('.add-on').hide();
        $("#disableDiv").addClass("disable-panel");
    });
</script>