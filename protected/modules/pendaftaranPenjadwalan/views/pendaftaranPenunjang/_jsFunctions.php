<script type="text/javascript">
/**
 * Override setKarcis di view pendaftaranRawatJalan._jsFunctions
 */
function setKarcisAll(){
    <?php  
    if(count((array)$modPasienMasukPenunjangs) > 0){
        foreach($modPasienMasukPenunjangs AS $i=>$modPasienMasukPenunjang){
    ?>
            var is_adakarcis = $("#form-karcis-<?php echo $i; ?>").parent().find('input[name$="[is_adakarcis]"]').val();
            if(is_adakarcis == 1){
                setKarcisPenunjang(<?php echo $i ?>);
            }
    <?php
        }
    }
    ?>
}    
/**
 * menampilkan karcis berdasarkan index form penunjang
 */
function setKarcisPenunjang(form_index)
{
    var pasien_id=$("#<?php echo CHtml::activeId($modPasien,"pasien_id");?>").val();
    var penjamin_id=$("#<?php echo CHtml::activeId($model,"penjamin_id");?>").val();
    var ruangan_id = $("#form-masukpenunjang-"+form_index).find('input[name$="[ruangan_id]"]').val();
    var kelaspelayanan_id = $("#form-masukpenunjang-"+form_index).find('input[name$="[kelaspelayanan_id]"]').val();
    
    if(ruangan_id !== "" && kelaspelayanan_id !=="" && penjamin_id !== "") {
        $("#form-karcis-"+form_index).addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetKarcis'); ?>',
            data: {form_index:form_index, kelaspelayanan_id:kelaspelayanan_id, ruangan_id : ruangan_id, penjamin_id:penjamin_id, pasien_id:pasien_id},//
            dataType: "json",
            success:function(data){
                $("#form-karcis-"+form_index+" #content-karcis-html").html(data.listKarcis[form_index]);
                $("#form-karcis-"+form_index).removeClass("animation-loading");
                $("#form-karcis-"+form_index+" #content-karcis-html table > tbody a").click();
            },
             error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
       $("#form-karcis-"+form_index).find("#content-karcis-html").html("");
    }
       
}
    
    
<?php  
if(count((array)$modPasienMasukPenunjangs) > 0){
    foreach($modPasienMasukPenunjangs AS $i=>$modPasienMasukPenunjang){
?>
        /** control accordion penunjang */
        $('#form-masukpenunjang-<?php echo $i; ?> > div > .accordion-heading').click(function(){
            var is_pilihpenunjang = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, "[".$i."]is_pilihpenunjang"); ?>");
            if(is_pilihpenunjang.val() > 0){ //hide
                is_pilihpenunjang.val(0);
            }else{//show
                is_pilihpenunjang.val(1);
            }
        });
        /** control accordion karcis lab klinik*/
        $('#form-karcis-<?php echo $i; ?> > div > .accordion-heading').click(function(){
            var is_adakarcis = $("#form-karcis-<?php echo $i; ?>").parent().find('input[name$="[is_adakarcis]"]');
            if(is_adakarcis.val() > 0){ //hide
                is_adakarcis.val(0);
            }else{//show
                is_adakarcis.val(1);
            }
        });
<?php
    }
}
?>
/**
 * pilih karcis (check - uncheck)
 * harus pilih salah satu
 */
function pilihKarcis(obj){
    var is_pilihkarcis = $(obj).parents('tr').find('input[name$="[is_pilihkarcis]"]');
    $(obj).parents('table').find('tr').each(function(){
        $(this).find('input[name$="[is_pilihkarcis]"]').val(0);
        $(this).removeClass('checked');
    });
    if(is_pilihkarcis.val() > 0){
        is_pilihkarcis.val(0);
        $(obj).parents('tr').removeClass('checked');
    }else{
        is_pilihkarcis.val(1);
        $(obj).parents('tr').addClass('checked');
    }
}


function getRuanganPoliklinikPasien(){
	// Hanya digunakan di transaksi Pendaftaran Rawat Jalan
}

/**
 * print status
 */
