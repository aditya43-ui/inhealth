<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function hitungTotal(){
    unformatNumberSemua();
    var total = 0;
    var totaljual = 0;
    $('#table-mutasidetail tbody > tr').each(function(){
        var jmlmutasi  = parseInt($(this).find('input[name$="[jmlmutasi]"]').val());
        var harganetto  = parseInt($(this).find('input[name$="[harganettoterima]"]').val());
        var hargajualsatuan  = parseInt($(this).find('input[name$="[hargajualterim]"]').val());
        var subtotal = harganetto * jmlmutasi;
        var subtotaljual = hargajualsatuan * jmlmutasi;
        total += subtotal;
        totaljual += subtotaljual;
        $(this).find('input[name$="[totalharga]"]').val(subtotal);
    });
    $('#total').val(total);    
    $('#<?php echo CHtml::activeId($model, 'totalharganettomutasi') ?>').val(total);    
    $('#<?php echo CHtml::activeId($model, 'totalharganettomutasi') ?>').val(total);  
    
    $('#<?php echo CHtml::activeId($model, 'totalharganetto') ?>').val(total);    
    $('#<?php echo CHtml::activeId($model, 'totalhargajual') ?>').val(totaljual);    
    formatNumberSemua();
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
function batalMutasiDetail(obj){
    myConfirm('Apakah Anda akan membatalkan terima mutasi obat alkes ini?', 'Perhatian!', function(r)
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
    var terimamutasi_id = '<?php echo $model->terimamutasi_id; ?>';
    window.open('<?php echo $this->createUrl('printTerimaMutasi'); ?>&terimamutasi_id='+terimamutasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer2").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var mutasioaruangan_id = '<?php echo isset($modMutasiRuangan->mutasioaruangan_id) ? $modMutasiRuangan->mutasioaruangan_id : null; ?>';
    var terimamutasi_id = '<?php echo isset($model->terimamutasi_id) ? $model->terimamutasi_id : null; ?>';
    if(mutasioaruangan_id != ""){
        renameInputRowObatAlkes($("#table-mutasidetail")); 
        hitungTotal();
    }
    if(terimamutasi_id != ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
        
        renameInputRowObatAlkes($("#table-mutasidetail")); 
        hitungTotal();
    }
});
</script>