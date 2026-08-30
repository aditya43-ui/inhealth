<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
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
    if(requiredCheck($('#forminvbarang-t-form'))){
        var jml = $('#barang-m-grid tbody tr').find("input[name$='[cekList]']").length;
        if(jml < 1){
            myAlert('Silakan pilih formulir inventarisasi barang terlebih dahulu!');
            return false;
        }
        else{
            $('#forminvbarang-t-form').submit();
        }
    }
    return false;
} 

function getTotal(){
    unformatNumberSemua();
    var totalNetto = 0;
    var totalVolume = 0;
    var subTotal = 0;    
    
    if ($("#carikata").val () == ''){
        $(".netto").each(function(){        
            if ($(this).parents("tr").find(".cekList").is(":checked")){            
                totalNetto += parseFloat($(this).parents("tr").find('input[name$="[harga_netto]"]').val());
                totalVolume += parseFloat($(this).parents("tr").find('input[name$="[volume_inventaris]"]').val());            
                subTotal += parseFloat($(this).parents("tr").find('input[name$="[volume_inventaris]"]').val()) * parseFloat($(this).parents("tr").find('input[name$="[harga_netto]"]').val());                                                   
            }
            
            $(this).parents("tr").find('input[name$="[subtotal]"]').val(parseFloat($(this).parents("tr").find('input[name$="[volume_inventaris]"]').val()) * parseFloat($(this).parents("tr").find('input[name$="[harga_netto]"]').val()));
        });
    }else{
        $("td:Contains('"+$("#carikata").val()+"')").each(function(){        
            if ($(this).parents("tr").find(".cekList").is(":checked")){            
                totalNetto += parseFloat($(this).parents("tr").find('input[name$="[harga_netto]"]').val());
                totalVolume += parseFloat($(this).parents("tr").find('input[name$="[volume_inventaris]"]').val());            
                subTotal += parseFloat($(this).parents("tr").find('input[name$="[volume_inventaris]"]').val()) * parseFloat($(this).parents("tr").find('input[name$="[harga_netto]"]').val());                                                   
            }
            
            $(this).parents("tr").find('input[name$="[subtotal]"]').val(parseFloat($(this).parents("tr").find('input[name$="[volume_inventaris]"]').val()) * parseFloat($(this).parents("tr").find('input[name$="[harga_netto]"]').val()));
        });
    }
    $("#<?php echo CHtml::activeId($model,'forminvbarang_totalharga'); ?>").val(subTotal);
    $("#<?php echo CHtml::activeId($model,'forminvbarang_totalvolume'); ?>").val(totalVolume);    
    formatNumberSemua();
    renameInputRowBarang();
}

function ubahSubTotal(obj){
    GUBarangV[".$data->barang_id."][subtotal]
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
    }else{
        obj.value = 0;
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
	}else{
		$(".cekList").val(0);
		$(".cekList").attr("checked",false);
	}
}

function print(caraPrint)
{
    var formulirinvbarang_id = '<?php echo isset($_GET['formulirinvbarang_id']) ? $_GET['formulirinvbarang_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&formulirinvbarang_id='+formulirinvbarang_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer2 di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}
</script>
