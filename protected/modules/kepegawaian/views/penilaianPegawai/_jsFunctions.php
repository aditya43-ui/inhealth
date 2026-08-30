<?php 
    $baseUrl = Yii::app()->createUrl("/");
    $gets = '';
?>
<script type='text/javascript'>

function setTingkatPenilaian(params){
    setIndikator();
}

function setDataPegawai(params){
$("#form-pegawai > div").addClass("animation-loading");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('getDataPegawai');?>",
    data: {idPegawai:params},
    dataType: "json",
    success:function(data){
        $("#nomorindukpegawai").val(data.nomorindukpegawai);
        $("#KPPenilaianpegawaiT_pegawai_id").val(data.pegawai_id);
		$("#KPPenilaianpegawaiT_jabatan_id").val(data.jabatan_id);
		$("#KPPenilaianpegawaiT_kategoripegawai").val(data.kategoripegawai);
        $("#namapegawai").val(data.nama_pegawai);
        $("#tempatlahir_pegawai").val(data.tempatlahir_pegawai);
        $("#tgl_lahirpegawai").val(data.tgl_lahirpegawai);
        $("#jabatan").val(data.jabatan_nama);
        $("#jabatan_id").val(data.jabatan_id);
        $("#jeniskelamin").val(data.jeniskelamin);
        $("#statusperkawinan").val(data.statusperkawinan);
        $("#alamat_pegawai").val(data.alamat_pegawai);
        if(data.photopegawai != ""){
            var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
            $("#photo_pasien").attr('src', url);
        } else {
            var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
            $("#photo_pasien").attr('src',url);
        }  
        
        $("#form-pegawai > legend > .judul").html('Data Pegawai '+data.nomorindukpegawai);
        $("#form-pegawai > legend > .tombol").attr('style','display:true;');
      //  $("#form-pegawai").removeClass("box").addClass("well");
        
        $("#form-pegawai > div").removeClass("animation-loading");
        $("#nomorindukpegawai").focus();        
		setIndikator();
    },
    error: function (jqXHR, textStatus, errorThrown) { 
        myAlert("Data pegawai tidak ditemukan!"); 
        console.log(errorThrown);
        setPegawaiReset();
        $("#form-pegawai > div").removeClass("animation-loading");
        $("#nomorindukpegawai").focus();
    }
});
}

function setPegawaiReset(){
    $("#nomorindukpegawai").val("");
    $("#KPPenilaianpegawaiT_pegawai_id").val("");
    $("#namapegawai").val("");
    $("#tempatlahir_pegawai").val("");
    $("#tgl_lahirpegawai").val("");
    $("#jabatan").val("");
    $("#jeniskelamin").val("");
    $("#statusperkawinan").val("");
    $("#alamat_pegawai").val("");
    var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
    $("#photo_pasien").attr('src',url);
    $("#form-pegawai > legend > .judul").html('Data Pegawai');
    $("#form-pegawai > legend > .tombol").attr('style','display:none;');
    $("#form-pegawai").removeClass("well").addClass("box");
    $("#form-pegawai > div").removeClass("animation-loading");
    $("#nomorindukpegawai").focus();
}

function setDataPenilai(params){
$("#form-datapenilai").addClass("animation-loading-1");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('getDataPegawai');?>",
    data: {idPegawai:params},
    dataType: "json",
    success:function(data){
        $("#penilainama").val(data.nama_lengkap);
		$("#KPPenilaianpegawaiT_penilainip").val(data.nomorindukpegawai);
		$("#KPPenilaianpegawaiT_penilaijabatan").val(data.jabatan_nama);
		$("#KPPenilaianpegawaiT_penilaiunitorganisasi").val(data.unit_perusahaan);  
        $("#form-datapenilai .tombol").attr('style','display:true;');
        $("#form-datapenilai").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    },
    error: function (jqXHR, textStatus, errorThrown) { 
        myAlert("Data pegawai tidak ditemukan!"); 
        console.log(errorThrown);
        setPenilaiReset();
        $("#form-datapenilai > div").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    }
});
}

