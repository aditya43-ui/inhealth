<?php 
$dataRiwayat = $modRiwayat->searchRiwayatDiagnosa();
$dataRiwayat->pagination = false;
$dataRiwayat = $dataRiwayat->data;
// echo '<pre>';var_dump($dataRiwayat->data);die;

$modRiwayat = [];
foreach ($dataRiwayat as $i => $data) {
    $tgl = explode(' ', $data->pendaftaran->tgl_pendaftaran);
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['no_pendaftaran'] = $data->pendaftaran->no_pendaftaran;
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['tgl_pendaftaran'] = $tgl[0];
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['pendaftaran_id'] = $data->pendaftaran_id;
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['data'][$data->pegawai_id . '_' . $data->ruangan_id]['nama_dokter'] = $data->pegawai->namaLengkap;
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['data'][$data->pegawai_id . '_' . $data->ruangan_id]['ruangan_nama'] = $data->ruangan->ruangan_nama;
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['data'][$data->pegawai_id . '_' . $data->ruangan_id]['pasienmorbiditas_id'] = $data->pasienmorbiditas_id;
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['data'][$data->pegawai_id . '_' . $data->ruangan_id]['pegawai_id'] = $data->pegawai_id;
    $modRiwayat[$data->pendaftaran->pendaftaran_id . '_' . $tgl[0]]['data'][$data->pegawai_id . '_' . $data->ruangan_id]['ruangan_id'] = $data->ruangan_id;
    
}
// echo '<pre>';
// var_dump($modRiwayat);die;
?>
<table id="table_id" class="table table-bordered">
    <thead>
        <th>No</th>
        <th>No Pendaftaran</th>
        <th>Tanggal Pendaftaran</th>
        <th>Riwayat</th>
        <th>Nama Dokter</th>
        <th>Ruangan</th>
        <th>Lihat Detail</th>
        
    </thead>
    <tbody>
            
