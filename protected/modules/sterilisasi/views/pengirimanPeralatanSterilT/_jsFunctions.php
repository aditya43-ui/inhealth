<script type="text/javascript">
function cekNoPenyimpanan(){
var penyimpanansteril_no=$("#<?php echo CHtml::activeId($modCari,"penyimpanansteril_no");?>").val();
	if (penyimpanansteril_no == ""){
		myAlert('Isi No. Penyimpanan yang akan dicari');
		return false;
	}else{
		$("#cspengirimanalatsteril-t-form").submit();
		return false;
	}
}

function cekPengiriman(){
var ruangan_id=$("#<?php echo CHtml::activeId($model,"ruangan_id");?>").val();
var jmlRow = $('#table-peralatansteril tbody tr').length;
var pegpengirim_id=$("#<?php echo CHtml::activeId($model,"pegpengirim_id");?>").val();
	if (ruangan_id == ""){
		myAlert('Silakan pilih ruangan data pengiriman!');
		return false;
	}else if (pegpengirim_id == ""){
		myAlert('Pegawai Pengirim belum dipilih!');
		return false;
	}else if(jmlRow === 0){
		myAlert('Peralatan dan Linen belum dipilih!');
		return false;
	}else{
		$("#cspengirimanalatsteril-t-form").submit();
		return false;
	}
}

function print(caraPrint)
{
    var kirimperlinensteril_id = '<?php echo isset($_GET['kirimperlinensteril_id']) ? $_GET['kirimperlinensteril_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&kirimperlinensteril_id='+kirimperlinensteril_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	var jmlRow = $('#table-peralatansteril tbody tr').length;
	if(jmlRow === 0){
		$('#pencarian').attr('disabled',false);
	}else{
		$('#pencarian').attr('disabled',true);
	}
//            $('form').bind('click keyup select change', function(event) { 
//                  cekDisabled(this); 
//            });  

           /* $(document).on('click keyup select change',function(){  
                  cekDisabled('form'); 
            }); 
            cekDisabled('form'); */
});
</script>