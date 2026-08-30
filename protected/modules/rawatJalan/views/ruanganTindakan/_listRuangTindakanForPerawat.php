<table class="items table table-bordered table-striped datatable" id="tblListKonsul">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Ruang Tindakan</th>
            <th>No. Permintaan</th>
            <th>Ruangan Asal</th>
            <th>Jeni Pemeriksaan</th>
            <th>Dokter Perujuk</th>
            <th>PPDS</th>
            <th>Detail</th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($modRiwayatPasienKeunitLain as $i => $permintaan) { ?>
        <?php 
            $dokterPerujuk = '';
            $operator = '';
            $nopermintaan = '';
            if(!empty($permintaan)) {
                $dokterPerujuk = $permintaan->pegawai->nama_pegawai ?? '';
                $operator = $permintaan->ppds->ppds_nama ?? '';
            }  
        ?>
        <tr>
            <td><?php echo $permintaan->tgl_kirimpasien ?></td>
            <td><?php echo $permintaan->no_permintaan ?> <?php echo CHtml::link("<i class='entypo-print'></i>", '#', array('onclick'=>'printPermintaan('.$permintaan->pasienkirimkeunitlain_id.');return false;','rel'=>'tooltip','title'=>'Klik untuk mencetak detail permintaan Poliklinik')); ?></td>
            <td><?php echo $permintaan->createruangan->ruangan_nama ?></td>
            <td><?php echo $permintaan->ruangan->ruangan_nama ?></td>
            <td><?= $dokterPerujuk ?></td>
            <td><?= $operator ?></td>
            <td style="text-align: center">

                <?php 
                   echo CHtml::Link(
                        "<i class=icon-form-eye></i>",
                        Yii::app()->createUrl("rawatJalan/ruangTindakan/lihatDetailHasilPemeriksaan", array(
                            "pasienkirimkeunitlain_id" => $permintaan->pasienkirimkeunitlain_id,
                            'pendaftaran_id' => $permintaan->pendaftaran_id,
                            'pasien_id' => $permintaan->pendaftaran->pasien_id
                        )),
                        array(
                            "class" => "",
                            "target" => "frame",
                            "onclick" => "$(\"#dialogDetail\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Lihat Detail Hasil Pemeriksaan",
                        )
                    );
                
                ?>
            </td>
                   
        </tr>
    <?php } ?>
        <tr>
            <td colspan="9">
                <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                    'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'buttons'=>array(
                        array('label'=>'Print', 'icon'=>MyIcon::getIcons('cetak'), 'url'=>'#', 'htmlOptions'=>array('onclick'=>'printRiwayat(\'PRINT\')')),
                        array('label'=>'', 'items'=>array(
                            array('label'=>'PDF', 'icon'=>MyIcon::getIcons('pdf'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'PDF\')')),
                            array('label'=>'Excel','icon'=>MyIcon::getIcons('excel'), 'url'=>'', 'itemOptions'=>array('onclick'=>'printRiwayat(\'EXCEL\')')),
                           
                        )),       
                    ),
                    'htmlOptions'=>array('style'=>'float:right')
                )); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 700,
        'resizable' => false,
        'position' => 'center',
    ),
));
?>
<iframe frameborder="0" name="frame" width="100%" height="700px"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>
    function removeRecord(pasienkirimkeunitlain_id) {
        myConfirm("apakah yakin ingin membatalkan rujukan?", 'perhatian', function(r) {
            if(r) {
                $.post('<?php echo $this->createUrl('deleteRujukan') ?>', {
                    pasienkirimkeunitlain_id: pasienkirimkeunitlain_id
                }, function(data) {
                    if(data.sukses == 1) {
                        toastr.success(data.pesan)
                        location.href = '<?php echo $this->createUrl('index') . "&pendaftaran_id=" . $_GET['pendaftaran_id'] ?>';
                    } else {
                        // myAlert(data.pesan);
                        toastr.error(data.pesan, 'Gagal', 'center')

                    }
                }, 'json');
            }
        });
    }
</script>