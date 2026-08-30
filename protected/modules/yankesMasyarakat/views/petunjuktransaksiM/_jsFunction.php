<script>
    function tambahLookup() {
        row = '<?php echo CJSON::encode($this->renderPartial('_rowPetunjuk', array('model' => $modDetail, 'form' => $form), true)); ?>'
        $('#tablePetunjuk').append(row);
        renameInputRow($("#tablePetunjuk"));
    }

    function checkGambar(obj) {  
        var file = obj.files[0];
        if (file.size > 1000000) {
            toastr.error("Ukuran maks : 1Mb", "Perhatian!");
            $(obj).attr("src", "blank");
            $(obj).wrap('<form>').closest('form').get(0).reset();
            $(obj).unwrap();
            return false;
        }
        
//        if (file.type.indexOf("image") == -1) {
//            toastr.error("Tipe file harus berupa gambar", "Perhatian!");
//            $(obj).attr("src", "blank");
//            $(obj).wrap('<form>').closest('form').get(0).reset();
//            $(obj).unwrap();
//            return false;
//        }
        
        if(file.type.match('image.*')) {
            var reader = new FileReader();
            // Read in the image file as a data URL.
            reader.readAsDataURL(file);
            reader.onload = function(evt){
                if( evt.target.readyState == FileReader.DONE) {
                    i = $(obj).parents('tr').find('#id_count').val();
                    $(obj).parents('tr').find('#output_'+i).attr('src', evt.target.result);
                }
            }    
        } 
//        else {
//            alert("not an image");
//        }
    }
    
    function setDokumen(){
        var tipe = $('.tipe').val();
        $("#tablePetunjuk").addClass("animation-loading");
        $('#tablePetunjuk > tbody').html("");
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('GetPetunjuk'); ?>',
                data: {
                    tipe: tipe, 
                    is_update: 1
                },//
                dataType: "json",
                success:function(data){
                        $('#tablePetunjuk > tbody').append(data.form);
                        jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                        renameInputRow($("#tablePetunjuk"));

                        $("#tablePetunjuk").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function renameInputRow(obj_table) {
        var row = 1;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#id_count").val(row);
            $(this).find('#no_urut').val(row);
            $(this).find(".gambar-prev").attr("id", "output_"+(row));
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

        //====button visibility
        //init
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
        var rowCount = $(obj_table).find('tbody tr').length;
        if (rowCount == 1) {
            $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
            $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
            id = $(obj_table).find('tr:first-child input[name*="[petunjuktransaksi_id]"]').val();
            if (id != "") {
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
            }
        }
        //====end button visibility

    }

    $(document).ready(function () {
        tambahLookup();
<?php if (!empty($model->petunjuktransaksi_id)) { ?>
            setDokumen();
<?php } ?>
    });
</script>
