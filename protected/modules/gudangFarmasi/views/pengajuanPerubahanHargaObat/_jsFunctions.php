<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function tambahObatAlkes()
{
    var obatalkes_id = $('#obatalkes_id').val();

    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadFormObat'); ?>',
            data: {obatalkes_id:obatalkes_id},
            dataType: "json",
            success:function(data){
                $('#table-obatalkespasien > tbody').append(data.form);
                renameInputRowObatAlkes($("#table-obatalkespasien"));
                $('#obatalkes_id').val('');
                $('#obatalkes_nama').val('');
                hitungTotal();
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Isikan Nama obat & Alkes terlebih dahulu");
    }
}

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

function pilihSatuan(obj){
    var satuanobat = $(obj).val();

    if(satuanobat == '<?php echo PARAMS::SATUAN_KECIL; ?>'){
        $(obj).parents('tr').find('.satuankecil').show();
        $(obj).parents('tr').find('.satuanbesar').hide();

    }else{
        $(obj).parents('tr').find('.satuanbesar').show();
        $(obj).parents('tr').find('.satuankecil').hide();
    }
}

function hitungTotal(){
    unformatNumberSemua();
    $('#table-obatalkespasien tbody tr').each(function(){
        var persenppn  = parseFloat($(this).find('input[name$="[ppn_persen]"]').val());
        var harganetto  = parseFloat($(this).find('input[name$="[harganettobaru]"]').val());
        var jmldiskon  = parseFloat($(this).find('input[name$="[diskonbaru]"]').val());
        var persenmargin  = parseFloat($(this).find('input[name$="[marginbaru]"]').val());

        var jmlppn = (((harganetto - jmldiskon)* persenppn)/100);
        if (jmlppn > 0){
            jmlppn = parseFloat(jmlppn.toFixed(2));
        }

        var hpp = ((harganetto - jmldiskon)+jmlppn);
        if (hpp > 0){
            hpp = parseFloat(hpp.toFixed(2));
        }
        var jmlmargin = ((persenmargin * hpp)/100);
        if (jmlmargin > 0){
            jmlmargin = parseFloat(jmlmargin.toFixed(2));
        }

        var hargajual = (hpp + jmlmargin);

        $(this).find('input[name$="[ppnbaru]"]').val(jmlppn);
        $(this).find('input[name$="[hppbaru]"]').val(hpp);
        $(this).find('input[name$="[hargajualbaru]"]').val(hargajual);

    });
    formatNumberSemua();
}

function batalObat(obj){
    myConfirm('Apakah Anda akan membatalkan Pengajuan obat ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
        }
    });
    hitungTotal();
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        if(jmlObat <= 0){
                myAlert('Silakan isikan perubahan harga terlebih dahulu!');
            return false;
        }else{
            $(".integer2, .float2, .integer-decimal").each(function(){
                $(this).val(unformatNumber($(this).val()));
            });
            $('#pengajuanhargaobat-form').submit();
        }
    }
    return false;
}

function print(caraPrint)
{
    var pengajuanhargaoa_id = '<?php echo (isset($_GET['pengajuanhargaoa_id'])?$_GET['pengajuanhargaoa_id']:"") ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pengajuanhargaoa_id='+pengajuanhargaoa_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
    <?php if(isset($_GET['pengajuanhargaoa_id'])){ ?>
        renameInputRowObatAlkes($("#table-obatalkespasien"));
        $("#table-obatalkespasien").find('tbody tr').each(function(){
            pilihSatuan($(this).find('select[name$="[satuanobat]"]'));
        });

        hitungTotal();
     <?php } ?>
});
</script>