function setPenilaiReset(){
	$("#form-datapenilai").addClass("animation-loading-1");
	$("#penilainama").val("");
	$("#KPPenilaianpegawaiT_penilainip").val("");
	$("#KPPenilaianpegawaiT_penilaijabatan").val("");
	$("#KPPenilaianpegawaiT_penilaiunitorganisasi").val("");
	$("#form-datapenilai .tombol").attr('style','display:none;');
	setTimeout(function(){
		$("#form-datapenilai").removeClass("animation-loading-1");
	},500);
}

function setDataPimpinan(params){
$("#form-datapimpinan").addClass("animation-loading-1");
$.ajax({
    type:'POST',
    url:"<?php echo $this->createUrl('getDataPegawai');?>",
    data: {idPegawai:params},
    dataType: "json",
    success:function(data){
        $("#pimpinannama").val(data.nama_lengkap);
		$("#KPPenilaianpegawaiT_pimpinannip").val(data.nomorindukpegawai);
		$("#KPPenilaianpegawaiT_pimpinanjabatan").val(data.jabatan_nama);
		$("#KPPenilaianpegawaiT_pimpinanunitorganisasi").val(data.unit_perusahaan);  
        $("#form-datapimpinan .tombol").attr('style','display:true;');
        $("#form-datapimpinan").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    },
    error: function (jqXHR, textStatus, errorThrown) { 
        myAlert("Data pegawai tidak ditemukan!"); 
        console.log(errorThrown);
        setPimpinanReset();
        $("#form-datapimpinan > div").removeClass("animation-loading-1");
        $("#pimpinannama").focus();
    }
});
}

function setPimpinanReset(){
	$("#form-datapimpinan").addClass("animation-loading-1");
	$("#pimpinannama").val("");
	$("#KPPenilaianpegawaiT_pimpinannip").val("");
	$("#KPPenilaianpegawaiT_pimpinanjabatan").val("");
	$("#KPPenilaianpegawaiT_pimpinanunitorganisasi").val("");
	$("#form-datapimpinan .tombol").attr('style','display:none;');
	setTimeout(function(){
		$("#form-datapimpinan").removeClass("animation-loading-1");
	},500);
}

function cekValiditas(){
	if(requiredCheck($("form"))){
		var cekrating = true;
		var cekscore = true;
		$(".tablepenilaian > tbody > tr").each(function(){
			var rating = $(this).find('input[type=radio]:checked').val();
				if(rating){
					cekrating &= true;
				}else{
					cekrating &= false;
				}
			var score = $(this).find('input[name*="[penilaianpegdet_socre]"]').val();
				if(score == ''){
					cekscore &= false;
				}
		});
		if((cekscore == true)){
			$('#sapegawai-m-form').submit();
			$(".animation-loading").removeClass("animation-loading");
			$("form").find('.float').each(function(){
				$(this).val(formatFloat($(this).val()));
			});
			$("form").find('.integer').each(function(){
				$(this).val(formatInteger($(this).val()));
			});
		}else{
			myAlert('Rating dan Score tidak boleh kosong');
		}
		
        
    }
    return false;
}

function setPlaceholder(obj){
	var awal = $(obj).parents('td').find('input[name*="[kolomrating_uraian]"]').val();
	var akhir = $(obj).parents('td').find('input[name*="[kolomrating_deskripsi]"]').val();
	var placeholder = "("+awal+"~"+akhir+")";
	var obj_score = $(obj).parents('tr').find('input[name*="[penilaianpegdet_socre]"');
	obj_score.attr('readonly',false);
	obj_score.val('');
	obj_score.attr('placeholder',placeholder);
	obj_score.focus();
}

