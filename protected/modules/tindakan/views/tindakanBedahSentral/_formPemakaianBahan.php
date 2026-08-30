<fieldset>
    <table>
        <tr>
            <td colspan="2">
                <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlkes").dialog("open");return false;')); ?>
                <?php echo CHtml::radioButton('pilihAlkes', true, array('value'=>'bahan','onclick'=>'pilihAlkesMedis(this);')); ?>
                Pemakaian BMHP
                <?php echo CHtml::radioButton('pilihAlkes', false, array('value'=>'medis','onclick'=>'pilihAlkesMedis(this);')); ?>
                Alat Medis
            </td>
        </tr>
        <tr>
            <td width="230px">				
				<?php CHtml::hiddenField('qty_stok',''); ?>
                <?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '',array(),array('empty'=>'Uraian Tindakan')) ?>
            </td>
            <td>
                <?php 
				$this->widget('MyJuiAutoComplete', array(
                            'name'=>'pakaiBahan',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.$this->createUrl('PemakaianBahan').'",
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
                                        $(this).val("");
                                        return false;
                                    }',
                                   'select'=>'js:function( event, ui ) {
                                        $(this).val(ui.item.value);
                                        $("#obatalkes_id").val(ui.item.obatalkes_id);
                                        $("#obatalkes_kode").val(ui.item.obatalkes_kode);
                                        $("#qty_stok").val(ui.item.qty_stok);
                                        $("#pakaiBahan").val(ui.item.obatalkes_nama);
                                        return false;
                                    }',
                            ),
                            'htmlOptions'=>array(
								'onkeyup'=>"return $(this).focusNextInputField(event)",
								'placeholder'=>'Pemakaian BMHP',
								'showAnim'=>'fold',
								'minLength' => 2,
								'focus'=> 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                               'select'=>'js:function( event, ui ) {
                                    return false;
                                }',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogAlkes'),
                        )); 
					?>
                <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogAlatmedis").dialog("open");return false;')); ?>
                
                <?php $this->widget('MyJuiAutoComplete',array(
                            'name'=>'alatMedis',
                            'value'=>'',
                            'source'=>'js: function(request, response) {
                                           $.ajax({
                                               url: "'.Yii::app()->createUrl('rawatJalan/tindakan/PemakaianAlatMedis').'",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
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
                                    inputAlatmedis(ui.item.alatmedis_id);
                                    return false;
                                }',

                            ),
                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2', 'placeholder'=>'Alat Medis'),
                            'tombolDialog'=>array('idDialog'=>'dialogAlatmedis'),
                )); ?>
				<div class='control-group' style="margin-left: -252px;margin-top:-33px;">
					<?php // echo CHtml::label('Jumlah', 'qty_input', array('class'=>'control-label')); ?>
						<div class="controls">							
							Jumlah <?php echo CHtml::textField('qty_input', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span1 integer')) ?>
							<?php echo CHtml::hiddenField('obatalkes_id',''); ?>
                            <?php echo CHtml::hiddenField('obatalkes_kode',''); ?>
							<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
									array('onclick'=>'inputPemakaianBahan(this);return false;',
										  'class' => 'btn btn-danger',
										  'onkeyup'=>"inputPemakaianBahan(this);",
										  'rel'=>"tooltip",
										  'title'=>"Klik untuk menambahkan resep",)); ?>
						</div>
				</div>
            </td>
			<td>
				
			</td>
        </tr>
    </table> 
    <div class="block-tabel">
        <h6>Tabel <b>Pemakaian BMHP</b></h6>
        <table class="items table table-striped table-condensed" id="table-pemakaianbahan">        
            <thead>
                <tr>
                    <th>Uraian Tindakan</th>
                    <th>Nama Alkes</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
    <!--<th>Sub Total</th>-->
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div>
            <b>Total Pemakaian BMHP : </b>
            <?php echo CHtml::textField("totPemakaianBahan", 0,array('readonly'=>true,'class'=>'inputFormTabel integer')); ?>
        </div>
    </div>
