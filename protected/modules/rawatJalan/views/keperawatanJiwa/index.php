<style>
    .form_predispo > tbody > tr > td {
        vertical-align: top;
        padding: 2px;
    }
    
    #tab_aniaya {
        width: 100%;
    }
    
    #tab_aniaya td {
        border: 1px solid black;
        padding: 2px;
    }
    
    #tab_aniaya .rad_center {
        text-align: center;
    }
</style>

<?php
$this->breadcrumbs=array(
	'Keperawatan Jiwa',
);

$this->widget('bootstrap.widgets.BootAlert');

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Keperawatan Jiwa
        </div>
    </div>
    <div class="panel-body">
        
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'keperawatanjiwa-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        
        <div class="col-sm-6">
            <div class="control-group">
                <?php 
                echo $form->label($model, 'perawat_id', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'perawat_id', CHtml::listData(RJAnamnesaT::model()->ParamedisItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'informan'); ?>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php 
                echo $form->labelEx($model, 'tgl_pengkajian', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_pengkajian',
                        'value'=>null,
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class'=>'span3 htpd',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($model, 'alasan_masuk', array('rows'=>8)); ?>
        </div>
        <div class="clear"></div>
        <?php echo $this->renderPartial($this->path_view."_predisposisi", array(
            'form'=>$form,
            'model'=>$model,
        ), true); ?>
        <?php echo $this->renderPartial($this->path_view."_fisik", array(
            'form'=>$form,
            'model'=>$model,
        ), true); ?>
        <?php echo $this->renderPartial($this->path_view."_psikososial", array(
            'form'=>$form,
            'model'=>$model,
        ), true); ?>
        <?php echo $this->renderPartial($this->path_view."_mental", array(
            'form'=>$form,
            'model'=>$model,
        ), true); ?>
        <?php echo $this->renderPartial($this->path_view."_persiapanPulang", array(
            'form'=>$form,
            'model'=>$model,
        ), true); ?>
        <?php echo $this->renderPartial($this->path_view."_koping", array(
            'form'=>$form,
            'model'=>$model,
        ), true); ?>
        
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan')); ?>
                <?php 
                echo CHtml::link(Yii::t('mds', '{icon} Print', 
                    array('{icon}'=>'<i class="entypo-print"></i>')), 
                        'javascript:void(0);', array('class'=>'btn btn-info',
                        'onclick'=>"print(".$modPendaftaran->pendaftaran_id.");return false"));
                ?>
                <?php
               $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>

                <?php //echo CHtml::link('Test Update Stok', '#', array('onclick'=>'testUpdateStok(80,4);return false;','class'=>'btn')); ?>
        </div>
        
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>

function print(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&id='+pendaftaran_id,'printwin','left=100,top=100,width=640,height=640');
}

</script>
