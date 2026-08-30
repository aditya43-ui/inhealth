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
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="11%" style="text-align:right;">Tanggal Penerimaan</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode($model->tglpenerimaan); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Harga Satuan</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->hargasatuan) ? $model->hargasatuan : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">No. Penerimaan</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->nopenerimaan) ? $model->nopenerimaan : "-"); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Total Harga</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode($model->totalharga); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Kelompok Transaksi</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode($model->kelompoktransaksi); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Keterangan Penerimaan</td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->keterangan_penerimaan) ? $model->keterangan_penerimaan : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Jenis Penerimaan </td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode($model->jenisKodeNama); ?>
                    </td>
                    <td width="11%" style="text-align:right;">Nama Penandatangan </td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode(isset($model->namapenandatangan) ? $model->namapenandatangan : "-"); ?>
                    </td>
                </tr>
                <tr>
                    <td width="11%" style="text-align:right;">Volume  </td><td width="2%">:</td>
                    <td width="37%">
                        <?php echo CHtml::encode($model->volume).' '.CHtml::encode($model->satuanvol); ?>
                    </td>
                    <td width="11%" style="text-align:right;"></td><td width="2%">:</td>
                    <td width="37%"></td>
                </tr>
                   
            </table>            
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>Uraian</th>
            <th>Volume</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($modUraian as $i => $uraian) { ?>
        <tr>
            <td>
                <?php echo isset($uraian->uraiantransaksi)?$uraian->uraiantransaksi:'-'; ?>
            </td>
            <td>
                <?php echo isset($uraian->volume)?$uraian->volume:'-'; ?>
            </td>
            <td>
                <?php echo isset($uraian->satuanvol)?$uraian->satuanvol:'-'; ?>
            </td>
            <td>
                <?php echo isset($uraian->hargasatuan)?$uraian->hargasatuan:'-'; ?>
            </td>
            <td>
                <?php echo isset($uraian->totalharga)?$uraian->totalharga:'-'; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>