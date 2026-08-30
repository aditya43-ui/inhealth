<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<script type="text/javascript">
function openDialog(obj){
    $('#dialogPegawai').attr('parentClick',obj);
    $('#dialogPegawai').dialog('open');
}

function setVolume(){
    var value = $("#fisiks").val();
    $("#obatalkes-m-grid").find(".fisik").each(function(){
        $(this).val(value);
    });
    getTotal();
    renameInputRowObatAlkes();
}

function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}

function getTotal(){
    unformatNumberSemua();
    var totalNetto = 0;
    var totalHarga = 0;
    var totalNilaiHpp = 0;
    $(".fisik").each(function(){
    var netto = parseFloat($(this).parents("tr").find('input[name$="[harganetto]"]').val());
      var hpp = parseFloat($(this).parents("tr").find('input[name$="[hpp]"]').val());
      var qty = parseFloat($(this).parents("tr").find('input[name$="[volume_fisik]"]').val());
      var qty_sistem = parseFloat($(this).parents("tr").find('input[name$="[volume_sistem]"]').val());

      var harga = (netto * qty);

      if(harga > 0){
        harga = parseFloat(harga.toFixed(2));
      }
      
      var totalqtynetto = (Math.abs((qty - qty_sistem)) * netto);
      if(totalqtynetto > 0){
        totalqtynetto = parseFloat(totalqtynetto.toFixed(2));
      }

        if ($(this).parents("tr").find(".cekList").is(":checked")){

            $(this).parents("tr").find('input[name$="[hargasatuan]"]').val(hpp);
            $(this).parents("tr").find('input[name$="[totalnilaipersediaan]"]').val(totalqtynetto);

            totalNilaiHpp += totalqtynetto;
            totalNetto += harga;
            totalHarga += totalqtynetto;
        }
    });

    $("#<?php echo CHtml::activeId($model,'totalnetto'); ?>").val(totalNetto);
    $("#<?php echo CHtml::activeId($model,'totalharga'); ?>").val(totalHarga);
    $(".footerTotalPersediaan").val(totalNilaiHpp);
    formatNumberSemua();
    renameInputRowObatAlkes();
}

