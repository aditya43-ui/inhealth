<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    .tblpadding td, th{
        padding: 5px;
    }
    h3, h4{
        color: black;
    }

    .borderclass{
        border: 1px solid black;
    }

    .bordertopclass{
        border-top: 1px solid black;
    }
</style>

    <table width="100%">
        <tr>
            <td>
                <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
            </td>
        </tr>
    </table>
    <center><h3><?php echo $judul_print ?></h3></center>
    <br/>
    <table width="100%">
        <tr>
            <td width="50%" valign="top">
                <table class="tblpadding">
                    <tr>
                        <td width="180px"> No. Pendaftaran </td>
                        <td>
                            : <?php echo $modPendaftaran->no_pendaftaran; ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Nama Pasien</td>
                        <td>
                            : <?php echo $modPendaftaran->pasien->namadepan .' '.$modPendaftaran->pasien->nama_pasien; ?>
                        </td>
                    </tr>
                    <tr>
                        <td> No. Rekam Medik </td>
                        <td>
                        : <?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Tgl. Lahir / Umur </td>
                        <td>
                        : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir) .' / '.$modPendaftaran->umur; ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top">
                <table class="tblpadding">
                    <tr>
                        <td width="150px"> Jenis Penjamin </td>
                        <td>
                        : <?php echo $modPendaftaran->carabayar_nama; ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Penjamin </td>
                        <td>
                        : <?php echo $modPendaftaran->penjamin_nama; ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Ruangan </td>
                        <td>
                        : <?php echo $modPendaftaran->ruangan_nama; ?>
                        </td>
                    </tr>
                    <tr>
                        <td> Kelas Pelayanan </td>
                        <td>
                            : <?php echo $modPendaftaran->kelaspelayanan_nama; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br/>
    <center><h4>DATA PEMAKAIAN BAHAN PASIEN</h4></center>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="tblpadding">
        <thead>
            <tr>
                <th class="borderclass">No.</th>
                <th class="borderclass">Tgl. Pemakaian</th>
                <th class="borderclass">Tipe Paket</th>
                <th class="borderclass">Jenis Obat Alkes</th>
                <th class="borderclass">Nama Bahan Medis</th>
                <th class="borderclass">Harga</th>
                <th class="borderclass">Jumlah</th>
                <th class="borderclass">Sub Total Harga</th>
            </tr>
        </thead>
        <?php $totalharga = 0; ?>
        <tbody>
        <?php
        $no = 0;
        foreach ($modDetails as $i => $dataTindakan) {
            $no++;
        ?>
            <tr>
                <td class="borderclass" valign="middle"><?php echo $no; ?></td>
                <td class="borderclass" valign="middle"><?php echo $dataTindakan['tglpelayanan']; ?></td>
                <td class="borderclass" valign="middle"><?php echo $dataTindakan['tipepaket_nama']; ?></td>
                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                    <table width="100%">
                        <?php
                        if(!empty($dataTindakan['detail'])){
                            foreach($dataTindakan['detail'] as $j =>$dataKomp){
                                $totalharga += $dataKomp['hargajual'];
                                $cls="";
                                if($j > 0){
                                    $cls="bordertopclass";
                                }
                                ?>
                                    <tr>
                                        <td class="<?php echo $cls; ?>">
                                            <?php echo $dataKomp['jenisobatalkes_nama']; ?>
                                        </td>
                                    </tr>    
                                <?php 
                            }
                        }?>
                    </table>
                </td>
                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                    <table width="100%">
                        <?php
                        if(!empty($dataTindakan['detail'])){
                            foreach($dataTindakan['detail'] as $j =>$dataKomp){
                                $cls="";
                                if($j > 0){
                                    $cls="bordertopclass";
                                }
                                ?>
                                    <tr>
                                        <td class="<?php echo $cls; ?>">
                                            <?php echo $dataKomp['obatalkes_nama']; ?>
                                        </td>
                                    </tr>    
                                <?php 
                            }
                        }?>
                    </table>
                </td>
                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                    <table width="100%">
                        <?php
                        if(!empty($dataTindakan['detail'])){
                            foreach($dataTindakan['detail'] as $j =>$dataKomp){
                                $cls="";
                                if($j > 0){
                                    $cls="bordertopclass";
                                }
                                ?>
                                    <tr>
                                        <td class="<?php echo $cls; ?>" style="text-align: right;">
                                            <?php echo "Rp. ".MyFormatter::formatNumberForPrint($dataKomp['hargasatuan_oa'],2); ?>
                                        </td>
                                    </tr>    
                                <?php 
                            }
                        }?>
                    </table>
                </td>
                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                    <table width="100%">
                        <?php
                        if(!empty($dataTindakan['detail'])){
                            foreach($dataTindakan['detail'] as $j =>$dataKomp){
                                $cls="";
                                if($j > 0){
                                    $cls="bordertopclass";
                                }
                                ?>
                                    <tr>
                                        <td class="<?php echo $cls; ?>">
                                        <?php echo MyFormatter::formatNumberForPrint($dataKomp['qty'],2).' '.$dataKomp['satuankecil']; ?>
                                        </td>
                                    </tr>    
                                <?php 
                            }
                        }?>
                    </table>
                </td>
                <td  class="borderclass" style="margin: 0px !important; padding: 0px !important;">
                    <table width="100%">
                        <?php
                        if(!empty($dataTindakan['detail'])){
                            foreach($dataTindakan['detail'] as $j =>$dataKomp){
                                $cls="";
                                if($j > 0){
                                    $cls="bordertopclass";
                                }
                                ?>
                                    <tr>
                                        <td class="<?php echo $cls; ?>" style="text-align: right;">
                                            <?php echo "Rp. ".MyFormatter::formatNumberForPrint($dataKomp['hargajual'],2); ?>
                                        </td>
                                    </tr>    
                                <?php 
                            }
                        }?>
                    </table>
                </td>        
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="borderclass" style="font-weight: bold; text-align: right;" colspan="7">Total Harga</td>
                <td class="borderclass" style="text-align: right;"><?php echo "Rp. ".MyFormatter::formatNumberForPrint($totalharga,2); ?></td>
            </tr>
        </tfoot>                
    </table>
     <br/>                   
    
    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">
        <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
    </div>
    <br/>   
<div class="footer">
  
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    
</div>
