<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'jurnalpiutangpasien-search',
    'type'=>'horizontal',
    'htmlOptions'=>array(
        'onKeyPress'=>'return disableKeyPress(event)'
    ),
    'focus'=>'#',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model,'tgl_pendaftaran',array('class'=>'control-label'));?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tglAwal',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true,'style'=>'width:130px;'
                        ),
                    ));
                ?>

            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="AKRincianpiutangrekeningpasienV_tglAkhir">Sampai Dengan</label>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                        'model'=>$model,
                        'attribute'=>'tglAkhir',
                        'mode'=>'date',
                        'options'=> array(
                            'dateFormat'=>Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions'=>array(
                            'class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'readonly'=>true,'style'=>'width:130px;'
                        ),
                    ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder' => 'No. Rekam Medik', 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model,'no_pendaftaran',array('placeholder' => 'No. Pendaftaran', 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="col-sm-6">
        <?php
            echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array('order'=>'instalasi_nama'),'instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
            'ajax' => array('type' => 'POST',
            'url' => $this->createUrl('GetRuanganDariInstalasi', array('encode' => false, 'namaModel' => 'AKRincianpiutangrekeningpasienV')),
            'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''),));
        ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearDetail()')); ?>
        <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData(CarabayarM::model()->findAll(array('order'=>'carabayar_nama'),'carabayar_aktif = true'), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
            'ajax' => array('type'=>'POST',
                'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'AKRincianpiutangrekeningpasienV')), 
                'update'=>'#' . CHtml::activeId($model, 'penjamin_id') . ''  //selector to update
            ),
            'class' => 'span4',
        )); ?>
        <?php echo $form->dropDownListRow($model,'penjamin_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class' => 'span4')); ?>           
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'addDetail()')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('id'=>'btn_resset','class' => 'btn btn-default', 'type'=>'reset','onclick'=>'konfirmasi();')); ?>    
</div>
<?php $this->endWidget();  
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai	
    Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/Index', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD);
?>