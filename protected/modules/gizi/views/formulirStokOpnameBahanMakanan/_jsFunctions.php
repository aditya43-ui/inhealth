<script>
function validasiBahan(){
    if(requiredCheck($('#formuliropnamegizi-r-form'))){
        var jml = $('#makanan-m-grid tbody tr').find("input[name$='[cekList]']").length;
        if(jml < 1){
            myAlert('Silakan pilih bahan makanan terlebih dahulu!');
            return false;
        }
        else{
            $('#formuliropnamegizi-r-form').submit();
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

function getTotal(){
    unformatNumberSemua();
    var totalStok = 0;
    //var totalHarga = 0;
    $(".stok").each(function(){
        if ($(this).parents("tr").find(".cekList").is(":checked")){
            totalStok += parseFloat($(this).val());
            //totalHarga += parseFloat($(this).parents("tr").find("#harga").val());
        }
    });
    $("#<?php echo CHtml::activeId($model,'totalvolume'); ?>").val(totalStok);
    //$("#<?php // echo CHtml::activeId($model,'totalharga'); ?>").val(totalHarga);
    formatNumberSemua();
}   

function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}

function print(caraPrint)
{
    var formuliropname_id = '<?php echo isset($_GET['formuliropnamegizi_id']) ? $_GET['formuliropnamegizi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&formuliropnamegizi_id='+formuliropname_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
