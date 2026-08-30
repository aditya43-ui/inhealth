<?php
/**
*  Dialog berisi data autocomplete dan dialog box pencarian tindakan
*
* @category     views
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<div id="form-dialogtindakan">

<div class="control-group">
	<?php echo CHtml::label("Pemeriksaan Rad",'',array('class' => 'control-label')) ?>
	<div class="controls">
		<?php 
		$this->widget('MyJuiAutoComplete', array(
						'name'=>'pemeriksaanrad_nama',
						'value'=>$modPemeriksaanRad->pemeriksaanrad_nama,
						'source'=>'js: function(request, response) {
									   $.ajax({
										   url: "'.$this->createUrl('AutocompleteKunjungan').'",
										   dataType: "json",
										   data: {
											   no_pendaftaran: request.term,
											   ruangan_id: $("#ruangan_id").val(),
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
						 'options'=>array(
							   'minLength' => 4,
								'focus'=> 'js:function( event, ui ) {
									 $(this).val( "");
									 return false;
								 }',
							   'select'=>'js:function( event, ui ) {
									$(this).val( ui.item.no_pendaftaran);
									setKunjungan(ui.item.pasienmasukpenunjang_id);
									return false;
								}',
						),
						'tombolDialog'=>array('idDialog'=>'dialogTindakan','idTombol' => 'tombolDialogTindakan'),
						'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'all-caps','rel'=>'tooltip','title'=>'No. Pendaftaran',
							'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
							),
					)); 
	?>
	</div>
</div>
</div>
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
		'id'=>'dialogTindakan',
		'options'=>array(
			'title'=>'Pencarian Pemeriksaan Rad',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>960,
			'height'=>600,
			'resizable'=>false,
		),
	));
	$tindakanLab = new ROTarifpemeriksaanradruanganV('search');
	$tindakanLab->unsetAttributes();
	$tindakanLab->ruangan_id = 9999;
	
	if(isset($_GET['ROTarifpemeriksaanradruanganV'])) {
		$tindakanLab->attributes = $_GET['ROTarifpemeriksaanradruanganV'];		
	}
    $tindakanLab->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
	
	$this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'tindakantariflab-m-grid',
			'dataProvider'=>$tindakanLab->searchTarif(),
			'filter'=>$tindakanLab,
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
					/*array(
						'header'=>'Pilih',
						'type'=>'raw',
						'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
										"id" => "selectAsuransi",
										"onClick" => "																						
											$(\"#dialogTindakan\").dialog(\"close\");
										"))',
					),*/
					array(
						'header'=>CHtml::checkBox('check_all', false, array(
							'class'=>'check_all_produk', 'onchange'=>'set_check_all_pemeriksaan(this);'
						)).' Pilih Semua',
						'type'=>'raw',
						'value'=>function($data) use ($tindakanLab) {																					
							return CHtml::checkBox('check', false, array(
								'data-id'=>$data->daftartindakan_id, 
								'data-pemeriksaanrad-id'=>$data->pemeriksaanrad_id, 
								'onchange'=>'check_sr_pemeriksaan(this);',
								'class'=>'request_checks_pemeriksaan',
							));
						},
						'htmlOptions'=>array(
							'style'=>'text-align: center',
						),
						'footer' => CHtml::htmlButton('+ Tambah', array('class'=>'btn btn-primary', 'onclick'=>'add_pemeriksaan_pilihan(); $("#dialogTindakan").dialog("close");'))
					),
					array(
						'header' => 'Jenis Pemeriksaan',
						'value' => '$data->jenispemeriksaanrad_nama',
						'filter' =>CHtml::activeHiddenField($tindakanLab, 'kelaspelayanan_id',array('class'=>'dialog_kelaspelayanan_id')). CHtml::activeHiddenField($tindakanLab, 'penjamin_id',array('class'=>'dialog_penjamin_id')).CHtml::activeHiddenField($tindakanLab, 'ruangan_id',array('class'=>'dialog_ruangan_id')).CHtml::activeDropDownList($tindakanLab, 'jenispemeriksaanrad_id',  CHtml::listData(JenispemeriksaanradM::model()->findAll("jenispemeriksaanrad_aktif = true ORDER BY jenispemeriksaanrad_nama"), 'jenispemeriksaanrad_id', 'jenispemeriksaanrad_nama'),array('empty' => '-- Pilih --'))
					),
					array(
						'header' => 'Pemeriksaan',
						'name' => 'pemeriksaanrad_nama',
						'value' => '$data->pemeriksaanrad_nama',
					)	
							
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});update_check_selected_produk();}',
	));
	
	
						
	$this->endWidget();
