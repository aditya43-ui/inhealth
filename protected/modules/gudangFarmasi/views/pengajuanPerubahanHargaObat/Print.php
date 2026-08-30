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
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  
<style>
    
    body {
        color: black;
    }
    
    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent"> <p style="margin: 0; text-align: center;"><b>PENGAJUAN PERUBAHAN HARGA OBAT ALKES</b></p></div>
                    <br>
                        <?php
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$alamatrs = $modProfilRs->alamatlokasi_rumahsakit.", Kelurahan ".$modProfilRs->kelurahan->kelurahan_nama.", Kecamatan ".$modProfilRs->kecamatan->kecamatan_nama.", ".$modProfilRs->kabupaten->kabupaten_nama;

if (!isset($_GET['frame'])){
}

?>
                    
                <table style="width: 100%; border: none;">
                    <tr>
                        <td width="50%">
                            <table style="width: 100%; border: none;">
                                <tr>
                                    <td width="200px">No. Pengajuan</td>
                                    <td>
                                        : <?php echo $model->nopengajuanhargaoa; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pengajuan</td>
                                    <td>
                                        : <?php echo MyFormatter::formatDateTimeForUser($model->tglpengajuanhargaoa); ?> 
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="200px">Keterangan Pengajuan</td>
                                    <td>
                                        : <?php echo $model->ketpengajuan; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pegawai yang Mengajukan</td>
                                    <td>
                                        :  <?php echo (isset($model->pegawai)?$model->pegawai->namaLengkap:""); ?> 
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>              
    <br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
        <thead class="border">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Jenis</th>
                    <th rowspan="2">Nama Obat</th>
                    <th rowspan="2">Satuan</th>
                    <th colspan="6" style="text-align: center">Lama</th>
                    <th colspan="6" style="text-align: center">Baru</th>
                    <th rowspan="2">Alasan Perubahan</th>
                </tr>
                <tr>
                    <th>Harga Netto</th>
                    <th>Keringanan</th>
                    <th>PPN</th>
                    <th>HPP</th>
                    <th>Margin (%)</th>
                    <th>Harga Jual</th>

                    <th>Harga Netto</th>
                    <th>Keringanan</th>
                    <th>PPN</th>
                    <th>HPP</th>
                    <th>Margin (%)</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
        </thead>
        <?php 
        foreach ($modDetail as $i=>$modObat){ 
            $oa = ObatalkesM::model()->findByPk($modObat->obatalkes_id);
            $satuanobat = "";
             if (!empty($modObat->satuanbesar_id)) {
                    $besar = SatuanbesarM::model()->findByPk($modObat->satuanbesar_id);
                    $satuanobat = $besar->satuanbesar_nama;
                } else if (!empty($modObat->satuankecil_id)) {
                    $kecil = SatuankecilM::model()->findByPk($modObat->satuankecil_id);
                    $satuanobat = $kecil->satuankecil_nama;
                }
        ?>
             <tr class="border">
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo (isset($oa->jenisobatalkes)? $oa->jenisobatalkes->jenisobatalkes_nama : ""); ?></td>
                <td><?php echo $oa->obatalkes_nama; ?></td>
                <td><?php echo "1 ".$satuanobat; ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->harganettolama,2); ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->diskonlama,2); ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->ppnlama,2); ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->hpplama,2); ?></td>
                <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modObat->marginlama); ?>%</td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->hargajuallama,2); ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->harganettobaru,2); ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->diskonbaru,2); ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->ppnbaru,2); ?></td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->hppbaru,2); ?></td>
                <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($modObat->marginbaru,2); ?>%</td>
                <td style = "text-align:right;">Rp <?php echo MyFormatter::formatNumberForPrint($modObat->hargajualbaru,2); ?></td>
                <td>
                    <?php echo $modObat->alasanperubahan; ?>
                </td>
            </tr>
        <?php } ?>
</table><br><br>
<div class="row">
	<div class="col-sm-4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Mengetahui, <br> Manager Keuangan
		</div>
		<div class="control-group">
			<?php echo $model->pegawaimengetahui->NamaLengkap;?>
		</div>
	</div>
    <div class="col-sm-4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			<!--Manager Keuangan, <br>Mengetahui-->
		</div>
		<div class="control-group">
			<!--( <?php // echo $model->pegawaimengetahuiumum->NamaLengkap;?> )-->
		</div>
	</div>
	<div class="col-sm-4" style="text-align:center;">
		<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
			Menyetujui, <br> Direktur
		</div>
		<div class="control-group">
			<?php echo $model->pegawaimenyetujui->NamaLengkap;?>
		</div>
	</div>
</div>
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
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>
