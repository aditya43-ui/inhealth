<script type="text/javascript">
    function searchData() {
        var kode_propinsi = $('#kode_propinsi').val();
        
        if(kode_propinsi != ""){
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('GetDataKemenkes'); ?>',
                data:{propinsi: kode_propinsi},
                dataType: "json",
                 beforeSend: function(){
                    $("#table-kab").addClass("animation-loading");
                },
                success: function (data) {
                    $("#table-kab").removeClass("animation-loading");
                    if(data.status!= '200'){
                      $("#table-kab > tbody > tr").remove();
                        $('#table-kab > tbody').html(data.form);
                        renameInputRow($("#table-kab"));  
                    }else{
                        myAlert(data.pesan);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                     $("#table-kab").removeClass("animation-loading");
                    console.log(errorThrown);
                }
            });
        }else{
            myAlert("Kode Provinsi Harus diisi");
        }
        
    }

    /**
     * rename input grid
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
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

    }

    function printData(caraPrint) {
        var kode_propinsi = $('#kode_propinsi').val();
        window.open('<?php echo $this->createUrl('PrintData'); ?>&propinsi='+kode_propinsi+'&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>