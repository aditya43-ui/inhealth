<style>
    table tr td {
        padding-left: 10px;
    }
</style>


<table width="100%">
    <tr>
        <td>
            <table>
                <tr>
                    <td>No. Pendaftaran</td>
                    <td> : </td>
                    <td><?= $modPendaftaran->no_pendaftaran ?></td>
                </tr>
                <tr>
                    <td>Tanggal Pendaftaran</td>
                    <td> : </td>
                    <td><?= MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) ?></td>
                </tr>
                <tr>
                    <td>Ruangan</td>
                    <td> : </td>
                    <td><?=  $hasilPemeriksaan[0]->ruangan->ruangan_nama ?>
            
                </tr>
                <!-- <tr>
                    <td>No. Hasil Pemeriksaan</td>
                    <td> : </td>
                    <td><?php //$modPasienMasukPenunjang->no_masukpenunjang ?? '' 
                        ?></td>
                </tr> -->
                <tr>
                    <td>Tanggal Pemeriksaan</td>
                    <td> : </td>
                    <td><?= MyFormatter::formatDateTimeForUser($hasilPemeriksaan[0]->tglpemeriksaantindakan) ?></td>
                </tr>
            </table>
        </td>
        <td>
            <table>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td> : </td>
                    <td><?= $modPendaftaran->pasien->nama_pasien ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td> : </td>
                    <td><?= MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir) ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td> : </td>
                    <td><?= $modPendaftaran->pasien->jeniskelamin ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : </td>
                    <td><?= $modPendaftaran->pasien->alamat_pasien ?></td>
                </tr>
                <tr>
                    <td>Jenis Penjamin</td>
                    <td> : </td>
                    <td><?= $modPendaftaran->carabayar->carabayar_nama ?></td>
                </tr>
            </table>
    </tr>
</table>

<table class="items table table-bordered table-striped datatable">
    <thead>
        <th>No.</th>
        <th>Tanggal Pemeriksaan</th>
        <th>Nama Pemeriksaan</th>
        <th>Hasil Pemeriksaan</th>
        <th>Kesimpulan</th>
        <th class="hide-sementara">Buka File</th>
    </thead>
    <tbody>
        <?php foreach ($hasilPemeriksaan as $i => $row) : ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= $row->tglpemeriksaantindakan ?></td>
                <td><?= $row->ruangan->ruangan_nama ?? '' ?></td>
                <td><?= $row->hasilpemeriksaantindakan ?></td>
                <td><?= $row->kesimpulantindakan ?></td>
                <td class="hide-sementara"><?php
                                            if (!empty($row->dokfiletindakan_filepath)) {
                                                echo CHtml::link("<i class='" . MyIcon::getIcons('file') . "'></i> Buka File", 'javascript:;', array('onclick' => 'lihatFile("' . $row->dokfiletindakan_filepath . '");', 'class' => 'btn btn-danger buka'));
                                            } else {
                                                echo 'Tidak Ada File di upload';
                                            }
                                            ?></td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <b>Dokumen </b> -->
<?php //echo CHtml::link("<i class='" . MyIcon::getIcons('file') . "'></i> Buka File", 'javascript:;', array('onclick' => 'bukaGambar(this);', 'class' => 'btn btn-danger buka')); 
?>
<br>
<br>
<!-- <div class="hide-sementara"><?php //echo CHtml::link("<i class='" . MyIcon::getIcons('cetak') . "'></i> Print", 'javascript:;', array('onclick' => 'printdulu(this);', 'class' => 'btn btn-success')); 
                                    ?></div> -->
<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp"; ?>


<div class="viewFile">
    <img alt="">
    <button class="badge badge-danger" style="display: none;" onclick="tutupFrame()"><i class="fas fa-times"></i> Tutup Dokumen</button>
    <iframe name="frame" frameborder="0" height="500px" width="100%"></iframe>
</div>

