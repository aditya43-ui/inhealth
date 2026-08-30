<script type="text/javascript">
    function tambahKomGajiPeg() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowKomGaji', array('model' => $modelGaji, 'i' => 0), true)); ?>'
        $('#table-komgajipeg').append(row);
        renameInputRow($("#table-komgajipeg"));
        $("#table-komgajipeg tr:last .integer2").maskMoney(
                {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0}
        );
    }

    function cekKomponen(obj) {
        var cekData = true;
        var nourut = $(obj).parents("tr").find(".no-urut").val();

        $('#table-komgajipeg > tbody > tr').each(function () {
            $(this).removeClass("yellow");

            var id = $(this).find(".komponengaji").val();
            var urut = $(this).find(".no-urut").val();

            if (id != '' && nourut != urut) {
                if (id == $(obj).val()) {
                    $(this).addClass("yellow");
                    cekData = false;
                }
            }
        });

        if (cekData == false) {
            myAlert(" Maaf komponen gaji ini sudah dipilih ");
            $(obj).parents("tr").removeClass("yellow");
            $(obj).val('');
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getKomponenGaji') ?>',
                dataType: "json",
                data: {id: $(obj).val()},
                success: function (data) {
                    if (data.sukses == 1) {
                        $(obj).parents("tr").find(".tipekomponen").val(data.tipekomponen);
                        $(obj).parents("tr").find(".jeniskomponen").val(data.jeniskomponen);
                    } else {
                        myAlert(data.pesan);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find(".no-urut").val(row + 1);
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

            jQuery('[data-toggle="tooltip"]').each(function (i, el)
            {
                var $this = jQuery(el),
                        placement = attrDefault($this, 'placement', 'top'),
                        trigger = attrDefault($this, 'trigger', 'hover'),
                        popover_class=$this.hasClass('tooltip-secondary') ? 'tooltip-secondary' : ($this.hasClass('tooltip-primary') ? 'tooltip-primary' : ($this.hasClass('tooltip-default') ? 'tooltip-default' : ''));

                $this.tooltip({
                    placement: placement,
                    trigger: trigger
                });

                $this.on('shown.bs.tooltip', function (ev)
                {
                    var $tooltip = $this.next();

                    $tooltip.addClass(popover_class);
                });
            });

        });
    }

    function hapusLookup(obj) {
        myConfirm(" Apakah Anda yakin menghapus komponen " + $(obj).text() + " ini ? ", "Perhatian !", 
            function (r) {
                if(r){ 
                    var id = $(obj).parents("tr").find(".komponenid").val();
                    
//                    $(obj).parents('tr').detach();
//                    renameInputRow($("#table-komgajipeg"));

//                    $("#table-delkomgajipeg > tbody ").append("<tr><td><input type='text' name='deletekomponen[]' value='" + id + "'></td></tr>");
                    $.ajax({
			type: 'POST',
                        url: '<?php echo $this->createUrl('deleteKomponen') ?>',
                        dataType: "json",
                        data: {id: id},
			success:function(data){
							if(data.sukses > 0){
                                                            $(obj).parents('tr').detach();
                                                            renameInputRow($("#table-komgajipeg"));
							}else{
                                                            myAlert('Data gagal dihapus!');
							}
			},
				error: function (jqXHR, textStatus, errorThrown) { 
                                    myAlert('Data gagal dihapus!'); 
                                    console.log(errorThrown);
                                }
                    });
                }
            }
        );
        return false;
    }
    

    function cekSubmit()
    {
            return requiredCheck($("#sapegawai-m-form"));
        
    }

    $(document).ready(function () {
        renameInputRow($("#table-komgajipeg"));
    });
</script>