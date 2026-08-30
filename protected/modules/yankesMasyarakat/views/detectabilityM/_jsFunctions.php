<script>
    function tambah()
    {
        var detectability_bobot = $('#detectability_bobot').val();
        var detectability_deskripsi = $('#detectability_deskripsi').val();
        var detectability_kemungkinan = $('#detectability_kemungkinan').val();
        var cek = $('#aktif').prop('checked');
        if(cek == true){
            var aktif = 1; 
        }else{
            var aktif = 0;
        }
        $.post('<?php echo $this->createUrl('getTabel'); ?>', { 
            detectability_bobot:detectability_bobot, 
            detectability_deskripsi:detectability_deskripsi, 
            detectability_kemungkinan:detectability_kemungkinan, 
            aktif:aktif},
        function(data){
            $('#table-master > tbody').append(data.return);
            $("#table-master tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
            resetForm();
            renameInputRow($("#table-master"));
        }, "json");
    }
    
    function renameInputRow(obj_table){
	var row = 0;	
	$(obj_table).find("tbody > tr").each(function(){
		$(this).find('.nourut').val(row+1);
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
    
    function hapusTemporary(obj){
        $(obj).parents('tr').detach();
        renameInputRow($("#table-master"));
    }
    
    function resetForm(){
        $('#detectability_bobot').val("");
        $('#detectability_deskripsi').val("");
        $('#detectability_kemungkinan').val("");
    }
</script>