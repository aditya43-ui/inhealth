<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model, 'obatalkes_kode'),
)); ?>

<legend class="rim">Pencarian</legend>
    <div class="control-group ">
        <table>
            <tr>
                <td>
                    <?php echo $form->dropDownListRow($model,'ruangan_id',CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                    <?php echo $form->dropDownListRow($model,'jenisobatalkes_id',CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_nama'),array('class'=>'span2','empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model,'obatalkes_golongan',LookupM::getItems('obatalkes_golongan'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                    <?php echo $form->dropDownListRow($model,'sumberdana_id',CHtml::listData($model->getSumberdanaItems(),'sumberdana_id','sumberdana_nama'),array('class'=>'span2','empty'=>'-- Pilih --')); ?>
                </td>
                <td>
                    <div class="control-label">
                        <?php echo CHtml::label('Tanggal Transaksi','tgl_awal',array('style'=>'font-size:11.6px;')); ?> <!-- 'class'=>'control-label' !-->
                    </div>
                    <div class="controls">
                        <?php   
                            $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                            $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                        ?>
                    </div>
                    <?php echo CHtml::label('Sampai dengan','tgl_akhir',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php
                            $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                        ?>
                    </div>
                    <?php echo $form->textFieldRow($model,'obatalkes_kode',array('placeholder'=>'Ketik Kode Obat Alkes','class'=>'span3')); ?>
                    <?php echo $form->textFieldRow($model,'obatalkes_nama',array('placeholder'=>'Ketik Nama Obat Alkes','class'=>'span3')); ?>
                    
                    <?php /*DIHIDE SEMENTARA KARENA INFORMASI STOK DI APLIKASI BERBEDA
                    <label class="control-label">Group Berdasarkan Obat</label>
                    <div class="controls"><?php echo CHtml::activeCheckBox($model, 'isGroupObat'); ?></div> */ ?>
                </td>
            </tr>
        </table>    
    </div>

    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit'));
            echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    Yii::app()->createUrl($this->route), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); 
           //SEMENTARA DI HIDE >> echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $content = $this->renderPartial($this->path_view.'tips/tipsInformasi',array(),true);
             $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
           ?>
    </div>

<?php $this->endWidget(); ?>
<?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printInformasi');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>