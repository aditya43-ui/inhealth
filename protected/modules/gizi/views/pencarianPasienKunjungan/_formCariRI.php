	 <legend class="rim">Tabel Pasien Rawat Inap</legend>
<?php
 $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
   	$this->widget('bootstrap.widgets.BootAlert');
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarianpasien-grid',
	'dataProvider'=>$model->searchRI(),
//                'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",

                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                    array(
                        'header'=>'Tanggal Admisi',
                        'name'=>'tgl_admisi',
                        'type'=>'raw',
                        'value'=>'$data->tgladmisi'
                    ),
                    array(
                        'header'=>'Ruangan',
                        'name'=>'instalasi_nama',
                        'type'=>'raw',
                        'value'=>'$data->instalasi_nama',
                    ),
                    array(
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                    ),
                    array(
                        'header'=>'Alias',
                        'name'=>'nama_bin',
                        'type'=>'raw',
                        'value'=>'$data->nama_bin',
                    ),
                    array(
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                    ),
                    array(
                        'name'=>'penjamin_nama',
                        'type'=>'raw',
                        'value'=>'$data->penjamin_nama',
                    ),
                     array(
                        'header'=>'Kasus Penyakit/<br>Kelas Pelayanan',
                        'type'=>'raw',
                        'value'=>'"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
                    ),
                    array(
                        'name'=>'umur',
                        'type'=>'raw',
                        'value'=>'$data->umur',
                    ),
                    array(
                        'header'=>'Jenis Kelamin',
                        'type'=>'raw',
                        'value'=>'$data->jeniskelamin',
                    ),
                    array(
                        'header'=>'Dokter<br>Penanggung Jawab',
                        'type'=>'raw',
                        'value'=>'$data->nama_pegawai',
                    ),
                    array(
                        'name'=>'alamat_pasien',
                        'type'=>'raw',
                        'value'=>'$data->alamat_pasien',
						
                    ),
                     array(
                       'header'=>'Konsultasi Gizi',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\"icon-user\"></i>",Yii::app()->controller->createUrl("/gizi/anamnesisDiet&pendaftaran_id",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienadmisi_id"=>"")), array("rel"=>"tooltip","title"=>"Klik untuk Rencana Pemeriksaan"))', 'htmlOptions'=>array('style'=>'text-align: center; width:40px')
						   
                    ),
                    
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
     

?>
<hr></hr>

<?php echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true); ?>