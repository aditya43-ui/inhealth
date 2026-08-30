<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Lembar Catatan Hasil Elektrokardiogram</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Tgl. Catatan Elektrokrdiogram</th>
                    <th>No. Pendaftaran</th>
                    <th>Instalasi/Ruangan</th>
                    <th>DPJP</th>
                    <th>Nama Pegawai</th>
                    <th>Lihat Gambar</th>
                    <th>Detail</th>
                    <th>Hapus</th>
                    <th>Cetak</th>
                    <th>Salin</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($riwayat)):?>
                <?php foreach ($riwayat as $idx=>$item): ?>
                <tr>
                    <td><?php echo MyFormatter::formatDateTimeForUser($item->tanggal); ?></td>
                    <td><?php echo $item->pendaftaran->no_pendaftaran; ?></td>
                    <td><?php echo $item->pendaftaran->instalasi->instalasi_nama . '/' . $item->pendaftaran->ruangan->ruangan_nama; ?>
                    </td>
                    <td><?php echo !empty($item->pasienadmisi_id) ? $item->pasienadmisi->pegawai->namaLengkap : $item->pendaftaran->pegawai->namaLengkap; ?>
                    </td>
                    <td><?php echo isset($item->pegawai_id) ? $item->pegawai->namaLengkap : '-'; ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::link("<i class='far fa-eye'></i>", 'javascript:void(0);', array('onclick'=>'lihatGambar("'. $item->catatanelektrokardiogram_id . '");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat gambar Catatan Elektrokardiogram')); ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::link("<i class='fa fa-file-text'></i>", Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detail",array("pendaftaran_id" => $item->pendaftaran_id, "id"=>$item->catatanelektrokardiogram_id)), array('rel'=>'tooltip','title'=>'Klik untuk melihat gambar Catatan Elektrokardiogram')); ?>
                    </td>
                    <td style="text-align: center;">
                        <a onclick="hapusCatatan('<?php echo $item->catatanelektrokardiogram_id; ?>',this);return false;"
                            rel="tooltip" href="javascript:void(0);"
                            title="Klik untuk menghapus Catatan Elektrokardiogram"><i class="icon-trash"></i></a>
                    </td>
                    <td style="text-align: center;">
                        <a onclick="printCatatan('PRINT',<?php echo $item->catatanelektrokardiogram_id; ?>);return false;"
                            rel="tooltip" href="javascript:void(0);"><i class="fa fa-print"></i></a>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::link("<i class='fa fa-copy'></i>", Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/copy",array("id" => $item->catatanelektrokardiogram_id, "id"=>$item->catatanelektrokardiogram_id)), array('rel'=>'tooltip','title'=>'Klik untuk melihat gambar Catatan Elektrokardiogram')); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else:?>
                <tr>
                    <td colspan="10">Data Tidak Ditemukan</td>
                </tr>
                <?php endif;?>
            </tbody>
        </table>

    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDetail',
    'options'=>array(
        //'title'=>'Obat & Alat Kesehatan',
        'title'=>'Detail Catatan Edukasi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

echo '<iframe name="frameDetail" style="border: 0px; width:100%; height: 530px; "></iframe>';

$this->endWidget();

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/print');

?>


<script>
function lihatGambar(id) {
    window.open(
        "<?= Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/lihatGambar')?>&catatanelektrokardiogram_id=" +
        id, "", 'location=_new, width=900px');
}

function hapusCatatan(id, obj) {
    tabel = obj;
    myConfirm('Apakah Anda akan menghapus Catatan Elektrokardiogram ini?', 'Perhatian!', function(r) {
        if (r) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('delete'); ?>',
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    var delete_row = $(tabel).parents('tr');
                    delete_row.detach();
                    console.log('data berhasil dihapus');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    });
}

function printCatatan(caraPrint, id) {
        window.open("<?php echo $urlPrint?>&id=" + id + "&caraPrint=" + caraPrint, "",
            'location=_new, width=900px');
}
</script>