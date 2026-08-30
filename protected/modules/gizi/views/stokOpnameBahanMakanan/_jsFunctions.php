<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script>
    function setJenisOpname(tidak_kosong) {
        var jenisopname = $("#<?php echo CHtml::activeId($modMakanan,'jenis_opname'); ?>").val();
        $("#<?php echo CHtml::activeId($model,'jenisstokopnamegizi'); ?>").val(jenisopname);
        if (tidak_kosong == false) $("#makanan-m-grid tbody").empty();
    }

    function getTotal() {
      unformatNumberSemua();
      var totalNetto = 0;
      var totalHarga = 0;
      var totalNilaiHpp = 0;
      $(".fisik").each(function(){
        var harganetto = parseFloat($(this).parents("tr").find('input[name$="[totalharganetto]"]').val());
        var hpp = parseFloat($(this).parents("tr").find('input[name$="[totalhpp]"]').val());
        var qty = parseFloat(unformatNumber($(this).parents("tr").find('input[name$="[volume_fisik]"]').val()));
        var qty_sistem = parseFloat(unformatNumber($(this).parents("tr").find('input[name$="[volume_sistem]"]').val()));
        
        var jmlHpp = (harganetto * qty);

        if(jmlHpp > 0){
          jmlHpp = parseFloat(jmlHpp.toFixed(2));
        }

        var totalqtynetto = (Math.abs((qty - qty_sistem)) * harganetto);
        if(totalqtynetto > 0){
            totalqtynetto = parseFloat(totalqtynetto.toFixed(2));
        }

          if ($(this).parents("tr").find(".cekList").is(":checked")){
            $(this).parents("tr").find('input[name$="[totalnilaipersediaan]"]').val(totalqtynetto);
              totalNetto += jmlHpp;
              totalNilaiHpp += totalqtynetto;
          }
      });

      $("#<?php echo CHtml::activeId($model,'totalnetto'); ?>").val(totalNetto);
      $("#<?php echo CHtml::activeId($model,'totalharga'); ?>").val(totalNilaiHpp);
      $(".footerTotalPersediaan").val(totalNilaiHpp);
      formatNumberSemua();
    }

    function setNol(obj){
        if($(obj).is(":checked")){
            obj.value = 1;
        }else{
            obj.value = 0;
        }
    }

    function validasiBarang(){
        if(requiredCheck($('#opnamemakanan-t-form'))){
            var jml = $('#makanan-m-grid tbody tr').find("input[name$='[cekList]']:checked").length;
            if(jml < 1){
                myAlert('Pilih terlebih dahulu bahan makanan yang akan di-opname.');
                return false;
            }
            else{
                var cekDataJml = 0;
            $('#makanan-m-grid tbody tr').each(function(){
                if ($(this).find(".cekList").is(":checked")){
                    if($(this).find('select[name$="[kondisibarang]"]').val() == 'Rusak'){
                        if(parseFloat($(this).find('input[name$="[volume_fisik]"]').val()) > parseFloat($(this).find('input[name$="[volume_sistem]"]').val())){
                            cekDataJml += 1;
                        }
                    }
                }
            });

            if(cekDataJml > 0){
                 myAlert('Stok Fisik tidak boleh lebih dari Stok Sistem Jika Kondisi Bahan Makanan Rusak !');
                return false;
            }else{
                var row = 0;
                $('#makanan-m-grid tbody tr').each(function(){
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
                $('#opnamemakanan-t-form').submit();
            }

            }
        }
    return false;
}

function print(caraPrint)
{
    var stokopname_id = '<?php echo isset($_GET['stokopnamegizi_id']) ? $_GET['stokopnamegizi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&stokopnamegizi_id='+stokopname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
	}else{
		$(".cekList").val(0);
		$(".cekList").attr("checked",false);
	}
}


/**
 * untuk mencari kata
 * @param {type} obj
 * @returns {undefined}
 */
function cariKata(){
	var kata = $("#carikata").val().trim().toLowerCase();
	$("#makanan-m-grid tbody tr").show();
	if(kata !== ""){
		jQuery.expr[':'].Contains = function(a, i, m) {
			return jQuery(a).text().toLowerCase().indexOf(m[3].toLowerCase()) >= 0;
		};
		$("#makanan-m-grid tbody tr").hide();
		$("#makanan-m-grid td:Contains('"+kata+"')").parents("tr").show().find(".cekList").focus();
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

    $(document).ready(function() {
        <?php echo $model->isNewRecord ? "setJenisOpname(".(isset($_GET['formuliropnamegizi_id']) ? "true" : "false").")" : ""; ?>;
    });
</script>
