

<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END);

$row = "";

    $row = $this->renderPartial($this->path_view.'_rowDetail',array('modRealisasiLemburDetail'=>$modRealisasiLemburDetail,'modPegawai'=>$modPegawai,'removeButton'=>true),true);
    $row = str_replace("\n", "", $row);
    $row = str_replace("\r", "", $row);
    $row = str_replace("\t", "", $row);

$biaya = BiayalemburM::model()->find(array('order'=>'biayalembur_id'));

$lembur = 4000;
$libur = 6000;

if (!empty($biaya)) {
    $lembur = $biaya->biayalembur_nilai;
    $libur = $biaya->biayalembur_nilailibur;
}


// var_dump($row); die;

?>

<script type="text/javascript">
    
var nilai_lembur = {normal: <?php echo $lembur; ?>, libur: <?php echo $libur; ?>};   
var vlembur = nilai_lembur.normal;

function loadRencana(id){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('loadRencanaLembur'); ?>',
		data: {rencanalembur_id:id},//
		dataType: "json",
		success:function(data){
			if (data.sukses == 1){
				$("#table-pegawai > tbody").html(data.tr);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'rencanalembur_id') ?>").val(data.rencana.rencanalembur_id);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'norencana') ?>").val(data.rencana.norencana);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'tglrencana') ?>").val(data.rencana.tglrencana);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'mengetahui_id') ?>").val(data.rencana.mengetahui_id);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'mengetahui_nama') ?>").val(data.rencana.mengetahui_nama);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'menyetujui_id') ?>").val(data.rencana.menyetujui_id);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'menyetujui_nama') ?>").val(data.rencana.menyetujui_nama);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'pemberitugas_id') ?>").val(data.rencana.pemberitugas_id);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'pemberitugas_nama') ?>").val(data.rencana.pemberitugas_nama);
				$("#<?php echo CHtml::activeId($modRencanaLembur, 'keterangan') ?>").val(data.rencana.keterangan);
				setNilaiLembur();
			}else{
				myAlert(data.pesan);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}
    
