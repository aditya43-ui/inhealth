<script type="text/javascript">
var trBahan=new String(<?php echo CJSON::encode($this->renderPartial('_rowPeralatan',array('model'=>$model,'modDetail'=>$modDetail,'form'=>$form,'removeButton'=>true),true));?>);
var trBahanFirst=new String(<?php echo CJSON::encode($this->renderPartial('_rowPeralatan',array('model'=>$model,'modDetail'=>$modDetail,'form'=>$form,'removeButton'=>false),true));?>);

function submitBarang(id, nama){
	var bariske = $("#bariske").val();
	$('#STPenerimaansterilisasidetT_'+bariske+'_barang_nama').val(nama);
	$('#STPenerimaansterilisasidetT_'+bariske+'_barang_id').val(id);
}

function setDialog(obj){
       var bariske = $(obj).parents('tr').find('input[name$="row"]').val();
        $("#bariske").val(bariske);
        $("#dialogPeralatan").dialog("open");
    }    
	
function batalBarang(obj)
    {
        myConfirm('Apakah Anda yakin akan membatalkan Barang ini?','Perhatian!',
        function(r){
            if(r){
                $(obj).parents('tr').next('tr').detach();
                $(obj).parents('tr').detach();
                
                <?php 
                $attributes = $modDetail->attributeNames(); 
                    foreach($attributes as $i=>$attribute){
                        echo "renameInput('STPenerimaansterilisasidetT','$attribute');";
                    }
                ?>
                renameInput('STPenerimaansterilisasidetT','barang_nama');
            }
        });
    }
function addRowBarang(obj)
    {
        $(obj).parents('table').children('tbody').append(trBahan.replace());
        <?php 
        $attributes = $modDetail->attributeNames(); 
            foreach($attributes as $i=>$attribute){
                echo "renameInput('STPenerimaansterilisasidetT','$attribute');";
            }
        ?>
        renameInput('STPenerimaansterilisasidetT','barang_nama');
        
        $(obj).parents('tr').find('input[name$="[barang_nama]"]').autocomplete({'showAnim':'fold','minLength':3,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.barang_nama);
                                                                                    $(this).parents("tr").find("input[name$=\"[penerimaansterilisasidet_jml]\"]").val(1);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutoCompleteBarang');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
                                                                                
        $(obj).parents('table').find('tr:last').find('.integer').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}); //set hanya tr terakhir agar tidak error valuenya RSSP-942
    }
	
function clear(){
        urut = 1;
            $(".noUrut").each(function(){
                    $(this).val(urut);
                     urut++;
                });
    }
	
