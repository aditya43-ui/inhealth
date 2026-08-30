	<table class="items table table-striped table-bordered table-condensed">
	 <thead>
		 <tr>
			 <th>No. Rekam Medik</th>
             <th>Pemeriksaan Umum</th>
             <th>Jantung</th>
             <th>Kandungan</th>
             <th>Lain-lain</th>
			 <th>Laboratorium</th>
			 <th>Radiologi</th>
             <th>Fisioterapi</th>
			 <th>Treadmill</th>
			 <th>Hearing Test</th>
			 <th>Diagnosis</th>
			 <th>Kesimpulan dan Saran</th>
			 <th>Jantung Koroner</th>
			 <th>Tes Spirometri</th>
			 <th>Print Hasil</th>
		 </tr>

	 </thead>
	 <tbody>
		 <tr>
			 <td><?php echo $modKunjungan->pasien->no_rekam_medik; ?></td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailPemeriksaanUmum",
						 array("id"=>$modKunjungan->pendaftaran_id,"frame"=>1,"popup"=>"true")),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Pemeriksaan Umum", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Pemeriksaan Umum")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailJantung",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Jantung", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Jantung")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailKandungan",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Kandungan", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Kandungan")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailLain2",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Lain-lain", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Lain-Lain")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHasilLab",
						 array("id"=>$modKunjungan->pendaftaran_id,"frame"=>1,"popup"=>"true")),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Laboratorium", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Laboratorium")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHasilRad",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Radiologi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Radiologi")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHasilRehab",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Fisioterapi", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Fisioterapi")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailTreadmill",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Treadmill", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Treadmill")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHearingTest",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Hearing Test", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Hearing Test")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailHasilDiagnosa",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Diagnosis", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Diagnosis")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailKesimpulanSaran",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Kesimpulan dan Saran", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Kesimpulan dan Saran")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailJantungKoroner",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Jantung Koroner", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Jantung Koroner")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailTesSpirometri",
						 array("id"=>$modKunjungan->pendaftaran_id)),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Jantung Koroner", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Tes Spirometri")); 

				 ?>
			 </td>
			 <td>
				 <?php
				 echo CHtml::link("<i class='fa fa-eye'></i> ",  Yii::app()->controller->createUrl("pemeriksaanPasienMC/detailPrintHasil",
						 array("id"=>$modKunjungan->pendaftaran_id,"frame"=>1,"popup"=>"true")),array("id"=>"$modKunjungan->no_pendaftaran","target"=>"detailDialog","rel"=>"tooltip","title"=>"Klik untuk Detail Print Hasil", "onclick"=>"var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text"=>"Riwayat Hasil")); 

				 ?>
			 </td>
		 </tr>
	 </tbody>
	 <tfoot><tr>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
			 <td></td>
		 </tr></tfoot>
 </table>

   
