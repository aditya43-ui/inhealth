<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?> 
<div id="form-resep">
	<div class="col-sm-6"  >
		<div class="control-group" >
			<?php 
				$format = new MyFormatter();
				$modReseptur->create_time = $format->formatDateTimeForUser($modReseptur->create_time);
				echo $form->labelEx($modReseptur,'create_time', array('class'=>'control-label')) 
			?>
			<div class="controls">
				<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modReseptur,
						'attribute' => 'create_time',
						'name'=> 'create_time',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							//										'maxDate' => 'd',
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3 realtime', 'onclick' => "return $(this).focusNextInputField(event)"),
					)); 
				?>	
			</div>
		</div>
	
		<div class="control-group">
			<?php echo $form->labelEx($modReseptur,'noresep_triage', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modReseptur,'noresep_triage',array('readonly'=>true, 'style'=>'width:170px;', )); ?><br>
			</div>
		</div>
	
		<div class="control-group">
			<?php echo $form->labelEx($modReseptur,'nama_pasien', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modReseptur,'nama_pasien',array('readonly'=>true, 'style'=>'width:170px;', )); ?><br>
			</div>
		</div>
		
		<?php echo $form->dropDownListRow($modReseptur,'petugasfarmasi_id',CHtml::listData($modReseptur->getDokterItems(), 'pegawai_id', 'NamaLengkap'),array('class' => 'span4 petugasfarmasi_id','onkeypress'=>"return $(this).focusNextInputField(event)"));?>
		<?php echo $form->textFieldRow($modReseptur,'petugas_pengambil_obat', array('class' => 'span3','onkeypress'=>"return $(this).focusNextInputField(event)"));?>

		<?php echo $form->hiddenField($modReseptur,'obatalkes_id',array('id'=>'obatalkes_id','readonly'=>true, 'style'=>'width:170px;', )); ?>
		<input type="hidden" id="hargasatuanreseptur">
		<input type="hidden" id="sumberdana_id">
		<input type="hidden" id="stfornas">
		<div class="control-group">
			<?php echo $form->labelEx($modReseptur, 'obatalkes_id', array('class'=>'control-label','label'=>'Nama Obat')); ?>
			<div class="controls">
				<?php 
					$this->widget('MyJuiAutoComplete', array(
						'name'=>'obatalkes_nama',
						'source'=>'js: function(request, response) {
							$.ajax({
								url: "'.$this->createUrl('/rawatJalan/reseptur/AutocompleteObatApiRuangan').'",
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
							'select'=>'js:function( event, ui ) {
								$(this).val(ui.item.nama);
								setObatDariApi(ui.item.kode, ui.item.jenis, ui.item.stFornas, ui.item.HJual, ui.item.satuan, ui.item.HPP, ui.item.nama)
								return false;
							}',
						),
						'tombolDialog'=>array('idDialog'=>'dialogObatDariApi'),
						'htmlOptions'=>array('id'=>'obatalkes_id_nama','class'=>'span3'),
					)); 
				?>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="jumlah">Jumlah Obat</label>
			<div class="controls">
				<?php echo CHtml::textField('jumlah', 1, array('readonly'=>false,'onkeyup'=>'$("#jumlah").val($(this).val());','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'jumlah number-char',"rel"=>"tooltip",'style'=>'width:50px;', 'onblur'=>'hitungJumlahObatQty();')) ?>
				<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
									array('onclick'=>'tambahDetailObat(this);return false;',
									'class'=>'btn btn-primary',
									'id'=>'tomboltambahracikan',
									'onkeypress'=>"tambahDetailObat(this);return false;",
									'rel'=>"tooltip",
									'title'=>"Klik untuk menambahkan ke tabel resep",)); ?>
			</div>
		</div>
	
	</div> <!-- ./col -->
	
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo $form->labelEx($modReseptur,'keterangan', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textArea($modReseptur,'keterangan',array('id'=>'keterangan','readonly'=>false, 'rows' => 10, 'cols' => 50 )); ?>
			</div>
		</div>	
	</div>
</div>
	
	
	

                    

<?php 
//========= Dialog paket obat  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPaketObat',
    'options'=>array(
        'title'=>'Data Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modPaketObat = new ObatalkesM('search');
// var_dump($modPaketObat); die;
$modPaketObat->unsetAttributes();
if(isset($_GET['ObatalkesM'])){
    $modPaketObat->attributes=$_GET['ObatalkesM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'dialog-paket-obat-m-grid',
	'dataProvider'=>$modPaketObat->search(),
	'filter'=>$modPaketObat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
								"id" => "selectObat",
								"onClick" => "
								$(\"#obatalkes_id\").val(\"$data->obatalkes_id\"); 
								$(\"#obatalkes_id_nama\").val(\"$data->obatalkes_nama\"); 
								$(\'#dialogPaketObat\').dialog(\'close\');
								return false;"))',
			),
			'obatalkes_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php
 $this->renderPartial($this->path_view . '_dialogObatApi');
?>


<script>


function hitungJumlahObatQty(){
    // unformatNumberSemua();
	$("#permintaan").addClass("animation-loading-1");

     var qtyRacik = parseFloat(unformatNumber($("#jumlah").val()));

    console.log(qtyRacik);

	setTimeout(function(){
		if((qtyRacik != '')){
			var permintaan = qtyRacik;
			$("#tomboltambahracikan").attr("disabled",false);
		}else{
			var permintaan = 0;
			$("#tomboltambahracikan").attr("disabled",true);
		}

		$("#permintaan").val(formatFloat(permintaan));
		$("#permintaan").removeClass("animation-loading-1");
	},500);

}

function setObatDariApi(kode_obat, sumberdana, stfornas, hargasatuanreseptur, satuan, HPP, nama) {
	$.ajax({
		type: 'POST',
		url: '<?php echo $this->createUrl('/rawatJalan/reseptur/getObat'); ?>',
		data: {
			kode_obat: kode_obat,
			sumberdana: sumberdana,
			stfornas:stfornas,
			harga_jual:hargasatuanreseptur,
			satuan:satuan,
			HPP:HPP,
			nama:nama
		},
		dataType: "json",
		success: function(data) {
			console.log(data);
			if(data.sukses == 1) {
				if(data.obatalkes.sukses == 1) {
					$("#obatalkes_id").val(data.obatalkes.id);
					$("#hargasatuanreseptur").val(hargasatuanreseptur); 
					$("#sumberdana_id").val(data.sumberdana.id); 
					$("#stfornas").val(stfornas); 
					$("#dialogObatDariApi").dialog("close");
				} else {
					myAlert(data.pesan);
				}
			} else {
				myAlert(data.pesan);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
		}
	});
}



function tambahDetailObat(obj)
{
    var obatalkes_id = $(obj).parents('#form-resep').find('#obatalkes_id').val();
    var jumlah = $(obj).parents('#form-resep').find('#jumlah').val();
    var keterangan = $(obj).parents('#form-resep').find('#keterangan').val();
    var petugasfarmasi_id = $('#FAPengambilanObatT_petugasfarmasi_id').val();
    var petugas_pengambil_obat = $('#FAPengambilanObatT_petugas_pengambil_obat').val();
    var tgl_resep = $('#create_time').val();
    var noresep = $('#FAPengambilanObatT_noresep_triage').val();
	var notriagepasien_id = '<?= isset($_GET['notriage_pasien_id']) ? $_GET['notriage_pasien_id'] : null ?>';
	var nama_pasien = $('#FAPengambilanObatT_nama_pasien').val();
   
   	var hargasatuanreseptur = $("#hargasatuanreseptur").val(); 
	var sumberdana_id = $("#sumberdana_id").val(); 
	var stfornas = $("#stfornas").val(); 
    
    if (jumlah == 0) {
        myAlert("Jumlah tidak boleh nol");
        return false;
    }

    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {
                obatalkes_id:obatalkes_id,
                jumlah:jumlah,
                racikan: false,
                keterangan: keterangan,
				petugasfarmasi_id:petugasfarmasi_id,
				petugas_pengambil_obat:petugas_pengambil_obat,
				tgl_resep:tgl_resep,
				noresep:noresep,
				notriagepasien_id:notriagepasien_id,
				nama_pasien:nama_pasien,
				hargasatuanreseptur:hargasatuanreseptur,
				sumberdana_id:sumberdana_id,
				stfornas:stfornas
                },//
            dataType: "json",
            success:function(data){
				if(data.status == 1) {
					myAlert("Tindak lanjut pasien sudah dilakukan validasi PJA");
					return false;
				}
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16
                    insert_notifikasi(params);
                    return false;
                }
			    var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
            
				if(tambahkandetail){
                        $('#table-obatalkespasien > tbody').append(data.form);
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                        );
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney(
                              {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                      );
                        addDataKeGridObat(obj);
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
						hitungTotal();
                    }
                // }
                $(obj).parents('#form-resep').find('#obatalkes_id').val('');
                $(obj).parents('#form-resep').find('#keterangan').val('');
                $('#obatalkes_id_nama').val('');
                $('#jumlah').val(1);
				$("#hargasatuanreseptur").val(''); 
				$("#sumberdana_id").val(''); 
				$("#stfornas").val(''); 
                // formatNumberSemua();
                renameInputRowObatAlkes($("#table-obatalkespasien"));
        },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#obatalkes_id_nama").focus();
}

function hitungTotal() {
	$("#table-obatalkespasien tbody tr").each(function() {
		var hargasatuanoa = $(this).find('input[name$="[hargasatuan_oa]"]').val();
	});
}

function batalObatAlkesPasienDetail(obj){
    myConfirm('Apakah Anda akan membatalkan penjualan obat alkes ini?','Perhatian!',
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });

        }
    }); 
}

function addDataKeGridObat(obj){

        var obatalkes_id = $(obj).parents('form-resep').find('#obatalkes_id').val();
		var keterangan = $(obj).parents('form-resep').find('#keterangan').val();
		var jumlah = $(obj).parents('form-resep').find('#jumlah').val();
}

function renameInputRowObatAlkes(obj_table) {
	var row = 0;
	$(obj_table).find("tbody > tr").each(function () {
		$(this).find("#no_urut").val(row + 1);
		$(this).find('span').each(function () { //element <input>
			var old_name = $(this).attr("name").replace(/]/g, "");
			var old_name_arr = old_name.split("[");
			if (old_name_arr.length == 3) {
				$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
			}
		});
		$(this).find('input,select,textarea').each(function () { //element <input>
			var old_name = $(this).attr("name").replace(/]/g, "");
			var old_name_arr = old_name.split("[");
			if (old_name_arr.length == 3) {
				$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
				$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
			}
		});
		row++;
	});
}

$(document).ready(function() {
	// Menonaktifkan elemen select saat halaman dimuat
	$('.petugasfarmasi_id').prop('disabled', true);

	// Mengaktifkan kembali elemen select saat formulir diajukan
	$('form').submit(function(event) {
		$('.petugasfarmasi_id').prop('disabled', false);
		$('.form-actions').addClass('animation-loading');
		$('#btn_submit').prop('disabled', true);
	});
});
</script>