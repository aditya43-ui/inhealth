<script type="text/javascript">
var trBahan=new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowDetail',array('model'=>$model,'modDetail'=>$modDetail,'form'=>$form,'removeButton'=>true),true));?>);
var trBahanFirst=new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowDetail',array('model'=>$model,'modDetail'=>$modDetail,'form'=>$form,'removeButton'=>false),true));?>);

function submitLinen(id, no, nama){
	var bariske = $("#bariske").val();
	$('#LAPenerimaanlinendetailT_'+bariske+'_linen_id').val(id);
	$('#LAPenerimaanlinendetailT_'+bariske+'_noregisterlinen').val(no);
	$('#LAPenerimaanlinendetailT_'+bariske+'_barang_nama').val(nama);
}

function setDialog(obj){
       var bariske = $(obj).parents('tr').find('input[name$="row"]').val();
        $("#bariske").val(bariske);
        $("#dialogLinen").dialog("open");
    }    
	
function batalLinen(obj)
    {
        myConfirm('Apakah Anda yakin akan membatalkan Linen ini?','Perhatian!',
        function(r){
            if(r){
                $(obj).parents('tr').next('tr').detach();
                $(obj).parents('tr').detach();
                
                <?php 
                $attributes = $modDetail->attributeNames(); 
                    foreach($attributes as $i=>$attribute){
                        echo "renameInput('LAPenerimaanlinendetailT','$attribute');";
                    }
                ?>
                renameInput('LAPenerimaanlinendetailT','barang_nama');
				renameInput('LAPenerimaanlinendetailT','noregisterlinen');
            }
        });
    }
function addRowLinen(obj)
    {
        $(obj).parents('table').children('tbody').append(trBahan.replace());
        <?php 
        $attributes = $modDetail->attributeNames(); 
            foreach($attributes as $i=>$attribute){
                echo "renameInput('LAPenerimaanlinendetailT','$attribute');";
            }
        ?>
        renameInput('LAPenerimaanlinendetailT','barang_nama');
        renameInput('LAPenerimaanlinendetailT','noregisterlinen');
        $(obj).parents('tr').find('input[name$="[barang_nama]"]').autocomplete({'showAnim':'fold','minLength':3,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    $(this).parents("tr").find("input[name$=\"[linen_id]\"]").val(ui.item.linen_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[noregisterlinen]\"]").val(ui.item.noregisterlinen);
                                                                                    $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.namalinen);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutocompleteRegisterLinen');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        namalinen: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                }); 
		
		$(obj).parents('tr').find('input[name$="[noregisterlinen]"]').autocomplete({'showAnim':'fold','minLength':3,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    $(this).parents("tr").find("input[name$=\"[linen_id]\"]").val(ui.item.linen_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[noregisterlinen]\"]").val(ui.item.noregisterlinen);
                                                                                    $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.namalinen);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutocompleteRegisterLinen');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        noregisterlinen: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });
                                                                                
//        $(obj).parents('table').find('tr:last').find('.integer').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}); //set hanya tr terakhir agar tidak error valuenya RSSP-942
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
        var trLength = $('#table-linen tr').length;
        var i = -1;
        $('#table-linen tr').each(function(){
            if($(this).has('input[name$="[linen_id]"]').length){
                i++;
            }
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
			$(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            $(this).find('input[id="row"]').attr('value',i);
            $(this).find('input[id="row"]').val(i)
            $(this).find('input[name$="[barang_nama]"]').addClass('ui-autocomplete-input');
            $(this).find('input[name$="[barang_nama]"]').autocomplete({'showAnim':'fold','minLength':3,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    $(this).val(ui.item.namalinen);
																					$(this).parents("tr").find("input[name$=\"[linen_id]\"]").val(ui.item.linen_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[noregisterlinen]\"]").val(ui.item.noregisterlinen);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutocompleteRegisterLinen');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        namalinen: request.term,
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });  
																				
			$(this).find('input[name$="[noregisterlinen]"]').addClass('ui-autocomplete-input');
            $(this).find('input[name$="[noregisterlinen]"]').autocomplete({'showAnim':'fold','minLength':3,'focus':function( event, ui ) {
                                                                                    $(this).val("");
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    $(this).val(ui.item.noregisterlinen);
																					$(this).parents("tr").find("input[name$=\"[linen_id]\"]").val(ui.item.linen_id);
                                                                                    $(this).parents("tr").find("input[name$=\"[barang_nama]\"]").val(ui.item.namalinen);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo $this->createUrl('AutocompleteRegisterLinen');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        noregisterlinen: request.term,
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

function unformatNumbers() {
	$('.integer').each(function () {
		this.value = unformatNumber(this.value)
	});
}
</script>