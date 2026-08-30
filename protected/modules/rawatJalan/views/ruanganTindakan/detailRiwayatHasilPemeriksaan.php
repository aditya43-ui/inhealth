<style>
    table tr td {
        padding-left: 10px;
    }
</style>
<h3>HASIL PEMERIKSAAN <b>RUANG TINDAKAN</b></h3>

<table class="items table table-bordered table-striped datatable">
    <thead>
        <th>No. Masuk Penunjang</th>
        <th>Nama Pemeriksaan</th>
        <th>Tanggal Order</th>
        <th>Hasil Pemeriksaan</th>
        <th>Kesimpulan</th>
        <th class="hide-sementara">Buka File</th>
    </thead>
    <tbody>
        <?php foreach($hasilPemeriksaan as $i => $row) : ?>
            <tr>
                <td><?= $row->pasienmasukpenunjang->no_masukpenunjang ?? '' ?></td>
                <td><?= $row->daftartindakan->daftartindakan_nama ?? '' ?> <?= $row->ruangan->ruangan_nama ?? '' ?></td>
                <td><?= $row->pasienmasukpenunjang->pasienkirimkeunitlain->tgl_kirimpasien ?></td>
                <td><?= $row->hasilpemeriksaantindakan ?></td>
                <td><?= $row->kesimpulantindakan ?></td>
                <td class="hide-sementara"><?php
                    if(!empty($row->dokfiletindakan_filepath)) {
                        echo CHtml::link("<i class='" . MyIcon::getIcons('file') . "'></i> Lihat File", 'javascript:;', array('onclick' => 'lihatFile("'. $row->dokfiletindakan_filepath.'");', 'class' => 'btn btn-success buka')); 
                    } else {
                        echo 'Tidak Ada File di upload';
                    }
                ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <b>Dokumen </b> -->
<?php //echo CHtml::link("<i class='" . MyIcon::getIcons('file') . "'></i> Buka File", 'javascript:;', array('onclick' => 'bukaGambar(this);', 'class' => 'btn btn-danger buka')); ?>
<br>
<br>
<div class="hide-sementara" hidden><?php echo CHtml::link("<i class='" . MyIcon::getIcons('cetak') . "'></i> Print", 'javascript:;', array('onclick' => 'printdulu(this);', 'class' => 'btn btn-success')); ?></div>


<div class="viewFile">
    <img alt="">
    <button class="badge badge-danger" onclick="tutupFrame()" style="display: none;"><i class="fas fa-times"></i> Tutup Dokumen</button>
    <iframe name="frame" frameborder="0" height="500px" width="100%"></iframe>
</div>

<div class="file" hidden>
    <table class="items table table-bordered table-striped datatable">
        <thead>
            <th>Nama Dokumen</th>
            <th>File</th>
        </thead>
        <tbody>
            <?php foreach($hasilPemeriksaan as $i => $row) :  ?>
                <tr>
                    <td><?php echo $row->dokfiletindakan_nama ?? '' ?></td>
                    <td>
                        <?php
                            $string = $row->dokfiletindakan_filepath;
                            $pattern = '/\b\w+\.pdf\b/i';
                            // 
                            if(preg_match($pattern, $string)) {
                                echo CHtml::link($row->dokfiletindakan_filepath, $this->path.$row->dokfiletindakan_filepath);
                            } else {
                                
                                echo CHtml::image($this->path.$row->dokfiletindakan_filepath, $row->dokfiletindakan_nama ?? '', array());
                              
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>

    function printdulu(obj) {
        console.log('testes jke ');

        $('.hide-sementara').addClass('hide');
        
        print($(obj));            
        
        $('.hide-sementara').removeClass('hide');

    }

    function bukaGambar(obj) {
        console.log($(obj).hasClass('buka'));
        if($(obj).hasClass('buka') == true) {
            $('.file').show();
            $(obj).removeClass('buka');
        } else {
            $(obj).addClass('buka');
            $('.file').hide();
        }
    }

    function lihatFile(nama_file){
        var path = '<?= $this->path ?>';

        console.log(nama_file)
        if (nama_file.indexOf("pdf") !== -1) {
            // console.log("Kata 'pdf' ditemukan pada string.");
            var src = path + nama_file;
            $('.viewFile').find('iframe').attr('src', src);
            $('.badge').show();
            $('.viewFile').find('img').attr('src', '');

        } else if(nama_file.indexOf('png') || nama_file.indexOf('jpg') || nama_file.indexOf('jpeg')){
            var src = path + nama_file;
            // console.log("Kata 'pdf' tidak ditemukan pada string.");
            $('.viewFile').find('img').attr('src', src);
            tutupFrame();
        } else {
            var src = path + nama_file;
            $('.viewFile').find('iframe').attr('src', src);
            $('.badge').show();
            $('.viewFile').find('img').attr('src', '');
        }
    }

    function tutupFrame() {
        $('.viewFile').find('iframe').attr('src', '');
        $('.badge').hide();
    }
</script>
