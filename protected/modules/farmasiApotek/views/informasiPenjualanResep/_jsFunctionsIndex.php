<script type ='text/javascript'>
/**
 * memanggil antrian ke farmasi apotek
 * @param {type} penjualanresep_id
 * @returns {undefined} */
function panggilAntrian(penjualanresep_id,antrianfarmasi_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('PanggilAntrian'); ?>',
        data: {penjualanresep_id:penjualanresep_id},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            if(data.smspasien==0){
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                insert_notifikasi(params);
            } 
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            console.log("Panggil");
            socket.emit('send',{conversationID:'antrian',panggil:5,antrian_id:antrianfarmasi_id});
            <?php } ?>
            $.fn.yiiGridView.update('informasipenjualanresep-grid');
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * mengecek hak akses pembatalan penjualan
 * @returns {undefined} */
function cekHakBatal(penjualanresep_id)
{
	$.ajax({
		url:'<?php echo $this->createUrl('cekHakAkses',array('action'=>'batalPenjualanResep')) ?>',
		data:{},
		type:'post',
		dataType:'json',
		success:function(data){
			if(data.cekAkses){
				batalPenjualanResep(penjualanresep_id)
			} else {
				$('#penjualanresep_id').val(penjualanresep_id);
				$("#untukaction").val('batalPenjualanResep');
				$("#username").val('');
				$("#password").val('');
				$('#logindialog').dialog('open');
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);},
		cache:false
	});
}
/**
 * melakukan pembatalan penjualan resep 
 * @returns {undefined} */
function batalPenjualanResep(penjualanresep_id){
	myConfirm('Anda yakin akan membatalkan penjualan resep ini?','Perhatian!',
	function(r){
		if(r){
			$.ajax({
                url:'<?php echo $this->createUrl('batalPenjualanResep');?>',
                data:{penjualanresep_id:penjualanresep_id},
                type:'post',
                dataType:'json',
                success:function(data){
						if(data.pesan){
							myAlert(data.pesan);
						}
						refreshTable();
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);},
                cache:false,
            });
		}
	}); 

}
/**
 * refresh table agar terlihat perubahan dari transaksi
 * @returns {undefined} */
function refreshTable(){
	var grid_id = $(".grid-view").attr("id");
	$.fn.yiiGridView.update(grid_id, {
		data: $('#search').serialize()
	});
}
/**
 * submit form login (dialog box) jika user ini tidak memiliki hak untuk membatalkan
 * @returns {undefined} */
function submitLogin()
{
	$('#loginform .form-actions').addClass('animation-loading-1');
	var untukaction = $("#untukaction").val();
	$.ajax({
		url:'<?php echo $this->createUrl('ajaxLogin')?>',
		data:$('#loginform').serialize(),
		type:'post',
		dataType:'json',
		success:function(data){
			if(data.pesan != ''){
				myAlert(data.pesan);
			}
			if(data.sukses == 1){
				var penjualanresep_id = $('#penjualanresep_id').val();
				if(untukaction == 'batalPenjualanResep'){
					batalPenjualanResep(penjualanresep_id);
					$('#logindialog').dialog('close');
				}
			}
			$('#loginform .form-actions').removeClass('animation-loading-1');
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);},
		cache:false
	});
}
</script>