<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<script type="text/javascript">    
function validasiObat(){
    if(requiredCheck($('#gfformuliropname-r-form'))){
        var jml = $('#obatalkes-m-grid tbody tr').find("input[name$='[cekList]']").length;
        if(jml < 1){
            myAlert('Silakan pilih obat alkes terlebih dahulu!');
            return false;
        }
        else{
            /*
            $("#tabel-detailstok tbody tr").each(function () {
                $(this).find('input,select,textarea').each(function(){
                    let row_data = $(this).parents('tr').attr('row-data');
                    let old_name = $(this).attr("name").replace(/]/g,"");
                    let old_name_arr = old_name.split("[");

                    let data_obat = $('#obatalkes-m-grid tbody tr[row-data="' + row_data + '"]').find("input[name$='["+old_name_arr[2]+"]']").val();

                    let rakobat_id = $('#obatalkes-m-grid tbody tr[row-data="' + row_data + '"]').find(".rakobat_id").val();

                    console.log('rakobat_id', rakobat_id);

                    $('#tabel-detailstok > tbody > tr[row-data="' + row_data + '"]').find("input[name$='["+old_name_arr[2]+"]']").val(
                        data_obat);

                    $('#tabel-detailstok > tbody > tr[row-data="' + row_data + '"]').find(".rakobat_id").val(
                        rakobat_id);

                });
            });
            */

            $('#obatalkes-m-grid tbody tr').each(function(){
                    $(this).find('input,select,textarea').each(function(){
                        $(this).attr('disabled',true);
                    });
                });

            $('#gfformuliropname-r-form').submit();
            disableOnSubmit($("#btn_submit"));

        }
    }
    return false;
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
    var totalStok = 0;
    var totalHarga = 0;

    $("#tabel-detailstok tbody tr").find('.stok').each(function () {
        let total = 0;
        let harga = 0;
        if ($(this).parents("tr").find(".cekList").is(":checked")){
            total = parseFloat($(this).val());
            sub_harga = parseFloat($(this).parents("tr").find("#harga").val());
            sub_total = total * sub_harga;
            harga =  sub_total; 
        } else {
            total = 0;
            harga = 0;
        }
        
        totalStok += total;
        totalHarga += harga;

    });

    $("#<?php echo CHtml::activeId($model,'totalvolume'); ?>").val(totalStok);
    $("#<?php echo CHtml::activeId($model,'totalharga'); ?>").val(totalHarga);
    formatNumberSemua();
}   

function print(caraPrint)
{
    var formuliropname_id = '<?php echo isset($_GET['formuliropname_id']) ? $_GET['formuliropname_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&formuliropname_id='+formuliropname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
 * pilih / tidak semua obat
 * @param {type} obj
 * @returns {undefined}
 */
function pilihSemua(obj){
	if($(obj).is(":checked")){
        $('#obatalkes-m-grid tbody tr').find(".cekList").val(1);
        $('#obatalkes-m-grid tbody tr').find(".cekList").prop("checked",true);
        $('#obatalkes-m-grid tbody tr').find(".cekList").addClass("required");
	}else{
        $('#obatalkes-m-grid tbody tr').find(".cekList").val(0);
        $('#obatalkes-m-grid tbody tr').find(".cekList").prop("checked",false);
        $('#obatalkes-m-grid tbody tr').find(".cekList").removeClass("required");
	}
    
    $('#obatalkes-m-grid tbody tr').each(function(){
        set_row($(this).find('.cekList'));
        getTotal($(this));
        setNol($(this).find('.cekList'));
    });
}
/**
 * untuk mencari kata
 * @param {type} obj
 * @returns {undefined}
 */
function cariKata(){
	var kata = $("#carikata").val().trim().toLowerCase();
	$("#obatalkes-m-grid tbody tr").show();
	// if(kata !== ""){
	// 	jQuery.expr[':'].Contains = function(a, i, m) {
	// 		return jQuery(a).text().toLowerCase().indexOf(m[3].toLowerCase()) >= 0;
	// 	};
	// 	$("#obatalkes-m-grid tbody tr").hide();
	// 	$("#obatalkes-m-grid td:Contains('"+kata+"')").parents("tr").show().find(".cekList").focus();
	// }

    $.fn.yiiGridView.update('obatalkes-m-grid', {
        data: {
            'GFObatalkesfarmasiV[obatalkes_nama]': kata,
        }
    });
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
 * agar waktu transaksi yg dilakukan sesuai dengan waktu nilai stok diambil
 * @returns {undefined}
 */
function setTanggalSistem(){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetTanggalSistem'); ?>',
		data: {},
		dataType: "json",
		success:function(data){
			$("#<?php echo CHtml::activeId($model, 'tglformulir'); ?>").val(data.tanggal);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

const set_row = (obj) => {
    var id = $(obj).parents('tr').attr("row-data");
    var checklist = $(obj).parents('tr').find('.cekList');

    if (checklist.is(" :checked")) {
        var tr = $(obj).parents("tr").clone();
        $("#tabel-detailstok > tbody").append(tr);
        $("#tabel-detailstok > tbody").find("tr:last").attr("row-data", id);
    } else {
        $('#tabel-detailstok > tbody > tr[row-data="' + id + '"]').remove();
    }
}

const set_checklist = () => {
    $("#tabel-detailstok tbody tr").each(function () {
        
        var obatalkes_id = $(this).find("input[name$='[obatalkes_id]']").val();
        var checklist = $(this).find('.cekList').is(":checked");

        // console.log("CEKLIS", checklist);
        
        $("#obatalkes-m-grid > table > tbody > tr input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function () {
            
            // console.log("pilihan", $(this));
            
            if (checklist) {
                $(this).parents('tr').find('.cekList').attr('checked', true);
            }
        });
    });
}

/**
* rename input grid
*/
function renameInputRowObatAlkes(){
    // var row = 0;
    $('#obatalkes-m-grid').find("tbody > tr").each(function(){

        row = $(this).find(".obatalkes_id").val();

        $(this).attr("row-data",row);
        $(this).find('input[name$="[cekList]"]').val(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        // row++;
    });
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var jenisobatalkes_id = $('#<?php echo CHtml::activeId($modObat,'jenisobatalkes_id'); ?>').val();
    if(jenisobatalkes_id != ''){
        getTotal();
    }
	<?php if(isset($_GET['sukses'])){ ?>
		$("input, select, textarea").attr('disabled', true);
	<?php } ?>
});
</script>