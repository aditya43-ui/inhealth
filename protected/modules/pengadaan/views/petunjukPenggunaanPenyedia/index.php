<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><strong>Petunjuk Penggunaan</strong></div>
    </div>
    <div class="panel-body">
        <table width="100%">
            <tr>
                <td style="text-align: center;"><p><h3><b><?=$modPetunjuk->petunjukpenggunaan_modul?></b></h3></p></td>
            </tr>
            <tr>
                <td style="text-align: center;"><p><h4><b>Tanggal: <?=$modPetunjuk->petunjukpenggunaan_tanggal?> Rev: <?=$modPetunjuk->petunjukpenggunaan_revisi?></b></h4></p></td>
            </tr>
            <tr>
                <td style="text-align: center;"><p><h4><?=$modPetunjuk->petunjukpenggunaan_deskripsi?></h4></p></td>
            </tr>
        </table>
        <br>
        <div>
            <?php 
            $path = Params::pathFilePetunjukPenggunaan() . $modPetunjuk->petunjukpenggunaan_lampiran;
            if (file_exists($path)) {
                $pdf = Params::urlFilePetunjukPenggunaan() . $modPetunjuk->petunjukpenggunaan_lampiran;
            }else{
                $pdf = "";
            }
            ?>
            <iframe src="<?= $pdf ?>" style="width:100%;height:700px;"></iframe>
        </div>
    </div>
</div>