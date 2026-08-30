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
<p style="margin: 0; text-align: center;"><?php  //echo $this->renderPartial('_headerPrint'); ?></p>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan,  'periode'=> '', 'colspan'=>10)); ?>
<table bgcolor='white' class='table' style = "box-shadow:none;" width="100%">
    <tr bgcolor='white' >
        <td width="50%">
            <table bgcolor='white' class='table' style = "box-shadow:none;"  width="100%">
                <tr bgcolor='white'>
                    <td width="200px">
                        <b>No Permintaan</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->nopengajuan; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Permintaan</b>
                    </td>
                    <td>
                        : <?php echo MyFormatter::formatDateTimeForUser($modPengajuan->tglpengajuanbahan); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Minta Dikirim</b>
                    </td>
                    <td>
                        : <?php echo (!empty($modPengajuan->tglmintadikirim)? MyFormatter::formatDateTimeForUser($modPengajuan->tglmintadikirim) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>No Rencana</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->renkebbahanmakanan)? $modPengajuan->renkebbahanmakanan->renkebbahanmakanan_no : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Rencana</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->renkebbahanmakanan)? MyFormatter::formatDateTimeForUser($modPengajuan->renkebbahanmakanan->renkebbahanmakanan_tgl) : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Pegawai Pemesan</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->mengajukan)? $modPengajuan->mengajukan->namaLengkap: "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Keterangan</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->keterangan_bahan; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Jenis PPh</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->pajak)?$modPengajuan->pajak->pajak_nama:"-"); ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table bgcolor='white' class='table' style = "box-shadow:none;">
                <tr bgcolor='white'>
                    <td width="200px">
                        <b>No Referensi</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->noreferensi; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Sumber Dana</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->sumberdana)?$modPengajuan->sumberdana->sumberdana_nama: "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Supplier</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->supplier)? $modPengajuan->supplier->supplier_nama : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Alamat</b>
                    </td>
                    <td>
                        : <?php echo $modPengajuan->alamatpengiriman; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>No Telp</b>
                    </td>
                    <td>
                        : <?php echo (isset($modPengajuan->supplier)? $modPengajuan->supplier->supplier_telp : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tgl. Permintaan Uang Muka</b>
                    </td>
                    <td>
                        : <?php echo (!empty($modPengajuan->tglpermintaanuangmuka)? MyFormatter::formatDateTimeForUser($modPengajuan->tglpermintaanuangmuka): "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Jumlah Permintaan Uang Muka</b>
                    </td>
                    <td>
                        : Rp <?php echo (!empty($modPengajuan->jmlpermintaanuangmuka)? MyFormatter::formatNumberForPrint($modPengajuan->jmlpermintaanuangmuka, 2): "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table id="tableBarang" class="table border" bgcolor='white'>
    <thead class="border">
        <th bgcolor='white'>No</th>
        <th bgcolor='white'>Kelompok</th>
        <th bgcolor='white'>Nama</th>
        <th bgcolor='white'>Spesifikasi Bahan Makanan</th>
        <th bgcolor='white'>Tgl. Kedaluwarsa</th>
        <th bgcolor='white'>Jumlah Permintaan</th>
        <th bgcolor='white'>Jumlah Persediaan</th>
        <th bgcolor='white'>Satuan</th>
        <th bgcolor='white'>Harga Netto</th>
        <th bgcolor='white'>Keringanan (%)</th>
        <th bgcolor='white'>Keringanan (Rp)</th>
        <th bgcolor='white'>PPN (%)</th>
        <th bgcolor='white'>PPN (Rp)</th>
        <th bgcolor='white'>PPh (%)</th>
        <th bgcolor='white'>PPh (Rp)</th>
        <th bgcolor='white'>Subtotal</th>
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
            <tr bgcolor='white' class="border">   
                <td bgcolor='white'><?php echo $no; ?></td>
                <td bgcolor='white'><?php echo $detail->bahanmakanan->kelbahanmakanan; ?></td>
                <td bgcolor='white'><?php echo $detail->bahanmakanan->namabahanmakanan; ?></td>
                <td bgcolor='white'><?php echo $detail->bahanmakanan->ket_spesifikasibahanmakanan; ?></td>
                <td bgcolor='white'><?php echo MyFormatter::formatDateTimeForUser($detail->bahanmakanan->tglkadaluarsabahan); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->qty_pengajuan,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->bahanmakanan->jmlpersediaan,2,",","."); ?></td>
                <td bgcolor='white'><?php echo $detail->satuanbahan; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($detail->harganettobhn,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->persendiscount,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($jmlDiskon,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->persenppn,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($jmlPpn,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->persenpph,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($jmlPph,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($totalAll,2,",","."):"Hidden"; ?></td>
            </tr>   
            <?php 
            $no++;
        endforeach;
     
    ?>
    </tbody>
     <tfoot>
         <tr class="border">
             <td class='border' colspan='15' style='text-align:right;' ><b> Total</b></td>
             <td class='border' style = 'text-align:right;'><b> <?php echo (Params::cekHiddenHargaGizi()==true) ? "Rp ".number_format($subTotal,2,",","."):"Hidden"; ?></b></td>
         </tr>
     </tfoot>
</table>
 
<?php
if (isset($_GET['frame'])){
    
    //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){        
        pengajuanbahanmkn_id = '<?php echo !empty($modPengajuan->pengajuanbahanmkn_id) ? $modPengajuan->pengajuanbahanmkn_id : ''; ?>';
        window.open('<?php echo $this->createUrl('DetailPrintPengajuan'); ?>&id='+pengajuanbahanmkn_id+'&caraPrint='+caraPrint+'&frame=false','printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    
<?php } 
?>
    <table class ="table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="33%" style="text-align:center;">
<!--<div><br>Manager Umum,<br>Mengetahui</div>
                       
                        <div style="margin-top:60px;"><?php // echo isset($modPengajuan->idpegawai_mengetahui) ? $modPengajuan->mengetahui->namaLengkap :?></div>
                        <hr style = "padding: 0;margin: 0;">
                        <div>
                            <?php //echo isset($modPengajuan->idpegawai_mengetahui) ? 'NIP. '.$modPengajuan->mengetahui->nomorindukpegawai :?>                            
                        </div>-->
                    </td>
                    <td width="33%" style="text-align:center;">
                       
<!--<div>
                            <br>
                            Manajer Keuangan,<br>Mengetahui</div>
                       
                        <div style="margin-top:60px;">                            
                            <?php // echo isset($modPengajuan->idpegawai_mengetahui2) ? $modPengajuan->mengetahui2->namaLengkap :?>                            
                        </div>
                        <hr style = "padding: 0;margin: 0;">
                        <div>
                            <?php //echo isset($modPengajuan->idpegawai_mengetahui2) ? 'NIP. '.$modPengajuan->mengetahui2->nomorindukpegawai :?>                            
                        </div>-->
                    </td>
                    <td style="text-align:center;">
                        <div>
                            Direktur,<br>Menyetujui</div>
                       
                        <div style="margin-top:60px;">                            
                            <?php echo isset($modPengajuan->idpegawai_menyetujui) ? $modPengajuan->menyetujui->namaLengkap : "-"?>                            
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
       <br>
       
    <?php
  echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT');"));      
  echo " ".CHtml::link(Yii::t('mds', '{icon} PDF', array('{icon}'=>'<i class="entypo-book"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>"print('PDF');"));      
  echo " ".CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}'=>'<i class="entypo-pdf"></i>')), '#', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL');"));      
?>
 <div class="footer">
     
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
 
    </div>   
    
