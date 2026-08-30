<?php
$this->breadcrumbs=array(
	'Reseptur',
);

$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>0,
    )
));

$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.number',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>1,
    )
));

$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.number0',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>0,
	 'allowDecimal'=>true
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rjreseptur-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#namaObatNonRacik',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return cekInput();'),
)); ?>
<div class="white-container">
    <legend class="rim2"><b>Reseptur</b></legend>
    <fieldset class="box">
        <legend class="rim">Data Pasien</legend>
	<?php $this->renderPartial('_formInfoPasien',array('modInfoRI'=>$modInfoRI)); ?>
    </fieldset>
    <div class="formInputTab">
        <?php $this->renderPartial('_formInputObat',array('form'=>$form,'modReseptur'=>$modReseptur)); ?>
        <div class="block-tabel">
            <h6>Tabel <b>Obat dan Alkes</b></h6>
            <table id="tblDaftarResep" class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Recipe</th>
                        <th>R ke</th>
                        <th>Nama Obat</th>
                        <th>Sumber Dana</th>
                        <th>Satuan Kecil</th>
                        <th>Jumlah</th>
                        <th>Estimasi Harga</th>
                        <th>Sub Total</th>
                        <th>Signa</th>
                        <th>Etiket</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" style="text-align: right;"><b>Total Estimasi Harga</b></td>
                        <td><input type="text" readonly name="totalHargaReseptur" id="totalHargaReseptur" class="inputFormTabel lebar2 currency" /></td>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="form-actions">
            <?php	
        //		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        //		array('class' => 'btn btn-danger', 'type'=>'submit','onclick'=>'cekObat();return false;', 'onKeypress'=>'return formSubmit(this,event)' ,'')); 
            ?>
            <?php	
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger','type'=>'submit','onclick'=>'submit requiredCheck(this)', )); 
            ?>

            <?php
            if(isset($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRecordTerakhir(\'PRINT\')')); 
            }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','disabled'=>'disabled')); 
            }
            ?>
            <?php    $content = $this->renderPartial('../tips/tips',array(),true);
                $this->widget('UserTips',array('type'=>'admin','content'=>$content)); ?>
        </div>
    </div>
</div>
<?php
   $urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
   $urlPrintRecordTerakhir=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);

$js = <<< JSCRIPT
function print(caraPrint,idReseptur)
{
    window.open("${urlPrint}&idReseptur="+idReseptur+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function printRecordTerakhir(caraPrint)
{
    window.open("${urlPrintRecordTerakhir}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php $this->renderPartial('_jsFunctions'); ?>
<script type="text/javascript">
	function viewDetailResep(idReseptur,pendaftaran_id)
	{
	
	$.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {idReseptur: idReseptur, pendaftaran_id: pendaftaran_id}, function(data){
			$('#contentDetailResep').html(data.result);
		}, 'json');
		$('#dialogDetailresep').dialog('open');
	}
</script>