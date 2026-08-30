<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pppendaftaran-mp-form',
        'type'=>'horizontal',
        'focus'=>'#isPasienLama',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));
//
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php 
if(empty($pasienadmisi_id))
    $this->renderPartial('/_ringkasDataPasienPendaftaran',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
else
    $this->renderPartial('/_ringkasDataPasienPendaftaranRI',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
?>
<?php
    $this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran));
?>

 
<?php $this->endWidget();?>
<script type="text/javascript">
    
$('#formPeriksaLab').tile({widths : [ 190 ]});
    
function inputperiksa(obj)
{
    if($(obj).is(':checked')) {
        var idPemeriksaanlab = obj.value;
        var kelasPelayan_id = <?php echo $modPendaftaran->kelaspelayanan_id;?>
        
        if(kelasPelayan_id==''){
                $(obj).attr('checked', 'false');
                myAlert('Anda Belum Memilih Kelas Pelayanan');
                
            }
        else{
        jQuery.ajax({'url':'<?php echo $this->createUrl('loadFormPemeriksaanLabPendLab')?>',
                 'data':{idPemeriksaanlab:idPemeriksaanlab,kelasPelayan_id:kelasPelayan_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         if($.trim(data.form)=='')
                         {
                            $(obj).removeAttr('checked');
                            alert ('Tindakan Bukan Termasuk kelas Pelayanan Yang Digunakan');
                         } else if($.trim(data.form)=='tarif kosong') {
                            $(obj).removeAttr('checked');
                            data.form = '';
                            alert ('Pemeriksaan belum memiliki tarif');
                         }
                         $('#tblFormPemeriksaanLab').append(data.form);
                 } ,
                 'cache':false});
        }     
    } else {         
        myConfirm("Apakah Anda akan membatalkan pemeriksaan ini?","Perhatian!",
        function(r){
            if(r){
                batalPeriksa(obj.value);
            }else{
                $(obj).attr('checked', 'checked');

            }
        }); 
    }
}

function inputperiksaTindakan()
{
        var idPemeriksaanlab = $('#idPemeriksaanlab').val();
        var kelasPelayan_id = <?php echo $modPendaftaran->kelaspelayanan_id;?>
        
        if(kelasPelayan_id==''){
                $(obj).attr('checked', 'false');
                myAlert('Anda Belum Memilih Kelas Pelayanan');
                
            }
        else{
        jQuery.ajax({'url':'<?php echo $this->createUrl('loadFormPemeriksaanLabPendLab')?>',
                 'data':{idPemeriksaanlab:idPemeriksaanlab,kelasPelayan_id:kelasPelayan_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                         if($.trim(data.form)=='')
                         {
                            $(obj).removeAttr('checked');
                            alert ('Tindakan Bukan Termasuk kelas Pelayanan Yang Digunakan');
                         } else if($.trim(data.form)=='tarif kosong') {
                            $(obj).removeAttr('checked');
                            data.form = '';
                            alert ('Pemeriksaan belum memiliki tarif');
                         }
                         $('#tblFormPemeriksaanLab').append(data.form);
                 } ,
                 'cache':false});
        } 
}

function batalPeriksa(idPemeriksaanlab)
{
    $('#tblFormPemeriksaanLab #periksalab_'+idPemeriksaanlab).detach();
}

function cekcyto(test, x){
    if(test.value == 1){
        $('.cyto_'+ x).show();
    }else{
        $('.cyto_'+ x).hide();
    }
}
</script>
    

<?php 
//========= Dialog daftar tindakan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAddTindakan',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDataTindakan = new PemeriksaanlabM('search');
$modDataTindakan->unsetAttributes();
if(isset($_GET['PemeriksaanlabM'])) {
    $modDataTindakan->attributes = $_GET['PemeriksaanlabM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pemeriksaanlab-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modDataTindakan->search(),
	'filter'=>$modDataTindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                        $(\"#dialogAddTindakan\").dialog(\"close\");
                                        $(\"#idPemeriksaanlab\").val(\"$data->pemeriksaanlab_id\");
                                        inputperiksaTindakan();
                                    "))',
                ),
                array(
                    'header'=>'Jenis Pemeriksaan Lab',
                    'name'=>'jenispemeriksaanlab_id',
                    'value'=>'$data->jenispemeriksaan->jenispemeriksaanlab_nama',
                ),
                array(
                    'header'=>'Nama Pemeriksaan',
                    'name'=>'pemeriksaanlab_nama',
                    'value'=>'$data->pemeriksaanlab_nama',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end pasien dialog =============================
?>
