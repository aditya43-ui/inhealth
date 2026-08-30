<?php
/**
* - digunakan untuk menampilkan detail poin pegawai
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>

<table class='table' style="border:none;">
    <tr>
        <td style="border:none;">
            <b> Tanggal</b>
        </td>
        <td style="border:none;">
            : <?php echo MyFormatter::formatDateTimeForUser($model->poinpegawai_tgl); ?>
        </td>
    </tr>   
    <tr>
        <td style="border:none;">
             <b>Nama Pegawai</b>
        </td>
        <td style="border:none;">
            : <?php echo $model->pegawai->namaLengkap; ?>
        </td>
    </tr>   
    <tr>
        <td style="border:none;">
             <b>Alasan</b>
        </td >
        <td style="border:none;">
            : <?php echo $model->poinpegawai_alasan; ?>
        </td>
    </tr>   
</table>

<table id="tableObatAlkes" class="table border">
    <thead>    
        <th>No.</th>
        <th>Nilai Poin</th>
        <th>Jumlah</th>
        <th>Remark</th>                    
    </thead>
    <tbody>
    <?php
        $no=1;
        foreach($modDet AS $det): 
    ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $det->nilaipoin->nilaipoin_nama; ?></td>
            <td style = 'text-align:right;'><?php echo $det->poinpegdet_poin; ?></td>
            <td><?php echo $det->poinpegdet_desc; ?></td>
        </tr>
    <?php
        $no++;
        endforeach;     
    ?>
    </tbody>  
    <tfoot>
        <tr>
            <td style = 'text-align:right;' colspan="3"><?php echo $model->poinpegawai_totpoin; ?></td>
            <td></td>
        </tr>
    </tfoot>
</table>
