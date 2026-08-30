<script type="text/javascript">
   function tambahBarang() {
     invperalatan_id = $('#invperalatan_id').val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getBarang'); ?>',
        data: {invperalatan_id:invperalatan_id},
        dataType: "json",
        success:function(data){
            $('#table-detailbarang > tbody').append(data);
            $('#table-detailbarang').removeClass("animation-loading");
            renameInputRowBarang($("#table-detailbarang"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }
    
    function inputBarang(){
     invperalatan_id = $('#invperalatan_id').val();
	if (!jQuery.isNumeric(invperalatan_id)){
		myAlert('Isi Barang yang akan dipesan');
		return false;
	}
	else{
		$('#table-detailbarang').addClass("animation-loading");
		cekList(invperalatan_id);
	}        
    }
    
    function cekList(id){
	x = true;
	$('.barang').each(function(){
		if ($(this).val() == id){
			myAlert('Barang telah ada d List');
			x = false;
		}else{

		}
	});

	if(x==true){
                    tambahBarang();
	return x;
        }
    }   
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
    
    function batal(obj){
	if(!confirm('Apakah anda akan membatalkan barang ini ?')) {
	return false;
	}else{
	$(obj).parents('tr').remove();
	rename();
	}
    }
    
    /* fungsi baru untuk input Data Aset*/
var row = <?php echo CJSON::encode(array('html'=>$this->renderPartial('ajaxLoadAset', array(), true))); ?>;
function tambahRowBarang(obj) {
    var last = "";
    if (obj != null) {
        $(obj).parents("tr").after(row.html);
        renameInput();
        last = $("#tableDetailBarang tbody tr").eq($(obj).parents("tr").index() + 1);
        console.log($(obj).parents("tr").index());
    } else {
        $("#tableDetailBarang tbody").append(row.html);
        renameInput();
        last = $("#tableDetailBarang tbody tr:last-child");
    }
    jQuery(last).find('.invperalatan_nama').autocomplete(
        {
            'showAnim':'fold',
            'minLength':3,
            'focus':function(event, ui )
            {
                $(this).val( ui.item.label);
            },
            'select':function( event, ui )
            {
                $(this).parents("tr").find(".invperalatan_id").val(ui.item.invbarang_id);
                $(this).val(ui.item.invperalatan_namabrg);
                setBarang($(this), ui.item);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('ajaxGetPeralatan'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
}

function renameInput() {
    var cnt = 0;
    $("#tableDetailBarang tbody tr").each(function() {
        $(this).find(".invperalatan_id").prop("name", "MAPengeluaranasetdetT[" + cnt + "][invperalatan_id]");
        $(this).find(".invperalatan_nama").prop("name", "MAPengeluaranasetdetT[" + cnt + "][invperalatan_nama]");
        $(this).find(".pengeluaranaset_keadaan").prop("name", "MAPengeluaranasetdetT[" + cnt + "][pengeluaranaset_keadaan]");
        $(this).find(".ket_pengeluaranaset").prop("name", "MAPengeluaranasetdetT[" + cnt + "][ket_pengeluaranaset]");
        $(this).data('row', cnt);
        cnt++;
    });
}   
    
var row_no = 0;
function setDialog(obj) {
    row_no = $(obj).parents("tr").data('row');
    
    $("#dialogPeralatan").dialog("open");
}

function setPeralatan(data) {
    console.log(data);
    $("#tableDetailBarang tbody tr").each(function() {
        if ($(this).data('row') == row_no) {
            $(this).find("#invperalatan_nama").val(data.invperalatan_namabrg);
            setBarang($(this).find(".pengeluaranaset_keadaan"), data);
        }
    });
}

function setBarang(obj, data) {
    $(obj).parents("tr").find(".no_aset").html(data.invperalatan_kode + " / " + data.invperalatan_noregister);
    $(obj).parents("tr").find(".merk").html(data.invperalatan_merk + " / " + data.invperalatan_ukuran + " / " + data.invperalatan_bahan);
    $(obj).parents("tr").find(".thn_beli").html(data.invperalatan_thnpembelian);
    $(obj).parents("tr").find(".pengeluaranaset_keadaan").val(data.invperalatan_keadaan);
    $(obj).parents("tr").find(".invperalatan_id").val(data.invperalatan_id);
}

function batalRowBarang(obj) {
    $(obj).parents("tr").remove();
    renameInput();
}
</script>