?>

<script>
var is_checked = {};
var is_checked_pemeriksaan = {};
var is_checked_pemeriksaanrad = {};


// ---------------------------- Produk ------------------------------

function check_sr_pemeriksaan(obj) {
	var id = $(obj).data('id');
	var rad_id = $(obj).data('pemeriksaanrad-id');
	
	if ($(obj).prop("checked")) {

		console.log('tercek: ' + rad_id);
		is_checked_pemeriksaan[id] = id;
		is_checked_pemeriksaanrad[rad_id] = rad_id;
	} else {

		console.log('tercek no: ' + $(obj).prop("checked"));
		is_checked_pemeriksaan[id] = 0;
		is_checked_pemeriksaanrad[rad_id] = 0;
	}
}

function update_check_selected_produk() {		
	$(".request_checks_pemeriksaan").each(function() {
		var id = $(this).data('id');		
		var rad_id = $(this).data('pemeriksaanrad-id');		
		var obj = $(this);
		
		if (typeof is_checked_pemeriksaanrad[rad_id] != "undefined" && is_checked_pemeriksaanrad[rad_id] != 0)
			$(this).prop("checked", true);
		
		$("#form-tindakanpemeriksaan > table > tbody > tr").each(function() {			
			if ( ($(this).find('input[name$="[pemeriksaanrad_id]"]').val() == rad_id) && ($(this).find('input[name$="[tindakanpelayanan_id]"]').val() == '') ) {
				$(obj).prop("checked", true).prop("disabled", true);
			}
		});
	});
}

function set_check_all_pemeriksaan(obj) {

	console.log('untuk semua tercek is: ' + $(obj).is(":checked"));
	console.log('untuk semua tercek prop: ' + $(obj).prop("checked"));
	
	$(".request_checks_pemeriksaan").prop("checked", $(obj).is(":checked")).change();
}

function add_pemeriksaan_pilihan() {
	var arr = new Array();
	var arr_rad = new Array();

	var pemeriksaan = '';
	
	$.each(is_checked_pemeriksaan, function(idx, val) {
		arr.push(val);		
	});

	console.log('pemeriksaan is cek: ');
	console.log(is_checked_pemeriksaanrad);
	
	$.each(is_checked_pemeriksaanrad, function(idx, val) {
		arr_rad.push(val);
		console.log('pemeriksaan ' + idx + ' : ' + val);		
	});

	console.log("pemeriksaan tercek: ");
	console.log(arr_rad);
	
	is_checked_pemeriksaan = {};
	is_checked_pemeriksaanrad = {};
	
	var ruangan_id = $("#ruangan_id").val();
	var penjamin_id = $("#penjamin_id").val();
	var kelaspelayanan_id = $("#kelaspelayanan_id").val();		
	var pasienmasukpenunjang_id = $("#pasienmasukpenunjang_id").val();	
	
	<?php if (isset($modPasienMasukPenunjang)){ ?>
		 ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
		 kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
	<?php } ?>
		
		
	
		$.post('<?php echo $this->createUrl('addTindakanPilihan'); ?>', {
				id: arr, 
				pemeriksaanrad_id: arr_rad, 
				ruangan_id: ruangan_id,
				penjamin_id: penjamin_id,
				kelaspelayanan_id: kelaspelayanan_id,
				pasienmasukpenunjang_id: pasienmasukpenunjang_id
			}, function(data) {
					if (data.sukses == 1){
						var cf = confirm("Apakah Anda yakin, akan menambahkan beberapa pemeriksaan yang sama, yaitu : "+data.ada+" ?");

						if (cf){
							$("#form-tindakanpemeriksaan > table > tbody").append(data.row);				
							renameInputRow($("#form-tindakanpemeriksaan"));				
							$(".request_checks_pemeriksaan, .check_all_pemeriksaan").prop("checked", false);
							renameInput();
						}
					}else{
							if (data.pesan != ''){
								alert(data.pesan);
							}
							$("#form-tindakanpemeriksaan > table > tbody").append(data.row);				
							renameInputRow($("#form-tindakanpemeriksaan"));				
							$(".request_checks_pemeriksaan, .check_all_pemeriksaan").prop("checked", false);
							renameInput();
					}	
					//rebuildDaftarTindakan(data);
		}, 'json');
}

