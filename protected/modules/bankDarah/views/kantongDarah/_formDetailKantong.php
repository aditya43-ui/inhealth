<?php
/**
 * -Digunakan untuk menampilkan detail observasi
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-1534
 */
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Detail Kantong Darah</div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
            <thead>
                <tr>                  
                    <th>Jenis Kantong Darah</th>
                    <th>No. Kantong Darah Utama</th>
                    <th>No. Sampel Konfirmasi Gol Darah</th>
                    <th>No. Sampel Skrining IMLTD</th>
                    <th>No. Komponen Darah</th>
                    <th>Tgl Pencatatan</th>
                    <th>Petugas Pencatatan</th>  
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($modKantong as $det ){
                    $mKantong = KantongdarahT::model()->findByAttributes(array('nomorbarcode_utama' => $det->nomorbarcode_utama));
                    $jenis = JeniskantongdarahM::model()->findByAttributes(array('jeniskantongdarah_id'=>$mKantong->jeniskantongdarah_id));
                    $petugas = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$mKantong->petugaspencatat_id));
                ?>
                <tr>
                    <td><?php echo $jenis->nama_jenis ?></td>
                    <td><?php echo $det->nomorbarcode_utama ?></td>
                    <td><?php echo !empty($mKantong->nomorbarcode_sample) ? $mKantong->nomorbarcode_sample : ""; ?> </td>
                    <td><?php echo !empty($mKantong->nomorbarcode_sample_imltd) ? $mKantong->nomorbarcode_sample_imltd : ""; ?> </td>
                    <td>
                        <?php 
                        $kantongDarah = KantongdarahT::model()->findAllByAttributes(array('nomorbarcode_utama' => $det->nomorbarcode_utama));
                        foreach($kantongDarah as $kantong){
                            $modPeriksa = PeriksakomponendarahT::model()->findByAttributes(array('kantongdarah_id' => $kantong->kantongdarah_id));
                            if (!empty($modPeriksa)) {
                                $modTerima = TerimakantongdetT::model()->findByPk($modPeriksa->terimakantongdet_id);
                                if (!empty($modTerima)) {
                                    echo "<ul>";
                                    echo "<li>".$modTerima->nobarcodekantong."</li>";
                                    echo "</ul>";
                                }
                            }
                            
                        }
                        ?>
                    </td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($mKantong->tglpencatatan) ?></td>
                    <td><?php echo $petugas->nama_pegawai ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
