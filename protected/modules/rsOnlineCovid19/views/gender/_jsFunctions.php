<script type="text/javascript">
    function searchData() {
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('GetDataKemenkes'); ?>',
            dataType: "json",
             beforeSend: function(){
                $("#table-jk").addClass("animation-loading");
            },
            success: function (data) {
                $("#table-jk").removeClass("animation-loading");
                if(data.status!= '200'){
                  $("#table-jk > tbody > tr").remove();
                    $('#table-jk > tbody').html(data.form);
                    renameInputRow($("#table-jk"));  
                }else{
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                 $("#table-jk").removeClass("animation-loading");
                console.log(errorThrown);
            }
        });
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
        window.open('<?php echo $this->createUrl('PrintData'); ?>&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
</script>