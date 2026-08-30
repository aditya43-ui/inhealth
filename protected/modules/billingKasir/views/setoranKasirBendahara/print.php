<style>
	.jdl {
		text-align: center;
		font-weight: bold;
		margin: 10px;
	}
	
	.tab_detail th, .tab_detail td {
		border: 1px solid black;
	}
	
	.tab_detail {
		margin-bottom: 20px;
	}
	
	.tab_detail thead, .tab_detail tfoot {
		font-weight: bold;
	}
	
	.tab_head {
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>

<?php
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'sub/_headerPrint'); 
}

?>
<div class="jdl">Setoran Kasir ke Bendahara</div>

<table class="tab_head" width="100%">
	<tbody>
		<tr>
			<td nowrap>Tgl. Setoran</td>
			<td>: </td>
			<td width="100%"><?php echo MyFormatter::formatDateTimeForUser($setoran->tglsetorankasir); ?></td>
			<td nowrap>Setoran Tgl.</td>
			<td>: </td>
			<td nowrap><?php echo MyFormatter::formatDateTimeForUser($setoran->setorankasirdari); ?></td>
		</tr>
		<tr>
			<td nowrap>No. Setoran</td>
			<td>: </td>
			<td><?php echo $setoran->nosetorankasir; ?></td>
			<td nowrap>Sampai Tgl.</td>
			<td>: </td>
			<td nowrap><?php echo MyFormatter::formatDateTimeForUser($setoran->sampaidengan); ?></td>
		</tr>
	</tbody>
</table>

<table width="100%" class="tab_detail">
	<thead>
		<tr>
			<th rowspan="2">Ruangan</th>
			<th colspan="2">Jumlah Pasien</th>
			<th colspan="2">Retribusi</th>
			<th colspan="2">Jasa Medis</th>
			<th colspan="2">Jasa Paramedis</th>
			<th colspan="2">Administrasi</th>
			<th colspan="2">Jumlah</th>
			<th rowspan="2">Jumlah Total</th>
		</tr>
		<tr>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
			<th>PL</th>
			<th>PB</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($setorandet as $idx=>$item) {
			echo $this->renderPartial('sub/_rowdetail', array('item'=>$item, 'idx'=>$idx), true);
		} 
		?>
	</tbody>
	<tfoot>
		<?php echo $this->renderPartial('sub/_rowtotal', array('item'=>$tot), true); ?>
	</tfoot>
</table>

<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo $this->createUrl('print', array('id'=>$setoran->setorankasir_id)); ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}else{
?>    
    <table width='100%'>
        <tr>
            <td>&nbsp;</td>
            <td width="100%">&nbsp;</td>
            <td align='center' nowrap><?php echo Yii::app()->user->getState('kecamatan_nama').", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td align='center' nowrap><?php echo !empty($setoran->bendaharapenerima_id)?"Pegawai Bendahara":"" ?></td>
            <td align='center' style="text-align: center;"></td>
            <td align='center' style="text-align: center;" nowrap>Pegawai Setoran</td>
        </tr>
        <tr>
            <td align='center' style="text-align: center;" nowrap>
				<br><br><br><br><br>
				<?php
				
				if (!empty($setoran->bendaharapenerima_id)) {
					$p = PegawaiM::model()->findByPk($setoran->bendaharapenerima_id);
					echo "<u>".$p->namaLengkap."</u><br>".$p->nomorindukpegawai;
				}
				
				?>
			</td>
            <td align='center' style="text-align: center;"></td>
            <td align='center' style="text-align: center;" nowrap>
				<br><br><br><br><br>
				<?php 
					$p = PegawaiM::model()->findByPk($setoran->pegawai_id);
					echo "<u>".$p->namaLengkap."</u><br>".$p->nomorindukpegawai;
				?>
			</td>
        </tr>
    </table>
<?php
}
?>
