<script type="text/javascript">
function inputLinen(){
	noregisterlinen = $('#noregisterlinen').val();
	linen_id = $('#linen_id').val();
	jumlah = unformatNumber($('#jumlah').val());
	jenisperawatan = $('#jenisperawatan').val();
	keterangan_pengperawatan = $('#keterangan_pengperawatan').val();
	if (!jQuery.isNumeric(linen_id)){
		myAlert('Isi Linen atau No Registrasi yang akan diajukan');
		return false;
	}
	else if (jenisperawatan == ''){
		myAlert('Silakan pilih jenis perawatan yang akan diajukan!');
		return false;
	}
	else{
		$('#table-linen').addClass("animation-loading");
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('loadFormLine'); ?>',
				data: {noregisterlinen:noregisterlinen, linen_id:linen_id, jenisperawatan:jenisperawatan, keterangan_pengperawatan:keterangan_pengperawatan,jumlah:jumlah},
				dataType: "json",
				success:function(data){
					$('#table-linen > tbody').append(data.form);
					$('#table-linen').removeClass("animation-loading");
					$("#table-linen").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":"","precision":0}
                    );
					renameInputRowBarang($("#table-linen"));
					clear();
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
			$('#table-linen').removeClass("animation-loading");
	}        
}
/**
* rename input grid
*/ 
function renameInputRowBarang(obj_table){
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

function clear(){
	$('#formLinen').find('input, select').each(function(){
		$(this).val('');
	});
	$('#jumlah').val(1);
}

function batalLinen(obj){
    myConfirm('Apakah Anda akan membatalkan linen ini?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').detach();
			rename();
        }
    });
}

function print(caraPrint)
{
    var pengperawatanlinen_id = '<?php echo isset($_GET['pengperawatanlinen_id']) ? $_GET['pengperawatanlinen_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&pengperawatanlinen_id='+pengperawatanlinen_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function unformatNumbers() {
	$('.integer').each(function () {
		this.value = unformatNumber(this.value)
	});
}
$( document ).ready(function(){
        cekDisabled($('#lapengajuanperawatan-t-form'));
        $('form').bind('click keyup select change', function(event) {
         cekDisabled(this);
      });
      $(document).on('click keyup select change','.ui-dialog-content',function(){
         cekDisabled('form');
      });
      
      // Notifikasi Pasien
    <?php 
        if(isset($_GET['sukses'])){
            if($_GET['sukses']==1){
    ?>
        //var params = [];
        //params = {instalasi_id:<?php echo Params::INSTALASI_ID_LAUNDRY; ?>, modul_id:<?php echo Params::MODUL_ID_LAUNDRY_NOTIF; ?>, judulnotifikasi:'PERMINTAAN PERAWATAN/PENCUCIAN LINEN', isinotifikasi:'Pengajuan perawatan atau pencucian linen dengan No. <?php echo $model->pengperawatanlinen_no; ?>, dari Ruangan: <?php echo $model->ruangan->ruangan_nama; ?>'}; 
        //insert_notifikasi(params);
    <?php            
            }
        }
    ?>
            
});
</script>