<?php
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>12));
?>

<table class='table'>
	<?php foreach($modHeader AS $header): ?>
    <tr>
        <td>
            <b><?php echo CHtml::encode($header->getAttributeLabel('no_rekam_medik')); ?>:</b>
            <?php echo CHtml::encode($header->no_rekam_medik); ?>
            <br>
            <b><?php echo CHtml::encode($header->getAttributeLabel('nama_pasien')); ?>:</b>
            <?php echo CHtml::encode($header->nama_pasien); ?>
             <br>
        </td>
        <td>
            <b><?php echo CHtml::encode($header->getAttributeLabel('nopeserta')); ?>:</b>
            <?php echo CHtml::encode($header->nopeserta); ?>
            <br>
            <b><?php echo CHtml::encode($header->getAttributeLabel('status_hubungan')); ?>:</b>
            <?php echo CHtml::encode($header->status_hubungan); ?>
            <br>
        </td>
    </tr>   
	<?php endforeach; ?>
</table>

<table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No </th>
        <th>Tanggal Rencana MCU</th>
        <th>Tanggal Pemanggilan MCU</th>
        <th>Tanggal Akan Diperiksa</th>
        <th>Pemanggilan Ke-</th>
    </thead>
    <tbody>
    <?php
        $no=1;
		//$modDetail = MCPemanggilanmcuV::model()->findAllByAttributes(array('pendaftaran_id'=>$modHeader->pendaftaran_id));
        foreach($modDetail AS $detail): ?>
            <tr>   
                <td><?php echo $no; ?></td>
                <td><?php echo $format->formatDateTimeForUser($detail->tglrenkontrol); ?></td>
                <td><?php echo $format->formatDateTimeForUser($detail->tglpemanggilanmcu); ?></td>
                <td><?php echo $format->formatDateTimeForUser($detail->tglakanperiksamcu); ?></td>
                <td><?php echo $detail->pemanggilanke; ?></td>
            </tr>
    <?php 
        $no++; 
        endforeach;     
    ?>
    </tbody>
</table>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
            array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
?>
<script type="text/javascript">
function print(caraPrint)
{
var id = <?php echo $_GET['id']; ?>;
var url = '<?php echo $this->createUrl("Print"); ?>';
    window.open(url+"&pendaftaran_id="+id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
</script>