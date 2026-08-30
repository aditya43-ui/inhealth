<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'apotek-tujuan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
); 
$this->widget('bootstrap.widgets.BootAlert');
$dataRuangan = RuanganM::model()->findAll('ruangan_aktif is true and instalasi_id not in (' . Params::INSTALASI_ID_FARMASI . ',' . Params::INSTALASI_ID_RJ .')');

$dataRuanganAlih = RuanganM::model()->findAll('ruangan_aktif is true and instalasi_id in (' . Params::INSTALASI_ID_FARMASI . ')');
?>
<div class="row panel-body">

    <div class="col-sm-12">
        <div class="control-group">
            <label class="control-label">Ruangan Apotek Tujuan</label>
            <div class="controls">
                <?= $form->hiddenField($modRuangan, 'ruangan_id') ?>
                <?= $form->textField($modRuangan, 'ruangan_nama', ['readonly' => true, 'class' => 'span5']) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Alih Irna</label>
            <div class="controls">
                <?= $form->checkBox($model, 'is_alih', ['onchange' => 'cekAlihIrna(this)', 'id' => 'is_alih']) ?>
            </div>
        </div>
        <div class="control-group box-alih" hidden>
            <label class="control-label">Alih Ruangan Ke</label>
            <div class="controls">
                <?= $form->dropDownList($model, 'alihke_ruanganapotektujuan_id', CHtml::listData($dataRuanganAlih, 'ruangan_id', 'ruangan_nama'), ['empty' => '-- Pilih --']) ?>
            </div>
        </div>
        <div class="control-group box-alih" hidden>
            <label class="control-label">Pada Jam</label>
            <div class="controls">
                <?php 
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'alihkan_jam',
                        'mode'=>'time',
                        'options'=> array(
                            'dateFormat'=>Params::TIME_FORMAT,
                            // 'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
                    )); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Ruangan Pelayanan</label>
            <div class="controls">
                <?php
                
                    $this->widget(
                        'application.extensions.emultiselect.EMultiSelect',
                        array('sortable' => true, 'searchable' => true)
                    );
                    echo CHtml::dropDownList(
                        'ruangan_pelayanan_id[]',
                        $dataRuanganDipilih,
                        CHtml::listData($dataRuangan, 'ruangan_id', 'ruangan_nama'),
                        array('multiple' => 'multiple', 'key' => 'ruangan_pelayanan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                    );
                ?>
            </div>
        </div>
        <div class="form-action">
            <?php 
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
                );
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    function cekAlihIrna(obj) {
        if($(obj).is(':checked')){
            $('.box-alih').show();
        } else {
            $('.box-alih').hide();
        }
    }

    $(function () { 
        cekAlihIrna($('#is_alih'));
    });
</script>