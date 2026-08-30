<script>
    function clearborder() { 
        $('.no_kantongpabrik').removeAttr('style');
        console.log('kkk')
    }

    function closeDialog(){
         window.parent.$("#dialogKantong").dialog('close');
    }
    function cekKantongDarah(nomor, obj) {
        var x = true;
        var barcode = $("#no_kantongdarah").val();

        if (barcode !== "") {
            pilihKantongDarah(nomor);
            $(obj).val('');
        }
    }

    function pilihKantongDarah(id) {
        var barcode = "barcode";        
        tambahKantongDarah(id, barcode);
    }
    function tambahKantongDarah(kantongdarah_id, tipe) {
        var kantongdarah_id = kantongdarah_id;
        var is_pilih = false;
        $('#pilih-kantong').find("tbody > tr").each(function () {
            if($(this).find('.det_kantongdarah_id').val() == kantongdarah_id) {
                is_pilih = true;
            }
        });
        if(is_pilih) {
            window.parent.myAlert("No. Kantong Darah sudah dipilih");
            return false;
        }
        var pendonor_id = <?php echo $_GET['pendonor_id'] ?>;
        console.log(kantongdarah_id);
        console.log(pendonor_id);
        $.post('<?php echo $this->createUrl('ajaxKantongDarah'); ?>',
            {kantongdarah_id: kantongdarah_id, pendonor_id: pendonor_id, tipe:tipe}, function (data) {
            var cnt = 1;
            if (data.data !== "") {
                toastr.error("Nomor Kantong Darah tidak ditemukan", "Perhatian!");
                $("#no_kantongdarah").focus();
            } else {
                $("#no_kantongdarah").val(data.nomorbarcode_utama);
                $("#tab_kantong_darah").append(data.html);
                $("#tab_kantong_darah tr").each(function () {
                    $(this).find(".html_no").html(cnt++);
                });
                renameInputRow($('#pilih-kantong'));
            }
            $("#petugasdistribusi_nama").blur();
        }, 'json');
    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            
            row++;
        });
        
        $('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    }
    
    function hapusKantong(obj) {
        var nomorbarcode = $(obj).parents("tr").find('.nomorbarcode').val();
        
        myConfirm("Apakah anda yakin akan menghapus data kantong darah ini ?","Perhatian!", function(r){
           if (r) {
               if (nomorbarcode != ''){
                   $("#hapus-kantong > tbody").append("<tr><td><input type='hidden' value='"+nomorbarcode+"' name='del_kantong[]'>/td></tr>");
               }
               
               $(obj).parents("tr").remove();
               $("#form-kantong-darah").removeClass('hide');
           }
        });        
    }
    
    function cekForm(){
                
        var cek = $("#pilih-kantong > tbody > tr").length;
        if (cek == 0){
            window.parent.toastr.warning("Kantong Darah belum ditambahkan","Perhatian!");
            return false;
        }

        if($('.no_kantongpabrik').val() == '') {
            window.parent.myAlert("No. Kantong Wajib Di Isi","Perhatian!");
            $('.no_kantongpabrik').focus();
            $('.no_kantongpabrik').attr('style', 'border:1px solid red');
            return false;
        }

        $("#detail-kantong-form").submit();
        disableOnSubmit($("#btn_submit"));
        
        return false;
    }

</script>
