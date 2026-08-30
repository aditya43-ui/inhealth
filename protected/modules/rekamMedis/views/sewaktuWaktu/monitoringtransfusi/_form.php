<style>
	.table_pengisi, tr, td{
		vertical-align:top;
		padding: 10px;
	}

	.isian{
		margin-left : 10px;
	}

</style>
<div class="form">
<?php 
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'monitoringtransfusi-t-form',
	'enableAjaxValidation'=>false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<?php echo $form->hiddenField($model,'pendaftaran_id');?>
<div class="row-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Form Serah Terima Transfusi Darah</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo CHtml::label('Nama Serah Terima','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::dropDownList('nama_serahterima', '',  LookupM::getItemsUrutan('namaserahterima'),array('empty'=>'-- Pilih --','class'=>'span3')) ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label('Penjelasan','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::textArea('penjelasan','',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo CHtml::label('Petugas Bank Darah','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::checkBox('is_petugasbankdarah','',array('size'=>60,'maxlength'=>200,'onClick'=>'cekPetugas();')); ?>
							<label>Cross Check</label>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label(' ','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'petugas_bankdarah',
										'id'=>'petugas_bankdarah',
										'name'=>'petugas_bankdarah',
										'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('getPegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
													response(data);
												}
											})
										}',
										'options'=>array(
											'showAnim'=>'fold',
											'minLength' => 2,
											'focus'=> 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												return false;
											}',
											'select'=>'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'petugas_id').'").val(ui.item.pegawai_id);
												$("#petugas_bankdarah").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#petugas_id").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'diaglogPetugasBank'),
									)); 
								?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label('Perawat','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::checkBox('is_perawat','',array('size'=>60,'maxlength'=>200,'OnClick'=>'cekPerawat();')); ?>
							<label>Cross Check</label>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label(' ','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'nama_perawat',
										'id'=>'nama_perawat',
										'name'=>'nama_perawat',
										'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('getPegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
													response(data);
												}
											})
										}',
										'options'=>array(
											'showAnim'=>'fold',
											'minLength' => 2,
											'focus'=> 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												return false;
											}',
											'select'=>'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'petugas_id').'").val(ui.item.pegawai_id);
												$("#nama_perawat").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#petugas_id").val(""); '
										),
										'tombolDialog'=>array('idDialog'=>'dialogPerawat'),
									)); 
								?>
						</div>
					</div>
					<div class="control-group">
						<div style="margin-left:310px;">
							<?php
							echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
								array('onclick' => 'inputSerahTerima();',
									'class' => 'btn btn-primary',
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'rel' => "tooltip",
									'title' => "Klik untuk menambahkan detail",));
							?> 
						</div>
					</div>
				</div>
				
				<div style="margin-left:20px;margin-right:20px;">
					<table width="100%" id ="riwayatserahterima" class = "table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th>Nama Serah Terima</th>
							<th>Penjelasan</th>
							<th>Petugas Bank Darah</th>
							<th>Perawat</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if (!empty($model->monitoringtranfusidarah_id)){
						$modDetail = SerahterimaT::model()->findAllByAttributes(array('monitoringtranfusidarah_id'=>$model->monitoringtranfusidarah_id));
						if (count($modDetail) > 0){
							foreach ($modDetail as $i=>$data){?>
								<tr>
									<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']nama_serahterima', array('class'=>'', 'readonly'=>TRUE)); echo $data->nama_serahterima; ?> </td>       
									<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']penjelasan', array('class'=>'', 'readonly'=>TRUE)); echo $data->penjelasan; ?> </td>
									<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']petugas_bankdarah', array('class'=>'', 'readonly'=>TRUE)); echo $data->petugas_bankdarah; ?> </td>       
									<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']nama_perawat', array('class'=>'', 'readonly'=>TRUE)); echo $data->nama_perawat; ?> </td>
									<?php echo Chtml::activeHiddenField($data, '['.$i.']petugas_bankdarah', array('class'=>'', 'readonly'=>TRUE)); ?>
									<?php echo Chtml::activeHiddenField($data, '['.$i.']is_perawat', array('class'=>'', 'readonly'=>TRUE));  ?>
									
									<td style="text-align:center;"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?></td>
								</tr>
							<?php }
						}}?>
					</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>	
</div>

