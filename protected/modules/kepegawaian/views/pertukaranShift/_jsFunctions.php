<script type="text/javascript">
/**
* rename input grid
*/ 
function renameInput(obj_table){
	var row = 0;
	$(obj_table).find("tbody > tr").each(function(){
		$(this).find("#row").val(row);
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

/**
 * menentukan tujuan baris dari button dialog 
 **/
function setDialogPegawai(obj,judul){
	var pegawai_id = '';
    var row = $(obj).parents('tr').find('input').val();
    $("#untuk_row").val(row);
    //var pegawai_untuk = $(obj).parent().parent().find('input').attr('id');
	var pegawai_untuk = "KPPertukaranjadwaldetT_"+row+"_nomorindukpegawai";
    //var pegawai_untukid = $(obj).parent().parent().parent().find('input').attr('id');
	var pegawai_untukid = "KPPertukaranjadwaldetT_"+row+"_pegawai_id";
	//var pegawai_untuknm = $(obj).parent().parent().parent().next('td').find('input').attr('id');
	var pegawai_untuknm = "KPPertukaranjadwaldetT_"+row+"_nama_pegawai";
  //  var pegawai_untuktgl = $(obj).parent().parent().parent().prev('td').find('input').attr('id');
    var pegawai_untukjadwalid = "KPPertukaranjadwaldetT_"+row+"_penjadwalan_id";
	var pegawai_untukjadwaldetailid = "KPPertukaranjadwaldetT_"+row+"_penjadwalandetail_id";
    var pegawai_untukshift = "KPPertukaranjadwaldetT_"+row+"_shiftasal_id";
	var pegawai_untukshifttukar = "KPPertukaranjadwaldetT_"+row+"_shift_id";
	var tukar_tgl = "KPPertukaranjadwaldetT_"+row+"_tglpertukaranjadwal";		

	

	$("#dialog_pegawai #pegawai_untuk").val(pegawai_untuk);
	$("#dialog_pegawai #pegawai_untukid").val(pegawai_untukid);
	$("#dialog_pegawai #pegawai_untuknm").val(pegawai_untuknm);
	$("#dialog_pegawai #pegawai_untuktgl").val(tukar_tgl);
	$("#dialog_pegawai #pegawai_untukshift").val(pegawai_untukshift);
	$("#dialog_pegawai #pegawai_untukjadwalid").val(pegawai_untukjadwalid);
	$("#dialog_pegawai #pegawai_untukjadwaldetailid").val(pegawai_untukjadwaldetailid);
	$("#dialog_pegawai #pegawai_untukshifttukar").val(pegawai_untukshifttukar);
	
    $("#ui-dialog-title-dialog_pegawai").html(judul);
    $("#dialog_pegawai > div").addClass("animation-loading");
    $("#dialog_pegawai").dialog("open");
    $.fn.yiiGridView.update('pegawai-grid', {
        data: $(this).serialize()
    });
}

/**
 * jika dipilih dari dialogbox
 */
function pilihPegawai(pegawai_id, nama_pegawai, nomorindukpegawai){
    var untuk_id = $("#pegawai_untuk").val();	
    var untuk_peg_id = $("#pegawai_untukid").val();	
    var untuk_peg_nama = $("#pegawai_untuknm").val();	
	var cekPegawai = 0;
		    	
	$("#tabel-pertukaran").each(function(){
		if ($(this).find('.datapegawai').val() == pegawai_id){
			cekPegawai++;
		}
	});
	
	if (cekPegawai < 1){
		$("#"+untuk_id).val(nomorindukpegawai);
		$("#"+untuk_peg_id).val(pegawai_id);
		$("#"+untuk_peg_nama).val(nama_pegawai);
		getShift(pegawai_id);
	}else{
		myAlert("Pegawai <b>"+nama_pegawai+"</b> sudah ditambahkan pada tabel")
		return false;
	}
}

/**
* untuk mengambil data shift
*/
function getShift(pegawai_id){
	var untuk_id = $("#pegawai_untuk").val();	
    var untuk_peg_id = $("#pegawai_untukid").val();	
    var untuk_peg_nama = $("#pegawai_untuknm").val();    
    var untuk_shift_id = $("#pegawai_untukshift").val();
	var untuk_shifttukar = $("#pegawai_untukshifttukar").val();
    var untuk_jadwalid = $("#pegawai_untukjadwalid").val();	
	var untuk_jadwaldetailid = $("#pegawai_untukjadwaldetailid").val();	
	var untuk_tgltukar = $("#pegawai_untuktgl").val();			  
	var tglshift = $("#"+untuk_tgltukar).val();
			
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('getDataShift'); ?>',
		data: {pegawai_id:pegawai_id,tglshift:tglshift},
		dataType: "json",
			success:function(data){
			if(data.pesan != ''){
				myAlert(data.pesan);
				$("#"+untuk_id).val('');
				$("#"+untuk_peg_id).val('');
				$("#"+untuk_peg_nama).val('');
				return false;
			}else{									
				$("#"+untuk_shift_id).html(data.dropdownShiftAsal);
				$("#"+untuk_shifttukar).html(data.dropdownShiftTukar);
				$("#"+untuk_jadwalid).val(data.penjadwalan_id);				
				$("#"+untuk_jadwaldetailid).val(data.penjadwalandetail_id);
				renameInput($("#tabel-pertukaran")); 
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function validasiCek(){
    if(requiredCheck($("form"))){
		var kosong=0;
		var keterangan=0;
		var shift=0;
		var ket=[];
		var shiftasal=[];
		var shifttukar=[];
		var row = 1;
		$('#tabel-pertukaran > tbody > tr').each(function(){
			var nama_pegawai = $(this).find('input[name*="[pegawai_id]"]').val();
			var keterangan = $(this).find('select[name*="[ketranganpertukaran]"] option:selected').val();
			var sawal = $(this).find('select[name*="[shiftasal_id]"] option:selected').val();
			var stuker = $(this).find('select[name*="[shift_id]"] option:selected').val();
			
			if(nama_pegawai == ''){
				kosong++;
			}
			
			ket[row] = keterangan;
			shiftasal[row] = sawal;
			shifttukar[row] = stuker;
				
			row++;
		});

		if(kosong > 0){
			myAlert('Data pegawai pada tabel pertukaran shift belum di load.');
			return false;
		}else{
			if (ket[1] == ket[2]){
				myAlert('Kolom Keterangan pada tabel, datanya tidak boleh sama dengan baris selanjutnya');
				return false;
			}else{
				//alert(shiftasal[1]+' '+shifttukar[2]);
				//alert(shiftasal[2]+' '+shifttukar[1]);
				if ( (shiftasal[1] != shifttukar[2]) || (shiftasal[2] != shifttukar[1]) ){
					myAlert(" Pada tabel, data shift asal orang yang mengajukan harus sama dengan perubahan shift orang yang menggantikan  ");
					return false;
				}else{
					$('#kppenjadwalan-t-form').submit();
				}
			}
									
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

/**
* untuk print pertukaran shift
 */
function print(caraPrint)
{
    var pertukaranjadwal_id = '<?php echo $model->pertukaranjadwal_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pertukaranjadwal_id='+pertukaranjadwal_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	var table = $('#tabel-pertukaran');
	renameInput($('#tabel-pertukaran'));
    //== set autocomplete daftartindakan
    $(table).find('input[name$="[nomorindukpegawai]"]').each(function(){
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':2,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {
                    $(this).val(ui.item.nomorindukpegawai);
                    $(this).parents('tr').find('input[name$="[pegawai_id]"]').val(ui.item.pegawai_id);
                    $(this).parents('tr').find('input[name$="[nama_pegawai]"]').val(ui.item.nama_pegawai);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompletePegawai');?>",
                        dataType: "json",
                        data:{
                            nomorindukpegawai: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });
	$(table).find('input[name$="[nama_pegawai]"]').each(function(){
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':2,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {
                    $(this).val(ui.item.nomorindukpegawai);
                    $(this).parents('tr').find('input[name$="[pegawai_id]"]').val(ui.item.pegawai_id);
                    $(this).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(ui.item.nomorindukpegawai);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompletePegawai');?>",
                        dataType: "json",
                        data:{
                            nama_pegawai: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });
	//set input datetime
	/*$(table).find('input[name$="[tglpertukaranjadwal]"]').each(function(){
        $(this).datepicker(
			jQuery.extend(
				{
					showMonthAfterYear:false
				}, 
				jQuery.datepicker.regional['es'],
				{
					'dateFormat':'dd/mm/yy',
					'maxDate':'d',
					'timeText':'Waktu',
					'hourText':'Jam',
					'minuteText':'Menit',
					'secondText':'Detik',
					'showSecond':true,
					'timeOnlyTitle':'Pilih Waktu',
					'timeFormat':'hh:mm:ss',
					'changeYear':true,
					'changeMonth':true,
					'showAnim':'fold',
					'yearRange':'-80y:+20y',
//					'showOn': 'button',
				}
			)
		);
		$(this).parent().find('.add-on').on('click',function(){$(this).datepicker('show');});
		$(this).parent().find('button').hide();
		$(this).mask("99/99/9999");
    });*/
	//== end set input datetime
});
</script>