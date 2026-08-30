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
                    <td><?=  isset($detailHasil[0]) ? $detailHasil[0]->ruangan->ruangan_nama : '' ?>
            
                </tr>
               
                <tr>
                    <td>Tanggal Pemeriksaan</td>
                    <td> : </td>
                    <td><?= isset($detailHasil[0]) ? MyFormatter::formatDateTimeForUser($detailHasil[0]->tglpemeriksaanrm) : '' ?></td>
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
        </td>
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
        <?php 
            if(count((array)$detailHasil) > 0){              
                foreach($detailHasil as $i=>$row){     
        ?> 
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= MyFormatter::formatDateTimeForUser($row->tglpemeriksaanrm) ?></td>
                <td><?= $row->tindakanterapi_rehab ?? '' ?></td>
                <td><?= $row->hasilpemeriksaanrm ?></td>
                <td><?= $row->keteranganhasilrm ?></td>
                <td class="hide-sementara">
                    <?php
                        if (!empty($row->dokfilerm_filepath)) {
                            echo CHtml::link("<i class='" . MyIcon::getIcons('file') . "'></i> Buka File", 'javascript:;', array('onclick' => 'lihatFile("' . $row->dokfilerm_filepath . '");', 'class' => 'btn btn-danger buka'));
                        } else {
                            echo 'Tidak Ada File di upload';
                        }
                    ?>
                </td>

            </tr>
        <?php }} ?>
    </tbody>
</table>



<?php 
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printHasil(\'PRINT\')')); 
echo " ";
// echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-form-silang icon-white"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>'window.parent.$("#dialogLihatHasil").dialog(\'close\')')); 
$urlPrint=  $this->createUrl($this->id.'/HasilPeriksaPrint', array("pendaftaran_id"=>$masukpenunjang->pendaftaran_id,"pasien_id"=>$masukpenunjang->pasien_id,"pasienmasukpenunjang_id"=>$masukpenunjang->pasienmasukpenunjang_id));
$js = <<< JSCRIPT
function printHasil(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=1024px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
?>



<div class="viewFile">
    <img alt="">
    <button class="badge badge-danger" style="display: none;" onclick="tutupFrame()"><i class="fas fa-times"></i> Tutup Dokumen</button>
    <iframe name="frame" frameborder="0" height="500px" width="100%"></iframe>
</div>

<script>


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