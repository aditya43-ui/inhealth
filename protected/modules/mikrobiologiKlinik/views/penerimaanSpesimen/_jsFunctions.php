<script type="text/javascript">
    function setNol(obj) {
        if ($(obj).is(":checked")) {
            obj.value = 1;
        } else {
            obj.value = 0;
        }
    }
    function checkAll() {
        $("#table-detailbarang > tbody > tr").find('input[type="checkbox"]').each(
                function () {
                    if ($("#check_semua").is(":checked")) {
                        $(this).attr('checked', 'checked');
                    } else {
                        $(this).removeAttr('checked');
                    }
                });
    }
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row + "]");
                }
            });
            $(this).find('input[name$="[maininput]"]').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row + "]");
                }
            });
            row++;
        });
    }

    function getRuangan(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getRuangan'); ?>',
            data: {id: id},
            dataType: "json",
            success: function (data) {
                $('#ruangankirim_nama').val(data.ruangan_nama);
                $('#instalasikirim_nama').val(data.instalasi_nama);
            },
        });

    }

    function getTanggal(tgl) {

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getTanggalKirim'); ?>',
            data: {tgl: tgl},
            dataType: "json",
            success: function (data) {
                $('#tglkirimspesimen').val(data.tglkirimspesimen);
            },
        });
    }

    function getPegawai(pegawai_id) {

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getPegawai'); ?>',
            data: {pegawai_id: pegawai_id},
            dataType: "json",
            success: function (data) {
                $('#pegawai_nama').val(data.pegawai_nama);
            },
        });
    }

    function getCoolbox(coolboxdarah_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getCoolbox'); ?>',
            data: {coolboxdarah_id: coolboxdarah_id},
            dataType: "json",
            success: function (data) {
                $('#jenis_coolbox').val(data.coolboxdarah_nama);
            },
        });
    }

    function getDetailKirim() {
        var pengirimanspesimen_id = $('#pengirimanspesimen_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getDetailKirim'); ?>',
            data: {pengirimanspesimen_id: pengirimanspesimen_id},
            dataType: "json",
            success: function (data) {
                $('#table-detailbarang > tbody').html(data);
                $('#table-detailbarang').removeClass("animation-loading");
                // renameInputRow($("#table-detailbarang"));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }

        })
    }

    var is_checked = {};

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }

    function setSpesimen(obj) {
        var nomor = $(obj).attr('no_spesimen');

        if ($(obj).prop("checked") == true) {
            is_checked[nomor] = nomor;
        } else {
            is_checked[nomor] = 0;
        }
    }

    function setSemuaSpesimen(obj) {
        if ($(obj).prop("checked") == true) {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", true).change();
            });
        } else {
            $("input:checkbox.pilih").each(function () {
                $(this).prop("checked", false).change();
            });
        }

    }

    function setCeklisSpesimen() {
        $("input:checkbox.pilih").each(function () {
            var nomor = $(this);
            nomor.prop("checked", false);
            nomor.removeAttr("disabled");
            $("#table-detailbarang > tbody > tr").find(".spesimen_id").each(function () {
                if (nomor.attr('no_spesimen') == $(this).val()) {
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });
        });
    }

    function batal(obj) {
        myConfirm("Apakah anda akan membatalkan spesimen ini ?", 'Perhatian!', function (r) {
            if (r) {
                $(obj).parents('tr').remove();
            }else{
                return false;
            }
        });
    }

    function cekSudahAda(nomor, obj) {
        var x = true;
        console.log(nomor);
        $('.spesimen_id').each(function () {
            if ($(this).val() == nomor) {
                x = false;
                $('#table-detailbarang').removeClass("animation-loading");
            } else {

            }
        });

        if (x == false) {
            toastr.error('Spesimen telah ada di list. Silahkan pilih yang lain.', "Perhatian!");
            $(obj).val('');
        } else {
            tambahSpesimen(nomor);
            $(obj).val('');
        }
    }

    function renameInputRowBarang(obj_table) {
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

            var a = 0;
            $(this).find('.detail-komponen').each(function () { //element <input>
                $(this).find('input,select,textarea').each(function () {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 5) {
                        $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + a + "_" + old_name_arr[4]);
                        $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + a + "][" + old_name_arr[4] + "]");
                    }
                });
                a++;
            });
            row++;
        });
    }
    
    function tambahSpesimen(nomor) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getSpesimen'); ?>',
            data: {no_spesimen: nomor},
            dataType: "json",
            success: function (data) {
                $('#table-detailbarang > tbody').append(data);
                $('#table-detailbarang').removeClass("animation-loading");
                renameInputRowBarang($("#table-detailbarang"));
                is_checked = {};
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function inputSpesimen() {
        var spesimen_id = is_checked;

        if (isEmpty(spesimen_id)) {
            myAlert('Spesimen yang akan dikirimkan belum dipilih');
            return false;
        } else {
            $('#table-detailbarang').addClass("animation-loading");
            cekList(spesimen_id);

        }
    }

    function cekList(id) {
        x = true;
        /*$('.barcode_utama').each(function(){
         if ($(this).val() == id){
         myAlert('Spesimen  telah ada d List');
         x = false;
         $('#table-detailbarang').removeClass("animation-loading");                
         }else{
         
         }
         });*/

        if (x == true) {
            tambahSpesimen(is_checked);
            $("#dialogKirimspesimen").dialog("close");
            return x;
        }
        return false;
    }

    $(document).ready(function () {

<?php if (isset($_GET['sukses'])) { ?>
            $("input, select, textarea").attr("disabled", true);
<?php } ?>

        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
    });

</script>

