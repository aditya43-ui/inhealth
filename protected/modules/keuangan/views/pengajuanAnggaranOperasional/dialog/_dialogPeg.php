<?php
/**
*  Dialog berisi data Pegawai Atasan yang akan dipilih.
*
* @category     views
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog_pegatasan',
    'options' => array(
        'title' => 'Diketahui Oleh',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

    <?php
				$modcom = new PegawairuanganV();								
				$modcom->ruangan_id = Yii::app()->user->getState('ruangan_id');
				if (isset($_GET['PegawairuanganV'])) {
					$modcom->attributes = $_GET['PegawairuanganV'];	
					$modcom->ruangan_id = Yii::app()->user->getState('ruangan_id');
				}
				
				$this->widget('bootstrap.widgets.BootGridView',array(
					'id'=>'pegacknown-m-grid',
					'dataProvider'=>$modcom->pegawaiMengetahui(),
					'filter'=>$modcom,					
					'itemsCssClass' => 'table table-bordered datatable dataTable',
					'columns'=>array(		
							array(
								'header'=>'Pilih',
								'type'=>'raw',
								 'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'diketahuiatasan_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'diketahuiatasan_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialog_pegatasan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
							),
							'nomorindukpegawai',
							array(
								'header' => 'Nama Pegawai',
								'name' => 'nama_pegawai',
								'value' => '$data->namaLengkap'
							),							
							array(
								'name' => 'jabatan_id',
								'value' => function($data){
									$j = JabatanM::model()->findByPk($data->jabatan_id);
									
									if (!empty($j)){
										return $j->jabatan_nama;
									}else{
										return '-';
									}
								},
								'filter' => CHtml::activeDropDownList($modcom, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('class'=>'form-control','empty'=>'-- Choose --'))
							),																								
						
					),
				));
							
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog_pegkeuangan',
    'options' => array(
        'title' => 'Diperiksa Oleh',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

				<?php
				$modcom = new PegawairuanganV();								
				$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_KEUANGAN,
											Params::UNITKERJA_ID_FINANCE,
											Params::UNITKERJA_ID_BENDAHARA
										);
				if (isset($_GET['PegawairuanganV'])) {
					$modcom->attributes = $_GET['PegawairuanganV'];						
					$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_KEUANGAN,
											Params::UNITKERJA_ID_FINANCE,
											Params::UNITKERJA_ID_BENDAHARA
										);
				}
				
				$this->widget('bootstrap.widgets.BootGridView',array(
					'id'=>'pegkeuangan-m-grid',
					'dataProvider'=>$modcom->PegawaiByUnitKerja(),
					'filter'=>$modcom,					
					'itemsCssClass' => 'table table-bordered datatable dataTable',
					'columns'=>array(		
							array(
								'header'=>'Pilih',
								'type'=>'raw',
								 'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'diketahuikeuangan_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'diketahuikeuangan_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialog_pegkeuangan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
							),
							'nomorindukpegawai',
							array(
								'header' => 'Nama Pegawai',
								'name' => 'nama_pegawai',
								'value' => '$data->namaLengkap'
							),					
							array(
								'name' => 'jabatan_id',
								'value' => function($data){
									$j = JabatanM::model()->findByPk($data->jabatan_id);
									
									if (!empty($j)){
										return $j->jabatan_nama;
									}else{
										return '-';
									}
								},
								'filter' => CHtml::activeDropDownList($modcom, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('class'=>'form-control','empty'=>'-- Choose --'))
							),																								
						
					),
				));
							
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog_disetujui',
    'options' => array(
        'title' => 'Disetujui Oleh',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

				<?php
				$modcom = new PegawairuanganV();								
				$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_KEUANGAN,
											Params::UNITKERJA_ID_FINANCE,
											Params::UNITKERJA_ID_BENDAHARA
										);
				if (isset($_GET['PegawairuanganV'])) {
					$modcom->attributes = $_GET['PegawairuanganV'];						
					$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_KEUANGAN,
											Params::UNITKERJA_ID_FINANCE,
											Params::UNITKERJA_ID_BENDAHARA
										);
				}
				
				$this->widget('bootstrap.widgets.BootGridView',array(
					'id'=>'pegkeuangan-m-grid',
					'dataProvider'=>$modcom->PegawaiByUnitKerja(),
					'filter'=>$modcom,					
					'itemsCssClass' => 'table table-bordered datatable dataTable',
					'columns'=>array(		
							array(
								'header'=>'Pilih',
								'type'=>'raw',
								 'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'disetujuioleh_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'disetujuioleh_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialog_disetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
							),
							'nomorindukpegawai',
							array(
								'header' => 'Nama Pegawai',
								'name' => 'nama_pegawai',
								'value' => '$data->namaLengkap'
							),					
							array(
								'name' => 'jabatan_id',
								'value' => function($data){
									$j = JabatanM::model()->findByPk($data->jabatan_id);
									
									if (!empty($j)){
										return $j->jabatan_nama;
									}else{
										return '-';
									}
								},
								'filter' => CHtml::activeDropDownList($modcom, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('class'=>'form-control','empty'=>'-- Choose --'))
							),																								
						
					),
				));
							
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog_pegacc',
    'options' => array(
        'title' => 'Direktur',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1002,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

				<?php
				$modcom = new PegawairuanganV();												
				$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_DIREKTUR,											
										);
				if (isset($_GET['PegawairuanganV'])) {
					$modcom->attributes = $_GET['PegawairuanganV'];						
					$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_DIREKTUR,											
										);
				}
				
				$this->widget('bootstrap.widgets.BootGridView',array(
					'id'=>'pegacc-m-grid',
					'dataProvider'=>$modcom->PegawaiByUnitKerja(),
					'filter'=>$modcom,					
					'itemsCssClass' => 'table table-bordered datatable dataTable',
					'columns'=>array(		
							array(
								'header'=>'Pilih',
								'type'=>'raw',
								 'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'accdirektur_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'accdirektur_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialog_pegacc\").dialog(\"close\"); 
                                                  return false;
                                        "))',
							),
							'nomorindukpegawai',
							array(
								'header' => 'Nama Pegawai',
								'name' => 'nama_pegawai',
								'value' => '$data->namaLengkap'
							),					
							array(
								'name' => 'jabatan_id',
								'value' => function($data){
									$j = JabatanM::model()->findByPk($data->jabatan_id);
									
									if (!empty($j)){
										return $j->jabatan_nama;
									}else{
										return '-';
									}
								},
								'filter' => CHtml::activeDropDownList($modcom, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('class'=>'form-control','empty'=>'-- Choose --'))
							),																								
						
					),
				));
							
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialog_pegkabidyanmed',
    'options' => array(
        'title' => 'Kabid Yanmed',
        'autoOpen' => false,
        'modal' => true,
        'zIndex'=>1003,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

				<?php
				$modcom = new PegawairuanganV();												
				$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_PELAYANAN_MEDIS,											
										);
				if (isset($_GET['PegawairuanganV'])) {
					$modcom->attributes = $_GET['PegawairuanganV'];						
					$modcom->unitkerja_id = array(
											Params::UNITKERJA_ID_PELAYANAN_MEDIS,											
										);
				}
				
				$this->widget('bootstrap.widgets.BootGridView',array(
					'id'=>'pegkabidyanmed-m-grid',
					'dataProvider'=>$modcom->PegawaiByUnitKerja(),
					'filter'=>$modcom,					
					'itemsCssClass' => 'table table-bordered datatable dataTable',
					'columns'=>array(		
							array(
								'header'=>'Pilih',
								'type'=>'raw',
								 'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'kabidyanmed_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'kabidyanmed_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialog_pegkabidyanmed\").dialog(\"close\"); 
                                                  return false;
                                        "))',
							),
							'nomorindukpegawai',
							array(
								'header' => 'Nama Pegawai',
								'name' => 'nama_pegawai',
								'value' => '$data->namaLengkap'
							),					
							array(
								'name' => 'jabatan_id',
								'value' => function($data){
									$j = JabatanM::model()->findByPk($data->jabatan_id);
									
									if (!empty($j)){
										return $j->jabatan_nama;
									}else{
										return '-';
									}
								},
								'filter' => CHtml::activeDropDownList($modcom, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('class'=>'form-control','empty'=>'-- Choose --'))
							),																								
						
					),
				));
							
$this->endWidget();
?>
		
		