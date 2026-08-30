
<script>

    function hapusDiagnosaKematian(obj, mortalitas_id, diagnosa_kode) {
        if(mortalitas_id != '') {
            $.post('<?= $this->createUrl('hapusDiagnosaKematian') ?>', {
                mortalitas_id:mortalitas_id
            }, function(data){
                if(data.status == 1) {
                    $(obj).parents('tr').detach();
                    delete id_diagnosax_m[diagnosa_kode];
                }
            }, 'json');
        } else {
            $(obj).parents('tr').detach();
        }
    }

    function addRowDiagnosaKematian(diagnosa_id, diagnosa_kode, diagnosa_nama, diagnosa_namalainnya) {
        var jumlahtr = $('#table-diagnosameninggal tbody tr').length;

        if (id_diagnosax_m[diagnosa_kode] == undefined) {

        $.post('<?= $this->createUrl('addRowDiagnosa') ?>', {
            jumlahtr:jumlahtr,
            diagnosa_id:diagnosa_id,
            diagnosa_kode:diagnosa_kode,
            diagnosa_nama:diagnosa_nama,
            diagnosa_namalainnya:diagnosa_namalainnya
        }, function(data){
            $('#table-diagnosameninggal tbody').append(data.html);
            setTimeout(() => {
                updateSorotX2();
            }, 200);

        }, 'json');

        id_diagnosax_m[diagnosa_kode] = 'yes';

    } else {
            myAlert("Diagnosis yang Anda input telah terdaftar, silakan cek kembali!");
        }
    }


    function updateSorotX() {
        $("#PPdiagnosa-m-grid table tbody tr td").removeClass('sorot');
        $("#tbl_diagnosax tbody tr .row_diagnosa_x_id").each(function() {
            $("#PPdiagnosa-m-grid table tbody #pilih_dialog_" + $(this).val()).parents("tr").find("td").addClass("sorot");
        });
    }

    function updateSorotX2() {

        console.log('update sorot x2');
        $("#PPdiagnosa-m2-grid table tbody tr td").removeClass('sorot');
        $("#table-diagnosameninggal tbody tr .row_diagnosa_x_id").each(function() {
            console.log('masuk sorot x2 ini');
            $("#PPdiagnosa-m2-grid table tbody #pilih_dialog_" + $(this).val()).parents("tr").find("td").addClass("sorot");
        });
    }
</script>