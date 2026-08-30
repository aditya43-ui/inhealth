<script type='text/javascript'>
    function checkAll(obj) {
        if ($(obj).is(':checked')) {
            $(obj).parents('td').find("input[name*='controller']").each(function () {
                $(this).attr('checked', true);
                tambahAction(this);
            });
        } else {
            $(obj).parents('td').find("input[name*='controller']").each(function () {
                $(this).attr('checked', false);
                tambahAction(this);
            });
        }
    }

    function checkAllActionModule(obj) {
        
        var cek = $(obj).is(":checked");
        
        $(obj).parents("td").find("input[type='checkbox']").not(".check_all_action_module").prop("checked", cek);
    }

    function checkAllAction(obj, controller_nama) {
        var modul_nama = $(obj).val();
        var controller_nama = controller_nama;
//        alert(modul_nama+controller_nama);
        if ($(obj).is(':checked')) {
            $(obj).parents('td').find("input[id*='action_" + controller_nama + "']").each(function () {
                $(this).attr('checked', true);
            });
        } else {
            $(obj).parents('td').find("input[id*='action_" + controller_nama + "']").each(function () {
                $(this).attr('checked', false);
            });
        }
    }
    function tambahController(obj) {
        if ($(obj).is(':checked')) {
            modul_id = $(obj).attr('modul_id');
            nama_modul = $(obj).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getControllers') ?>',
                data: {namaModul: nama_modul, modul_id: modul_id},
                // dataType: "json",
                success: function (data) {
                    $("#row_controller_" + $(obj).val()).html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            id = obj.id;
            $("#controller_" + id).detach();
            $("#row_action_" + id).html('');
        }

    }
    function tambahAction(obj, isUpdate) {
        if ($(obj).is(':checked')) {
            nama_controller = $(obj).val();
            nama_modul = $(obj).attr('modul');
            $(obj).attr('disabled', true);
            $(obj).parents('td').find('input[name*="checkAll"]').attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('getActions') ?>',
                data: {namaController: nama_controller, namaModul: nama_modul},
                success: function (data) {
                    $("#row_action_" + nama_modul).append(data);
                    $(obj).removeAttr('disabled');
                    $(obj).parents('td').find('input[name*="checkAll"]').removeAttr('disabled');
                    if (isUpdate) {
                        checkAction();
                    }
                    console.log("Pilih");
                    $("#checkAllaction_" + nama_modul).prop("checked", false);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            nama_controller = $(obj).val();
            $("#action_" + nama_controller).detach();
        }
    }
    function cekPengguna(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekPeranPengguna') ?>',
            data: {pengguna: id},
            dataType: "json",
            success: function (data) {
                if (data.success == 1) {
                    window.location = "<?php echo $this->createUrl('update'); ?>&id=" + data.id;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>