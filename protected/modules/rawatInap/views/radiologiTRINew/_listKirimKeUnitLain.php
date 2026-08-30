<table id="tblListPemeriksaanRad" class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tanggal Kirim Ke Radiologi</th>
            <th>Tanggal Rencana Pemeriksaan</th>
            <th>No. Pendaftaran</th>
            <th>No. Permintaan</th>
            <th>Permintaan Pemeriksaan</th>
            <th>Jumlah</th>
            <th>Status Verifikasi Penunjang</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
            $modPermintaan = RIPermintaanPenunjangT::model()->with('daftartindakan', 'pemeriksaanrad')->findAllByAttributes(array('pasienkirimkeunitlain_id' => $riwayat->pasienkirimkeunitlain_id));
        ?>
            <tr>
                <td><?php echo $riwayat->tgl_kirimpasien; ?></td>
                <td><?php echo !empty($riwayat->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($riwayat->tglrencanapemeriksaan) : "-"; ?></td>
                <td><?php echo !empty($riwayat->pendaftaran_id) ? $riwayat->pendaftaran->no_pendaftaran : "<button class=\"btn btn-success\" disabled=\"disabled\" style=\"opacity:1.0\">Elektif</button>"; ?></td>
                <td><?php echo $riwayat->pasienkirimkeunitlain_id; ?> <a href='' onclick="printPermintaan('<?php echo $riwayat->pasienkirimkeunitlain_id; ?>')"><i class="icon-print"></i></a> </td>
                <td>
                    <?php
                    foreach ($modPermintaan as $j => $permintaan) {
                        echo $permintaan->pemeriksaanrad->pemeriksaanrad_nama . '<br>';
                    } ?>
                </td>
                <!--<td>
            //<?php
                //            foreach($modPermintaan as $j => $permintaan){
                //                $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$riwayat->kelaspelayanan_id,
                //                                                                            'daftartindakan_id'=>$permintaan->pemeriksaanrad->daftartindakan_id,
                //                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                //                echo (!empty($modTarif->harga_tariftindakan))? number_format($modTarif->harga_tariftindakan).'<br>':'0 <br>';
                //            } 
                ?>
        </td>-->
                <td>
                    <?php
                    foreach ($modPermintaan as $j => $permintaan) {
                        echo $permintaan->qtypermintaan . '<br>';
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
                <td>
                    <?php echo CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'batalKirim(' . $riwayat->pasienkirimkeunitlain_id . ',' . $riwayat->pasien_id . ');return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan kirim pasien', 'data-placement' => 'left')); ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
    'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'buttons' => array(
        array('label' => 'Print', 'icon' => 'entypo-print', 'url' => '#', 'htmlOptions' => array('onclick' => 'printRiwayat(\'PRINT\')')),
        array('label' => '', 'items' => array(
            array('label' => 'PDF', 'icon' => 'icon-book', 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(\'PDF\')')),
            array('label' => 'Excel', 'icon' => 'icon-pdf', 'url' => '', 'itemOptions' => array('onclick' => 'printRiwayat(\'EXCEL\')')),

        )),
    ),
    'htmlOptions' => array('style' => 'float: right; clear: both; margin-bottom: 17px;')
    //        'htmlOptions'=>array('class'=>'btn')
)); ?>