<?php 
            if(!empty($modRiwayat)) {
                $no = 1;
                foreach($modRiwayat as $i => $data) {
                    $rowspan = count($data['data']);
        ?>
            <tr>
                <td rowspan="<?= $rowspan ?>"><?= $no++ ?></td>
                <td rowspan="<?= $rowspan ?>"><?= $data['no_pendaftaran'] ?></td>
                <td rowspan="<?= $rowspan ?>"><?= $data['tgl_pendaftaran'] ?></td>
                <td rowspan="<?= $rowspan ?>">
                    <?php 
                        echo "<center>" . CHtml::link("<i class='entypo-eye'></i>", 'javascript:;', array('onclick' => 'viewDetailRiwayatDiagnosa("' . $data['pendaftaran_id'] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail riwayat diagnosa'));
                    ?>
                </td>


                <?php 
                    $row = 0;
                    foreach($data['data'] as $ii => $val) {
                ?>
                       
                        <td><?= $val['nama_dokter'] ?></td>
                        <td><?= $val['ruangan_nama'] ?></td>
                        <td>
                            <?php 
                                echo "<center>" . CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick' => 'viewDetailDiagnosa("' . $val['pasienmorbiditas_id'] . '","' . $data['pendaftaran_id'] . '","' . $val['pegawai_id'] . '","' . $val['ruangan_id'] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail diagnosa'));
                            ?>
                        </td>
                       
                    </tr>

                <?php } ?>

               

        <?php
                }
            }
       ?>
           
    </tbody>
</table>
<div id="pagination">
    <ul class="pagination">
        <li class="page-item"></li>
        <!-- Tambahkan lebih banyak halaman jika diperlukan -->
    </ul>
</div>

<script>
    $(document).ready(function () {
    var table = $('#table_id');
    var rows = table.find('tbody tr');
    var rowsPerPage = 5; // Ubah jumlah baris per halaman sesuai kebutuhan
    var currentPage = 1;

    // Fungsi untuk menampilkan halaman tertentu
    function showPage(page) {
        var start = (page - 1) * rowsPerPage;
        var end = start + rowsPerPage;

        rows.hide();
        rows.slice(start, end).show();
    }

    // Hitung jumlah halaman berdasarkan jumlah baris
    var totalPages = Math.ceil(rows.length / rowsPerPage);

    // Inisialisasi pagination
    var pagination = $('#pagination ul');
    for (var i = 1; i <= totalPages; i++) {
        pagination.append('<li class="page-item"><a class="page-link" href="#">' + i + '</a></li>');
    }

    // Tampilkan halaman pertama saat halaman dimuat
    showPage(currentPage);

    // Tampilkan halaman yang sesuai saat tombol pagination diklik
    pagination.on('click', 'li', function () {
        currentPage = parseInt($(this).text(), 10);
        showPage(currentPage);

        // Tambahkan kelas aktif ke tombol pagination yang aktif
        pagination.find('li').removeClass('active');
        $(this).addClass('active');
    });
});
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailDiagnosa',
    'options'=>array(
        'title'=>'Detail Diagnosa',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

echo '<div id="contentDetailDiagnosa"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailRiwayatDiagnosa',
    'options'=>array(
        'title'=>'Detail Riwayat Diagnosa',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>900,
        'height' => 500,
        'resizable'=>false,
        'position'=>'top',
    ),
));

echo '<div id="contentDetailRiwayatDiagnosa" ></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    function cekDiagnosa(pendaftaran_id, pegawai_id, ruangan_id) {
        var jumlahtrX = $('#tbl_diagnosax tbody > tr').length;
        var jumlahtrIX = $('#tbl_diagnosaix tbody > tr').length;
        $('.bodylanguage').addClass('animation-loading');
        $.get('<?= $this->createUrl('cekDiagnosaUtama') ?>', {
            pendaftaran_id: pendaftaran_id,
            pasienadmisi_id: '<?= isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null?>',
            ruangan_id:ruangan_id,
            pegawai_id:pegawai_id,
            jumlahtrX:jumlahtrX,
            jumlahtrIX:jumlahtrIX
        }, function(data) {
            is_kelompokdiagnosautama = 0;
            $('#tbl_diagnosax tbody > tr').each(function(){
                kel = $(this).find('select[name$="[kelompokdiagnosa_id]"]').val();
                if (kel == '<?php echo Params::KELOMPOKDIAGNOSA_UTAMA ?>') {
                    is_kelompokdiagnosautama += 1;
                }
            });
            
            if(is_kelompokdiagnosautama < 1 && data.sudahAdaDiagnosaUtama < 1) {
                myAlert('Diagnosa utama ICD 10 belum ditambahkan!');
                $('.bodylanguage').removeClass('animation-loading');
                return false;
            } else {
                $('#tbl_diagnosax tbody').append(data.rowDiagnosaX);
                $('#tbl_diagnosaix tbody').append(data.rowDiagnosaIX);
                $('.bodylanguage').removeClass('animation-loading');
            }
            var pegawai_id_load = jQuery('.pegawai_id_load');

            jQuery(pegawai_id_load).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '240px',
                enableCaseInsensitiveFiltering: true,
            }).hide();
        }, 'json');
    }
    function viewDetailDiagnosa(pasienmorbiditas_id,pendaftaran_id, pegawai_id, ruangan_id){

    $.post('<?php echo $this->createUrl('/rawatJalan/diagnosaNew/ajaxDetailDiagnosa') ?>', {
        pasienmorbiditas_id: pasienmorbiditas_id, 
        pendaftaran_id: pendaftaran_id,
        pegawai_id:pegawai_id,
        ruangan_id:ruangan_id
    }, function(data){
        $('#contentDetailDiagnosa').html(data.result);
    }, 'json');
        $('#dialogDetailDiagnosa').dialog('open');
    }

    function viewDetailRiwayatDiagnosa(pendaftaran_id) {
        $.post('<?php echo $this->createUrl('/rawatJalan/diagnosaNew/ajaxDetailRiwayatDiagnosa') ?>', {
            pendaftaran_id: pendaftaran_id
        }, function(data){
            $('#contentDetailRiwayatDiagnosa').html(data.result);
        }, 'json');
        $('#dialogDetailRiwayatDiagnosa').dialog('open');
    }

    /**
     * Fungsi copy resep 
     */
    const copy_resep = (penjualanresep_id) => {
        var hitung = 0;
        $('#table-obatalkespasien > tbody > tr').each(function() {
            var det_id = $(this).find('.penjualanresep_id').val();
            if (penjualanresep_id == det_id) {
                hitung++;
            }
        });

        if (hitung >= 1) {
            myAlert("Data Penjualan Resep sudah ada di tabel. Silahkan pilih yang lain.", "Perhatian!");
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?php //echo $this->createUrl('copyResep'); ?>',
            data: {
                penjualanresep_id: penjualanresep_id
            }, //
            dataType: "json",
            success: function(data) {
                $('#table-obatalkespasien > tbody').append(data.tr);
                renameInputRowObatAlkes($("#table-obatalkespasien"));

                var row = 0;

                $("#table-obatalkespasien").find("tbody > tr").each(function() {
                    $(this).find(".r").val(row + 1);
                    $(this).find(".rke").val(row + 1);
                    
                    row++;
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>