<div class="file" hidden>
    <table class="items table table-bordered table-striped datatable">
        <thead>
            <th>Nama Dokumen</th>
            <th>File</th>
        </thead>
        <tbody>
            <?php foreach ($hasilPemeriksaan as $i => $row) :  ?>
                <tr>
                    <td><?php echo $row->dokfiletindakan_nama ?? '' ?></td>
                    <td>
                        <?php
                        $string = $row->dokfiletindakan_filepath;
                        $pattern = '/\b\w+\.pdf\b/i';
                        // 
                        if (preg_match($pattern, $string)) {
                            echo CHtml::link($row->dokfiletindakan_filepath, $this->path . $row->dokfiletindakan_filepath);
                        } else {

                            echo CHtml::image($this->path . $row->dokfiletindakan_filepath, $row->dokfiletindakan_nama ?? '', array());
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<script>
    <?php
    $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintHasil&pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '&pasienkirimkeunitlain_id=' . $modPasienKirimKeUnitLain->pasienkirimkeunitlain_id . '&pasien_id=' . $modPendaftaran->pasien_id);
    ?>

    function print(caraPrint) {
        var urlPrint = "<?php echo $urlPrint ?>&caraPrint=" + caraPrint;
        window.open(urlPrint, '', 'location=_new, width=460px');
        console.log('kesini');
    }

    function printdulu(obj) {
        console.log('testes jke ');

        $('.hide-sementara').addClass('hide');

        //print($(obj));            

        $('.hide-sementara').removeClass('hide');

    }

    function bukaGambar(obj) {
        console.log($(obj).hasClass('buka'));
        if ($(obj).hasClass('buka') == true) {
            $('.file').show();
            $(obj).removeClass('buka');
        } else {
            $(obj).addClass('buka');
            $('.file').hide();
        }
    }

    //     function lihatFile(nama_file){
    //     var path = '<?php //$this->path 
                        ?>';

    //         console.log(nama_file)
    //     if (nama_file.indexOf("pdf") !== -1) {
    //             // console.log("Kata 'pdf' ditemukan pada string.");
    //         var src = path + nama_file;
    //             $('.viewFile').find('iframe').attr('src', src);
    //         $('.badge').show();
    //         $('.viewFile').find('img').attr('src', '');

    //         } else if(nama_file.indexOf('png') || nama_file.indexOf('jpg') || nama_file.indexOf('jpeg')){
    //         var src = path + nama_file;
    //             // console.log("Kata 'pdf' tidak ditemukan pada string.");
    //             $('.viewFile').find('img').attr('src', src);
    //         tutupFrame();
    //     } else {
    //         var src = path + nama_file;
    //             $('.viewFile').find('iframe').attr('src', src);
    //         $('.badge').show();
    //         $('.viewFile').find('img').attr('src', '');
    //     }
    // }

    function lihatFile(nama_file) {
        var path = '<?= $this->path ?>';

        console.log(nama_file);
        var $viewFile = $('.viewFile');
        $viewFile.empty(); // Menghapus konten sebelumnya

        if (nama_file.indexOf("pdf") !== -1) {
            var src = path + nama_file;
            $viewFile.append('<a href="' + src + '" download class="btn btn-primary">Download File</a>');
            $viewFile.append('<iframe src="' + src + '"></iframe>');
            $('.badge').show();
            $('.viewFile').find('img').attr('src', '');

        } else if (nama_file.indexOf('png') !== -1 || nama_file.indexOf('jpg') !== -1 || nama_file.indexOf('jpeg') !== -1) {
            var src = path + nama_file;
            $viewFile.append('<a href="' + src + '" download class="btn btn-primary">Download File</a>');
            $viewFile.append('<img src="' + src + '">');
            tutupFrame();

        } else {
            var src = path + nama_file;
            $viewFile.append('<a href="' + src + '" download class="btn btn-primary">Download File</a>');
            $viewFile.append('<iframe src="' + src + '"></iframe>');
            $('.badge').show();
            $('.viewFile').find('img').attr('src', '');
        }
    }


    function tutupFrame() {
        $('.viewFile').find('iframe').attr('src', '');
        $('.badge').hide();
    }
</script>