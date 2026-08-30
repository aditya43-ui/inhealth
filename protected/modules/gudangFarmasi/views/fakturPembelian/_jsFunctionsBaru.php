<script type="text/javascript">
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var obatalkes_nama = $('#obatalkes_nama').val();
    var jenisobatalkes_nama = $('#jenisobatalkes_nama').val();
    var tglkadaluarsa = $('#tglkadaluarsa').val();
    var jumlah = unformatNumber($('#qty_input').val());
    var stok = $('#stokoa').val();
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormDetailPemesanan'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,tglkadaluarsa:tglkadaluarsa,stok:stok},//
            dataType: "json",
            success:function(data){
             //   alert(parseInt(data.jumlah)+'-'+parseInt(data.stok));
                if (parseInt(data.jumlah) > parseInt(data.stok)){
                    myAlert("Jumlah Pesan Melebihi Stok",'Perhatian');
                    return false;
                }
                
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+obatalkes_nama+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-detailpemesanan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                var tanggalkadaluarsasama = $("#table-detailpemesanan input[name$='[tglkadaluarsa]'][value='"+tglkadaluarsa+"']");
                if(obatalkesyangsama.val() && tanggalkadaluarsasama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah anda akan input ulang obat ini?', 'Perhatian!', function(r)
                    {
                        if(r){
                            $("#table-detailpemesanan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                
                                if ($(this).parents('tr').find("input[name$='[tglkadaluarsa]']").val() == tanggalkadaluarsasama.val()){
                                    $(this).parents('tr').detach();
                                }
                                
                            });
				if(tambahkandetail){
					$('#table-detailpemesanan > tbody').append(data.form);
					renameInputRowObatAlkes($("#table-detailpemesanan"));                    
					// hitungTotal();
				}
                        }else{
                            tambahkandetail = false;
                        }
                    });
                }else{
			if(tambahkandetail){
				$('#table-detailpemesanan > tbody').append(data.form);
				// $("#table-detailpemesanan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
				//     {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				// );
				renameInputRowObatAlkes($("#table-detailpemesanan"));                    
				// hitungTotal();
			}
		}
                $('#obatalkes_id').val('');
                $('#obatalkes_nama').val('');
                $('#jenisobatalkes_nama').val('');
                $('#tglkadaluarsa').val('');
                $('#stokoa').val('');
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih obat / alkes terlebih dahulu!");
    }
    $("#obatalkes_nama").focus();   
}



/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
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
/**
 * menghapus detail mutasi berdasarkan obatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalPemesananDetail(obj){
    myConfirm('Apakah anda akan membatalkan mutasi obat alkes ini?', 'Perhatian!', function(r)
    {
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
        }
    });
}

/**
* untuk print rencana kebutuhan
 */
function print(caraPrint)
{
    var pesanobatalkes_id = '<?php echo $model->pesanobatalkes_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pesanobatalkes_id='+pesanobatalkes_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

function refreshDialogOA(){
        
	$("#obatalkes_nama").addClass("animation-loading-1");
        var ru = $("#GFPesanobatalkesT_ruangan_id option:selected").html();
        if (ru == "-- Pilih --"){
            ru = "(Ruangan Belum Dipilih)";
        }
	setTimeout(function(){
                $("#dialog_ruangan").html(ru);
		$("#obatalkes_nama").removeClass("animation-loading-1");
	},500);
}


$('#tombolDialogObatAlkes').click(function(){
	var ruangan_id = $('#<?php echo CHtml::activeId($model,"ruangan_id") ?>').val();
        var instalasi_id = $('#<?php echo CHtml::activeId($model,"instalasitujuan_id") ?>').val();
        $(".dialog_ruangan_id").val(ruangan_id);
        $(".dialog_instalasi_id").val(instalasi_id);
	$.fn.yiiGridView.update('obatalkes-m-grid', {
		data: {
			"GFInfostokobatalkesruanganV[ruangan_id]":ruangan_id,
                        "GFInfostokobatalkesruanganV[instalasi_id]":instalasi_id,
		}
	});
});

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var pesanobatalkes_id = '<?php echo $model->pesanobatalkes_id; ?>';
    if(pesanobatalkes_id != ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
        renameInputRowObatAlkes($("#table-detailpemesanan"));
    }

    <?php
        if($model->pesanobatalkes_id){
    ?>
            var params = [];
            params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Pesan Obat Alkes', isinotifikasi:'Pemesanan obat alkes dari <?php echo $model->ruangantujuan->ruangan_nama ?> ke <?php echo $model->ruanganpemesan->ruangan_nama ?>'}; // 16 
            insert_notifikasi(params);
    <?php
        }
    ?>
    refreshDialogOA();
});
</script>