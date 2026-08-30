<script type="text/javascript">
function cekNoPengajuan(){
var pengajuansterlilisasi_no=$("#<?php echo CHtml::activeId($modCari,"pengajuansterlilisasi_no");?>").val();
	/*if (pengajuansterlilisasi_no == ""){
		myAlert('Isi No. Pengajuan yang akan dicari');
		return false;
	}else{
		$("#cspenerimaanperalatansteril-t-form").submit();
		return false;
	}*/
    $("#cspenerimaanperalatansteril-t-form").submit();
		return false;
}
function searchPenerimaan(){
	$('#table-peralatansteril').addClass('animation-loading');
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pencarianPenerimaanView'); ?>',
		//data: {data:$('#pencarian-form').serialize()},//
        data: $("#pencarian-form").serialize(),
		dataType: "json",
		success:function(data){
			$('#table-peralatansteril > tbody').html("");
			if(data.pesan !== ""){
				myAlert(data.pesan);
				$('#table-peralatansteril').removeClass('animation-loading');
				return false;
			}
			$('#table-peralatansteril').html(data.form);
			
			renameInputRow($("#table-peralatansteril"));
			$('#table-peralatansteril').removeClass('animation-loading');
            $("#STPenerimaansterilisasiT_penerimaansterilisasi_ket").blur();
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}
function print(caraPrint)
{
    var penerimaansterilisasi_id = '<?php echo isset($_GET['penerimaansterilisasi_id']) ? $_GET['penerimaansterilisasi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penerimaansterilisasi_id='+penerimaansterilisasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
} 

function cekTabel(){

    if(requiredCheck($('#cspenerimaanperalatansteril-t-form'))){
        var jmlRow = $('#table-peralatansteril tbody tr').length;
        if(jmlRow === 0){
            myAlert('Peralatan dan Linen belum dipilih');
            return false;
        }else{
            $("#cspenerimaanperalatansteril-t-form").submit();
            return false;
        }
        return false;
    }
}

function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){		
        $(this).find("#no_urut").val(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        $(this).find('input[name$="[maininput]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+row);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        row++;
    });	
}

$(document).ready(function(){
	/*var jmlRow = $('#table-peralatansteril tbody tr').length;
	if(jmlRow === 0){
		$('#pencarian').attr('disabled',false);
	}else{
		$('#pencarian').attr('disabled',true);
	}*/
           
    <?php if(isset($_GET['sukses'])){ ?>
        $("input, select, textarea").attr("readonly",true);
		$(".btn-mini, .add-on").detach();
		
    <?php } ?>
    
    
    // Notifikasi Pasien
     //cekDisabled($('#cspenerimaanperalatansteril-t-form'));
   setValidasiCekDisabled($("#cspenerimaanperalatansteril-t-form"), function() {
		if ($("#table-peralatansteril tbody tr").length == 0) {
			return false;	
		}
		return true;
	});
       
});
</script>