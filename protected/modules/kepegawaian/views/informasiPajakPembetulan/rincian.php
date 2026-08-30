<p style="margin: 0; text-align: center;">
    <h3><u>Perbaikan PPh 21</u></h3>
</p>
<table>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td> <?php echo isset($modelpeg->pegawai_id)?$modelpeg->pegawai->namaLengkap:""; ?></td>
    </tr>
    <tr>
        <td>NPWP</td>
        <td>:</td>
        <td> <?php echo isset($modelpeg->pegawai_id)?$modelpeg->pegawai->npwp:""; ?></td>
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
<br>
<br>
<br>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRincian(\'PRINT\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRincian(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printRincian(\'EXCEL\')'));       
        echo CHtml::htmlButton(Yii::t('mds','{icon} Export CSV',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'exportRincianCSV()'));       
    ?>
</div>

<?php
$penggajianpeg_id = isset($_GET['penggajianpeg_id']) ? $_GET['penggajianpeg_id'] : null;

$urlPrint= $this->createUrl('printRincian',array('penggajianpeg_id'=>$penggajianpeg_id));
$urlExportCsv= $this->createUrl('ExportRincianCSV',array('penggajianpeg_id'=>$penggajianpeg_id));
$js = <<< JSCRIPT
function printRincian(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
    
function exportRincianCSV()
{
    window.open("${urlExportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('printRincian',$js,CClientScript::POS_HEAD);  
?>