</fieldset>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAlkes',
    'options'=>array(
        'title'=>'Alat Kesehatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));

$moObatAlkes = new RJObatAlkesM('search');
$moObatAlkes->unsetAttributes();
if(isset($_GET['RJObatAlkesM']))
    $moObatAlkes->attributes = $_GET['RJObatAlkesM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjobat-alkes-m-grid',
	'dataProvider'=>$moObatAlkes->searchObatFarmasi(),
	'filter'=>$moObatAlkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
										$(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_kode\').val(\'$data->obatalkes_kode\');
                                        $(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
                                        $(\'#pakaiBahan\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogAlkes\').dialog(\'close\');
//										inputPemakaianBahan($data->obatalkes_id);
										return false;"
									))',
                ),
                'obatalkes_kategori',
				'obatalkes_nama',
                'obatalkes_golongan',
                array(
                    'name'=>'satuankecilNama',
                    'value'=>'$data->satuankecil->satuankecil_nama',
                ),
                array(
                    'name'=>'sumberdanaNama',
                    'value'=>'$data->sumberdana->sumberdana_nama',
                ),
                'minimalstok',
                array(
                    'name'=>'hargajual',
                    'value'=>'number_format($data->hjaresep)',
                ),
				array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">   
$('#alatMedis').parent().addClass('hide');
function pilihAlkesMedis(obj)
{
    $('#table-pemakaianbahan > tbody').html('');
    $('#totPemakaianBahan').val('0');
    if(obj.value=='bahan'){
        $('#alatMedis').parent().addClass('hide');
        $('#pakaiBahan').parent().removeClass('hide');
    } else if(obj.value=='medis') {
        $('#pakaiBahan').parent().addClass('hide');
        $('#alatMedis').parent().removeClass('hide');
    }
} 

function inputPemakaianBahan(obj)
{
    var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
    var obatalkes_id = $('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var obatalkes_nama = $('#pakaiBahan').val();
    var jumlah = $(obj).parents().find('#qty_input').val();
    if(daftartindakan_id == ''){
        myAlert('Belum ada Tindakan');
        return false;
    }
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormPemakaianBahan'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,daftartindakan_id:daftartindakan_id},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+obatalkes_nama+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var pemakaianbahanyangsama = $("#table-pemakaianbahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(pemakaianbahanyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah Anda akan input ulang obat ini?', 'Perhatian!', function(r)
                    {
                        if(r){
                            $("#table-pemakaianbahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
                        }else{
                            tambahkandetail = false;
                        }
                    });
                }
                if(tambahkandetail){
                    $('#table-pemakaianbahan > tbody').append(data.form);
                    $("#table-pemakaianbahan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    renameInputRowPemakaianBahan($("#table-pemakaianbahan"));  
                }
                $(obj).parents('fieldset').find('#obatalkes_id').val('');
                $('#pakaiBahan').val('');
                $('#qty_input').val(1);
                formatNumberSemua();
                renameInputRowPemakaianBahan($("#table-pemakaianbahan")); 
				hitungTotal();
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih pemakaian bahan terlebih dahulu!");
    }
    setPemakaianBahanReset();
    $("#obatalkes_nama").focus();
}
/**
 * reset form obat
 */
function setPemakaianBahanReset(){
    $('#qty_input').val("1");
    $('#obatalkes_kode').val('');
    $('#pakaiBahan').focus();
}
/**
* rename input grid
*/ 
function renameInputRowPemakaianBahan(obj_table){
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
function renameInput(modelName,attributeName)
{
	var i = -1;
	$('#table-pemakaianbahan tr').each(function(){
		if($(this).has('input[name$="[obatalkes_id]"]').length){
			i++;
		}
		$(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
		$(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
		$(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
		$(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
	});
}
 
 /**
 * membatalkan form input obat alkes pasien 
 */ 
function batalOaPasien(obj)
{
    myConfirm('Apakah Anda akan membatalkan obat / alat kesehatan ini?', 'Perhatian!', function(r)
    {
        if(r){
            $(obj).parent().parent().remove();
            renameInputRowPemakaianBahan($("#table-pemakaianbahan"));
			hitungTotal();
        }
    });
}

function removeObat(obj)
{
    myConfirm("Apakah Anda akan menghapus obat?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
    
            renameInputAfterRemove('pemakaianBahan', 'obatalkes_id');
            renameInputAfterRemove('pemakaianBahan', 'hargajual');
            renameInputAfterRemove('pemakaianBahan', 'qty');
            renameInputAfterRemove('pemakaianBahan', 'subtotal');
            renameInputAfterRemove('pemakaianBahan', 'daftartindakan_id');

            renameInputAfterRemove('pemakaianBahan', 'hargasatuan');
            renameInputAfterRemove('pemakaianBahan', 'harganetto');
            renameInputAfterRemove('pemakaianBahan', 'sumberdana_id');
            renameInputAfterRemove('pemakaianBahan', 'satuankecil_id');
            hitungTotal();
        }
    });
}

function renameInputAfterRemove(modelName,attributeName)
{
    var i = -1;
    $('#table-pemakaianbahan tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

function hitungSubTotal(obj)
{
    var qty = unformatNumber(obj.value);
    var harga = unformatNumber($(obj).parents("#table-pemakaianbahan tr").find('input[name$="[harganetto_oa]"]').val());
    var subtotal = qty * harga;
    $(obj).parents("#table-pemakaianbahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
    hitungTotal();
}
    
function hitungTotal()
{
    var total = 0;
    $('#table-pemakaianbahan').find('input[name$="[subtotal]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totPemakaianBahan').val(formatNumber(total));
}

function inputAlatmedis(idAlat)
{
    var idDaftartindakan = $('#daftartindakanPemakaianBahan option:selected').val();
    if(idDaftartindakan == ''){
        myAlert('Belum ada Tindakan');
        return false;
    }
    
    jQuery.ajax({'url':'<?php echo $this->createUrl(Yii::app()->controller->id.'/addFormPemakaianAlat')?>',
                 'data':{idAlat:idAlat, idDaftartindakan:idDaftartindakan},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
                     if(!sudahAdaAlat(idAlat)){
                         $('#table-pemakaianbahan #trPemakaianBahan').detach();
                         $('#table-pemakaianbahan > tbody').append(data.form);
                         renameInput('pemakaianAlat', 'alatmedis_id');
                         renameInput('pemakaianAlat', 'hargajual');
                         renameInput('pemakaianAlat', 'hargasatuan');
                         renameInput('pemakaianAlat', 'harganetto');
                         renameInput('pemakaianAlat', 'qty');
                         renameInput('pemakaianAlat', 'subtotal');
                         renameInput('pemakaianAlat', 'daftartindakan_id');
                         renameInput('pemakaianAlat', 'sumberdana_id');
                         hitungTotal();
                     }
    
                        $("#table-pemakaianbahan > tbody tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
                        $('.integer').each(function(){this.value = formatNumber(this.value)});
                 } ,
                 'cache':false});
        function sudahAdaAlat(idAlat)
        {
             var ada;
             $('#table-pemakaianbahan').find('input[name$="[alatmedis_id]"]').each(function(){
                 var cek = true;
                 if(this.value!=idAlat){
                     ada = cek && ada;
                 } else {
                     myAlert('Sudah ada!');
                     ada = cek && true;
                 }
             });

            return ada;
        }

        function renameInput(modelName,attributeName)
        {
            var i = -1;
            $('#table-pemakaianbahan tr').each(function(){
                if($(this).has('input[name$="[alatmedis_id]"]').length){
                    i++;
                }
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
            });
        }
}
</script>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogAlatmedis',
    'options'=>array(
        'title'=>'Alat Medis',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>550,
        'resizable'=>false,
    ),
));

$modAlat = new AlatmedisM('search');
$modAlat->unsetAttributes();
if(isset($_GET['AlatmedisM']))
    $modAlat->attributes = $_GET['AlatmedisM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'almes-m-grid',
	'dataProvider'=>$modAlat->search(),
	'filter'=>$modAlat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                'jenisalatmedis.jenisalatmedis_nama',
                'alatmedis_nama',
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "inputAlatmedis($data->alatmedis_id);return false;"))',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>