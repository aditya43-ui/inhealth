<legend class="rim"><i class="entypo-search"></i> Berdasarkan Tanggal Kunjungan/Pendaftaran</legend>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        table{
            margin-bottom: 0;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
        .nav-tabs > .active a:hover{cursor:pointer;}
    </style>
    <?php echo CHtml::hiddenField('type', ''); ?>
    <?php //echo CHtml::hiddenField('src', ''); ?>
    <table width="100%" border="0">
        <tr>
            <td><div class='control-label'>Tanggal Pulang</div>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
//                                          'maxDate'=>'d',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> </td>
            <td style="padding:0px 100px 0 0;">
                <?php echo CHtml::label(' Sampai dengan', ' s/d', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
//                                         'maxdate'=>'d',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div> 
                
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="padding:0px 100px 0 0;">
                <label class="control-label">
                    <?php echo CHtml::activecheckBox($model, 'is_nursestation', array('onclick'=>'cekNurse()','uncheckValue'=>0,'rel'=>'tooltip' ,'data-original-title'=>'Cek untuk pencarian berdasarkan nurse station')); ?>
                    Nurse Station
              </label>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll($model->RuanganNurse), 'ruangan_id', 'ruangan_nama') ,array('disabled'=>($model->is_nursestation==1)? false : true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-default',
            'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'));
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
</div>  

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<script type="text/javascript">
    function cekNurse(){
        if($('#<?php echo CHtml::activeId($model, 'is_nursestation') ?>').is(':checked')){
            $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').attr('disabled',false);
	}else{
            $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').attr('disabled',true);
            $('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>').val('');
	}
    }
</script>
