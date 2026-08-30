<script>
    function tambah()
    {

        var nama = $('#nama').val();
        var namalain = $('#namalain').val();
        var tipeinsiden_id = $('#tipeinsiden_id').val();
        var kelompoksubtipeinsiden_id = $('#kelompoksubtipeinsiden_id').val();
        var cek = $('#aktif').prop('checked');
        if(cek == true){
            var aktif = 1; 
        }else{
            var aktif = 0;
        }
        $.post('<?php echo $this->createUrl('getTabel'); ?>', { 
            nama:nama, 
            namalain:namalain, 
            tipeinsiden_id:tipeinsiden_id, 
            kelompoksubtipeinsiden_id:kelompoksubtipeinsiden_id, 
            aktif:aktif},
        function(data){
            if(data.message == 'sukses'){
                var cekAda = 0;
                $('#table-master').find("tbody > tr").each(function(){
                   var tipeinsiden_id = $(this).find('.tipeinsiden_id').val();
                   var kelompoksubtipeinsiden_id = $(this).find('.kelompoksubtipeinsiden_id').val();
                   var nama = $(this).find('.nama').val();
                   if((tipeinsiden_id == data.tipeinsiden_id) && (nama == data.nama) && (kelompoksubtipeinsiden_id == data.kelompoksubtipeinsiden_id)){
                       cekAda = 1;
                   }
                });
                if(cekAda == 0){
                    $('#table-master > tbody').append(data.return);
                    $("#table-master tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                    resetForm();
                    renameInputRow($("#table-master"));
                }else{
                    myAlert('Data duplikat');
                    return false;
                }
            }else{
                myAlert('Data sudah ada');
                return false;
            }
        }, "json");
    }
    
    function setSubtipeInsiden()
    {
        var tipeinsiden_id = $('#tipeinsiden_id').val();
        var kelompoksubtipeinsiden_id = $('#kelompoksubtipeinsiden_id').val();
        if(tipeinsiden_id != '' && kelompoksubtipeinsiden_id != ''){
            $("#table-master").addClass("animation-loading");
            $('#table-master > tbody').html("");
            $.post('<?php echo $this->createUrl('setTabel'); ?>', { 
                tipeinsiden_id:tipeinsiden_id, 
                kelompoksubtipeinsiden_id:kelompoksubtipeinsiden_id
            },
            function(data){
                $('#table-master > tbody').append(data.form);
                $("#table-master tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
                renameInputRow($("#table-master"));
                $("#table-master").removeClass("animation-loading");
            }, "json");
        }else{
            $("#table-master").addClass("animation-loading");
            $('#table-master > tbody').html("");
            $("#table-master").removeClass("animation-loading");
        }
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
    
    function hapus(obj){
	var subtipeinsiden_id = $(obj).parents("tr").find("input[name$='[subtipeinsiden_id]']").val();
	myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
            function(r){
                    if(r){
                        $.ajax({
                                type:'POST',
                                url:'<?php echo $this->createUrl('DeleteSubtipe'); ?>&id='+subtipeinsiden_id,
                                data: {id : subtipeinsiden_id},//
                                dataType: "json",
                                success:function(data){
                                        if(data.sukses == 1){
                                                $(obj).parents('tr').detach();
                                                renameInputRow($("#table-master"));
                                        }
                                        myAlert(data.pesan);
                                        var rowCount = $("#table-master").find('tbody tr').length;						
                                },
                                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                        });
                    }
            });
    }
    
    function namaLain(nama)
    {
        document.getElementById('namalain').value = nama.value.toUpperCase();
    }
    
    function resetForm(){
        $('#nama').val("");
        $('#namalain').val("");
        //$('#tipeinsiden_id').val("");
        //$('#kelompoksubtipeinsiden_id').val("");
        $('#aktif').attr('checked',true);
    }
</script>