function delItems(obj){
	$(obj).parents('tr').addClass("yellow");
	
	var result = confirm("Apakah Anda yakin menghapus data pemeriksaan ini ??");
	if (result) {
		rebuildDaftarTindakanDel($(obj).parents('tr').find(".id-daftartindakan").val());
		$(obj).parents('tr').remove();
		renameInputRow($("#form-tindakanpemeriksaan"));	
		renameInput();
	}else{
		$(obj).parents('tr').removeClass("yellow");
		return false;
	}	
}

function delItemsAda(obj, id) {
    $(obj).parents('tr').attr("style","border:red 2px solid;");
	
    myConfirm("Apakah Anda yakin membatalkan data pemeriksaan ini ??", "Perhatian", function(r) {
        if (r) {
            $.post("<?php echo $this->createUrl('hapusTindakanPemeriksaan'); ?>", {id: id}, function(data){
                if (data.ok == 1) {
                    myAlert(data.msg);
                    $(obj).parents('tr').remove();
                    renameInputRow($("#form-tindakanpemeriksaan"));	
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
        } else {
            $(obj).parents('tr').attr("style","");
        }
    });
}

function updateTabelProduk() {
	jQuery.fn.yiiGridView.update('tindakantariflab-m-grid', {
		data: $("#tindakantariflab-m-grid :input").serialize(),
	});
}
	
function refreshDialogOA(){
        
	$("#pemeriksaanlab_nama").addClass('animation-loading');
	
	
	
	setTimeout(function(){			
		$("#pemeriksaanlab_nama").removeClass("animation-loading");
	},500);
	
}

function rebuildDaftarTindakan(data){	
	var obj_table = '#table-rujukankeluar';
	var i = 0;
	$(obj_table).find("tbody > tr").each(function () {		
		var id = $(this).find('.rujukkeluar-daftartindakan-id').val();
		$('#PemeriksaankeluarT_'+i+'_daftartindakan_id').append(data.drop);            		
		$('#PemeriksaankeluarT_'+i+'_daftartindakan_id').val(id);
		i++;
	});				 	
}

function rebuildDaftarTindakanDel(id, tinpel_id){	
	var obj_table = '#table-rujukankeluar';
	var i = 0;
	$(obj_table).find("tbody > tr").each(function () {		
		var sel_id = $(this).find('.rujukkeluar-daftartindakan-id option:selected').val();
		//alert(id);
		$('#PemeriksaankeluarT_'+i+'_daftartindakan_id').find("option[value='"+id+'-'+tinpel_id+"']").remove();            		
		//$('#PemeriksaankeluarT_'+i+'_daftartindakan_id').find().remove();            		
		$('#PemeriksaankeluarT_'+i+'_daftartindakan_id').val(sel_id);
		i++;
	});				 	
}

$('#tombolDialogTindakan').click(function(){
	var ruangan_id = $("#ruangan_id").val();
	var penjamin_id = $("#penjamin_id").val();
	var kelaspelayanan_id = $("#kelaspelayanan_id").val();
	var pendaftaran_id = $("#pendaftaran_id").val();	
	
	<?php if (isset($modPasienMasukPenunjang)){ ?>
		 ruangan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'ruangan_id') ?>").val();
		 kelaspelayanan_id = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang,'kelaspelayanan_id') ?>").val();
	<?php } ?>
		
	if (pendaftaran_id != ''){			
        $(".dialog_ruangan_id").val(ruangan_id);
        $(".dialog_penjamin_id").val(penjamin_id);
		$(".dialog_kelaspelayanan_id").val(kelaspelayanan_id);
		$.fn.yiiGridView.update('tindakantariflab-m-grid', {
			data: {
				"ROTarifpemeriksaanradruanganV[ruangan_id]":ruangan_id,
				"ROTarifpemeriksaanradruanganV[penjamin_id]":penjamin_id,
				"ROTarifpemeriksaanradruanganV[kelaspelayanan_id]":kelaspelayanan_id,
			}
		});		
	}else{
		$("#dialogTindakan").dialog("close");
		alert("Maaf, Pasien Belum Dipilih");
		return false;
	}
});

function cekTinKeluar(obj){
	var obj_table = '#table-rujukankeluar';
	var cekTin = 0;
	
	if ($(obj).val() != ''){
		$(obj_table).find("tbody > tr").each(function () {		
			$(this).find('input,select,textarea').each(function () { //element <input>		
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");	

				if (old_name_arr[2] == 'daftartindakan_id'){				
					if ($(this).val() == $(obj).val()){
						cekTin++;
					}
				}
			});				
		});
		
		if (cekTin > 1){
			myAlert("Tindakan yang sudah dipilih, tidak dapat dipilih untuk pememriksaan keluar yang lain ");
			$(obj).val("");
			return false;
		}
	}
}

</script>