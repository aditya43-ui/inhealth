<script type="text/javascript">
function peralatanBarang(){
	var peralatan = $('#jenis_peralatan').val();
	if(peralatan == "Peralatan"){
		$('#peralatan').show();
		$('#linen').hide();	
		resetDropdown();
	}else{
		$('#linen').show();
		$('#peralatan').hide();
		resetDropdown();
	}
}	

function resetDropdown(){
	 $("#barang_id").val("");
	 $("#linen_id").val("");
	 $("#namaPeralatan").val("");
	 $("#namalinen").val("");
}

function inputPeralatanLinen(){
	var peralatansterilisasi_id = $('#peralatansterilisasi_id').val();	
	var jumlah = $('#jml').val();
        var keadaanperalatan = $('#keadaanperalatan option:selected').val();
        var jenisperalatan = $('#jenisperalatan option:selected').val();
        
	if (!jQuery.isNumeric(peralatansterilisasi_id)){
		myAlert('Peralatan belum dipilih!');
		return false;
	}else if (!jQuery.isNumeric(jumlah)){
		myAlert('Silakan tentukan jumlah yang akan diajukan!');
		return false;
        }else  if (keadaanperalatan == ''){
                myAlert('Keadaan belum dipilih!');
		return false;
	}else{
            var count = 0;
            var countKeadaan = 0;
            
            $('#table-linen > tbody > tr').each(function(){
                if ($(this).find('.peralatan_id').val() == peralatansterilisasi_id){
                    count++;
                }
                
                if (keadaanperalatan != $(this).find('.keaadaan').val()){
                    countKeadaan++;
                }
            });
            
            if (count > 0){
                myAlert("Peralatan sudah ditambahkan");
                return false;
            }else{            
                
                 if (countKeadaan > 0){
                    myAlert("Keadaan tidak boleh berbeda, dengan data yang sebelumnya sudah ditambahkan");
                    return false;
                }else{ 
                
                
                    $('#table-linen').addClass("animation-loading");
                    $.ajax({
                        type:'POST',
                        url:'<?php echo $this->createUrl('loadFormLine'); ?>',
                        data: {keadaanperalatan:keadaanperalatan, peralatansterilisasi_id:peralatansterilisasi_id, jumlah:jumlah,jenisperalatan:jenisperalatan},
                        dataType: "json",
                        success:function(data){
                            $('#table-linen > tbody').append(data.form);
                            $('#table-linen').removeClass("animation-loading");
                            $("#table-linen").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                            );
                            cekRow();
                            renameInputRowBarang($("#table-linen"));
                            clear();
                        },
                        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                    });
                }
                
            }
                $('#table-linen').removeClass("animation-loading");
	}        
}
/**
* rename input grid
*/ 
function renameInputRowBarang(obj_table){
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

function clear(){
//	$('#formLinen').find('input, select').each(function(){
//		$(this).val('');
//	});
	$('#formLinen').find('input').each(function(){
		$(this).val('');
	});
	$('#jml').val(1);
}

function batalLinen(obj){
    myConfirm('Apakah Anda akan membatalkan peralatan sterilisasi ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			renameInputRowBarang();
			cekRow();
        }
    });
}

function cekRow(){
	var jmlRow = $('#table-linen tbody tr').length;
	if(jmlRow === 0){
		$('#jenis_peralatan').attr('disabled',false);
	}else{
		$('#jenis_peralatan').attr('disabled',true);
	}
}
function print(caraPrint)
{
    var pengajuansterlilisasi_id = '<?php echo isset($_GET['pengajuansterlilisasi_id']) ? $_GET['pengajuansterlilisasi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pengajuansterlilisasi_id='+pengajuansterlilisasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekPengiriman(){

    if(requiredCheck($('#cspengajuansterilisasi-t-form'))){
        var jmlRow = $('#table-linen tbody tr').length;
        if(jmlRow === 0){
            myAlert('Peralatan dan Linen belum dipilih');
            return false;
        }else{
            $("#cspengajuansterilisasi-t-form").submit();
            return false;
        }
        return false;
    }
}

function refreshDialog(){      
    $("#namaperalatan").addClass('animation-loading-1');
    
    var jenisperalatan = $("#jenisperalatan option:selected").text();
    
    
    if (jenisperalatan == "-- Pilih --"){
            jenisperalatan = "(Jenis Peralatan Belum Dipilih)";
    }
    
    
    $("#namaperalatan_dialog").html(jenisperalatan);
    
    
    
    
    setTimeout(function(){                                
            $("#namaperalatan").removeClass('animation-loading-1');
            var jenis = $('#jenisperalatan option:selected').val();        

            $(".dialog_jenisperalatan").val(jenis);                            
            
            if (jenis == '<?php echo Params::JENIS_PERALATAN_LINEN ?>'){
                $("#ganti-judul").html("Linen");
            }else if (jenis == '<?php echo Params::JENIS_PERALATAN_BARANG ?>'){
                $("#ganti-judul").html("Barang");
            }else if (jenis == '<?php echo Params::JENIS_PERALATAN_ALATMEDIS ?>'){
                
            }
            
            $.fn.yiiGridView.update('peralatan-m-grid', {
                    data: {
                            "PeralatansterilisasiM[jenisperalatan]":jenis,			
                    }
            });
    },500);
}

$('#tombolPeralatan').click(function(){
    var jenis = $('#jenisperalatan').val();
    
    if (jenis == ''){        
        $("#dialogPeralatan").dialog("close");
        myAlert("Jenis peralatan belum dipilih!");
    }
});

$( document ).ready(function(){
  cekDisabled($('#cspengajuansterilisasi-t-form'));
});

</script>