<div class="row-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Form Serah Terima Transfusi Darah</div>
		</div>
		<div class="panel-body">
			<br>
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo CHtml::label('Waktu Transfusi Darah','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'name' => 'waktu_transfusi',
								'id'=>'waktu_transfusi',
								'attribute' => 'waktu_transfusi',
								'mode' => 'datetime',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									//'maxDate' => 'd',
								),
								'htmlOptions' => array(
									'readonly' => true,
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'class'=>'span3',
								),
							));
							?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label('Kondisi','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::dropDownList('kondisi_transfusidarah', '',  LookupM::getItemsUrutan('kondisi_transfusidarah'),array('empty'=>'-- Pilih --','class'=>'span3')) ?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label('Deskripsi','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::textField('deskripsi','',array('size'=>60,'maxlength'=>200)); ?>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="control-group">
						<div class="control-label">
							<?php echo CHtml::checkBox('is_reaksi','',array('size'=>60,'maxlength'=>200,'OnCLick'=>'cekReaksi();'))." ".CHtml::label('Tanda Reaksi','' , array('class' => '')); ?>
						</div>
						<div class="controls">
							<?php $counter_mental = 1;?>
							<?php echo CHtml::dropDownList('[0]tandareaksi', '',  LookupM::getItemsUrutan('tandareaksi'),array('empty'=>'-- Pilih --','class'=>'span3 tandareaksi_0')) ?>
							<?php echo CHtml::htmlButton('+', array(
                                    'class'=>'btn btn-primary btn-sm', 'onclick'=>'tambahRow();', 'id'=>'tambah_id',
                                )); ?>
						</div>
					</div>
					<div id="tab_upload">
            
        			</div>
					<div class="control-group">
						<?php echo CHtml::label('Waktu Transfusi','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::dropDownList('waktu_tranfusi', '',  LookupM::getItemsUrutan('waktu_transfusi'),array('empty'=>'-- Pilih --','class'=>'span3','OnChange'=>'cekwaktu();')) ?>
							
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label(' ','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'name' => 'jam_transfusi',
								'id'=>'jam_transfusi',
								'attribute' => 'jam_transfusi',
								'mode' => 'time',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									//'maxDate' => 'd',
								),
								'htmlOptions' => array(
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'class'=>'span3',
								),
							));
							?>
						</div>
					</div>
					<div class="control-group">
						<?php echo CHtml::label('Petugas','' , array('class' => 'control-label')); ?>
						<div class="controls">
							<?php 
									$this->widget('MyJuiAutoComplete', array(
										'attribute'=>'petugas',
										'id'=>'petugas',
										'name'=>'petugas',
										'source'=>'js: function(request, response) {
											$.ajax({
												url: "'.$this->createUrl('getPegawai').'",
												dataType: "json",
												data: {
													term: request.term,
												},
												success: function (data) {
													response(data);
												}
											})
										}',
										'options'=>array(
											'showAnim'=>'fold',
											'minLength' => 2,
											'focus'=> 'js:function( event, ui ) {
												$(this).val( ui.item.label);
												return false;
											}',
											'select'=>'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'petugas_id').'").val(ui.item.pegawai_id);
												$("#petugas").val(ui.item.label); 
												return false;
											}',
									),
										'htmlOptions'=>array(
											'onkeyup'=>"return $(this).focusNextInputField(event)",
											'class'=>'span3',
											'onblur' => 'if(this.value === "") $("#petugas_id").val(""); ',
										),
										'tombolDialog'=>array('idDialog'=>'dialogPetugas'),
										
									)); 
								?>
						</div>
					</div>
				</div>
			</div>
			<div class="control-group">
				<div class="control-label">
						<?php
						echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
							array('onclick' => 'inputRestrain();',
								'class' => 'btn btn-primary',
								'onkeypress' => "return $(this).focusNextInputField(event)",
								'rel' => "tooltip",
								'title' => "Klik untuk menambahkan detail pemberian obat",));
						?> 
				</div>
			</div>
			<br>
			<table width="100%" id ="riwayatrestrain" class = "table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>Waktu Transfusi Dimulai</th>
						<th>Kondisi</th>
						<th>Deskripsi</th>
						<th>Tanda Reaksi</th>
						<th>Waktu Transfusi</th>
						<th>Petugas</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				if (!empty($model->monitoringtranfusidarah_id)){
				$modDetail = TransfusidarahT::model()->findAllByAttributes(array('monitoringtranfusidarah_id'=>$model->monitoringtranfusidarah_id));
				if (count($modDetail) > 0){
					foreach ($modDetail as $i=>$data){?>
						<tr>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']waktu_transfusi', array('class'=>'', 'readonly'=>TRUE)); echo $data->waktu_transfusi; ?> </td>       
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']kondisi_transfusidarah', array('class'=>'', 'readonly'=>TRUE)); echo $data->kondisi_transfusidarah; ?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']deskripsi', array('class'=>'', 'readonly'=>TRUE)); echo $data->deskripsi; ?> </td>
							<td> <?php 
									$modTransDet = TransfusidarahdetT::model()->findAllByAttributes(array('transfusidarah_id'=>$data->transfusidarah_id));
									foreach ($modTransDet as $c => $det){
										echo $det->nama_tandareaksi."<br>";
										echo Chtml::activeHiddenField($det, '['.$c.']nama_tandareaksi', array('class'=>'', 'readonly'=>TRUE));
									}?>
							</td>
							<?php echo Chtml::activeHiddenField($data, '['.$i.']jam_transfusi', array('class'=>'', 'readonly'=>TRUE));?>
							
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']waktu_tranfusi', array('class'=>'', 'readonly'=>TRUE)); echo $data->waktu_tranfusi." <br>".$data->jam_transfusi; ?> </td>
							<td> <?php echo Chtml::activeHiddenField($data, '['.$i.']petugas', array('class'=>'', 'readonly'=>TRUE)); echo $data->petugas; ?> </td>     
							<td style="text-align:center;"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'hapus(this); return false;')) ?></td>
						</tr>
					<?php }
				}}?>
				</tbody>
			</table>


		</div>
	</div>
