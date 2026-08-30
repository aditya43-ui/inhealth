<?php 
Yii::import('rawatJalan.models.RJPaketbmhpM');
 ?>
<fieldset>
    <legend>
    </legend> 
        <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogPaketBMHP").dialog("open");return false;')); ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'name'=>'paketBMHP',
                    'value'=>'',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.$this->createUrl('PaketBMHP').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           idTipePaket: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                           idKelasPelayanan: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            inputBMHP(ui.item.daftartindakan_id, ui.item.kelompokumur_id);
                            $(this).val(\'\');
                            return false;
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2','placeholder'=>'Paket BMHP'),
                    'tombolDialog'=>array('idDialog'=>'dialogPaketBMHP'),
        )); ?>
    <div class="block-tabel">
        <h6>Tabel Pemakaian <b>Paket BMHP</b></h6>
        <table class="items table table-striped table-condensed" id="table-paketbmhp">
            <thead>
                <tr>
                    <th>Uraian Tindakan</th>
                    <th>Nama BMHP</th>
                    <th>Harga</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div>
            <b>Total BMHP : </b>
            <?php echo CHtml::textField("totHargaBmhp", 0,array('readonly'=>true,'class'=>'inputFormTabel integer')); ?>
        </div>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Paket BMHP =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPaketBMHP',
    'options'=>array(
        'title'=>'Paket BMHP',
        'autoOpen'=>false,
        'modal'=>true,
//        'width'=>500,
//        'height'=>600,
        'width'=>800,
        'height'=>440,
        'resizable'=>false,
    ),
));

$filtersForm=new MyFiltersForm;
if (isset($_GET['MyFiltersForm']))
    $filtersForm->filters=$_GET['MyFiltersForm'];

$modBMHP = new RJPaketbmhpM('searchPaket');
    $modBMHP->unsetAttributes();    
    if(isset($_GET['RJPaketbmhpM'])) {
        $modBMHP->attributes = $_GET['RJPaketbmhpM'];
        $modBMHP->kelompokumurNama = $_GET['RJPaketbmhpM']['kelompokumurNama'];
        $modBMHP->daftartindakanNama = $_GET['RJPaketbmhpM']['daftartindakanNama'];
    }

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjpaketobat-alkes-m-grid',
    'dataProvider'=>$modBMHP->searchPaket(),
    'filter'=>$modBMHP,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputBMHP($data->daftartindakan_id,$data->kelompokumur_id);return false;"))',
                ),
                array(
                    'header'=>'Daftar Tindakan',
                    'name'=>'daftartindakanNama',
                    'value'=>'$data->daftartindakan_nama',
                ),
                array(
                    'header'=>'Kelompok Umur',
                    'name'=>'kelompokumurNama',
                    'value'=>'$data->kelompokumur_nama',
                ),
                array(
                    'header'=>'Harga Pemakaian',
                    'name'=>'hargapemakaian',
                    'value'=>'number_format($data->hargapemakaian)',
                ),
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
function inputBMHP(daftartindakan_id,kelumur_id)
{
    var ketemu = false;
//    var pendaftaran_id = <?php // echo (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : ""); ?> ;
    var pendaftaran_id = $("#pendaftaran_id").val();
    $('#tbl-tindakanoperasi').find('input[name$="[daftartindakan_id]"]').each(function(){
//     DISABLE SEMENTARA KARENA ADA BMHP YG TDK BERDASARKAN TINDAKAN >> if($(this).val() == daftartindakan_id){
            ketemu = true;
            jQuery.ajax({'url':'<?php echo $this->createUrl(Yii::app()->controller->id.'/addFormPaketBmhp')?>',
                 'data':{daftartindakan_id:daftartindakan_id, kelumur_id:kelumur_id, pendaftaran_id:pendaftaran_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
						if(data.pesan !== ""){
							myAlert(data.pesan);
							return false;
						}
						$('#table-paketbmhp > tbody').append(data.form);
						$("#table-paketbmhp").find('input[name*="[ii]"][class*="integer"]').maskMoney(
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
						);
						renameInputRowPemakaianBahan($("#table-paketbmhp"));  
						
						$('#obatalkes_id').val('');
						$('#paketBMHP').val('');
						formatNumberSemua();
						renameInputRowPaketBmhp($("#table-paketbmhp")); 
						hitungTotalBMHP();
                 } ,
                 'cache':false});
//        } 
    });
    if(!ketemu) {
        myAlert('Tidak ada tindakan yang dimaksud.');
    }
}
    
function hitungTotalBMHP()
{ 
    var total = 0;
    $('#table-paketbmhp').find('input[name$="[hargapemakaian]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totHargaBmhp').val(formatNumber(total));
}

/**
* rename input grid
*/ 
function renameInputRowPaketBmhp(obj_table){
	var row = 0;
	$(obj_table).find("tbody > tr").each(function(){
		$(this).find("#no_urut").val(row+1);
		$(this).find('span').each(function(){ //element <input>
			var old_name = $(this).attr("name").replace(/]/g,"");
			var old_name_arr = old_name.split("[");
			if(old_name_arr.length == 3){
				$(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
			}
		});
		$(this).find('input,select,textarea').each(function(){ //element <input>
			var old_name = $(this).attr("name").replace(/]/g,"");
			var old_name_arr = old_name.split("[");
			if(old_name_arr.length == 3){
				$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
				$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
			}
		});
		row++;
	});
}

function hapusBMHP(obj){
    myConfirm("Apakan Anda ingin menghapus ini?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
            renameInputRowPaketBmhp();
            hitungTotalBMHP();
        }
    });
    return false;
}
</script>