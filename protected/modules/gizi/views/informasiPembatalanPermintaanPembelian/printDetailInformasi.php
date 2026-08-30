<style>
    .border{
        border:1px solid #000;
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
<?php  //echo $this->renderPartial('_headerPrint'); ?>
<?php //echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>'',  'periode'=> '', 'colspan'=>10)); ?>
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
			<div class="judulcontent">  </div>
                        <table width="100%" style = "box-shadow:none;">
    <tr><th style = "text-align:center; font-weight: bold;" colspan="5"><h4><?php echo $judulLaporan; ?></h4><br></th></tr>
    <tr>
        <td width="200px">
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('nopengajuan')); ?></b>                                                                           
        </td>
        <td>: <?php echo CHtml::encode($modPengajuan->nopengajuan); ?></td>
        <td width="200px"><b>Pegawai Mengajukan</b></td>
        <td>: <?php echo CHtml::encode($modPengajuan->mengajukan->namaLengkap); ?></td>
    </tr>
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('tglpengajuanbahan')); ?></b>            
        </td>
        <td>
            : <?php echo CHtml::encode($modPengajuan->tglpengajuanbahan); ?>
        </td>
        <td><b>Status Persetujuan</b></td>
        <td>: <?php echo ($modPengajuan->status_persetujuan == FALSE)?"BELUM DISETUJUI":"SUDAH DISETUJUI"; ?></td>
<!--<td>&nbsp;</td>
        <td><b>Manajer Umum / Keuangan</b></td>
        <td>: <?php // echo !empty($modPengajuan->idpegawai_mengetahui)?$modPengajuan->mengetahui->namaLengkap:'-'; ?></td>-->
    </tr>   
    <tr>
        <td>
             <b><?php echo CHtml::encode($modPengajuan->getAttributeLabel('supplier_id')); ?></b>            
        </td>
        <td>
            : <?php echo isset($modPengajuan->supplier->supplier_nama)?$modPengajuan->supplier->supplier_nama:';'; ?>
        </td>
        <td>
             <b>No Referensi</b>
        </td>
        <td>
            : <?php echo !empty($modPengajuan->noreferensi)?$modPengajuan->noreferensi:""; ?>
        </td>
    </tr>  
</table>
<br>
<table id="tableObatAlkes" class="table" style = "box-shadow:none;">
    <thead>
    
       <th class="border">No</th>
        <th class="border">Kelompok</th>
        <th class="border">Nama</th>
        <th class="border">Spesifikasi Bahan Makanan</th>
        <th class="border">Tgl. Kedaluwarsa</th>
        <th class="border">Jumlah Permintaan</th>
        <th class="border">Jumlah Persediaan</th>
        <th class="border">Satuan</th>
        <th class="border">Harga Netto</th>
        <th class="border">Keringanan (%)</th>
        <th class="border">Keringanan (Rp)</th>
        <th class="border">PPN (%)</th>
        <th class="border">PPN (Rp)</th>
        <th class="border">PPh (%)</th>
        <th class="border">PPh (Rp)</th>
        <th class="border">Sub Total</th>
    
    </thead>
    <tbody>
     <?php
    $no=1;
    $subTotal = 0;
        foreach($modDetailPengajuan AS $detail): 
            $jmlQty = ($detail->qty_pengajuan * $detail->harganettobhn);
            $jmlDiskon = round((($jmlQty * $detail->persendiscount)/100),2);
            $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persenppn)/100),2);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph)/100),2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);
            $subTotal += $totalAll;
            ?>
            <tr>   
                <td class="border"><?php echo $no; ?></td>
                <td class="border"><?php echo $detail->bahanmakanan->kelbahanmakanan; ?></td>
                <td class="border"><?php echo $detail->bahanmakanan->namabahanmakanan; ?></td>
                <td class="border"><?php echo $detail->bahanmakanan->ket_spesifikasibahanmakanan; ?></td>
                <td class="border"><?php echo MyFormatter::formatDateTimeForUser($detail->bahanmakanan->tglkadaluarsabahan); ?></td>
                <td class="border" style = "text-align:right;"><?php echo number_format($detail->qty_pengajuan,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo number_format($detail->bahanmakanan->jmlpersediaan,2,",","."); ?></td>
                <td class="border"><?php echo $detail->satuanbahan; ?></td>
                <td class="border" style = "text-align:right;"><?php echo "Rp ".number_format($detail->harganettobhn,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo number_format($detail->persendiscount,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo "Rp ".number_format($jmlDiskon,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo number_format($detail->persenppn,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo "Rp ".number_format($jmlPpn,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo number_format($detail->persenpph,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo "Rp ".number_format($jmlPph,2,",","."); ?></td>
                <td class="border" style = "text-align:right;"><?php echo "Rp ".number_format($totalAll,2,",","."); ?></td>
            </tr>   
            <?php 
            $no++;
        endforeach;
     
    ?>
    </tbody>
     <tfoot>
        <tr>
            <td class='border' colspan='15' style='text-align:right;'><b> Total Harga Netto</b></td>
            <td class='border' style = 'text-align:right;'><b> <?php echo "Rp ".number_format($subTotal,2,",","."); ?></b></td>
        </tr>
    </tfoot>
</table>
    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="33%" style="text-align:center;">
                        <div><br>Manager Umum,<br>Mengetahui</div>
                       
                        <div style="margin-top:60px;"><?php echo isset($modPengajuan->idpegawai_mengetahui) ? $modPengajuan->mengetahui->namaLengkap : ''?></div>
                        <hr style = "padding: 0;margin: 0;">
                        <div>
                            <?php //echo isset($modPengajuan->idpegawai_mengetahui) ? 'NIP. '.$modPengajuan->mengetahui->nomorindukpegawai :?>                            
                        </div>
                    </td>
                    <td width="33%" style="text-align:center;">
                       
                        <div>
                            <br>
                            Manajer Keuangan,<br>Mengetahui</div>
                       
                        <div style="margin-top:60px;">                            
                            <?php echo isset($modPengajuan->idpegawai_mengetahui2) ? $modPengajuan->mengetahui2->namaLengkap : '' ?>                            
                        </div>
                        <hr style = "padding: 0;margin: 0;">
                        <div>
                            <?php //echo isset($modPengajuan->idpegawai_mengetahui2) ? 'NIP. '.$modPengajuan->mengetahui2->nomorindukpegawai :?>                            
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <div>
                            <?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br>
                            Direktur,<br>Menyetujui</div>
                       
                        <div style="margin-top:60px;">                            
                            <?php echo isset($modPengajuan->idpegawai_menyetujui) ? $modPengajuan->menyetujui->namaLengkap : ''?>                            
                        </div>
                        <hr style = "padding: 0;margin: 0;">
                        <div>
                            <?php //echo isset($modPengajuan->idpegawai_menyetujui) ? 'NIP. '.$modPengajuan->menyetujui->nomorindukpegawai :?>                            
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
       <br>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
<tr>
    <td>Surat Pesanan ini telah disetujui dan disahkan secara Elektronik</td>
</tr>

</table>

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

    
