<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
<p>&nbsp;</p>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rencanaanestesi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
$myicon = new MyIcon();
?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Data Rencana Anestesi / Sedasi </b> </div>
    </div>
    <div class="panel panel-body">
        <?php $this->renderPartial($this->path_view . '_form', array('model' => $model, 'form' => $form)); ?>
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <?php
                    echo CHtml::label("Tanggal / Jam <i style='color: red'> * </i>", "tglrencanaanestesi", array(
                        'class' => 'control-label required'
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglrencanaanestesi',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Diperiksa Oleh <i style='color: red'> * </i>", 'koordinatormutu_id', array('class' => 'control-label required')) ?>
                    <div class = "controls">
                        <?php
                        $criteria = new CDbCriteria();
                        $criteria->addCondition("ruangan_id=" . Params::RUANGAN_ID_ANASTESI);
                        echo $form->dropDownList($model, 'pegawaipenyusun_id', CHtml::listData(PegawairuanganV::model()->findAll($criteria), 'pegawai_id', 'nama_pegawai'), array('class' => 'required', 'empty' => '-- Pilih --'))
                        ?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <?php echo CHtml::label("Catatan", 'catatan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($model, 'catatan', array('placeholder' => 'Catatan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>            
                    </div>
                </div>
            </div>
        </div>
         <div class="row-fluid">
            <div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.$myicon::getIcons('simpan').'"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="'.$myicon::getIcons('ulang').'"></i>')), 
				$this->createUrl('index&pasienanastesi_id='.$_GET['pasienanastesi_id']), 
				array('class'=>'btn btn-default',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php
                    $tips = array(
                        '0' => 'tanggal',
                        '1' => 'cari',
                        '2' => 'ulang'
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.transaksi',array('tips'=>$tips),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
            </div>
	</div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . 'jsFunctions', array('model' => $model)); ?>
<?php $this->endWidget(); ?>