function renameInput(modelName,attributeName)
    {
        var trLength = $('#tblDetailPeralatan tr').length;
        var i = -1;
        $('#tblDetailPeralatan tr').each(function(){
            if($(this).has('input[name$="[barang_id]"]').length){
                i++;
            }
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            $(this).find('input[id="row"]').attr('value',i);
            $(this).find('input[id="row"]').val(i)
            $(this).find('input[name$="[barang_nama]"]').addClass('ui-autocomplete-input');
            $(this).find('input[name$="[barang_nama]"]').autocomplete({'showAnim':'fold','minLength':3,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    $(this).val(ui.item.value);
                                                                                    $(this).parents("tr").find("input[name$=\"[barang_id]\"]").val(ui.item.barang_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.barang_nama);
                                                                                    $(this).parents("tr").find("input[name$=\"[penerimaansterilisasidet_jml]\"]").val(1);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutoCompleteBarang');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });   
        });
        clear();
    }

function print(caraPrint)
{
    var penerimaansterilisasi_id = '<?php echo isset($_GET['penerimaansterilisasi_id']) ? $_GET['penerimaansterilisasi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penerimaansterilisasi_id='+penerimaansterilisasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function refreshDialog(){      
    $("#namaperalatan").addClass('animation-loading-1');
    
    var jenisperalatan = $("#jenisperalatan option:selected").text();
    
    
    if (jenisperalatan == "-- Pilih --"){
            jenisperalatan = "(Jenis Peralatan Belum Dipilih)";
    }
    
    
    $("#namaperalatan_dialog").html(jenisperalatan);
    
    
    
    
    setTimeout(function(){                                
            $("#namaperalatan").removeClass('animation-loading-1');
            var jenis = $('#jenisperalatan option:selected').val();        

            $(".dialog_jenisperalatan").val(jenis);                            
            
            if (jenis == '<?php echo Params::JENIS_PERALATAN_LINEN ?>'){
                $("#ganti-judul").html("Linen");
            }else if (jenis == '<?php echo Params::JENIS_PERALATAN_BARANG ?>'){
                $("#ganti-judul").html("Barang");
            }else if (jenis == '<?php echo Params::JENIS_PERALATAN_ALATMEDIS ?>'){
                
            }
            
            $.fn.yiiGridView.update('peralatan-m-grid', {
                    data: {
                            "PeralatansterilisasiM[jenisperalatan]":jenis,			
                    }
            });
    },500);
}

function inputPeralatanLinen(){
	var peralatansterilisasi_id = $('#peralatansterilisasi_id').val();
        var barang_id = $('#barang_id').val();
	var jumlah = $('#jml').val();
        var keadaanperalatan = $('#keadaanperalatan option:selected').val();
        var jenisperalatan = $('#jenisperalatan option:selected').val();
        
	if (!jQuery.isNumeric(peralatansterilisasi_id)){
		myAlert('Peralatan belum dipilih!');
		return false;
	}else if (!jQuery.isNumeric(jumlah)){
		myAlert('Silakan tentukan Jumlah yang akan diajukan!');
		return false;
        }else  if (keadaanperalatan == ''){
                myAlert('Keadaan belum dipilih!');
		return false;
	}else{
            var count = 0;
            var countKeadaan = 0;
            
            $('#table-linen > tbody > tr').each(function(){
                if ($(this).find('.peralatan_id').val() == peralatansterilisasi_id){
                    count++;
                }
                
                if (keadaanperalatan != $(this).find('.keaadaan').val()){
                    countKeadaan++;
                }
            });
            
            if (count > 0){
                myAlert("Peralatan sudah ditambahkan");
                return false;
            }else{            
                
                 if (countKeadaan > 0){
                    myAlert("Keadaan tidak boleh berbeda, dengan data yang sebelumnya sudah ditambahkan");
                    return false;
                }else{ 
                
                
                    $('#table-linen').addClass("animation-loading");
                    $.ajax({
                        type:'POST',
                        url:'<?php echo $this->createUrl('loadFormLine'); ?>',
                        data: {keadaanperalatan:keadaanperalatan, peralatansterilisasi_id:peralatansterilisasi_id, jumlah:jumlah,jenisperalatan:jenisperalatan,barang_id:barang_id},
                        dataType: "json",
                        success:function(data){
                            $('#tblDetailPeralatan > tbody').append(data.form);
                            $('#tblDetailPeralatan').removeClass("animation-loading");
                            $("#tblDetailPeralatan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                            );
                            
                            renameInputRowBarang($("#tblDetailPeralatan"));
                            clearJumlah();
                        },
                        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                    });
                }
                
            }
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

function clearJumlah(){

	$('#formLinen').find('input').each(function(){
		$(this).val('');
	});
	$('#jml').val(1);
}

$('#tombolPeralatan').click(function(){
    var jenis = $('#jenisperalatan').val();
    
    if (jenis == ''){        
        $("#dialogPeralatan").dialog("close");
        myAlert("Jenis peralatan belum dipilih!");
    }
});

function validasiCek(){
    if(requiredCheck($("form"))){
        var jumlah_bahan = $('#tblDetailPeralatan tbody tr').length;
        if(jumlah_bahan <= 0){
            myAlert('Silakan isi table peralatan CSSD terlebih dahulu!');
            return false;
        }else{
            $('#cspenerimaanperalatansteril-t-form').submit();
        }
        
    }
    return false;    
}

$( document ).ready(function(){
    $('form').bind('click keyup select change', function(event) { 
        cekDisabled(this); 
    });  

    $(document).on('click keyup select change',function(){  
        cekDisabled('form'); 
    }); 
    cekDisabled('form'); 
});
</script>