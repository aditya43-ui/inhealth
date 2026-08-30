<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<legend class="rim2">Error <?php echo $code; ?></legend>

<div class="error">
	<table class="table table-bordered table-condensed">
		<tr>
			<td>Link</td>
			<td><?php echo CHtml::encode($actual_link);?></td>
		</tr>
		<tr>
			<td>Kode</td>
			<td><?php echo CHtml::encode($code);?></td>
		</tr>
		<tr>
			<td>Tipe</td>
			<td><?php echo CHtml::encode($type);?></td>
		</tr>
		<tr>
			<td>Pesan</td>
			<td><?php echo CHtml::encode($message);?></td>
		</tr>
		<tr>
			<td>File</td>
			<td><?php echo CHtml::encode($file);?></td>
		</tr>
		<tr>
			<td>Baris</td>
			<td><?php echo CHtml::encode($line);?></td>
		</tr>
	</table>
	<div>
		Log lainnya bisa dilihat juga di <b><a href="<?php echo Yii::app()->createUrl("/sistemAdministrator/MonitoringReportBugs"); ?>">sini</a></b>
	</div>
</div>