</div>

	<div class="row-fluid">
		<div class="form-actions">
			<?php if (isset($model->observasipemasanganrestrain_id) && $ubah == false){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary','disabled'=>true, 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPemasanganRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>false,'type'=>'button','onclick'=>'print('.$model->observasipemasanganrestrain_id.')'))."&nbsp";

			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'))."&nbsp";
				echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
					$this->createUrl('IndexPemasanganRestraint',array('pendaftaran_id'=>$model->pendaftaran_id)),
					array(
						'class' => 'btn btn-danger',
						'onclick' => 'return refreshForm(this);'))."&nbsp";
				echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')),array('class'=>'btn btn-primary', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
			}?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->



<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'diaglogPetugasBank',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#petugas_bankdarah\").val(\"$data->NamaLengkap\");
									$(\'#diaglogPetugasBank\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>



<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPerawat',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#nama_perawat\").val(\"$data->NamaLengkap\");
									$(\'#dialogPerawat\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPetugas',
    'options'=>array(
        'title'=>'Daftar Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>750,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiTriase = new RKPegawaiM('searchPegawaiTriase');
$modPegawaiTriase->unsetAttributes();
if(isset($_GET['RKPegawaiM'])){
    $modPegawaiTriase->attributes = $_GET['RKPegawaiM'];
    $modPegawaiTriase->gelarbelakang_nama = $_GET['RKPegawaiM']['gelarbelakang_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugas-m-grid',
	'dataProvider'=>$modPegawaiTriase->searchPegawaiTriase(),
	'filter'=>$modPegawaiTriase,
	'template'=>"{summary}\n{items}{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\"#'.CHtml::activeId($model, 'petugas_id').'\").val(\"$data->pegawai_id\");  
									$(\"#petugas\").val(\"$data->NamaLengkap\");
									$(\'#dialogPetugas\').dialog(\'close\');return false;"))',
			),
			'gelardepan',
            array(
                'name'=>'nama_pegawai',
                'header'=>'Nama Dokter',
            ),
            array(
                'name'=>'gelarbelakang_nama',
                'header'=>'Gelar Belakang',
                'value'=>'isset($data->gelarbelakang->gelarbelakang_nama) ? $data->gelarbelakang->gelarbelakang_nama : ""',
            ),
            'jeniskelamin',
            'agama',               
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<script>
var counter_mental = <?php echo $counter_mental; ?>;
function inputSerahTerima(){
	var buttonMinus = '<?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?>'; 
	var nama_serahterima = $("#nama_serahterima").val();
	var penjelasan = $("#penjelasan").val(); 
	var petugas_bankdarah = $("#petugas_bankdarah").val();
	var nama_perawat = $("#nama_perawat").val();
	var is_petugasbankdarah = $("#is_petugasbankdarah").val();
	var is_perawat = $("#is_perawat").val();
	var no = $("#riwayatserahterima tbody").find("tr").length;              
	
	$('#riwayatserahterima tbody').append("<tr>\n\
											<td><input readonly = TRUE type = 'hidden' id = 'SerahterimaT"+(no+1)+"_nama_serahterima' name = 'SerahterimaT["+(no+1)+"][nama_serahterima]' value = '"+nama_serahterima+"' >"+nama_serahterima+"</td>"+
											"<td><input readonly = TRUE type = 'hidden' id = 'SerahterimaT"+(no+1)+"_penjelasan' name = 'SerahterimaT["+(no+1)+"][penjelasan]' value = '"+penjelasan+"' >"+penjelasan+"</td>"+
											"<td><input readonly = TRUE type = 'hidden' id = 'SerahterimaT"+(no+1)+"_petugas_bankdarah' name = 'SerahterimaT["+(no+1)+"][petugas_bankdarah]' value = '"+petugas_bankdarah+"' >"+petugas_bankdarah+"</td>"+
											"<input readonly = TRUE type = 'hidden' id = 'SerahterimaT"+(no+1)+"_is_petugasbankdarah' name = 'SerahterimaT["+(no+1)+"][is_petugasbankdarah]' value = '"+is_petugasbankdarah+"' >"+is_petugasbankdarah+
											"<input readonly = TRUE type = 'hidden' id = 'SerahterimaT"+(no+1)+"_is_perawat' name = 'SerahterimaT["+(no+1)+"][is_perawat]' value = '"+is_perawat+"' >"+is_perawat+
											"<td><input readonly = TRUE type = 'hidden' id = 'SerahterimaT"+(no+1)+"_nama_perawat' name = 'SerahterimaT["+(no+1)+"][nama_perawat]' value = '"+nama_perawat+"' >"+nama_perawat+"</td>\n\
											<td style='text-align:center;'>"+buttonMinus+"</td>\n\
										</tr>");

	resetSerahTerima();
}

function resetSerahTerima()
    {
        $("#nama_serahterima").val('');
        $("#penjelasan").val('');
        $("#petugas_bankdarah").val('');
        $("#nama_perawat").val('');
    }


function inputRestrain()
    {
       var buttonMinus = '<?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'hapus(this); return false;')) ?>'; 
       var waktu_transfusi = $("#waktu_transfusi").val();
       var tandareaksi = $("#tandareaksi").val();
	   var kondisi_transfusidarah = $("#kondisi_transfusidarah").val();
	   var s = $("#s").val();
	   var deskripsi = $("#deskripsi").val();
	   var waktu_tranfusi = $("#waktu_tranfusi").val();
	   var petugas = $("#petugas").val();
	   var jam_transfusi = $("#jam_transfusi").val(); 
       var no = $("#riwayatrestrain tbody").find("tr").length;
	   var tandareaksi_1 = '';
	   var tandareaksi_2 = '';
	   var tandareaksi_3 = '';
	   
	   
	   for (x = 0; x <= counter_mental; x++) {
		   if (x == 0){
				var tandareaksi_1 = $(".tandareaksi_"+x).val();
				
				if (tandareaksi_1 === undefined){
					tandareaksi_1 = '';
				} 
		   } else if (x == 1){
				
				var tandareaksi_2 = $(".tandareaksi_"+x).val();
				
				if (tandareaksi_2 === undefined){
					tandareaksi_2 = '';
				} 
		   } else if (x == 2){
				var tandareaksi_3 = $(".tandareaksi_"+x).val();
				if (tandareaksi_3 === undefined){
					tandareaksi_3 = '';
				} 
		   }
			
		}        
       
       $('#riwayatrestrain tbody').append("<tr>\n\
	   											<td><input readonly = TRUE type = 'hidden' id = 'TransfusidarahT"+(no+1)+"_waktu_transfusi' name = 'TransfusidarahT["+(no+1)+"][waktu_transfusi]' value = '"+waktu_transfusi+"' >"+waktu_transfusi+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'TransfusidarahT"+(no+1)+"_kondisi' name = 'TransfusidarahT["+(no+1)+"][kondisi_transfusidarah]' value = '"+kondisi_transfusidarah+"' >"+kondisi_transfusidarah+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'TransfusidarahT"+(no+1)+"_deskripsi' name = 'TransfusidarahT["+(no+1)+"][deskripsi]' value = '"+deskripsi+"' >"+deskripsi+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'TransfusidarahT"+(no+1)+"_tandareaksi' name = 'TransfusidarahT["+(no+1)+"][tandareaksi]' value = '"+tandareaksi+"' >"+tandareaksi_1+"<br> "+tandareaksi_2+"<br> "+tandareaksi_3+"</td>"+
												"<td><input readonly = TRUE type = 'hidden' id = 'TransfusidarahT"+(no+1)+"_waktu_tranfusi' name = 'TransfusidarahT["+(no+1)+"][waktu_tranfusi]' value = '"+waktu_tranfusi+"' >"+waktu_tranfusi+"<br>"+jam_transfusi+"</td>"+
                                               "<td><input readonly = TRUE type = 'hidden' id = 'TransfusidarahT"+(no+1)+"_petugas' name = 'TransfusidarahT["+(no+1)+"][petugas]' value = '"+petugas+"' >"+petugas+"</td>"+
											   "<input readonly = TRUE type = 'hidden' id = 'TransfusidarahdetT"+(no+1)+"_tandareaksi' name = 'TransfusidarahdetT["+(no+1)+"][0][tandareaksi]' value = '"+tandareaksi_1+"' >"+tandareaksi_1+
											   "<input readonly = TRUE type = 'hidden' id = 'TransfusidarahdetT"+(no+1)+"_tandareaksi' name = 'TransfusidarahdetT["+(no+1)+"][1][tandareaksi]' value = '"+tandareaksi_2+"' >"+tandareaksi_2+
											   "<input readonly = TRUE type = 'hidden' id = 'TransfusidarahdetT"+(no+1)+"_tandareaksi' name = 'TransfusidarahdetT["+(no+1)+"][2][tandareaksi]' value = '"+tandareaksi_3+"' >"+tandareaksi_3+
											   "<input readonly = TRUE type = 'hidden' id = 'TransfusidarahT"+(no+1)+"_jam_transfusi' name = 'TransfusidarahT["+(no+1)+"][jam_transfusi]' value = '"+jam_transfusi+"' >"+jam_transfusi+"\n\
                                                <td style='text-align:center;'>"+buttonMinus+"</td>\n\
                                            </tr>");
    
       resetRiwayat();
    }
    
    function resetRiwayat()
    {
        $("#waktu_transfusi").val('');
        $("#kondisi_transfusidarah").val('');
        $(".tandareaksi_0").val('');
		$(".tandareaksi_1").val('');
		$(".tandareaksi_2").val('');
		$("#deskripsi").val('');
		$("#waktu_tranfusi").val('');
		$("#petugas").val('');
		$("#jam_transfusi").val('');
		$('#tab_upload').find("tr").remove();
		counter_mental = 1;
    }
    
    function delRow(obj)
    {
         myConfirm('Apakah Anda yakin ingin menghapus data detail ini ?','Perhatian!',function(r){
            if (r){
                $(obj).parent().parent().remove();
           }
        });
        
    }

	function hapus(obj)
    {
         myConfirm('Apakah Anda yakin ingin menghapus data detail ini ?','Perhatian!',function(r){
            if (r){
                $(obj).parent().parent().remove();
           }
        });
        
    }

	
    
    function tambahRow() {
        $.post('<?php echo $this->createUrl('ajaxTambahRowUpload'); ?>', {counter: counter_mental}, function(data) {
            $("#tab_upload").append(data.html);
            counter_mental++;
        }, 'json');
    }
    
	function hapusData(obj) {
        $(obj).parents("tr").remove();
    }
    
	function cekPetugas(){
		var cek = $('#is_petugasbankdarah').is(':checked');
		if (cek == true){
			$('#petugas_bankdarah').attr('readonly',false);
			$('#id_petugasbank').attr('readonly',false);
		}else{
			$('#petugas_bankdarah').attr('readonly',true);
			$('#id_petugasbank').attr('readonly',true);
		}
	}
    
	function cekPerawat(){
		var cek = $('#is_perawat').is(':checked');
		if (cek == true){
			$('#nama_perawat').attr('disabled',false);
		}else{
			$('#nama_perawat').attr('disabled',true);
		}
	}

	function cekReaksi(){
		var cek = $('#is_reaksi').is(':checked');
		if (cek == true){
			$('#_0tandareaksi').attr('disabled',false);
			$('#tambah_id').attr('disabled',false);
			
		}else{
			$('#_0tandareaksi').attr('disabled',true);
			$('#tambah_id').attr('disabled',true);
		}
	}

	function cekwaktu(){
		var waktu = $('#waktu_tranfusi').val();
		if (waktu != 'sebelum transfusi dimulai'){
			$('#jam_transfusi').attr('disabled',false);
		}else{
			$('#jam_transfusi').attr('disabled',true);
			$("#jam_transfusi").val('');
		}
	}

	$(document).ready(function(){
		cekPetugas();
		cekPerawat();
		cekReaksi();
		cekwaktu();
	});
    
</script>