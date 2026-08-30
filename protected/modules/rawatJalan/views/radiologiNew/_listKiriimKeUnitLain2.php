<table class="table table-bordered table-striped table-condensed" id="tblListPemeriksaanRad">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Radiologi</th>
            <th>Tanggal Rencana Pemeriksaan</th>
            <th>No. Pendaftaran</th>
            <th>No. Permintaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Status Verifikasi Penunjang</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
        $modPermintaan = RJPermintaanPenunjangT::model()->with('daftartindakan','pemeriksaanrad')->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$riwayat->pasienkirimkeunitlain_id));
        ?>

        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($riwayat->tgl_kirimpasien); ?></td>
            <td><?php echo !empty($riwayat->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($riwayat->tglrencanapemeriksaan) : "-"; ?></td>
                <td><?php echo !empty($riwayat->pendaftaran_id) ? $riwayat->pendaftaran->no_pendaftaran : "<button class=\"btn btn-success\" disabled=\"disabled\" style=\"opacity:1.0\">Elektif</button>"; ?></td>
            <td><?php echo $riwayat->pasienkirimkeunitlain_id;?> <a href='' onclick="printPermintaan('<?php echo $riwayat->pasienkirimkeunitlain_id; ?>')"><i class="icon-print"></i></a> </td>
            <td>
                <?php
                foreach($modPermintaan as $j => $permintaan){
                    $tindakan = null;
                    if (!empty($permintaan->tindakanpelayanan_id)) {
                        $tindakan = TindakanpelayananT::model()->findByPk($permintaan->tindakanpelayanan_id);
                    }
                    
                    if(!empty($permintaan->pemeriksaanrad)){
                        echo strip_tags($permintaan->pemeriksaanrad->pemeriksaanrad_nama);
                    }
                    
                    if (!empty($tindakan) && $tindakan->tipepaket_id != Params::TIPEPAKET_ID_NONPAKET) {
                        $paket = TipepaketM::model()->findByPk($tindakan->tipepaket_id);
                        echo " (".$paket->tipepaket_nama.")";
                    }
                    
                    echo '<br>';
                } ?>
            </td>
            <td>
                <?php
                foreach($modPermintaan as $j => $permintaan){
                    echo $permintaan->qtypermintaan.'<br>';
                } ?>
            </td>
            <td>
                <?php
                    $pasienKirim = PasienkirimkeunitlainT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id));
                    $pasienBatal_1 = PasienbatalperiksaR::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $riwayat->pasienkirimkeunitlain_id));
                    $pasienBatal_2 = PasienbatalperiksaR::model()->findByAttributes(array('pasienmasukpenunjang_id' => $riwayat->pasienmasukpenunjang_id));
                    
                    if(!empty($pasienKirim->pasienmasukpenunjang_id) && ($pasienBatal_1 || $pasienBatal_2)) {
                        $status = '<button style="pointer-events: none;" id="red" class="btn btn-red nohover btn-status"> BATAL </button>';
                    } else if(!empty($pasienKirim->pasienmasukpenunjang_id) && empty($pasienBatal_1) && empty($pasienBatal_2)) {
                        $status = '<button style="pointer-events: none;" id="green" class="btn btn-green nohover btn-status"> SUDAH </button>';
                    } else if(empty($pasienKirim->pasienmasukpenunjang_id)) {
                        $status = '<button style="pointer-events: none;" id="red" class="btn btn-red nohover btn-status"> BELUM </button>';
                    }

                    echo $status;
                ?>
            </td>
           
        </tr>
        <?php } ?>

        <tr>
            <td colspan="8">
            <?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
                        'type'=>'info',
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