function setKolomRating(obj,trke){
	var point = $(obj).parents('td').find('input[name*="[kolomrating_point]"]').val();
	var total_point = 0;
	var jmlrow = $(".tablepenilaian > tbody > tr").length;
	$('#KPPenilaianpegawaidetT_'+trke+'_kolomrating_id').val(obj.value);
	$('#KPPenilaianpegawaidetT_'+trke+'_penilaianpegdet_socre').val(point);
	
	$(".tablepenilaian > tbody > tr").each(function(){
		var score = parseFloat($(this).find('input[name*="[penilaianpegdet_socre]"]').val());
		if(isNaN(score)){ score = 0; }
		total_point += score;
	});
	$("#<?php echo CHtml::activeId($model, 'jumlahpenilaian') ?>").val(total_point);
	$("#<?php echo CHtml::activeId($model, 'nilairatapenilaian') ?>").val((total_point/jmlrow).toFixed(2));
}


function cekScore(obj,label,aspek){
	var nilai = obj.value;
	var kolomrating_id = $(obj).parents('td').find('input[name*="[kolomrating_id]"').val();
	var indikator = $(obj).parents('tr').find('input[name*="[indikatorperilaku_id]"').val();
	var obj_totalscore = $(obj).parents('table').find('input[name*="[jumlahpenilaian]"');
	var obj_ratarata = $(obj).parents('table').find('input[name*="[nilairatapenilaian]"');
	var totalscore = 0;
	var ratarata = 0;
	var jumlahrows = $(".tablepenilaian > tbody > tr").length;
        var totalbobotnilai_indikator = 0;
        
        console.log(indikator);
        
	$(".tablepenilaian > tfoot > tr").find('input[name*="[jumlahpenilaian]"').addClass("animation-loading-1");
	$(".tablepenilaian > tfoot > tr").find('input[name*="[nilairatapenilaian]"').addClass("animation-loading-1");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('CekScore'); ?>',
		data: {nilai : nilai,indikator:indikator},
		dataType: "json",
		success:function(data){
//                        $(obj).parents('tr').find('textarea[name*="[keterangan]"').val(data.pesanSkor);
			$(obj).parents('tr').find('.pesan').html(data.pesanSkor);
			$(obj).parents('tr').find('input[name*="[kolomrating_id]"').val(data.rating_id);
			$(obj).parents('tr').find('input[name*="[point]"').val(data.point);
			if(data.pesan != ''){
				myAlert(data.pesan);
				$(obj).val('');
				$(obj).focus();
			}else{
				$("[id^="+label+"-]").each(function(){
					var score = parseFloat($(this).find('input[name*="[penilaianpegdet_socre]"]').val());
                                        var bobot_indikator = parseFloat($(this).find('input[name*="[bobotnilai_indikator]"]').val());
					if(isNaN(score)){ score = 0; }                                    
					totalscore += score;
                                        if(isNaN(bobot_indikator)){ bobot_indikator = 0; }
                                        totalbobotnilai_indikator += bobot_indikator;
				});

				var jumlahrows = $("[id^="+label+"-]").length;

				$("#subJumlah"+label).val(totalscore);
				//$("#rataRata"+label).val(Math.round(totalscore/jumlahrows));//.toFixed(2)
                                //
//				$("#rataRata"+label).val((totalscore/jumlahrows).toFixed(2)); //RSPMC-686

                                var bobot_penilaian = parseFloat($("#jmlBobotPenilaian"+label).val());
                                if(totalbobotnilai_indikator > 0){
                                    $("#rataRata"+label).val((totalscore/totalbobotnilai_indikator).toFixed(2));
                                    $("#jmlBobotIndikator"+label).val(totalbobotnilai_indikator);
                                    $("#nilaiAspek"+label).val(((totalscore/totalbobotnilai_indikator) * (bobot_penilaian/100)).toFixed(2));
                                }else{
                                    $("#rataRata"+label).val(0);
                                    $("#jmlBobotIndikator"+label).val(0);
                                    $("#nilaiAspek"+label).val(0);
                                }
                                
//                                $("#nilaiAspek"+label).val(((totalscore/totalbobotnilai_indikator) * bobot_penilaian).toFixed(2)); //RSPMC-686
                                

				jumlahrows = 0;
				totalscore = 0;

				$("[id^="+aspek+"-]").each(function(){
					var score = parseFloat($(this).find('input[name*="[penilaianpegdet_socre]"]').val());
					if(isNaN(score)){ score = 0; }                                    
					totalscore += score;
				});                                                               
				
				var jumlahrowsRata = 0;
				var totalscoreRata = 0;
				
				$("[id^=rataRata"+aspek+"-]").each(function(){
					var score = parseFloat($(this).val());
					if(isNaN(score)){ score = 0; }                                    
					totalscoreRata += score;
				});                                                               
				
				var jumlahrowsSub = 0;
				var totalscoreSub = 0;
				
				$("[id^=subJumlah"+aspek+"-]").each(function(){
					var score = parseFloat($(this).val());
					if(isNaN(score)){ score = 0; }                                    
					totalscoreSub += score;
				});    
                                
                                var jumlahrowsAspek = 0;
				var totalscoreAspek = 0;
				
				$("[id^=nilaiAspek"+aspek+"-]").each(function(){
					var score = parseFloat($(this).val());
					if(isNaN(score)){ score = 0; }                                    
					totalscoreAspek += score;
				});
				

				var jumlahrows = $("[id^="+aspek+"-]").length;
				 jumlahrowsRata = $("[id^=rataRata"+aspek+"-]").length;
				 jumlahrowsSub = $("[id^=subJumlah"+aspek+"-]").length;
                                 jumlahrowsAspek = $("[id^=nilaiAspek"+aspek+"-]").length;

				$("#totalJumlah"+aspek).val(totalscoreSub);
				//$("#totalRataRata"+aspek).val(Math.round(totalscore/jumlahrows));
				$("#totalRataRata"+aspek).val( (totalscoreRata/jumlahrowsRata).toFixed(2));
				//$("#totalKeseluruhan-"+aspek).val(Math.round(totalscore/jumlahrows));
                                //
//				$("#totalKeseluruhan-"+aspek).val((totalscoreRata/jumlahrowsRata).toFixed(2)); //RSPMC-686
                                $("#totalKeseluruhan-"+aspek).val((totalscoreAspek).toFixed(2));
                                
				//var tot = Math.round(totalscore/jumlahrows);
				var tot = ( (totalscore/jumlahrows).toFixed(2));

				var grand = 0;
				$("[id^=totalKeseluruhan-]").each(function()
				{
					var score = parseFloat($(this).val());   
					if(isNaN(score)){ score = 0; }     
					grand += score;
				});

				//$("#grandTotal").val(grand);
				$("#<?php echo CHtml::activeId($model, 'jumlahpenilaian') ?>").val(grand);
				//$("#grandAverage").val(Math.round(grand/parseInt($("#totalJenis").val())));
				$("#<?php echo CHtml::activeId($model, 'nilairatapenilaian') ?>").val((grand/parseFloat($("#totalJenis").val())).toFixed(2));

				//var avg = parseInt($("#grandAverage").val());
				var avg = parseInt($("#<?php echo CHtml::activeId($model, 'nilairatapenilaian') ?>").val());

				$("[id^=ketNilai-]").each(function()
				{
					var min = parseInt($(this).attr('min'));
					var max = parseInt($(this).attr('max'));

					if ( (tot.toFixed(0) >= min) && (tot.toFixed(0) <= max) ){
						$(".stket-"+aspek).html($(this).attr('keterangan'));										
					}

					if ( (avg.toFixed(0) >= min) && (avg.toFixed(0) <= max) ){
						$(".grandKet").html($(this).attr('keterangan'));										
					}
				});
                                
				//$(".tablepenilaian > tbody > tr").each(function(){
				//	var score = parseFloat($(this).find('input[name*="[point]"]').val());
                                  //      if(isNaN(score)){ score = 0; }
				//	totalscore += score;
				//});
				//obj_totalscore.val(totalscore);
				//obj_ratarata.val(Math.round(totalscore/jumlahrows));
			}
			$(".tablepenilaian > tfoot > tr").find('input[name*="[jumlahpenilaian]"').removeClass("animation-loading-1");
			$(".tablepenilaian > tfoot > tr").find('input[name*="[nilairatapenilaian]"').removeClass("animation-loading-1");
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

$("input[type=radio]").on("click",function() {
	var obj_kolomrating_id = $(this).parents('tr').find('input[name*="[kolomrating_id]"');
	$(this).parents('tr').find("input[type=radio]:checked").each(function() {
		obj_kolomrating_id.val(this.value);
	});
});

function loadDataAfterSave(penilaianpegawai_id){
	var table = $(".tablepenilaian > tbody > tr");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('LoadDataAfterSave'); ?>',
		data: {penilaianpegawai_id : penilaianpegawai_id},
		dataType: "json",
		success:function(data){
			setDataPegawai(data.modPenilaianPegawai.pegawai_id);
			setDataPenilai(data.penilai.pegawai_id);
			setDataPimpinan(data.modPenilaianPegawai.pegawai_id);
			table.each(function(index){
				var kolomrating_id = data.modPenilaianPegawaiDet[index].kolomrating_id;
				var penilaianpegdet_socre = data.modPenilaianPegawaiDet[index].penilaianpegdet_socre;
				var obj_radio = $(this).find("input[type=radio]");
				var obj_score = $(this).find('input[name*="[penilaianpegdet_socre]"]');
				if ((penilaianpegdet_socre-1) > 0) {
					var element_id = 'radiorating['+index+']['+(penilaianpegdet_socre-1)+']';
					document.getElementById(element_id).checked = true;
					obj_score.val(penilaianpegdet_socre);
					obj_radio.attr('disabled',true);
				}
			});
			$('#KPPenilaianpegawaiT_jumlahpenilaian').val(data.modPenilaianPegawai.jumlahpenilaian);
			$('#KPPenilaianpegawaiT_nilairatapenilaian').val(data.modPenilaianPegawai.nilairatapenilaian);
			
			$('#KPPenilaianpegawaiT_periodepenilaian').val(data.modPenilaianPegawai.periodepenilaian);
			$('#KPPenilaianpegawaiT_sampaidengan').val(data.modPenilaianPegawai.sampaidengan);
			$('#KPPenilaianpegawaiT_keterangan_score').val(data.modPenilaianPegawai.keterangan_score);
			$('#KPPenilaianpegawaiT_performanceindex').val(data.modPenilaianPegawai.performanceindex);
			$('#KPPenilaianpegawaiT_tanggal_tanggapanpejabat').val(data.modPenilaianPegawai.tanggal_tanggapanpejabat);
			$('#KPPenilaianpegawaiT_tanggapanpejabat').val(data.modPenilaianPegawai.tanggapanpejabat);
			$('#KPPenilaianpegawaiT_tanggal_keputusanatasan').val(data.modPenilaianPegawai.tanggal_keputusanatasan);
			$('#KPPenilaianpegawaiT_keputusanatasan').val(data.modPenilaianPegawai.keputusanatasan);
			$('#KPPenilaianpegawaiT_tanggal_keberatanpegawai').val(data.modPenilaianPegawai.tanggal_keberatanpegawai);
			$('#KPPenilaianpegawaiT_keberatanpegawai').val(data.modPenilaianPegawai.keberatanpegawai);
			$('#KPPenilaianpegawaiT_penilaianpegawai_keterangan').val(data.modPenilaianPegawai.penilaianpegawai_keterangan);
			$('#KPPenilaianpegawaiT_diterimatanggalpegawai').val(data.modPenilaianPegawai.diterimatanggalpegawai);
			$('#KPPenilaianpegawaiT_diterimatanggalatasan').val(data.modPenilaianPegawai.diterimatanggalatasan);
			$('#fieldset-tabelpenilaian').addClass('well');
			$('#fieldset-datapenilaian').addClass('well');
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function hitungMundur(durasi, tampil) {
    var timer = durasi, menit, detik;
    setInterval(function () {
        menit = parseInt(timer / 60, 10)
        detik = parseInt(timer % 60, 10);

        menit = menit < 10 ? "0" + menit : menit;
        detik = detik < 10 ? "0" + detik : detik;

        tampil.text(menit + ":" + detik);

        if (--timer < 0) {
			alert('Waktu pengisian habis, halaman ini akan reload otomatis.');
			location.reload();
			timer = durasi;
        }
    }, 1000);
}
// Diset 30menit
jQuery(function ($) {
	<?php if(!isset($_GET['sukses'])){ ?>
		/*myConfirm("Pengisian Form ini hanya diberi waktu selama 30 menit?","Perhatian!",function(r) {
			if (r){
				var setelahJam = 60 * 30,
				tampil = $('#time');
				hitungMundur(setelahJam, tampil);
			}else{
				location.reload();
			}
		});*/
	<?php } ?>
});

function print(caraPrint){
    var penilaianpegawai_id = '<?php echo isset($_GET['penilaianpegawai_id']) ? $_GET['penilaianpegawai_id'] : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penilaianpegawai_id='+penilaianpegawai_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640,scrollbars=1');
}

<?php if(isset($_GET['penilaianpegawai_id'])){ ?>
	//loadDataAfterSave(<?php echo $_GET['penilaianpegawai_id'] ?>);
<?php } ?>

function setReadOnly(){
	$('#nomorindukpegawai').attr('readonly',true);
	$('#namapegawai').attr('readonly',true);
	$('#KPPenilaianpegawaiT_tglpenilaian').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
	$('#').attr('readonly',true);
}

/**
 * - digunakan untuk mengenerate data master jenis penilaian, kompetensi, indikator dan kolom rating
 * @returns {}
 */
function setIndikator(){
    
    var jabatan_id = $("#jabatan_id").val();
	var awal = $("#<?php echo CHtml::activeId($model, 'periodepenilaian') ?>").val();
	var akhir = $("#<?php echo CHtml::activeId($model, 'sampaidengan') ?>").val();
	var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
        var tingkatpenilaian = $("#<?php echo CHtml::activeId($model, 'tingkatpenilaian') ?>").val();
        
    if (pegawai_id != ''){
				
		$("#generateEvaluasi").addClass("animation-loading");
		$.ajax({
			type:'POST',
			url:"<?php echo $this->createUrl('GenerateFormulir');?>",
			data: {jabatan_id:jabatan_id,awal:awal,akhir:akhir,pegawai_id:pegawai_id,tingkatpenilaian:tingkatpenilaian},
			dataType: "json",
			success:function(data){
				if (data.sukses == 1){
					$("#generateEvaluasi").removeClass("animation-loading");
					$("#generateEvaluasi").html(data.tr);
				}else{
					$("#generateEvaluasi").removeClass("animation-loading");
					$("#generateEvaluasi").html(data.tr);
					alert(data.pesan);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {             
				console.log(errorThrown);            
				$("#generateEvaluasi").removeClass("animation-loading");
				$("#generateEvaluasi").html('');
			}
		});
	}else{
		alert("Maaf, Data Pegawai Belum Dipilih");
	}
}

function cekData(obj){

	// var tr = $(".tablepenilaian > tbody > tr");	
	
	// if (tr.length > 0){
	// 	if (requiredCheck($("#sapegawai-m-form"))){
	// 		$('#sapegawai-m-form').submit();
	// 	}else{
	// 		return false;
	// 	}
	// }else{
	// 	alert("Maaf, Data pada penilaian pegawai pada tabel penilaian belum diisi");
	// 	return false;
	// }
	if (requiredCheck($("#sapegawai-m-form"))){
			$('#sapegawai-m-form').submit();
		}else{
			return false;
		}
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    <?php if(isset($_GET['id'])){ ?>
            $("#form-pegawai .add-on").remove();
//            $("#fieldset-datapenilaian .add-on").remove();
			setReadOnly();
    <?php } ?>
		
	
		
	//jQuery("div.range_inputs").on('click', 'button.applyBtn', function() {		
	//	setIndikator();
	//});
		
});	
</script>