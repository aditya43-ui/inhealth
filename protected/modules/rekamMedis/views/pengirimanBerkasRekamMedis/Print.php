<!-- <?php 
//if($caraPrint=='EXCEL')
//{
//    header('Content-Type: application/vnd.ms-excel');
//    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
//    header('Cache-Control: max-age=0');     
//}
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
?>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			<div class="judulcontent"><?php echo $judulLaporan ?></div>
                        <?php
    //                    $this->widget('ext.bootstrap.widgets.BootGridView',array(
	//'id'=>'sajenis-kelas-m-grid',
	//'enableSorting'=>false,
	//'dataProvider'=>$model->searchPrint(),
	//'template'=>"{summary}\n{items}\n{pager}",
	//'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	//'columns'=>array(
	//	array(
	//		'header'=>'Tgl. Rekam Medik',
	//		'value'=>'isset($data->tgl_rekam_medik) ? MyFormatter::formatDateTimeForUser($data->tgl_rekam_medik) : ""',
	//	),
	//	array(
	//		'header'=>'No. Rekam Medik',
	//		'value'=>'$data->no_rekam_medik',
	//	),
	//	array(
	//		'header'=>'No. Pendaftaran',
	//		'value'=>'$data->no_pendaftaran',
	//	),
	//	array(
	//		'header'=>'Nama Pasien',
	//		'value'=>'$data->nama_pasien',
	//	),
	//	array(
	//		'header'=>'Tanggal Lahir',
	//		'value'=>'isset($data->tanggal_lahir) ? MyFormatter::formatDateTimeForUser($data->tanggal_lahir) : ""',
	//	),
	//	array(
	//		'header'=>'Warna Dokumen',
	//		'value'=>'$data->warnadokrm_namawarna',
	//	),
	//	array(
	//		'header'=>'Lokasi Rak',
	//		'value'=>'$data->lokasirak_nama',
	//	),
	//),
	//));
    //                    ?>
	//	</div>		
    //        </td>
    //    </tr>
    //</tbody>
    //<tfoot>
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
    <!-- <?php //  if (isset($caraPrint) && $caraPrint!="PDF"){  ?> -->
    <!-- <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?> -->
    <!-- <?php // }  ?> -->
<!-- </div> -->

<style>
	TD, P SPAN{
		font-family: "Arial" !important;
		font-size: 8.3pt !important;
    }
</style>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewOneLogo'); ?>

<table style="width: 100%; border: none; margin-left:10pt;">
    <tr>
        <td>
			<tr>
				<td align="center" valig="middle" colspan="3">
					<b><?php echo strtoupper($judulLaporan) ?></b>
				</td>
			</tr>
			<tr>
				<td align="center" valig="middle" colspan="3">
					DATA PASIEN
				</td>
			</tr>
            <?php
			$modelrm = RKDokumenpasienrmlamaV::model()->findByAttributes(array('pengirimanrm_id'=> $model->ids));

			$modelrs = RKPengirimanrmT::model()->findByAttributes(array('pengirimanrm_id'=> $model->ids));
            ?>
			<tr>
				<td>No Pendaftaran</td>
				<td>:</td>
				<td><?php echo $modelrm->no_pendaftaran; ?></td>
			</tr>
			<tr>
				<td>Nama Pasien</td>
				<td>:</td>
				<td><b><?php echo $modelrm->namadepan . " " . $modelrm->nama_pasien; ?></b></td>
			</tr>
			<tr>
				<td>No Rekam Medis</td>
				<td>:</td>
				<td><b><?php echo $modelrm->no_rekam_medik; ?></b></td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td><?php echo $modelrm->jeniskelamin; ?></td>
			</tr>
			<tr>
				<td>Alamat Pasien</td>
				<td>:</td>
				<td><?php echo $modelrm->alamat_pasien; ?></td>
			</tr>
			<tr>
				<td>Tgl. Lahir</td>
				<td>:</td>
				<td><?php echo MyFormatter::formatDateTimeId($modelrm->tanggal_lahir); ?></td>
			</tr>
			<tr>
				<td>Warna Dokumen</td>
				<td>:</td>
				<td><?php echo $modelrm->warnadokrm_namawarna; ?></td>
			</tr>
			<tr>
				<td>Lokasi Rak</td>
				<td>:</td>
				<td><?php echo $modelrm->lokasirak_nama; ?></td>
			</tr>
			<tr>
				<td>Instalasi</td>
				<td>:</td>
				<td><?php echo $modelrm->instalasi_nama; ?></td>
			</tr>
			<tr>
				<td>Tgl. Pengiriman</td>
				<td>:</td>
				<td><b><?php echo MyFormatter::formatDateTimeId($modelrs->tglpengirimanrm); ?></b></td>
			</tr>	
			<tr>
				<td>Petugas Pengirim</td>
				<td>:</td>
				<td><b><?php echo $modelrs->petugaspengirim; ?></b></td>
			</tr>		
        </td>
    </tr>
</table>
<div class="">
</div>
<!-- <div class="footer">
    <?php   //if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  //}  ?>
</div> -->



