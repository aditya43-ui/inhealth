<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran <span class='required'>*</span>", 'no_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modKunjungan,
                    'attribute' => 'no_pendaftaran',
					'name'=>'no_pendaftaran',
					'value'=>$modKunjungan->no_pendaftaran,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompleteKunjungan').'",
							dataType: "json",
							data: {
								no_pendaftaran: request.term,
								ruangan_id: $("#ruangan_id").val(),
							},
							success: function (data) {
								response(data);
							}
						})
					}',
					 'options'=>array(
						'minLength' => 4,
						 'focus'=> 'js:function( event, ui ) {
							$(this).val( "");
							return false;
						}',
						'select'=>'js:function( event, ui ) {
							$(this).val( ui.item.no_pendaftaran);
							setKunjungan(ui.item.pendaftaran_id);
							return false;
						}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
					'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'No. Pendaftaran',
						'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
					),
				)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tgl. Pendaftaran <span class='required'>*</span>", 'tgl_pendaftaran', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modKunjungan->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Instalasi Asal", 'instalasi_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('instalasi_id',$modKunjungan->instalasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('instalasi_nama',$modKunjungan->instalasi_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Ruangan Asal", 'ruangan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id',$modKunjungan->ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('ruangan_nama',$modKunjungan->ruangan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('kelaspelayanan_id',$modKunjungan->kelaspelayanan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('kelaspelayanan_nama',$modKunjungan->kelaspelayanan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('jeniskasuspenyakit_id',$modKunjungan->jeniskasuspenyakit_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('jeniskasuspenyakit_nama',$modKunjungan->jeniskasuspenyakit_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id',$modKunjungan->carabayar_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama',$modKunjungan->carabayar_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('pasienadmisi_id',$modKunjungan->pasienadmisi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('pasienmasukpenunjang_id',$modKunjungan->pasienmasukpenunjang_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
				$this->widget('MyJuiAutoComplete', array(
					'name'=>'no_rekam_medik',
					'value'=>$modKunjungan->no_rekam_medik,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompleteKunjungan').'",
							dataType: "json",
							data: {
								no_rekam_medik: request.term,
								ruangan_id: $("#ruangan_id").val(),
							},
							success: function (data) {
								response(data);
							}
						})
					}',
					 'options'=>array(
						'minLength' => 4,
						 'focus'=> 'js:function( event, ui ) {
							$(this).val( "");
							return false;
						  }',
						'select'=>'js:function( event, ui ) {
							$(this).val( ui.item.no_rekam_medik);
							setKunjungan(ui.item.pendaftaran_id);
							return false;
						}',
					),
					'htmlOptions'=>array('placeholder'=>'No. Rekam Medik','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'No. rekam medik untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
				)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('namadepan',$modKunjungan->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    
					'name'=>'nama_pasien',
					'value'=>$modKunjungan->nama_pasien,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompleteKunjungan').'",
							dataType: "json",
							data: {
								nama_pasien: request.term,
								ruangan_id: $("#ruangan_id").val(),
							},
							success: function (data) {
								response(data);
							}
						})
					}',
					 'options'=>array(
						'minLength' => 2,
						 'focus'=> 'js:function( event, ui ) {
							$(this).val( "");
							return false;
						  }',
						'select'=>'js:function( event, ui ) {
							$(this).val( ui.item.nama_pasien);
							setKunjungan(ui.item.pendaftaran_id);
							return false;
						}',
					),
					'htmlOptions'=>array('class'=>'span3','placeholder'=>'Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data kunjungan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
				)); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modKunjungan->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modKunjungan->umur,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modKunjungan->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modKunjungan->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div style="text-align: center;">
        <?php 
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/> 
    </div>    
</div>

<?php 
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogKunjungan',
    'options'=>array(
        'title'=>'Pencarian Data Kunjungan Pasien '.Yii::app()->user->getState('ruangan_nama'),
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));

    $modDialogKunjungan = new InfopasienpengunjungV('searchKunjunganRuanganDialog');
    $modDialogKunjungan->unsetAttributes();
    $format = new MyFormatter();
    $modDialogKunjungan->tgl_pendaftaran = date('d/m/Y') . ' - ' . date('d/m/Y');

    // $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    
    if(isset($_GET['InfopasienpengunjungV'])) {        
        $modDialogKunjungan->attributes = $_GET['InfopasienpengunjungV'];     
    }
    

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$modDialogKunjungan->searchKunjunganRuanganDialog(),
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectKunjungan",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    'no_pendaftaran',

                    array(
                        'name'=>'tgl_pendaftaran',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=>CHtml::activeTextField($modDialogKunjungan, 'tgl_pendaftaran', array('class' => 'span3 tgl_pendaftaran', 'readonly' => true)),
                        'htmlOptions'=>array('width'=>'150px','style'=>'text-align:center'),
                    ),

                    'no_rekam_medik',
                    array(
                        'name'=>'nama_pasien',
                        'value'=>'$data->namadepan.$data->nama_pasien',
                    ), 
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=> CHtml::dropDownList('RJInfokunjunganrjV[jeniskelamin]',$modDialogKunjungan->jeniskelamin,LookupM::model()->getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                    ),
                    array(
                        'header'=>'Jenis Penjamin',
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=> CHtml::dropDownList('RJInfokunjunganrjV[carabayar_nama]',$modDialogKunjungan->carabayar_nama,CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"),'carabayar_nama','carabayar_nama'), array('empty'=>'-- Pilih --')),
                    ),                
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',

            'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                  jQuery("#' . CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran') . '").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });

            }',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>

<script>
$(document).ready(function(){
    
     setPickerRangeTanggal();
});
    
function setPickerRangeTanggal() {
    $('#<?php echo CHtml::activeId($modDialogKunjungan, 'tgl_pendaftaran'); ?>').daterangepicker({
        "maxDate": "<?php echo date('m/d/Y') ?>",
        "format": "DD/MM/YYYY",
        "applyClass": "btn-primary btn_pendaftaran_apply",
        "showDropdowns": true,
    });
    
    $(".btn_pendaftaran_apply").on("click", function() {
        setTimeout(function() {
            $.fn.yiiGridView.update("datakunjungan-grid", {data: $("#datakunjungan-grid :input").serialize()});
        }, 100);
    });
}
</script>