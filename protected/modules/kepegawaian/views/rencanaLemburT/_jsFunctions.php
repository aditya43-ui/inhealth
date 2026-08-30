<script type="text/javascript">
$('#KPRencanaLemburT_menyetujui_nama').val('<?php echo $modRencanaLembur->menyetujui_nama ?>');
$('#KPRencanaLemburT_mengetahui_nama').val('<?php echo $modRencanaLembur->mengetahui_nama ?>');
$('#KPRencanaLemburT_pemberitugas_nama').val('<?php echo $modRencanaLembur->pemberitugas_nama ?>');
function submitPegawaiLembur()
{
	var pegawailembur_id = $('#pegawailembur_id').val();      
	var nomorindukpegawaiPegawaiLembur = $('#KPRencanaLemburT_rencana_nip').val();
    
    $('#pegawailembur_id').val("");
    $('#KPRencanaLemburT_rencana_nip').val("");
    
    if ((nomorindukpegawaiPegawaiLembur.length==0)&&(pegawailembur_id.length==0)) {
        myAlert('Silakan isi field Nama atau No. Induk Pegawai Pegawai Lembur!');
    } else {
        var karlemburNama = $("#tabelPegawaiLembur tbody").find(".karlemburNama[value="+pegawailembur_id+"]");
        var jumlahNama =  karlemburNama.length;
        
        if (jumlahNama == 0){
			$.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('getPegawaiLembur'); ?>',
                data: {pegawailembur_id: pegawailembur_id, nomorindukpegawaiPegawaiLembur: nomorindukpegawaiPegawaiLembur},
                dataType: "json",
                success:function(data){
                    $('#tabelPegawaiLembur tbody').append(data.tr);
					hitungSemua();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        }else{
            alert ('Pegawai ini sudah diinputkan!');
        }        
        
    }   
}

function print(caraPrint)
{
    var norencana = '<?php echo isset($modRencanaLembur->rencanalembur_id) ? $modRencanaLembur->rencanalembur_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&id='+norencana+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function konfirmasi()
{
    location.reload();
}

function validasiLembur(event){
    if(requiredCheck($("form"))){
        if(validasiForm(event)){
            $('#rencana-lembur-t-form').submit();
        }else{
            return false;
        }
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
        
}

function validasiForm(event)
{ 
	var tglPegawaiLembur = '';
	// var karlemburTglMulai = $("#tabelPegawaiLembur tbody").find("detailRequired[value="+tglPegawaiLembur+"]");  
	// var jumlah =  karlemburTglMulai.length;    
        var jumlah = 0; 
	var pegawai_id = $('#pegawailembur_id').val();
	var jumlah_data = $('#tabelPegawaiLembur tbody tr').length;
	if(jumlah_data <= 0){
			myAlert('Silakan isikan data rencana lembur terlebih dahulu!');
		return false;
	}
    
    var jam_kosong = false;
    $("#tabelPegawaiLembur tbody tr .jam").each(function() {
        if ($(this).val().trim() == "") {
            jam_kosong = true;
        }
    });
    
    if (jam_kosong) {
        myAlert("Jam lembur harus diisi");
        return false;
    }
	
	if($("#tabelPegawaiLembur tbody tr").length == 0){
        myAlert('Silakan isikan data pegawai!')
        return false;
    }else if(jumlah==0){        
        $('#btn_simpan').click();
        return true;        
    }else{
        alert ('Jam Mulai Tidak Boleh Kosong!');
        return false;
    }
}

function hapusBaris(obj){
    myConfirm("Apakah Anda ingin membatalkan ini?","Perhatian!",function(r){if(r){
        $(obj).parents('tr').detach();
        hitungSemua();
        $.fn.yiiGridView.update('karlembur-m-grid');
    }});
}

function hitungSemua()
{
     noUrut = 1;
     $('.noUrut').each(function() {
          $(this).val(noUrut);
          noUrut++;
     });

}
        
function remove (obj) {
    $(obj).parents('tr').remove();
    hitungSemua();
}
        
// Original JavaScript code by Chirp Internet: www.chirp.com.au 
// Please acknowledge use of this code by including this header. 
    function checkTime(field) { 
        var errorMsg = ""; 
        // regular expression to match required time format 
        re = /^(\d{1,2}):(\d{2})(:00)?([ap]m)?$/; 
        if(field.value != '') { 
            if(regs = field.value.match(re)) { 
                 
                // 24-hour time format 
                if(regs[1] > 23) { 
                    errorMsg = "Kesalahan format jam : " + regs[1] + ". Masukan jam antara 00 s.d 23 !"; 
                } 
                 
                if(!errorMsg && regs[2] > 59) { 
                    errorMsg = "Kesalahan format menit: " + regs[2] + ". Masukan menit antara 00 s.d 59 !"; 
                } 
            } else { 
                errorMsg = "Kesalahan format waktu: " + field.value + ". Masukan jam dan waktu antara 00:00 s.d 23:59 !"; 
            } 
       } 
       if(errorMsg != "") { 
           myAlert(errorMsg);
           field.value = "";
           field.focus();
           return false; 
       } 
       return true; 
}
        
        
//function validasiSelisihJam(jm,js){
//       jm = jm.split(/:/);
//       js = js.split(/:/);
//       
//       if (jm[0] < js[0] || (jm[0] == js[0] && jm[1] < js[1])){
//            return true;
//        }else{
//            myAlert('Jam Selesai harus lebih besar dari Jam Mulai!');
//            
//            return false;
//        }
//    }
</script>