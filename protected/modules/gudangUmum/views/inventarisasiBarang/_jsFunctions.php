<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function setVolume(){
    var value = $("#fisiks").val();
    $("#barang-m-grid").find(".fisik").each(function(){
        $(this).val(value);
    });
    getTotal();
    renameInputRowBarang();
}
/**
 * untuk mencari kata
 * @param {type} obj
 * @returns {undefined}
 */
function cariKata(){
	var kata = $("#carikata").val().trim().toLowerCase();
	$("#barang-m-grid tbody tr").show();
	if(kata !== ""){
		jQuery.expr[':'].Contains = function(a, i, m) {
			return jQuery(a).text().toLowerCase().indexOf(m[3].toLowerCase()) >= 0;
		};
		$("#barang-m-grid tbody tr").hide();
		$("#barang-m-grid td:Contains('"+kata+"')").parents("tr").show().find(".cekList").focus();
	}
}
/**
 * reset cari kata
 * @returns {undefined}
 */
function resetCariKata(){
	$("#carikata").val("");
	cariKata();
}

function validasiBarang(){
    if(requiredCheck($('#invbarang-t-form'))){
        var jml = $('#barang-m-grid tbody tr').find("input[name$='[cekList]']").is(":checked");
        if(jml < 1){
            myAlert('Pilih terlebih dahulu barang yang akan di inventarisasi !');
            return false;
        }else{
           var cekDataJml = 0;
            $('#barang-m-grid tbody tr').each(function(){
                if ($(this).find(".cekList").is(":checked")){
                    if($(this).find('select[name$="[kondisi_barang]"]').val() == 'Dalam Perbaikan' || $(this).find('select[name$="[kondisi_barang]"]').val() == 'Rusak'){
                        if(parseInt($(this).find('input[name$="[inventarisasi_qty_fisik]"]').val()) > parseInt($(this).find('input[name$="[inventarisasi_qty_skrg]"]').val())){
                            cekDataJml += 1;

                        }
                    }
                }
            });

            if(cekDataJml > 0){
                 myAlert('Stok Fisik tidak boleh lebih dari Stok Sistem Jika Kondisi barang Dalam Perbaikan dan Rusak !');
                return false;
            }else{
                var row = 0;
                $('#barang-m-grid tbody tr').each(function(){
                    if(!$(this).find('.cekList').is(':checked')){
                        $(this).find('input,select,textarea').each(function(){
                           $(this).attr('disabled',true);
                        });
                    }else{
                        $(this).find('input,select,textarea').each(function(){
                           var old_name = $(this).attr("name").replace(/]/g,"");
                           var old_name_arr = old_name.split("[");

                           if(old_name_arr.length == 3){
                               $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                               $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                           }
                        });
                        row++;
                    }
                });
                $(".integer2, .float2, .integer-decimal").each(function(){
                    $(this).val(unformatNumber($(this).val()));
                });
                $('#invbarang-t-form').submit();
            }
        }
    }
    return false;
}

function getTotal(){
    unformatNumberSemua();
    var totalNetto = 0;
    var totalHarga = 0;
    var totalNilaiHpp = 0;

    $(".fisik").each(function(){
      var volFisik = parseInt($(this).parents("tr").find('input[name$="[inventarisasi_qty_fisik]"]').val());
      var volSistem = parseInt($(this).parents("tr").find('input[name$="[inventarisasi_qty_skrg]"]').val());
      var hpp = parseFloat($(this).parents("tr").find('input[name$="[barang_hpp]"]').val());
      var netto = parseFloat($(this).parents("tr").find('input[name$="[inventarisasi_hargasatuan]"]').val());

      var jmlQtyHpp = (volFisik * netto);
      if (jmlQtyHpp > 0){
         jmlQtyHpp = parseFloat(jmlQtyHpp.toFixed(2));
       }

       var totalqtynetto = (Math.abs((volFisik - volSistem)) * netto);
        if(totalqtynetto > 0){
            totalqtynetto = parseFloat(totalqtynetto.toFixed(2));
        }
       

        if ($(this).parents("tr").find(".cekList").is(":checked")){
          totalHarga += totalqtynetto;
          totalNetto += jmlQtyHpp;
          totalNilaiHpp += totalqtynetto;
          $(this).parents("tr").find('input[name$="[totalnilaipersediaan]"]').val(totalqtynetto);
        }
        
    });
    $("#<?php echo CHtml::activeId($model,'totalnilaipersediaan'); ?>").val(totalHarga);
    $("#<?php echo CHtml::activeId($model,'invbarang_totalnetto'); ?>").val(totalNetto);
    $(".footerTotalPersediaan").val(totalNilaiHpp);
    formatNumberSemua();
    renameInputRowBarang();
}

/**
 * menentukan GUInvbarangT_invbarang_jenis dari GUInfoinventarisasibarangV_invbarang_jenis
 * @param {type} caraPrint
 * @returns {undefined} */
function setJenisInventarisasi(){
	var jenisinventarisasi = $("#<?php echo CHtml::activeId($modBarang,'invbarang_jenis'); ?>").val();
	$("#<?php echo CHtml::activeId($model,'invbarang_jenis'); ?>").val(jenisinventarisasi);
}

/**
* rename input grid
*/
function renameInputRowBarang(){
    var row = 0;
    $('#barang-m-grid').find("tbody > tr").each(function(){
        $(this).find('input[name$="[cekList]"]').val(row+1);
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

function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
		$(obj).parents('tr').find('input[name$="[tglperiksafisik]').addClass('required');
    }else{
        obj.value = 0;
		$(obj).parents('tr').find('input[name$="[tglperiksafisik]').removeClass('required');
    }
}

/**
 * pilih / tidak semua obat
 * @param {type} obj
 * @returns {undefined}
 */
function pilihSemua(obj){
	if($(obj).is(":checked")){
		$(".cekList").val(1);
		$(".cekList").attr("checked",true);
		$(".cekFisik").addClass("required");
	}else{
		$(".cekList").val(0);
		$(".cekList").attr("checked",false);
		$(".cekFisik").removeClass("required");
	}
        getTotal();
}

function print(caraPrint)
{
    var invbarang_id = '<?php echo isset($_GET['invbarang_id']) ? $_GET['invbarang_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&invbarang_id='+invbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
	<?php if(isset($_GET['sukses'])){ ?>
		$("input, select, textarea").attr('disabled', true);
	<?php } ?>
});
</script>
