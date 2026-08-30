
<div class="search-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'pemakaianambulans-t-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($modPemakaian,'nopolisi'),
)); ?>
    <table>
        <tr>
            <td>
                <?php //echo $form->textFieldRow($modPemesanan,'tglpemesananambulans',array('class'=>'span3')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pemakaian','tglPemakaian', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                            $modPemakaian->tgl_awal = $format->formatDateTimeForUser($modPemakaian->tgl_awal);
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$modPemakaian,
                                'attribute'=>'tgl_awal',
                                'mode'=>'date',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    //'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                            )); 
                            $modPemakaian->tgl_awal = $format->formatDateTimeForDb($modPemakaian->tgl_awal);
                         ?> 
                    </div></div>
                    <div class="control-group">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                    </label>
                    <div class="controls">
                            <?php   
                                $modPemakaian->tgl_akhir = $format->formatDateTimeForUser($modPemakaian->tgl_akhir);
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$modPemakaian,
                                    'attribute'=>'tgl_akhir',
                                    'mode'=>'date',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        //'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                                )); 
                                $modPemakaian->tgl_akhir = $format->formatDateTimeForDb($modPemakaian->tgl_akhir);
                            ?>
                    </div>
                </div>
                <?php //echo CHtml::activeTextField($modPemakaian->mobil, 'nopolisi', array('readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPemakaian,'nopolisi',array('placeholder'=>'No. Polisi','class'=>'span3','maxlength'=>20)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($modPemakaian,'norekammedis',array('placeholder'=>'No. Rekam Medik','class'=>'span3','maxlength'=>10)); ?>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPemakaian,'namapasien', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemakaian,'namapasien',array('placeholder'=>'Nama Pasien','class'=>'span3','maxlength'=>100)); ?>
                    </div></div>                        
                <?php echo $form->textFieldRow($modPemakaian,'ruangan_nama',array('placeholder'=>'Ruangan Nama','class'=>'span3')); ?>
            </td>
        </tr>
    </table>
    

    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class' => 'btn btn-default',
                                  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
<?php  
$content = $this->renderPartial('../tips/informasi_pemakaian',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>

<?php $this->endWidget(); ?>
</div>