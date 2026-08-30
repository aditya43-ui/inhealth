<script>
    function tambah()
    {
        var peluang_descriptor = $('#peluang_descriptor').val();
        var peluang_bobotdescriptor = $('#peluang_bobotdescriptor').val();
        var peluang_deskripsi = $('#peluang_deskripsi').val();
        var peluang_frekuensi = $('#peluang_frekuensi').val();
        var peluang_kemungkinan = $('#peluang_kemungkinan').val();
        var cek = $('#aktif').prop('checked');
        if(cek == true){
            var aktif = 1; 
        }else{
            var aktif = 0;
        }
        $.post('<?php echo $this->createUrl('getTabel'); ?>', { 
            peluang_descriptor:peluang_descriptor, 
            peluang_bobotdescriptor:peluang_bobotdescriptor, 
            peluang_deskripsi:peluang_deskripsi, 
            peluang_frekuensi:peluang_frekuensi,
            peluang_kemungkinan:peluang_kemungkinan,
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
        $('#peluang_descriptor').val("");
        $('#peluang_bobotdescriptor').val("");
        $('#peluang_deskripsi').val("");
        $('#peluang_frekuensi').val("");
        $('#peluang_kemungkinan').val("");
        $('#aktif').val("");
    }
</script>