function setNilaiLembur() {
    /*
    if ($("#isharilembur").is(":checked")) {
        vlembur = nilai_lembur.libur;
    } else {
        vlembur = nilai_lembur.normal;
    }
    
    console.log(vlembur);
    */
    
    $("#table-pegawai tbody tr").each(function() {
        hitungJam($(this).find(".jam_mulai"));
    });
    
    
}
    
    
function submitPegawaiLembur(obj)
{
    var pegawailembur_id = $('#pegawailembur_id').val();   
    var nomorindukpegawai = $('#<?php echo CHtml::activeId($modRencanaLembur,"rencana_nip"); ?>').val();
    if(pegawailembur_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setPegawaiLembur'); ?>',
            data: {pegawailembur_id:pegawailembur_id,nomorindukpegawai:nomorindukpegawai},//
            dataType: "json",
            success:function(data){
                var tambahkanpegawai = true;
                var pegawaiyangsama = $("#table-pegawai input[name$='[pegawai_id]'][value='"+pegawailembur_id+"']");
                if(pegawaiyangsama.val()){ //jika ada obat sudah ada di table
                    if(confirm("Apakah Anda akan input ulang pegawai ini?")){
                        $("#table-pegawai input[name$='[pegawai_id]'][value='"+pegawailembur_id+"']").each(function(){
                            $(this).parents('tr').detach();
                        });
                    }else{
                        tambahkanpegawai = false;
                    }
                }
                if(tambahkanpegawai){
                    $('#table-pegawai > tbody').append(data.tr);
                    $("#table-pegawai").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    renameInputRowRencanaLembur($("#table-pegawai"));          
                }
                $('#pegawailembur_id').val('');
                $('#<?php echo CHtml::activeId($modRencanaLembur,"nama_pegawai"); ?>').val('');
                renameInputRowRencanaLembur($("#table-pegawai")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih pegawai dahulu!");
    }
    $("#<?php echo CHtml::activeId($modRencanaLembur,"karlembur_nama"); ?>").focus();   
}

/**
* untuk print permintaan penawaran
 */
function print(caraPrint)
{
    var id_realisasi = '<?php echo isset($_GET['id_realisasi']) ? $_GET['id_realisasi'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&id='+id_realisasi+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=640,height=480');
}

/**
* rename input grid
*/ 
function renameInputRowRencanaLembur(obj_table){
    return false;
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find(".no_urut").val(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                // $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}


function hapusBaris(obj){
        myConfirm("Apakah Anda ingin membatalkan ini?","Perhatian!",function(r){if(r){
            $(obj).parents('tr').detach();
        }});
    }

    function check(obj){
        var kosongJamMulai = 0;
        var kosongJamSelesai = 0;
        var kosongAlasan = 0;
		var kosongPegawai = 0;
		
        $("#table-pegawai").find('[name*="[jamMulai]"]').each(function(){
            if($(this).val()==""){
                kosongJamMulai++;
            }
        });
        $("#table-pegawai").find('[name*="[jamSelesai]"]').each(function(){
            if($(this).val()==""){
                kosongJamSelesai++;
            }
        });
        $("#table-pegawai").find('[name*="[alasanlembur]"]').each(function(){
            if($(this).val()==""){
                kosongAlasan++;
            }
        });
		$("#table-pegawai").find('[name*="[pegawai_id]"]').each(function(){
            if($(this).val()==""){
                kosongPegawai++;
            }
        });

        if(kosongJamMulai>0){
            myAlert('Jam Mulai harus di isi!');
            return false;
        }else if(kosongJamSelesai>0){
            myAlert('Jam Selesai harus di isi!');
            return false;
        }else if(kosongAlasan>0){
            myAlert('Alasan lembur harus di isi!');
            return false;
        }else if(kosongPegawai>0){
            myAlert('Data Pegawai harus di isi!');
            return false;
        }

        return requiredCheck(obj);
    }
	
function setDialogPegawai(obj){
    var tindakan_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#tindakan_untuk").val(tindakan_untuk);
    $("#dialogPegawaiBadak").dialog("open");
	var nomorindukpegawai = '';
    $.fn.yiiGridView.update('pegawaibadak-m-grid', {
        data:{
            "PegawaiM[nomorindukpegawai]":nomorindukpegawai,
        }
    });
}
	
function setPegawaiAuto(pegawai_id,is_auto,tr){
	var is_ada = false;
        
    if(is_auto != '1'){
		var tindakan_untuk = $("#tindakan_untuk").val();
		var tr = $('#'+tindakan_untuk).parents('tr');	
	}
    
    
    $("#table-pegawai tbody .pegawai_id").each(function() {
        if ($(this).val() == pegawai_id) is_ada = true;
    });
    
	if(is_ada){ //jika ada pegawai sudah ada di list
		myAlert('Pegawai sudah ada dalam list');
	}else{
		$(tr).addClass("animation-loading-1");
		$.get('<?php echo $this->createUrl('GetPegawai'); ?>',{pegawai_id: pegawai_id},function(data){
			$(tr).find('input[name$="[pegawai_id]"]').val(data[0].pegawai_id);
			$(tr).find('input[name$="[nomorindukpegawai]"]').val(data[0].nomorindukpegawai);
			$(tr).find('input[name$="[nama_pegawai]"]').val(data[0].nama_pegawai);
			$(tr).find('input[name$="[upah_bulanan]"]').val(data[0].upah_bulanan);
			$(tr).removeClass("animation-loading-1");
            hitungJam($(tr).find('input[name$="[upah_bulanan]"]'));
		},"json");
		$("#dialogPegawaiBadak").dialog("close");
	}
}


function addRow(){
    var table = $('#table-pegawai');
	var row_tindakan = '<?php echo $row; ?>';
    var last = "";
	$(table).append(row_tindakan);
	renameInputRow($('#table-pegawai'));	
    
    last = $(table).find("tbody tr:last-child");
    $(last).find(".jam").each(function() {
        var tgt_text = jQuery(this);
        var input_append = jQuery(tgt_text).parents('.input-append');
        var add_on = jQuery(input_append).find('.add-on');
        
        tgt_text.timepicker({
            timeText:"Waktu",
            hourText:"Jam",
            minuteText:"Menit",
            secondText:"Detik",
            showSecond:true,
            timeOnlyTitle:'Pilih Waktu',
            timeFormat:'hh:mm:ss',
            showAnim:'fold',
        });
        
        jQuery(tgt_text).off('focus');
        jQuery(tgt_text).on('change', function() {
            hitungJam($(this));
        });
        jQuery(add_on).on('click', function() {
            jQuery(tgt_text).timepicker('show');
        });
    });
    hitungJam($(last).find(".jam_selesai"));
    
    $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
}

function hitungJam(obj) {
    
    var jenis_lembur = $("#KPRealisasiLemburT_jenislembur :selected").data('kode');
    
	var obj_jenis = $(obj).parents('tr').find('.biayalembur_id :selected');
	var upah_bulanan = parseFloat(unformatNumber($(obj).parents('tr').find(".upah_bulanan").val()));
	
    var jam_awal = jam2time($(obj).parents('tr').find('.jam_mulai').val());
    var jam_selesai = jam2time($(obj).parents('tr').find('.jam_selesai').val());
    
    var selisih = jam_selesai - jam_awal;
    var selisih_jam = 0;
    var upahsejam = 0;
    
    
    var jam_normal = $(obj).parents('tr').find('.total_jam_normal').val();
    
    if (jenis_lembur == 'JLB-LL5') {
        $(obj).parents('tr').find('.total_jam_normal option[value=8]').prop("disabled", false);
        $(obj).parents('tr').find('.total_jam_normal option[value!=8]').prop("disabled", true);
        jam_normal = 8;
        $(obj).parents('tr').find('.total_jam_normal').val(jam_normal);
    } else if (jenis_lembur == 'JLB-LHK' || jenis_lembur == 'JLB-LLN') {
         $(obj).parents('tr').find('.total_jam_normal option[value=8]').prop("disabled", false);
        $(obj).parents('tr').find('.total_jam_normal option[value!=8]').prop("disabled", false);
    }else {
        $(obj).parents('tr').find('.total_jam_normal option[value=8]').prop("disabled", true);
        $(obj).parents('tr').find('.total_jam_normal option[value!=8]').prop("disabled", false);
        if (jam_normal == 8) {
            jam_normal = 5;
            $(obj).parents('tr').find('.total_jam_normal').val(jam_normal);
        }
    }
    
    
    if (selisih < 0) 
        selisih += (24 * 3600);
   
//    selisih_jam = Math.ceil(selisih/3600);
    selisih_jam = Math.floor(selisih/3600);    
    
    
    $(obj).parents('tr').find('.totalJam').val(selisih_jam);
     if (jenis_lembur == 'JLB-LHK') {
         upahsejam = Math.round(upah_bulanan * 1 / 173);
     }
    $(obj).parents('tr').find('.upahsejamlembur').val(formatNumber(upahsejam));
    var arr_lembur = [];
    
    if (jenis_lembur == 'JLB-LL5' || jenis_lembur == 'JLB-LL6') {
        arr_lembur = hitungNilaiLembur(jenis_lembur, selisih_jam, jam_normal, upah_bulanan);
    }else if (jenis_lembur == 'JLB-LHK'){
         arr_lembur = hitungNilaiLembur_NSHK(jenis_lembur, selisih_jam, jam_normal, upahsejam);
    }else if (jenis_lembur == 'JLB-LLN'){
         arr_lembur = hitungNilaiLembur_NSHK(jenis_lembur, selisih_jam, jam_normal, upah_bulanan);
    }
//    var arr_lembur = hitungNilaiLembur(jenis_lembur, selisih_jam, jam_normal, upah_bulanan);
    $(obj).parents('tr').find('.upah_lembur_jam1').val(formatNumber(arr_lembur[0]));
    $(obj).parents('tr').find('.upah_lembur_jam2').val(formatNumber(arr_lembur[1]));
    $(obj).parents('tr').find('.upah_lembur_jam3').val(formatNumber(arr_lembur[2]));
    
    var v_lembur = arr_lembur[0] + arr_lembur[1] + arr_lembur[2];
	
    $(obj).parents('tr').find('.totalNilai').val(formatNumber(v_lembur));
    
}

function hitungNilaiLembur_NSHK(jenis, jam_lembur, jam_normal, nilai) {
    var hasil = [0, 0, 0];
    var arr = [];
    
    if (jenis == 'JLB-LHK') {
        arr = [
            {jam: 1, multi: 1.5},
            {jam: 1, multi: 2},
            {jam: 1, multi: 2}
        ];
    } else if (jenis == 'JLB-LLN') {
        arr = [
            {jam: 5, multi: 2},
            {jam: 1, multi: 3},
            {jam: 1, multi: 4}
        ];
    }
    var jamlemburori = jam_lembur;
    for (var i = 0; i < arr.length; i++) {
        var v = arr[i];
        
         if(jamlemburori < v.jam){
             if (jenis == 'JLB-LLN') {
                 hasil[i] = Math.round(v.jam * v.multi * 1 / 173 * nilai);
             }else{
                 hasil[i] = Math.round(v.jam * v.multi * nilai);
             }
                
                break;
           }
        if (jam_lembur - v.jam < 0) {
            break;
        } 
        else {
            if (v.jam == 0) {
                 if (jenis == 'JLB-LLN') {
                      hasil[i] = Math.round(v.jam * v.multi  * 1 / 173 * nilai);
                 }else{
                      hasil[i] = Math.round(v.jam * v.multi * nilai);
                 }
               
            } else {
                if (jenis == 'JLB-LLN') {
                    hasil[i] = Math.round(v.jam * v.multi  * 1 / 173 * nilai);
                 }else{
                     hasil[i] = Math.round(v.jam * v.multi * nilai);
                 }
                
                jam_lembur = jam_lembur - v.jam;
            }
        }
    }
    return hasil;
}

function hitungNilaiLembur(jenis, jam_lembur, jam_normal, nilai) {
    
    var hasil = [0, 0, 0];
    var arr = [];
    
    var sub = 0;
    if (jam_normal == 7) {
        sub = 2;
    } else if (jam_normal == 5) {
        sub = 1;
    }
    
    if (jenis == 'JLB-LHK') {
        arr = [
            {jam: 1, multi: 1.5},
            {jam: 0, multi: 2}
        ];
    } else if (jenis == 'JLB-LL6') {
        arr = [
            {jam: jam_normal, multi: 2},
            {jam: 1, multi: 3},
            {jam: 0, multi: 4}
        ];
    } else if (jenis == 'JLB-LL5') {
        arr = [
            {jam: 8, multi: 2},
            {jam: 1, multi: 3},
            {jam: 0, multi: 4}
        ];
    } else if (jenis == 'JLB-LLN') {
        arr = [
//            {jam: 1, multi: 1.5},
//            {jam: 0, multi: 2}
            {jam: 8, multi: 2},
            {jam: 1, multi: 3},
            {jam: 0, multi: 4}
        ];
        /*
        arr = [
            {jam: 5, multi: 2},
            {jam: 1, multi: 3},
            {jam: 0, multi: 4}
        ];
        */
    }
    
    if (jam_lembur < jam_normal) {
        hasil[0] = Math.round(nilai * jam_lembur * 2 / 173);
        return hasil; 
    }
    
    for (var i = 0; i < arr.length; i++) {
        var v = arr[i];
        if (jam_lembur - v.jam < 0) {
            hasil[i] = Math.round(nilai * jam_lembur * v.multi / 173);
            break;
        } else {
            if (v.jam == 0) {
                hasil[i] = Math.round(nilai * jam_lembur * v.multi / 173);
            } else {
                hasil[i] = Math.round(nilai * v.jam * v.multi / 173);
                jam_lembur = jam_lembur - v.jam;
            }
        }
    }
    
    
    return hasil;
}

function jam2time(v) {
    
    if (typeof v == "undefined") return 0;
    
    var arr = v.trim().split(":");
    return parseInt(arr[0]*3600) + parseInt(arr[1]*60) + parseInt(arr[2]);
}

function cancelRow(obj){
	var tr = $(obj).parents('tr');
	var pegawai_id = $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val();
	if(pegawai_id != ''){
		myConfirm("Apakah Anda akan membatalkan pegawai ini?",
		"Perhatian!",
		function(r){
			if(r){
				$(tr).addClass("animation-loading-1");
				setTimeout(function(){
					$(obj).parents('tr').detach();
					renameInputRow($("#table-pegawai"));
					$(tr).removeClass("animation-loading-1");
				},400);
			}
		}); 
	}else{
		$(obj).parents('tr').detach();
		renameInputRow($("#table-pegawai"));
	}
}

function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find(".nourut").val(row + 1).prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][nourut]');
        $(this).find(".pegawai_id").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][pegawai_id]');
        $(this).find(".rencanalemburdet_id").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][rencanalemburdet_id]');
        $(this).find(".total_jam_normal").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][total_jam_normal]');
        $(this).find(".biayalembur_id").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][biayalembur_id]');
        $(this).find(".upah_bulanan").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][upah_bulanan]');
        $(this).find(".upah_lembur_jam1").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][upah_lembur_jam1]');
        $(this).find(".upah_lembur_jam2").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][upah_lembur_jam2]');
        $(this).find(".upah_lembur_jam3").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][upah_lembur_jam3]');
        
        $(this).find(".nip").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][nomorindukpegawai]');
        $(this).find(".nama_pegawai").prop('name', '<?php echo get_class($modPegawai); ?>[' + row + '][nama_pegawai]');
        
        $(this).find(".jam_mulai").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][jamMulai]');
        $(this).find(".jam_selesai").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][jamSelesai]');
        
        $(this).find(".totalJam").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][totalJam]');
        $(this).find(".totalJamNormal").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][total_jam_normal]');
        $(this).find(".totalJamKeseluruhan").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][total_jam_keseluruhan]');
        $(this).find(".nilaiLembur").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][nilaiLembur]');
        $(this).find(".totalNilai").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][totalNilai]');
        $(this).find(".alasanLembur").prop('name', '<?php echo get_class($modRealisasiLemburDetail); ?>[detail][' + row + '][alasanLembur]');
        
        /*
        $(this).find('input[name*="nourut"]').val(row+1);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
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
        */
        row++;
    });
    
}

$(document).ready(function(){
    renameInputRow($("#table-pegawai")); 
    
    setNilaiLembur();
});
</script>