function printStatus()
{
    window.open('<?php echo $this->createUrl('printStatus',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}
/**
 * print karcis
 */
function printKarcis()
{
    window.open('<?php echo $this->createUrl('printKarcisPenunjang',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=480,height=640');
}

function cekPenunjang() {
<?php 
//echo count((array)$modPasienMasukPenunjangs);
//exit();
if (count((array)$modPasienMasukPenunjangs) > 0) { ?>

			var cek = 0;
	<?php foreach ($modPasienMasukPenunjangs AS $i => $modPasienMasukPenunjang) {
		?>
				var is_pilihpenunjang = $("#<?php echo CHtml::activeId($modPasienMasukPenunjang, "[" . $i . "]is_pilihpenunjang"); ?>");
				if (is_pilihpenunjang.val() == 1) {
					cek++;
				}
		<?php
	}
	?>
			if (cek == 0) {
				return false;
			} else {
				return true;
			}
	<?php
}
?>
	}

	/**
	 * menampilkan form verifikasi
	 * @returns {undefined}
	 */
	function setVerifikasiPenunjang() {
            console.log('asdasdas');
		if (cekPenunjang()){
                    console.log('masukkkkkk');
			if (requiredCheck($("form"))) {
                            console.log('masukkkkkk  rqueri');
            if ($(".is_adapjpasien").val() != 1){
                myAlert("Penanggung jawab pasien harus diisi.");
                return false;
            }
				$('#dialog-verifikasi').dialog("open");
				$.ajax({
					type: 'POST',
					url: '<?php echo $this->createUrl('verifikasi'); ?>',
//					url: '<?php // echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/verifikasi'); ?>',
					data: $("form").serialize(),
					dataType: "json",
					success: function (data) {
                                            console.log(data.content);
						$('#dialog-verifikasi > .dialog-content').html(data.content);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					}
				});
				//untuk verifikasi hilangkan srbac loading
				$(".animation-loading").removeClass("animation-loading");
				$("form").find('.float').each(function () {
					$(this).val(formatFloat($(this).val()));
				});
				$("form").find('.integer').each(function () {
					$(this).val(formatInteger($(this).val()));
				});
			}
		}else{
			myAlert("Silakan Pilih Ruangan Penunjang Tujuan!");
			return false;
		}
		x = $('input:radio[name="PPPasienM[jeniskelamin]"]:checked').val();
		if(x!=undefined){
			$('#jenkel').removeClass("error");
		}else{
			$('#jenkel').addClass("error");
		}
		return false;
	}

    function setChecklistPemeriksaanLab(obj,form_index){
        var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
        var ruangan_id = $(obj).find("input[name$='[ruangan_id]']").val();
        var kelaspelayanan_id = $(obj).find("select[name$='[kelaspelayanan_id]']").val();
        $("#form_index").val(form_index);
        if(penjamin_id == ""){
            myAlert("Silahkan pilih penjamin!");
        }else if(kelaspelayanan_id == ""){
            myAlert("Silahkan pilih kelas pelayanan!");
        }else{
            $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
            $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
            $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
            updateChecklistPemeriksaanLab();
            $('#dialog-pilihpemeriksaan').dialog('open'); 
        }
    }
    
    function setChecklistPemeriksaan(obj,form_index){
        var penjamin_id = $("#<?php echo CHtml::activeId($model, 'penjamin_id') ?>").val();
        var ruangan_id = $(obj).find("input[name$='[ruangan_id]']").val();
        var kelaspelayanan_id = $(obj).find("select[name$='[kelaspelayanan_id]']").val();
        $("#form_index").val(form_index);
        if(penjamin_id == ""){
            myAlert("Silahkan pilih penjamin!");
        }else if(kelaspelayanan_id == ""){
            myAlert("Silahkan pilih kelas pelayanan!");
        }else{
            $("#form-caripemeriksaan").find("input[name$='[ruangan_id]']").val(ruangan_id);
            $("#form-caripemeriksaan").find("input[name$='[penjamin_id]']").val(penjamin_id);
            $("#form-caripemeriksaan").find("input[name$='[kelaspelayanan_id]']").val(kelaspelayanan_id);
            updateChecklistPemeriksaan();
            $('#dialog-pilihpemeriksaan').dialog('open'); 
        }
    }

    function updateChecklistPemeriksaanLab(){
        var form_index = $('#form_index').val();
        $('#dialog-pilihpemeriksaan .dialog-content').addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/pendaftaranPenjadwalan/PendaftaranPenunjang/SetChecklistPemeriksaanLab'); ?>',
            data: {data:$("#form-caripemeriksaan :input").serialize()},
            dataType: "json",
            success:function(data){
                $('#dialog-pilihpemeriksaan .dialog-content').html(data.content);
                $('.checkboxlist-tile').tile({widths : [ 190 ]});
                $('#dialog-pilihpemeriksaan .dialog-content').removeClass("animation-loading");
                setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('#dialog-pilihpemeriksaan .dialog-content'));
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function updateChecklistPemeriksaan(){
        var form_index = $('#form_index').val();
        $('#dialog-pilihpemeriksaan .dialog-content').addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/pendaftaranPenjadwalan/PendaftaranPenunjang/SetChecklistPemeriksaan'); ?>',
            data: {data:$("#form-caripemeriksaan :input").serialize()},
            dataType: "json",
            success:function(data){
                $('#dialog-pilihpemeriksaan .dialog-content').html(data.content);
                $('.checkboxlist-tile').tile({widths : [ 190 ]});
                $('#dialog-pilihpemeriksaan .dialog-content').removeClass("animation-loading");
                setCheckedPemeriksaan($("#form-tindakanpemeriksaan-"+form_index),$('#dialog-pilihpemeriksaan .dialog-content'));
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function setCheckedPemeriksaan(obj_table,obj_dialog){
        var form_index = $('#form_index').val();
        $(obj_table).find('input[name$="[pemeriksaanlab_id]"]').each(function(){
            var pemeriksaanlab_id = $(this).val();
            $(obj_dialog).find('input[name$="[is_pilih]"][value='+pemeriksaanlab_id+']').attr('checked',true);
        });

    }
    
    function setChecklistPemeriksaanLabReset(){
        $("#form-caripemeriksaan").find("input:not(:disabled):not([readonly])").each(function(){
            $(this).val("");
        });
        updateChecklistPemeriksaanLab();
    }
    
    /**
    * Centang pemeriksaan lab dari checkboxlist
    */
   function pilihPemeriksaanIni(obj){
       var form_index = $('#form_index').val();
       var pemeriksaanlab_id = $(obj).val();
       var pemeriksaanlab_nama = $(obj).parent().find('input[name$="[pemeriksaanlab_nama]"]').val();
       var daftartindakan_id = $(obj).parent().find('input[name$="[daftartindakan_id]"]').val();
       var jenistarif_id = $(obj).parent().find('input[name$="[jenistarif_id]"]').val();
       var harga_tariftindakan = $(obj).parent().find('input[name$="[harga_tariftindakan]"]').val();
       var rowtindakan = [];
       rowtindakan[0] = '<?php echo CJSON::encode($this->renderPartial('_rowTindakanPemeriksaan',array('i'=>0,'modTindakan'=>$modTindakan),true));?>';
       rowtindakan[1] = '<?php echo CJSON::encode($this->renderPartial('_rowTindakanPemeriksaan',array('i'=>1,'modTindakan'=>$modTindakan),true));?>';
       rowtindakan[2] = '<?php echo CJSON::encode($this->renderPartial('_rowTindakanPemeriksaan',array('i'=>2,'modTindakan'=>$modTindakan),true));?>';
       rowtindakan[3] = '<?php echo CJSON::encode($this->renderPartial('_rowTindakanPemeriksaan',array('i'=>3,'modTindakan'=>$modTindakan),true));?>';
       if($(obj).is(':checked')){
           $("#form-tindakanpemeriksaan-"+form_index).find('tbody').append(rowtindakan[form_index]);
           $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
           $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
           $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
           $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);$("#form-tindakanpemeriksaan-"+form_index).find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
           $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
           $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(harga_tariftindakan));
           $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(harga_tariftindakan));
       }else{
           var delete_row = $("#form-tindakanpemeriksaan-"+form_index).find('input[name$="[pemeriksaanlab_id]"][value="'+pemeriksaanlab_id+'"]').parents('tr');
           delete_row.detach();
       }
       renameInputRow($("#form-tindakanpemeriksaan-"+form_index));
   }
   /**
    * rename input row yang terakhir di tambahkan
    * @param {type} obj_table
    */
   function renameInputRow(obj_table){
       var row = 0;
       $(obj_table).find("tbody > tr").each(function(){
           $(this).find("#no_urut").val(row+1);
           $(this).find('span').each(function(){ //element <span>
               var old_name = $(this).attr("name").replace(/]/g,"");
               var old_name_arr = old_name.split("[");
               if(old_name_arr.length == 3){
                   $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
               }
           });
           $(this).find('input,select,textarea').each(function(){ //element <input>
               var old_name = $(this).attr("name").replace(/]/g,"");
               var old_name_arr = old_name.split("[");
               if(old_name_arr.length == 4){
                   $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                   $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
               }
           });
           row++;
       });

   }

$(document).ready(function() {
    $("#form-masukpenunjang-3 a").click(function() {
        $("#form-karcis-3 a").click();
    });
	$("#form-masukpenunjang-4 a").click(function() {
        $("#form-karcis-4 a").click();
    });
});
</script>
    