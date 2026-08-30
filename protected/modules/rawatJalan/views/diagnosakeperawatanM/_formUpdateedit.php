
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadiagnosakeperawatan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
            <?php //echo CHtml::textField('BKPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
                
            <?php echo $form->hiddenField($model,'diagnosa_id',array('value'=>$row->diagnosa_id,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'diagnosa_nama');?>
            <?php //echo $form->textFieldRow($model,'diagnosakeperawatan_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
            <?php //echo $form->textAreaRow($model,'diagnosa_medis',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textAreaRow($model,'diagnosa_keperawatan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textAreaRow($model,'diagnosa_tujuan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->checkBoxRow($model,'diagnosa_keperawatan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<?php
//            echo count((array)$datakriteriahasil);
//            foreach($datakriteriahasil as $j=>$kriteriahasil){
//                
//            }
        ?>
        <table id="tbl-DiagnosaKeperawatan" class="table table-striped table-bordered table-condensed">
           <thead>
            <tr>
                <th></th>
                <th>Kode</th>
                <th>Diagnosa Medis</th>
                <th>Diagnosa Keperawatan</th>
                <th>Diagnosa Tujuan</th>
                <th>Kriteria Hasil</th>
                <th>Tambah</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($modIdDiagnosa as $i=>$DiagnosaId) { ?>
            <tr>
                <td>
                    <?php echo $form->hiddenField($DiagnosaId, "[$i]diagnosakeperawatan_id", array('value'=>$row->diagnosakeperawatan_id));?>
                </td>
                <td>
                    <?php echo $form->textField($DiagnosaId,"[$i]diagnosakeperawatan_kode",array('value'=>$row->diagnosakeperawatan_kode, 'class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?> 
                </td>   
                <td>
                    <?php echo $form->textArea($DiagnosaId,"[$i]diagnosa_medis",array('value'=>$row->diagnosakeperawatan_medis,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo $form->textArea($DiagnosaId,"[$i]diagnosa_keperawatan",array('value'=>$row->diagnosakeperawatan_keperawatan,'class'=>'span3', 'onkeypress'=>"return return $(this).focusNextInputField(event);")); ?>
                </td>
               <td>
                    <?php echo $form->textArea($DiagnosaId,"[$i]diagnosa_tujuan",array('value'=>$row->diagnosakeperawatan_tujuan,'class'=>'span3', 'onkeypress'=>"return return $(this).focusNextInputField(event);")); ?>
                </td>
                
                
                    <?php //echo $form->checkBoxRow($model,'[1]lookup_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','LookupM_lookup_urutan')")); ?>
                <td>
                    <table class="kriteria">
                            <tbody>
                            <tr>
                                <td>
                                    <?php 
//                                    $datakriteriahasil2 = KriteriahasilM::model()->findByAttributes(array('diagnosakeperawatan_id'=>$model->diagnosakeperawatan_id));
//                                    foreach($datakriteriahasil2 as $j=>$datakriteria){
////                                        ini nama fieldnya
////                                        echo $j; 
////                                        isi dari fieldnya
////                                        echo $datakriteria;
//                                        echo $datakriteriahasil2['kriteriahasil_nama']=>$datakriteria;
////                                        
////                                           echo $datakriteria['kriteriahasil_nama'];
////                                        echo CHtml::activeTextField($datakriteria,'[$i][$j]kriteriahasil_nama',array('class'=>'span2', 'onkeypress'=>"return return $(this).focusNextInputField(event);")); 
//                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'addRow2(this)','id'=>'row1-plus')); ?>
                                    </td>
                            </tr>
                            </tbody>
                        </table>
                    <?php //echo CHtml::activeTextField($modKriteriaHasil,'[1]kriteriahasil_nama',array('class'=>'span2', 'onkeypress'=>"return return $(this).focusNextInputField(event);")); ?>
                    <?php //echo $form->textField($model,'[1]kriteriahasil_id',CHtml::listData(KriteriahasilM::model()->findAllByAttributes($attributes), 'kriteriahasil_id', 'kriteriahasil_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)array('empty'=>'-- Pilih --')")); ?>
                </td>
                
                         
              
                            <td>
                    <?php echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'addRow(this)','id'=>'row1-plus')); ?>
                </td>
            </tr>
            <?php }?>
        </tbody>
        </table>
        
        
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/diagnosakeperawatanM/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
		<?php
$content = $this->renderPartial('../tips/tips',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT
function addRow(obj)
{
    var tr = $('#tbl-RencanaKeperawatan tbody tr:first').html();
    $('#tbl-DiagnosaKeperawatan tr:last').after('<tr>'+tr+'</tr>');
    $('#tbl-DiagnosaKeperawatan tr:last td:last').append('$buttonMinus');
        
        renameInput('RJDiagnosakeperawatanM','diagnosa_id');
        renameInput('RJDiagnosakeperawatanM','diagnosakeperawatan_id');
        renameInput('RJDiagnosakeperawatanM','diagnosakeperawatan_kode');
        renameInput('RJDiagnosakeperawatanM','diagnosa_medis');
        renameInput('RJDiagnosakeperawatanM','diagnosa_keperawatan');
        renameInput('RJDiagnosakeperawatanM','diagnosa_tujuan');
    $('#tbl-DiagnosaKeperawatan tr:last').find('input').val('');
    $('#tbl-DiagnosaKeperawatan tr:last').find('textarea').val('');
    $('#tbl-DiagnosaKeperawatan tr:last').find('select').val('');

}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tbl-DiagnosaKeperawatan tbody tr').length;
    var i = 1;
    $('#tbl-DiagnosaKeperawatan tbody tr').each(function(){
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    i++;    
    });
}

function delRow(obj)
{
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();
			renameInput('RJDiagnosakeperawatanM','diagnosa_id');
			renameInput('RJDiagnosakeperawatanM','diagnosakeperawatan_id');
			renameInput('RJDiagnosakeperawatanM','diagnosakeperawatan_kode');
			renameInput('RJDiagnosakeperawatanM','diagnosa_medis');
			renameInput('RJDiagnosakeperawatanM','diagnosa_keperawatan');
			renameInput('RJDiagnosakeperawatanM','diagnosa_tujuan');
		}
	});
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>