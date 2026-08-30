<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left;
        text-align: right;
        width:50%;
        color:black;
        padding-right:10px;
        font-size:18pt;
    }
    body{
        font-size:18pt;
    }
    td .uang{
        text-align:right;
    }
    .border tr{
        border:1px solid #000;
        padding:2px;
    }

    .judulcontent{
        text-align: center;
        font-weight: bold;
        padding-bottom: 10px;
        font-size: 27px !important;
        font-family: "Arial Narrow";
    }
');
?>
<style>
    .border td, .border th {
        border: none !important;
        text-align: center;
    }

    .tbl-uraian tr, .tbl-uraian td {
        font-size: 13pt !important;
    }

    @page {
        size: 280mm 180mm
    }
</style>
<?php

$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$format = new MyFormatter;
if (!isset($_GET['frame'])){

   ?>

<table width="100%" class="tbl-uraian">
    <thead>
        <tr>
            <td>
               <div style="font-size: 12pt;"><b><?php echo str_replace("MALANG", "", $data->nama_rumahsakit) ?></b></div>
            </td>
        </tr>
        <tr>
            <td>
               <div style="font-size: 12pt;"><b><?php echo $data->alamatlokasi_rumahsakit . " Malang" ?></b></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <?php
}
?>
                    <style type="text/css">
                    table.identitas-pasien tr td {
                        vertical-align: top;
                        padding: 3px;
                        font-size: 13pt !important;

                    }
                    </style>
                    <table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0" class="identitas-pasien">
                        <tr>
                            <td align="center" valig="middle" colspan="6">
                                <div class="judulcontent" style="font-size: 13pt !important;"><?php echo $judul_print ?></div>
                                <br />
                            </td>
                        </tr>

                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?php echo $modPenjualan->pasien->namadepan.' '.$modPenjualan->pasien->nama_pasien; ?>
                            </td>

                            <td>No. Billing</td>
                            <td>:</td>
                            <td><?php echo $modTindakan->pendaftaran->no_pendaftaran  ?></td>
                        </tr>

                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?php echo $modPenjualan->pasien->alamat_pasien; ?></td>
                            <td>No. RM</td>
                            <td>:</td>
                            <td><?php echo $modPenjualan->pasien->no_rekam_medik; ?></td>
                        </tr>

                        <tr>
                            <td>Tempat Pelayanan</td>
                            <td>:</td>
                            <td><?php 
                                $instalasi_singkatan = '';
                                $ruangan_nama = '';
                                $modul_id = Yii::app()->user->getState('modul_id');
                                if($modul_id == Params::MODUL_ID_LAB || $modul_id == Params::MODUL_ID_RAD || $modul_id == Params::MODUL_ID_APOTEK) {
                                    $modRuangan = RuanganM::model()->findByPk($modTindakan->create_ruangan);
                                    if(!empty($modRuangan)) {
                                       echo $modRuangan->ruangan_nama;
                                    } else {
                                        echo Yii::app()->user->getState('ruangan_nama');
                                    }
                                } else {
                                    if(!empty($modPenjualan->reseptur->ruanganreseptur_id)) {
                                        $modRuangan = RuanganM::model()->findByPk($modPenjualan->reseptur->create_ruangan);
                                        if(!empty($modRuangan)) {
                                            $instalasi_singkatan =  $modRuangan->instalasi->instalasi_singkatan;
                                            $ruangan_nama = $modRuangan->ruangan_nama;
                                        }
                                    }
                                    
                                    if(empty($instalasi_singkatan) && empty($ruangan_nama)) {
                                        echo $modPenjualan->ruangan->instalasi->instalasi_nama . ' / ' . $modPenjualan->ruangan->ruangan_nama;
                                    } else {
                                        echo $instalasi_singkatan . " / " . $ruangan_nama; 
                                    }
                                }
                                
                                ?>
                            </td>
                            <td>Kelas</td>
                            <td>:</td>
                            <?php $kelas = KelaspelayananM::model()->findByPk($modPenjualan->kelaspelayanan_id) ?>
                            <td>
                                <?php 
                                    if(Yii::app()->user->getState('ruangan_id') == 84) {
                                        echo $kelas->kelaspelayanan_nama ?? '';
                                    } else {
                                        echo "-";
                                    }
                                ?>    
                            </td>
                        </tr>

                        <tr>
                            <td>Jenis Pembayaran</td>
                            <td>:</td>
                            <td><?php echo $modPenjualan->carabayar->carabayar_namalainnya; ?></td>
                            <td>Tgl. Kunjungan</td>
                            <td>:</td>
                            <td><?php echo $format->formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
                        </tr>

            <td><?php  ?>
                    </table><br />


                    <?php
        $total = 0;
        $subtotal = 0;
        $jasapelayanan_farmasi = 0;
        // var_dump($modPenjualan->attributes); die;
        foreach ($modPenjualanDetail as $i=>$modObat){
          $totaladmin = round(($modObat->biayaadministrasi * $modObat->qty_oa),2);
          // $ppnpersen = round($modObat->jumlahppn/$jumlhqty * 100,2);

          $subtotal = $modObat->hargajual_oa;
          $jasapelayanan_farmasi = $modPenjualan->jasapelayanan_farmasi;
          $total = $total + $jasapelayanan_farmasi + $subtotal;
        ?>                   

        <?php } ?>

                    <table width="95%" style='' class="border tbl-uraian">
                        <thead>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Uraian Tarif</th>
                            <th style="text-align: right;">Jumlah Biaya</th>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <tr>
                                <td><?php echo 1 ?></td>
                                <td><?php echo $modTindakan->daftartindakan->daftartindakan_kode ?></td>
                                <td>
                                    <?php 

                                      if ( $modTindakan->daftartindakan->daftartindakan_nama=='Perawatan Rawat Inap' and $modTindakan->create_ruangan==Params::RUANGAN_ID_PERINATOLOGI){
                                          echo 'Ruang Perinatologi';
                                      }else{
                                          echo $modTindakan->daftartindakan->daftartindakan_nama;
                                      }

                                    ?>

                                </td>
                                <td style="text-align: right;">Rp.
                                    <?php echo !empty($modTindakan->tarif_tindakan) ? MyFormatter::formatNumberForPrint($modTindakan->tarif_tindakan, 2) : '' ?>
                                </td>
                            </tr>

                            <?php 
                                $total += floatval($modTindakan->tarif_tindakan);
                            ?>
                        </tbody>
                    </table>

                    <?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
