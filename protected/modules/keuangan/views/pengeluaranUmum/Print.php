<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));  
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td style="width:50%" valign="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="200px">Tgl. Pengeluaran</td><td width="10px">:</td>
                    <td>
                        <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($model->tglpengeluaran)); ?>
                    </td>
                </tr>
                <tr>
                    <td>No Pengeluaran</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode(isset($model->nopengeluaran) ? $model->nopengeluaran : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>Kelompok Transaksi</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($model->kelompoktransaksi); ?>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Pengeluaran </td><td>:</td>
                    <td>
                        <?php  echo CHtml::encode((isset($model->jenispengeluaran)? $model->jenispengeluaran->jenispengeluaran_nama:"")); ?>
                    </td>
                </tr>
                <tr>
                    <td>Volume  </td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($model->volume).' '.CHtml::encode($model->satuanvol); ?>
                    </td>
                </tr>
                <tr>
                    <td>Cara Pembayaran</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->carabayarkeluar); ?>
                    </td>
                </tr>
                <?php if($modTandaBukti->carabayarkeluar == Params::CARAPEMBAYARAN_TRANSFER){ ?>
                <tr>
                    <td>Nama Bank Penerima</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->melalubank); ?>
                    </td>
                </tr>
                <tr>
                    <td>No Rekening</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->denganrekening); ?>
                    </td>
                </tr>
                <tr>
                    <td>Atas Nama Rekening</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->atasnamarekening); ?>
                    </td>
                </tr>
                <tr>
                    <td>No Struk Bukti Transfer</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->nobukti_transfer); ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td>Nama Penerima</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->namapenerima); ?>
                    </td>
                </tr>
                <tr>
                    <td>Alamat Penerima</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->alamatpenerima); ?>
                    </td>
                </tr>
                   
            </table>            
        </td>
        <td style="width:50%" valign="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="200px">Tgl. Kas Keluar</td><td width="10px">:</td>
                    <td>
                        <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modTandaBukti->tglkaskeluar)); ?>
                    </td>
                </tr>
                <tr>
                    <td>No Kas Keluar</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($modTandaBukti->nokaskeluar); ?>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td><td>:</td>
                    <td>
                        <?php echo CHtml::encode($model->keterangankeluar); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total Biaya Administrasi</td><td>:</td>
                    <td>
                        <?php echo (($modTandaBukti->biayaadministrasi > 0) ? "Rp ". number_format($modTandaBukti->biayaadministrasi) :""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total PPh 21</td><td>:</td>
                    <td>
                       <?php echo (($model->jmlpph_21 > 0) ? "Rp ". number_format($model->jmlpph_21) :""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total PPh 23</td><td>:</td>
                    <td>
                        <?php echo (($model->jmlpph_23 > 0) ? "Rp ". number_format($model->jmlpph_23) :""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total PPh Final</td><td>:</td>
                    <td>
                        <?php echo (($model->jmlpph_22 > 0) ? "Rp ". number_format($model->jmlpph_22) :""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Total PPN</td><td>:</td>
                    <td>
                        <?php echo (($model->ppn > 0) ? "Rp ". number_format($model->ppn) :""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Kas Keluar</td><td>:</td>
                    <td>
                        <?php echo (($modTandaBukti->jmlkaskeluar > 0) ? "Rp ". number_format($modTandaBukti->jmlkaskeluar) :""); ?>
                    </td>
                </tr>
            </table>            
        </td>
    </tr>
</table><br>

<?php if (count((array)$modUraian) != 0): ?>

<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>Uraian</th>
            <th>Volume</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modUraian as $i => $uraian) { ?>
        <tr>
            <td>
                <?php echo isset($uraian->uraiantransaksi)?$uraian->uraiantransaksi:'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->volume)?$uraian->volume:'-'; ?>
            </td>
            <td>
                <?php echo isset($uraian->satuanvol)?$uraian->satuanvol:'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->hargasatuan)?  MyFormatter::formatNumberForPrint($uraian->hargasatuan):'-'; ?>
            </td>
            <td style="text-align: right;">
                <?php echo isset($uraian->totalharga)?MyFormatter::formatNumberForPrint($uraian->totalharga):'-'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php endif; ?>