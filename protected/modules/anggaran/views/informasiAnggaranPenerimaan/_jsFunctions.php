<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
function terminke(){
var renanggaranpenerimaandet_id=$("#<?php echo CHtml::activeId($model,"renanggaranpenerimaandet_id");?>").val();

var renanggpenerimaan_id= '<?php echo !isset($_GET['renanggpenerimaan_id'])?'':$_GET['renanggpenerimaan_id'];?>';

$("#relangpen").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('CekNilaiPenerimaan'); ?>',
            data: {renanggaranpenerimaandet_id:renanggaranpenerimaandet_id,renanggpenerimaan_id:renanggpenerimaan_id},//
            dataType: "json",
            success:function(data){
                $("#<?php echo CHtml::activeId($model,"penerimaanke");?>").val(data.renanggaran_ke);
                $("#<?php echo CHtml::activeId($model,"nilaipenerimaan");?>").val(data.nilaipenerimaan);
                $("#relangpen").removeClass("animation-loading");
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
}

function hitungJumlahBayar(){
unformatNumberSemua();
var realisasipenerimaan= parseInt($("#<?php echo CHtml::activeId($model,"realisasipenerimaan");?>").val());
var biayamaterai= parseInt($("#<?php echo CHtml::activeId($modTandaBuktiBayar,"biayamaterai");?>").val());
var jmlbayar= 0;
jmlbayar = realisasipenerimaan + biayamaterai;
$('#<?php echo CHtml::activeId($modTandaBuktiBayar,"jmlpembayaran"); ?>').val(jmlbayar);  
formatNumberSemua();
}

function setFormCaraPembayaran(carapembayaran){
    if(carapembayaran == 0){
		sembunyiFormTransfer();
		sembunyiFormCek();
        $('#form-transfer').hide(); 
		$('#form-cek').hide();
    }else if(carapembayaran == 1){
		sembunyiFormCek();
        tampilFormTransfer();
        $('#form-transfer').show(); 
		$('#form-cek').hide();
    }else if(carapembayaran == 2){
		sembunyiFormTransfer();
        tampilFormCek();
        $('#form-transfer').hide(); 
		$('#form-cek').show();
    }
}

function sembunyiFormTransfer(){
        $('#content-transfer').find(".required").addClass("not-required").removeClass("required");
        $('#form-transfer > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-transfer > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-transfer').removeClass().addClass("accordion-body collapse");
        $('#content-transfer').removeAttr("style").attr("style","height:0px");  
        $('#content-transfer').find("input,select,textarea").attr("disabled",true); 
  
}
function tampilFormTransfer(){
        $('#form-transfer > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-transfer > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-transfer').removeClass().addClass("accordion-body in collapse");
        $('#content-transfer').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-transfer').removeAttr("style").attr("style","height:auto"); 
        $('#content-transfer').find("input,select,textarea").removeAttr("disabled");
  
}

function sembunyiFormCek(){
        $('#content-cek').find(".required").addClass("not-required").removeClass("required");
        $('#form-cek > .accordion-group > .accordion-heading').find(".btn").removeClass("btn-primary");
        $('#form-cek > .accordion-group > .accordion-heading').find(".icon-minus").addClass("icon-plus").removeClass("icon-minus");
        $('#content-cek').removeClass().addClass("accordion-body collapse");
        $('#content-cek').removeAttr("style").attr("style","height:0px");  
        $('#content-cek').find("input,select,textarea").attr("disabled",true); 
  
}
function tampilFormCek(){
        $('#form-cek > .accordion-group > .accordion-heading').find(".btn").addClass("btn-primary");
        $('#form-cek > .accordion-group > .accordion-heading').find(".icon-plus").addClass("icon-minus").removeClass("icon-plus");
        $('#content-cek').removeClass().addClass("accordion-body in collapse");
        $('#content-cek').find(".not-required").addClass("required").removeClass("not-required");
        $('#content-cek').removeAttr("style").attr("style","height:auto"); 
        $('#content-cek').find("input,select,textarea").removeAttr("disabled");
  
}

function setTransferBaru(){
    $("#<?php echo CHtml::activeId($model,'nostruk_trf') ?>").val("");
    $("#<?php echo CHtml::activeId($model,'tglrealisasianggpen') ?>").val(null);
    $("#<?php echo CHtml::activeId($model,'namabank_trf') ?>").val("");
    $("#<?php echo CHtml::activeId($model,'norek_trf') ?>").val("");
	
	$(".judultransfer").html("Pembayaran Transfer");
	$(".refreshtransfer").attr("style","display:none;");
}

function setCekBaru(){
    $("#<?php echo CHtml::activeId($model,'nocek') ?>").val("");
    $("#<?php echo CHtml::activeId($model,'tglcek') ?>").val(null);
    $("#<?php echo CHtml::activeId($model,'atasnama_cek') ?>").val("");
    $("#<?php echo CHtml::activeId($model,'namabank_cek') ?>").val("");
    $("#<?php echo CHtml::activeId($model,'utkkeperluan_cek') ?>").val("");
	
	$(".judulcek").html("Pembayaran Cek");
	$(".refreshcek").attr("style","display:none;");
}

function loadPenerimaan(data) {
    console.log(data);
    $('#<?php echo CHtml::activeId($modPenerimaan, "renanggpenerimaan_id"); ?>').val(data.base.renanggpenerimaan_id);
    $('#<?php echo CHtml::activeId($modPenerimaan, "noren_penerimaan"); ?>').val(data.base.noren_penerimaan);
    $('#<?php echo CHtml::activeId($modPenerimaan, "deskripsiperiode"); ?>').val(data.konfig.deskripsiperiode);
    $('#<?php echo CHtml::activeId($modPenerimaan, "konfiganggaran_id"); ?>').val(data.base.noren_penerimaan);
    $('#<?php echo CHtml::activeId($modPenerimaan, "sumberanggarannama"); ?>').val(data.sumber.sumberanggarannama);
    $('#<?php echo CHtml::activeId($modPenerimaan, "sumberanggaran_id"); ?>').val(data.base.sumberanggaran_id);
    $('#<?php echo CHtml::activeId($modPenerimaan, "nilaipenerimaananggaran"); ?>').val(data.base.nilaipenerimaananggaran);
    $('#<?php echo CHtml::activeId($model, "renanggaranpenerimaandet_id"); ?>').html(data.termin);
    
}  

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
    var digitnilai = $('#<?php echo CHtml::activeId($modPenerimaan, "digitnilai"); ?>').val();
    $('#digit-label-totalpenerimaan').html(digitnilai);
    $('#digit-label-nilaipenerimaan').html(digitnilai);
	$('#form-transfer').hide(); 
	$('#form-cek').hide(); 
});
</script>