?>
                    <script type='text/javascript'>
                    /**
                     * print
                     */
                    function print(caraPrint) {
                        penjualanresep_id =
                            '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : ''; ?>';
                        window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id=' + penjualanresep_id +
                            '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
                    }
                    </script>
                    <?php
}else{ ?>
                    <br>
                    <table style="width: 95%;" class="tbl-uraian">
                        <tr>
                        <td style="width: 50%;">
                           <b> No. Nota:
                            <?php 

                            $modPendaftaran = $modTindakan->pendaftaran;
                            if(!empty($modPendaftaran->pasienadmisi_id)) {
                                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                                
                                //if($modTindakans[0]->tgl_tindakan >= $modPasienAdmisi->tgladmisi) {
                                    $tgl_tindakan = strtotime($modTindakan->tgl_tindakan);
                                    $tgl_admisi = empty($modPasienAdmisi) ? null : strtotime($modPasienAdmisi->tgladmisi);
                                if (
                                    !empty($modTindakan->pasienadmisi_id) 
                                    || in_array($modTindakan->instalasi_id, Params::grupInstalasiRIID())
                                    || (!empty($tgl_admisi) && $tgl_tindakan > $tgl_admisi)
                                    ) {
                                    $nopendaftaran = str_replace(["RD", 'RJ'], "RI", $modPendaftaran->no_pendaftaran);
                                } else {
                                    $nopendaftaran = $modPendaftaran->no_pendaftaran;
                                }
                            } else {
                                $nopendaftaran = $modPendaftaran->no_pendaftaran;
                            }
                            
                            $nota = !empty($modTindakan->nopelayanan) ? $nopendaftaran . $modTindakan->nopelayanan : $nopendaftaran . "001";

                            
                            echo $nota; ?></b></td>
                            <td style="width: 30%; text-align: right;"><b>Total Biaya</b></td>
                            <td style="width: 20%; text-align: right;">
                                <b>RP. <?php echo $format->formatNumberForPrint(($modPenjualan->jasapelayanan_farmasi + $total), 2); ?></b>
                            </td>
                        </tr>
                    </table><br>
                    <table style="width: 100%;" class="tbl-uraian">
                        <tr>
                            <td style="width: 32%;">&emsp;</td>

                            <td style="width: 32%; text-align: center;"></td>
                            <td style="width: 32%; text-align: center;">
                                <div style="font-size: 13pt !important;">
                                    <?php echo str_replace("KOTA", "", Yii::app()->user->getState("kabupaten_nama")).", ".date('d-m-Y'); ?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="">Lembar 1: Loket <?= (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) ? 'Pembayaran' : 'Pendaftaran' ?></td>
                            <td style=" text-align: center;">Telah diverifikasi</td>
                            <td style=" text-align: center;">Petugas Billing</td>
                        </tr>
                        <tr>
                            <td style="">Lembar 2: <?= (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) ? 'Tempat' : 'Loket' ?> Layanan</td>
                            <td style=" text-align: center;">&emsp;</td>
                            <td style=" text-align: center;">&emsp;</td>
                        </tr>
                        <tr>
                            <td style="">&emsp;</td>
                            <td style=" text-align: center;">&emsp;</td>
                            <td style=" text-align: center;">&emsp;</td>
                        </tr>
                        <tr>
                            <td style="">&emsp;</td>
                            <td style=" text-align: center;">&emsp;</td>
                            <td style=" text-align: center;">&emsp;</td>
                        </tr>
                        <tr>
                            <td style="">&emsp;</td>
                            <td style=" text-align: center;">&emsp;</td>
                            <td style=" text-align: center;">&emsp;</td>
                        </tr>
                        <tr>
                            <td style="">&emsp;</td>
                            <td style=" text-align: center;">(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)</td>
                            <?php
                                $login = LoginpemakaiK::model()->findByPk($modPenjualan->create_loginpemakai_id);
                                //$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                            ?>
                            <td style=" text-align: center;"><?php echo $login->pegawai->namaLengkap ?? "-"; ?></td>
                        </tr>
                    </table>
                    
                    <?php } ?>
                    <?php
    if (!isset($_GET['frame'])){
   ?>
                </div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php // echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>

<?php
    }
   ?>