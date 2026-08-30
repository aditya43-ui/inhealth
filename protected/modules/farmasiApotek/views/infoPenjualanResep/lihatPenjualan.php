<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'lihatpenjualan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'method'=>'get',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));
?>

<fieldset>
    <legend class="rim">Lihat Penjualan</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($detailJuals[0],'no_rekam_medik',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'nama_pasien',array('class'=>'span3','readonly'=>true)); ?>
                <div class="control-group">
                    <label for="FAInformasipenjualanapotikV_jeniskelamin" class="control-label">Umur / Jeniskelamin</label>
                    <div class="controls">
                        <?php echo $form->textField($detailJuals[0],'umur',array('class'=>'span2','readonly'=>true)); ?> /
                        <?php echo $form->textField($detailJuals[0],'jeniskelamin',array('class'=>'span2','readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($detailJuals[0],'tglpenjualan',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'tglresep',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'noresep',array('class'=>'span3','readonly'=>true)); ?>
            </td>
        </tr>
    </table>
</fieldset>

<div id="divTabelPenjualan">
<?php $this->renderPartial('_tblPenjualan',array('detailJuals'=>$detailJuals,'$obatpasiens'=>$obatpasiens)); ?>
</div>

<div id="errorMessage" class="errorSummary">
    
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
function batalObat(idPenjualanResep,idReseptur,idObatAlkes)
{
    myConfirm('Apakah Anda akan membatalkan penjualan obat ini?','Perhatian!',
    function(r){
        if(r){
            $.post('<?php echo $this->createUrl('batalJualObat'); ?>', {idPenjualanResep:idPenjualanResep, idReseptur:idReseptur, idObatAlkes:idObatAlkes}, function(data){
                if(data.sukses) {
                    $('#divTabelPenjualan').html(data.tblPenjualan);
                } else {
                    myAlert('Gagal membatalkan Obat Alkes');
                }
                $('#errorMessage').html(data.errorMessage);
            }, 'json');
        }
    }); 
}
</script>