/**
* rename input grid
*/
function renameInputRowObatAlkes(){
    var row = 0;
    $('#obatalkes-m-grid').find("tbody > tr").each(function(){
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

function cekPegawaiSama(id) {
    var isAda = false;
    $(".pegawai").each(function() {
        if ($(this).val() == id) {
            myAlert("Pegawai yang dipilih tidak boleh dipakai 2 kali");
            isAda = true;
        }
    });

    return !isAda;
}


function validasiObat(){
    if(requiredCheck($('#gfstokopname-t-form'))){
        var jml = $('#obatalkes-m-grid tbody tr').find("input[name$='[cekList]']").length;
        if(jml < 1){
            myAlert('Pilih terlebih dahulu obat alkes !');
            return false;
        }
        else{
            var cekDataJml = 0;
            $('#obatalkes-m-grid tbody tr').each(function(){
                if ($(this).find(".cekList").is(":checked")){
                    if($(this).find('select[name$="[kondisibarang]"]').val() == 'Dalam Perbaikan' || $(this).find('select[name$="[kondisibarang]"]').val() == 'Rusak'){
                        if(parseFloat($(this).find('input[name$="[volume_fisik]"]').val()) > parseFloat($(this).find('input[name$="[volume_sistem]"]').val())){
                            cekDataJml += 1;
                        }
                    }
                }
            });

            if(cekDataJml > 0){
                 myAlert('Stok Fisik tidak boleh lebih dari Stok Sistem Jika Kondisi Obat Rusak !');
                return false;
            }else{
                var row = 0;
                $('#obatalkes-m-grid tbody tr').each(function(){
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
                $('#gfstokopname-t-form').submit();
            }
        }
    }
    return false;
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
        $(".cekList").addClass("required");
	}else{
		$(".cekList").val(0);
        $(".cekList").attr("checked",false);
        $(".cekList").removeClass("required");
	}
}

function validasiBarang(){
    if(requiredCheck($('#gfstokopname-t-form'))){
        var jml = $('#obatalkes-m-grid tbody tr').find("input[name$='[cekList]']").is(":checked");
        if(jml < 1){
            myAlert('Pilih terlebih dahulu obat alkes !');
            return false;
        }else{
           var cekDataJml = 0;
            $('#obatalkes-m-grid tbody tr').each(function(){
                if ($(this).find(".cekList").is(":checked")){
                    if($(this).find('select[name$="[kondisibarang]"]').val() == 'Dalam Perbaikan' || $(this).find('select[name$="[kondisibarang]"]').val() == 'Rusak'){
                        if(parseInt($(this).find('input[name$="[volume_fisik]"]').val()) > parseInt($(this).find('input[name$="[volume_sistem]"]').val())){
                            cekDataJml += 1;

                        }
                    }
                }
            });

            if(cekDataJml > 0){
                 myAlert('Stok Fisik tidak boleh lebih dari Stok Sistem Jika Kondisi Obat Rusak !');
                return false;
            }else{
              $(".integer2, .float2, .integer-decimal").each(function(){
                  $(this).val(unformatNumber($(this).val()));
              });
                $('#gfstokopname-t-form').submit();
            }
        }
    }
    return false;
}

/**
 * untuk mencari kata
 * @param {type} obj
 * @returns {undefined}
 */
function cariKata(){
	var kata = $("#carikata").val().trim().toLowerCase();
	$("#obatalkes-m-grid tbody tr").show();
	if(kata !== ""){
		jQuery.expr[':'].Contains = function(a, i, m) {
			return jQuery(a).text().toLowerCase().indexOf(m[3].toLowerCase()) >= 0;
		};
		$("#obatalkes-m-grid tbody tr").hide();
		$("#obatalkes-m-grid td:Contains('"+kata+"')").parents("tr").show().find(".cekList").focus();
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
/**
 * menentukan GFStokopnameT_jenisstokopname dari GFInformasistokobatalkesV_jenisstokopname
 * @param {type} caraPrint
 * @returns {undefined} */
function setJenisStokOpname(){
	var jenisstokopname = $("#<?php echo CHtml::activeId($modObat,'jenisstokopname'); ?>").val();
	$("#<?php echo CHtml::activeId($model,'jenisstokopname'); ?>").val(jenisstokopname);
}

function print(caraPrint)
{
    var stokopname_id = '<?php echo isset($_GET['stokopname_id']) ? $_GET['stokopname_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&stokopname_id='+stokopname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
	var jenisobatalkes_id = $('#<?php echo CHtml::activeId($modObat,'jenisobatalkes_id'); ?>').val();
    var obatalkes_kode = $('#<?php echo CHtml::activeId($modObat,'obatalkes_kode'); ?>').val();
    if(jenisobatalkes_id != '' || obatalkes_kode != ''){
        getTotal();
        renameInputRowObatAlkes();
    }
	<?php if(isset($_GET['sukses'])){ ?>
		$("input, select, textarea").attr('disabled', true);
	<?php } ?>

    <?php
        if(isset($model->stokopname_id)){
            if($model->jenisstokopname = 'Penyesuaian'){
    ?>
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI ?>, judulnotifikasi:'Stok Opname Penyesuaian', isinotifikasi:'Telah dilakukan stok penyesuaian pada <?php echo $model->tglstokopname ?>' };
                insert_notifikasi(params);
    <?php
            }else{
    ?>
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI ?>, judulnotifikasi:'Stok Opname Awal', isinotifikasi:'Telah dilakukan stok awal pada <?php echo $model->tglstokopname ?>' };
                insert_notifikasi(params);
    <?php
            }
        }
    ?>
});
</script>
