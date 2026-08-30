<style>
    body {
        color: black;
    }

    .borderclass {
        border: 1px solid black;
    }
</style>
<?php 
    $this->widget('bootstrap.widgets.BootAlert');

    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); 
    $konfig = KonfigsystemK::model()->find();

    $titleDetail = "RM. 033";
    $header = "DAFTAR PEMAKAIAN OBAT DAN ALAT KESEHATAN HABIS PAKAI";
?>
<div style="padding: 20px">
    <div>
        <?php echo $this->renderPartial($this->path_view.'_header', array('modPendaftaran'=>$modPendaftaran, 'peg'=>$peg,'modPasien'=>$modPasien,'modRencanaOperasi'=>$modRencanaOperasi, 'header' => $header, 'titleDetail' => $titleDetail)); ?>
        <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama </th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$_GET['pendaftaran_id']));
                            $modObatAlkes = ObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPenunjang->pasienmasukpenunjang_id));
                            $no=1;
                            if (!empty($modObatAlkes)) { 
                        ?>
                            <?php
                                foreach($modObatAlkes as $mp => $val){
                            ?>
                            <tr>
                                <td><?php echo $no?></td>
                                <td><?php echo empty($val->obatalkes_id) ? '-' : $val->obatalkes->obatalkes_nama ?></td>
                                <td><?php echo empty($val->qty_oa) ? '-' : $val->qty_oa ?></td>
                                <td><?php echo empty($val->ket_penggunaan) ? '-' : ($val->ket_penggunaan) ?></td>
                            </tr>
                            <?php $no+=1;
                                }
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="10">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
    </div>
</div>