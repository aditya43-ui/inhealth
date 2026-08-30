<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }	
    echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
?>
<table>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td><?php echo isset($modelpeg->pegawai_id)?$modelpeg->pegawai->namaLengkap:""; ?></td>
    </tr>
    <tr>
        <td>NPWP</td>
        <td>:</td>
        <td><?php echo isset($modelpeg->pegawai_id)?$modelpeg->pegawai->npwp:""; ?></td>
    </tr>
    <tr>
        <td>Kode Objek Pajak</td>
        <td>:</td>
        <td> <?php echo isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->kode_objekpajak : null; ?></td>
    </tr>
    <tr>
        <td>Kode Negara</td>
        <td>:</td>
        <td></td>
    </tr>
</table>
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
        <th>Perbaikan Ke</th>
        <th>Masa Pajak</th>
        <th>Tahun Pajak</th>
        <th>Jumlah Bruto</th>
        <th>Jumlah PPh</th>
        <th>Jumlah Perbaikan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($model as $key => $val) {
    ?>
        <tr>
           <td><?php echo $val->pembetulanke; ?></td>
           <td><?php echo !empty($val->tglpajak)?date("n", strtotime($format->formatDateTimeForDb($val->tglpajak))):"-" ?></td>
           <td><?php echo !empty($val->tglpajak)?date("Y", strtotime(MyFormatter::formatDateTimeForDb($val->tglpajak))):"-" ?></td>
           <td style="text-align: right;"><?php echo $format->formatNumberForPrint($modelpeg->totalterima); ?></td>
           <td style="text-align: right;"><?php echo $format->formatNumberForPrint($modelpeg->pph21perbulan); ?></td>
           <td style="text-align: right;"><?php echo $format->formatNumberForPrint($val->jmlpembetulan); ?></td>
        </tr> 
     <?php
        }
     ?>
        
    </tbody>
</table>