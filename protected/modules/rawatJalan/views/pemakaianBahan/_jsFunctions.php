<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
function inputPemakaianBahan(obj)
{
    var daftartindakan_id = $('#daftartindakanPemakaianBahan').val();
    var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
	var obatalkes_id = $('#form_pilih_obat').find('#obatalkes_id').val();
    var obatalkes_kode = $('#form_pilih_obat').find('#obatalkes_kode').val();
    var obatalkes_nama = $('#form_pilih_obat').find('#namaObatNonRacik').val();
    var jumlah = parseFloat(unformatNumber($('#form_pilih_obat').find('#konversi').val()));
    var jumlahBahan = $('#jumlahBahan').val();
    
    console.log(obj, "OA", obatalkes_id, jumlah);
    
    if (jumlahBahan == ''){
        $('#jumlahBahan').val(1);
    }
	
	if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,pendaftaran_id:pendaftaran_id,daftartindakan_id:daftartindakan_id},
            dataType: "json",
            success:function(data){
			   if(data.pesan !== ""){
				    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+obatalkes_nama+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
				    return false;
			   }
			   $('#tblInputPemakaianBahan #trPemakaianBahan').detach();
			   var tambahkandetail = true;
			   var obatalkesyangsama = $("#tblInputPemakaianBahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
			   if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
				   myConfirm("Apakah Anda akan input ulang obat ini?","Perhatian!",function(r) {
					   if(r){
						   $("#tblInputPemakaianBahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
							   $(this).parents('tr').detach();
						   });
					   }else{
						   tambahkandetail = false;
					   }
				   });
			   }
			   if(tambahkandetail){
				   $('#tblInputPemakaianBahan > tbody').append(data.form);
				   $("#tblInputPemakaianBahan").find('input[name*="[ii]"][class*="float2"]').maskMoney(
					   {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
				   );
				   $("#tblInputPemakaianBahan").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
					   {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"."}
				   );
				   renameInputRowObatAlkes($("#tblInputPemakaianBahan"));  
			   }			

//						$('#tblInputPemakaianBahan > tbody').append(data.form);

			   $('#namaObatNonRacik').val('');
			   $('#qty_input').val(formatThousandDecimal(1));
			   $('#obatalkes_id').val('');						
			   $("#tblInputPemakaianBahan > tbody > tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
			   $('.integer').each(function(){this.value = formatNumber(this.value)});
			   renameInputRowObatAlkes($("#tblInputPemakaianBahan"));
			   hitungTotal();
			   $('.qty').each(function(){
				   hitungSubTotal(this);
			   });
               $("#konversi").val(formatThousandDecimal(1));
               $("#jmlkemasan").val(formatThousandDecimal(1));
		},
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
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
	
	cekObat();
}

function removeObat(obj)
{
    myConfirm("Apakah Anda akan menghapus obat?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
			renameInputRowObatAlkes($("#tblInputPemakaianBahan"));
            hitungTotal();
        }
    });
}

function renameInputAfterRemove(modelName,attributeName)
{
    var i = -1;
    $('#tblInputPemakaianBahan tr').each(function(){
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
    var qty = obj.value;
    var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual_oa]"]').val());
    var subtotal = qty * harga;
    $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[iurbiaya]"]').val(formatNumber(subtotal));
    hitungTotal(); 
}
    
function hitungTotal()
{
    var total = 0;
    var totalQty = 0;
//    $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function(){
//        total = total + unformatNumber(this.value);
//    });
    $('#tblInputPemakaianBahan').find('input[name$="[qty_oa]"]').each(function(){
        totalQty = totalQty + unformatNumber(this.value);
    });
//    $('#totPemakaianBahan').val(formatNumber(total));
    $('#totQtyPemakaianBahan').val(formatNumber(totalQty));
}
function validasi(){
    var obatalkes_id = $('#obatalkes_id').val();
    var jumlahObat = $('#qty_input').val();
    if (obatalkes_id == ''){
        myAlert('Obat Belum Diisi');
    } else if (jumlahObat == ''){
        myAlert('jumlah Obat Belum Diisi')
    } else if (jumlahObat < 1){
        myAlert('jumlah Obat Tidak Sesuai')
    } else {
        inputPemakaianBahan(obatalkes_id);
    }
    
}

function print(pendaftaran_id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
}

function cekObat(){
	var tr = $("#tblInputPemakaianBahan > tbody > tr");
	
	if (tr.length){
		$("#btn_simpan").attr("disabled", false);
	}else{
		$("#btn_simpan").attr("disabled", true);
	}
}

// untuk menjumlahkan konversi dari qty input / jmlkemasan terkecil
function totalKonversi(){
	var qty_input = parseFloat(unformatNumber($('#qty_input').val()));
	var jmlkemasan = parseFloat(unformatNumber($('#jmlkemasan').val()));
	var jmlkonversi = parseFloat(unformatNumber($('#konversi').val()));

	var jml = qty_input / jmlkemasan;
    
    if (jml > 0){
        jml = parseFloat(jml.toFixed(2));
    }

	$('#konversi').val(formatThousandDecimal(jml));
}

function totalJumlah(){
	var qty_input = parseFloat(unformatNumber($('#qty_input').val()));
	var jmlkemasan = parseFloat($('#jmlkemasan').val());
	var jmlkonversi = parseFloat(unformatNumber($('#konversi').val()));

	var jumlah = jmlkonversi * jmlkemasan;
    if (jumlah > 0){
        jumlah = parseFloat(jumlah.toFixed(2));
    }
	$('#konversi').val(formatThousandDecimal(jumlah));
}

function setSatuanObat(obatalkes_id){
	$.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('actionAjax/setSatuanObat'); ?>',
        data: {obatalkes_id:obatalkes_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                window.parent.myAlert(data.pesan);
            }else{
				$('#satuankecil_nama').html(data.satuankecil);
				$('#satuanterkecil_nama').html(data.satuanterkecil);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            window.parent.myAlert("Data Obat tidak ditemukan!"); 
            console.log(errorThrown);
        }
    });
}

function cekSimpan(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#tblInputPemakaianBahan tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Isikan Bahan Medis terlebih dahulu.');
            return false;
        }else{
            $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
            $('#rjpemakaian-bahan-form').submit();
        }

    }
    return false;

}

function cekstokRuangan(){
    <?php 
        $kofigfarmasi = KonfigfarmasiK::model()->find();
        if($kofigfarmasi->isstokfarmasiminus == false){ ?>
        var numQty = parseFloat($('#qty_stok').val());
        var kondisi = 0;

        if(parseFloat($('#qty_stok').val()) <= 0){
            kondisi = 1;
        }
        if(numQty % 1 != 0){
            kondisi = 1;
        }
       
        if(kondisi == 1){
            myAlert('Stok '+$('#obatalkes_nama').val()+' bernilai 0 !');

            $('#qty_stok').val(formatThousandDecimal(1));
            $('#obatalkes_id').val('');
            $('#obatalkes_kode').val('');
            $('#satuankecil_id').val('');
            $('#satuankecil_nama').val('');
            $('#hargajual').val('');
            $('#harganetto').val('');
            $('#obatalkes_nama').val('');
            $('#namaObatNonRacik').val('');
            $('#sumberdana_id').val('');
            $("#qty_input").val(formatThousandDecimal(1));
            $("#jmlkemasan").val(formatThousandDecimal(1));
        }
    <?php } ?>
}


$(document).ready(function(){
	cekObat();
});
</script>