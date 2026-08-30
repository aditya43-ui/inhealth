<fieldset>
    <legend class="rim">Detail Informasi Pegawai</legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'frmpresensi-t',
        'type'=>'horizontal',
    )
);
Yii::app()->clientScript->registerScript('search', "
    $('#frmpresensi-t').submit(function(){
            $.fn.yiiGridView.update('lapegawai-d-grid', {
                data: $(this).serialize()
            });
            return false;
    });
");

?>
    
<table>
    <?php /*
    <tr>
         <td>                        
           
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?> 
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi_akhir',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?>
                </div>
            </div>            
            
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), "#", array('class' => 'btn btn-default','onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")){return false;}else{window.location.reload();}')); ?>
            </div>
        </td>
    </tr> */ ?>
    <tr>
        <?php echo $form->hiddenField($model,'tglpresensi',array('readonly'=>true,'class'=>'span3')); ?>
        <?php echo $form->hiddenField($model,'tglpresensi_akhir',array('readonly'=>true,'class'=>'span3')); ?>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($modPegawai,'nofingerprint',array('readonly'=>true,'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($modPegawai,'kelompokpegawai_id',array('readonly'=>true,'value'=>$modPegawai->kelompokpegawai->kelompokpegawai_nama, 'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($modPegawai,'jabatan_id',array('readonly'=>true,'value'=>($modPegawai->jabatan_id === null)?'':$modPegawai->jabatan->jabatan_nama, 'class'=>'span3')); ?>
            <?php echo $form->textFieldRow($modPegawai,'nomorindukpegawai',array('readonly'=>true, 'class'=>'span3')); ?>            
            <?php echo $form->textFieldRow($modPegawai,'nama_pegawai',array('readonly'=>true, 'class'=>'span3')); ?>            
            <?php //echo $form->textFieldRow($modPegawai,'shift_id',array('readonly'=>true, 'class'=>'span3', 'value'=>isset($modPegawai->shift_id)?$modPegawai->shift->shift_nama:'-')); ?>            
            <?php //echo $form->textAreaRow($modPegawai,'alamat_pegawai',array('readonly'=>true,'class'=>'span3')); ?>
            <?php //echo $form->textFieldRow($modPegawai,'unit_perusahaan',array('readonly'=>true,'class'=>'span3')); ?>
        </td>
       <td>
           <?php echo $form->textFieldRow($modPegawai,'hadir',array('readonly'=>true,'class'=>'span3')); ?>
           <?php echo $form->textFieldRow($modPegawai,'izin',array('readonly'=>true,'class'=>'span3')); ?>
           <?php echo $form->textFieldRow($modPegawai,'sakit',array('readonly'=>true,'class'=>'span3')); ?>
           <?php echo $form->textFieldRow($modPegawai,'dinas',array('readonly'=>true,'class'=>'span3')); ?>
           <?php echo $form->textFieldRow($modPegawai,'alpha',array('readonly'=>true,'class'=>'span3')); ?>
           <?php //echo $form->textFieldRow($modPegawai,'rerata_jam_masuk',array('readonly'=>true,'class'=>'span3')); ?>
           <?php //echo $form->textFieldRow($modPegawai,'rerata_jam_keluar',array('readonly'=>true,'class'=>'span3')); ?>
           
       </td>
    </tr>
</table>

<?php $this->endWidget(); ?>
</fieldset>
<br>
<?php
      $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'lapegawai-d-grid',
            'dataProvider'=>$model->detailPresensi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header' => 'No.',
                    'value' => '$row+1',
                    'htmlOptions'=>array('style'=>'text-align: center; width:20px'),
                ),
//                array(
//                    'header'=>'<p style="margin: 0; text-align: center;">Masuk</p>',
//                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->tglpresensi),true)',
//                ),
                array(
                   'header'=>'Tanggal Presensi',
                   'type'=>'raw',
                   'value'=>'MyFormatter::formatDateTimeForUser($data->datepresensi)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Masuk</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Keluar</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>3, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Datang</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>4, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Pulang</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),                                
                 array(
                    'header'=>'<p style="margin: 0; text-align: center;">Terlambat</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_terlambat",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                     //'value'=>'""',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ), 
                 array(
                    'header'=>'<p style="margin: 0; text-align: center;">Pulang Awal</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_pulangAwal",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    // 'value'=>'""',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ), 
                 array(
                    'header' => 'Status',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    'type' => 'raw'
                ), 
            ),
            'afterAjaxUpdate'=>'
                function(id, data){
                    jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            }',
        )
  );
      
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl(
        $module.'/'.$controller.'/printDetailLaporanPresensi',
        array(
            'id'=>$modPegawai->pegawai_id
        )
    );
    
$js = <<< JSCRIPT
function print(caraPrint)
{
    var urlDate = "&tglpresensi=" + $("#frmpresensi-t").find('input[name$="[tglpresensi]"]').val() + "&" + "tglpresensi_akhir=" + $("#frmpresensi-t").find('input[name$="[tglpresensi_akhir]"]').val();
    window.open("${urlPrint}&caraPrint="+caraPrint+urlDate,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>
