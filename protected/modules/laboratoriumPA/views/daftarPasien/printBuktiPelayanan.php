<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    hr.garis {
        border-top: 1px dashed black;
    }
    tr.garis {
        /* border-top: 1px dashed black; */
        border-top: 1px dashed black;
        border-bottom: 1px dashed black;
    }
    tr.atas {
        /* border-top: 1px dashed black; */
        border-top: 1px dashed black;
    }
    tr.bawah {
        /* border-top: 1px dashed black; */
        border-bottom: 1px dashed black;
    }

    table {
        width: 100%;
    }
</style>

    <hr class="garis">
    <table>
        <tr>
            <td>
                BUKTI PELAYANAN PENUNJANG
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table class="status">
        <tr>
            <td>Poli/ Intalasi</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->instalasi_nama; ?></td>
        </tr>
        <tr>
            <td>No. RM</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->no_rekam_medik; ?></td>
            <td>Asal Pasien</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->ruanganasal_nama; ?></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->nama_pasien; ?></td>
            <td>Kelas</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->kelaspelayanan_nama ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->jeniskelamin; ?></td>
            <td>Jenis Penjamin</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->carabayar_nama; ?></td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->umur; ?></td>
            <td>Dokter Pengirim</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->nama_dokterasal .' ,'. $modPasienMasukPenunjang->gelardokterasal  ; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->alamat_pasien; ?></td>
            <td>Diagnosa</td>
            <td>:</td>
            <td><?php if(!empty($modDiagnosa)){
                foreach($modDiagnosa as $diagnosa){
                    $diag = DiagnosaM::model()->findByPk($diagnosa->diagnosa_id);
                    echo $diag->diagnosa_nama;
                }

            }else{
                echo '-';
            }?></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>Tanggal</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->tglmasukpenunjang; ?></td>
        </tr>
        <tr>
            <td>No. Kartu</td>
            <td>:</td>
            <?php $kartu= LBPasienMasukPenunjangV::model()->findByAttributes(array('no_rujukan'=>$modPasienMasukPenunjang->pendaftaran_id));?>
            <?php if (empty($kartu)) {
                ?>
                <td><?php echo '-'; ?></td>
                <?php
            }else{
                ?>
                <td><?php echo $kartu; ?></td>
                <?php
            }?>
            <td>no. Registrasi</td>
            <td>:</td>
            <td><?php echo $modPasienMasukPenunjang->no_pendaftaran; ?></td>
        </tr>
        <tr>
            <td>No. SEP</td>
            <td>:</td>
            <td><?php echo $modSep; ?></td>
            <td>sample ID/RS</td>
            <td>:</td>
            <td><?php if(!empty($modSampel)){
                foreach($modSampel as $sample){
                    echo $sample->no_pengambilansample.'<br>';
                }
            }else{
                echo '-';
            } ?></td>
        </tr>
    </table>
    <table>
        <tr class="garis">
            <td>No.</td>
            <td>Uraian Tindakan</td>
            <td>Qty</td>
            <td>Pelaksana</td>
            <td>Tarif</td>
            <td>Tagihan</td>
        </tr>
        <?php 
            $no = 1;
            $t_pelayanan = 0;
            foreach($modTindakan as $row){
                // print_r($row->karcis_id);die;
                // $karcis = LBTindakanPelayananT::model()->findByAttributes(array('karsis_id'=>'','pasienmasukpenunjang_id'=>$row->pasienmasukpenunjang_id));

                $nama= DaftartindakanM::model()->findByPk($row->daftartindakan_id);
                $t_pelayanan += $row->tarif_satuan;
                ?>
                    <tr>
                    <td><?php echo $no++;?></td>
                    <td><?php echo $nama->daftartindakan_nama;?></td>
                    <td><?php echo $row->qty_tindakan;?></td>
                    <td><?php echo '';?></td>
                    <td><?php echo MyFormatter::formatNumberForUser($row->tarif_satuan);?></td>
                    <td><?php echo MyFormatter::formatNumberForUser($row->tarif_tindakan);?></td>
                    </tr>
                <?php
            }
            $karcis = LBTindakanPelayananT::model()->findByAttributes(
                array(
            'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id,
                ), array(
            'condition' => 'karcis_id is not null',
                )
        );
        $karcis2 =  !empty($karcis->tarif_tindakan) ? $karcis->tarif_tindakan : '0';
        $total  = $t_pelayanan + $karcis2; 
        ?>
        <tr class="atas">
            <td colspan="4" style="text-align: right;">Total Pelayanan</td>
            <td colspan="2" style="text-align: right;"> <?= MyFormatter::formatNumberForUser($t_pelayanan) ?> <td>
        </tr>
        <tr class="bawah">
            <td colspan="4" style="text-align: right;">Karcis</td>
            <td colspan="2" style="text-align: right;"><?= !empty($karcis->tarif_tindakan) ? MyFormatter::formatNumberForUser($karcis->tarif_tindakan) : '0' ?></td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: right;"><h4>Total Pelayanan dan Karcis</h4></td>
            <td colspan="2" style="text-align: right;"><?= MyFormatter::formatNumberForUser($total) ?></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <h3>Terbilang: <?php echo MyFormatter::formatNumberTerbilang($total)?> Rupiah</h3>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <th></th>
            <th colspan = "5"></th>
            <th>Surabaya, <?php echo date("d F Y")?></th>
        </tr>
        <tr>
            <th></th>
            <th colspan = "5"></th>
            <th>Petugas</th>
        </tr>
        <tr>
            <td><br><br><br></td>
            <td><br><br><br></td>
            <td><br><br><br></td>
            <td><br><br><br></td>
            <td><br><br><br></td>
        </tr>
        <tr>
            <td style="text-align: right;">Keluarga / Pasien</td>
            <td colspan="5"></td>
            <td style="text-align: center;">(<?php echo $modPegawai->nama_pegawai?>)</td>
        </tr>
    </table> 
    