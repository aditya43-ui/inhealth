<div id="divPasien"  style="display: block;">
    <div class="control-group">
        <label class="control-label">
        <div class="label_no">
         <i class="icon-user"></i>  
            <?php echo CHtml::checkBox('isPasienLama', $modPasien->isPasienLama, array('rel'=>'tooltip','title'=>'Pilih jika pasien lama','onclick'=>'pilihNoRm()', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
            No. Rekam Medik                    
        </div>
      </label>
                <div class="controls" id="controlNoRekamMedik">
        
                          <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=>'no_rekam_medik',
                                    'value'=>$model->no_rekam_medik,
                                    'sourceUrl'=> $this->createUrl('PasienLama'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'style'=>'height:20px;',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            $("#noRekamMedik").val( ui.item.value );
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            $(\'#PPBuatJanjiPoliT_pasien_id\').val(ui.item.pasien_id);
                                            $(\'#no_rekam_medik\').val(ui.item.no_rekam_medik);
                                            $("#'.CHtml::activeId($modPasien,'jenisidentitas').'").val(ui.item.jenisidentitas);
                                            $("#'.CHtml::activeId($modPasien,'no_identitas_pasien').'").val(ui.item.no_identitas_pasien);
                                            $("#'.CHtml::activeId($modPasien,'namadepan').'").val(ui.item.namadepan);
                                            $("#'.CHtml::activeId($modPasien,'nama_pasien').'").val(ui.item.nama_pasien);
                                            $("#'.CHtml::activeId($modPasien,'nama_bin').'").val(ui.item.nama_bin);
                                            $("#'.CHtml::activeId($modPasien,'tempat_lahir').'").val(ui.item.tempat_lahir);
                                            $("#'.CHtml::activeId($modPasien,'tanggal_lahir').'").val(ui.item.tanggal_lahir);
                                            $("#'.CHtml::activeId($modPasien,'kelompokumur_id').'").val(ui.item.kelompokumur_id);
                                            $("#'.CHtml::activeId($modPasien,'jeniskelamin').'").val(ui.item.jeniskelamin);
                                            setJenisKelaminPasien(ui.item.jeniskelamin);
                                            setRhesusPasien(ui.item.rhesus);
                                            loadDaerahPasien(ui.item.propinsi_id, ui.item.kabupaten_id, ui.item.kecamatan_id, ui.item.kelurahan_id);
                                            $("#'.CHtml::activeId($modPasien,'statusperkawinan').'").val(ui.item.statusperkawinan);
                                            $("#'.CHtml::activeId($modPasien,'golongandarah').'").val(ui.item.golongandarah);
                                            $("#'.CHtml::activeId($modPasien,'rhesus').'").val(ui.item.rhesus);
                                            $("#'.CHtml::activeId($modPasien,'alamat_pasien').'").val(ui.item.alamat_pasien);
                                            $("#'.CHtml::activeId($modPasien,'rt').'").val(ui.item.rt);
                                            $("#'.CHtml::activeId($modPasien,'rw').'").val(ui.item.rw);
                                            $("#'.CHtml::activeId($modPasien,'propinsi_id').'").val(ui.item.propinsi_id);
                                            $("#'.CHtml::activeId($modPasien,'kabupaten_id').'").val(ui.item.kabupaten_id);
                                            $("#'.CHtml::activeId($modPasien,'kecamatan_id').'").val(ui.item.kecamatan_id);
                                            $("#'.CHtml::activeId($modPasien,'kelurahan_id').'").val(ui.item.kelurahan_id);
                                            $("#'.CHtml::activeId($modPasien,'no_telepon_pasien').'").val(ui.item.no_telepon_pasien);
                                            $("#'.CHtml::activeId($modPasien,'no_mobile_pasien').'").val(ui.item.no_mobile_pasien);
                                            $("#'.CHtml::activeId($modPasien,'suku_id').'").val(ui.item.suku_id);
                                            $("#'.CHtml::activeId($modPasien,'alamatemail').'").val(ui.item.alamatemail);
                                            $("#'.CHtml::activeId($modPasien,'anakke').'").val(ui.item.anakke);
                                            $("#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'").val(ui.item.jumlah_bersaudara);
                                            $("#'.CHtml::activeId($modPasien,'pendidikan_id').'").val(ui.item.pendidikan_id);
                                            $("#'.CHtml::activeId($modPasien,'pekerjaan_id').'").val(ui.item.pekerjaan_id);
                                            $("#'.CHtml::activeId($modPasien,'agama').'").val(ui.item.agama);
                                            $("#'.CHtml::activeId($modPasien,'warga_negara').'").val(ui.item.warga_negara);
                                            loadUmur(ui.item.tanggal_lahir);
                                            return false;
                                        }',

                                    ),
                                    'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
										'tombolDialog'=>array('idDialog'=>'dialogPasien','idTombol'=>'tombolPasienDialog'),
                            )); ?>                          
      </div>
</div> 
</div>   
<br>
<div class="row well">
<fieldset id='fieldsetPasien'>
    <legend class="rim">Masukan Data Pasien</legend>
    <div class="row">
            <div class="col-sm-6">        
                <div class="control-group">
						<?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
						<div class="controls">
							<?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
														  array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
																)); ?>   
							<?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'No. Identitas','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
							<?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
						</div>
				</div>
                    
                          
				<div class="control-group">
				   <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
				   <div class="controls inline">

					   <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
													 array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1'
														   )); ?>   
					   <?php echo $form->textField($modPasien,'nama_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 all-caps','placeholder'=>'Nama Pasien')); ?>            

					   <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
				   </div>
				</div>

				<?php echo $form->textFieldRow($modPasien,'nama_bin', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alias')); ?>
				<?php echo $form->textFieldRow($modPasien,'tempat_lahir', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Tempat Lahir')); ?>
                             
				<div class="control-group">
					<?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php   
								$this->widget('MyDateTimePicker',array(
												'model'=>$modPasien,
												'attribute'=>'tanggal_lahir',
												'mode'=>'date',
												'options'=> array(
//                                                                  'dateFormat'=>Params::DATE_FORMAT,
													'maxDate' => 'd',
													'onkeyup'=>"js:function(){getUmur(this);}",
													'onSelect'=>'js:function(){getUmur(this);}',
												),
												'htmlOptions'=>array('class'=>'dtPicker4 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
												),
						)); ?>
						<?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
					</div>
				</div>
                              
				<div class="control-group">
					<?php echo $form->labelEx($modPasien,'umur', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php
							$this->widget('CMaskedTextField', array(
							'model' => $modPasien,
							'attribute' => 'umur',
							'mask' => '99 Thn 99 Bln 99 Hr',
							'htmlOptions' => array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'onblur'=>'getTglLahir(this)','placeholder'=>'Umur Pasien')
							));
							?>
						<?php echo $form->error($modPasien, 'umur',array('placeholder'=>'Umur Pasien')); ?>
					</div>
				</div>
				<?php echo $form->radioButtonListInlineRow($modPasien,'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
				<?php echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

				<div class="control-group">
						<?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>

						<div class="controls">

							<?php echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
														  array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span4')); ?>   
							<div class="radio inline">
								<div class="form-inline">
								<?php echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
								</div>
						   </div>
							<?php echo $form->error($modPasien, 'golongandarah'); ?>
							<?php echo $form->error($modPasien, 'rhesus'); ?>
						</div>
				</div> 
				<?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alamat Lengkap Pasien',)); ?>

				<div class="control-group">
					<?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline ')) ?>

					<div class="controls">
						<?php echo $form->textField($modPasien,'rt', array('placeholder'=>'RT','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>   / 
						<?php echo $form->textField($modPasien,'rw', array('placeholder'=>'RW','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>            
						<?php echo $form->error($modPasien, 'rt'); ?>
						<?php echo $form->error($modPasien, 'rw'); ?>
					</div>
				</div>
					<?php echo $form->textFieldRow($modPasien,'no_telepon_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Telepon Pasien ','class'=>'span4 numbersOnly')); ?>
					<?php echo $form->textFieldRow($modPasien,'no_mobile_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Hp Pasien','class'=>'span4 numbersOnly')); ?>                          
			</div>
        

            <div class="col-sm-6">
                <div class="control-group">
					<?php echo $form->labelEx($modPasien,'propinsi_id', array('class'=>'control-label')) ?>
					<div class="controls">
					<?php $modPasien->propinsi_id = (!empty($modPasien->propinsi_id))?$modPasien->propinsi_id:Yii::app()->user->getState('propinsi_id');?>
					<?php echo $form->dropDownList($modPasien,'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
													  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
															'ajax'=>array('type'=>'POST',
																		  'url'=>$this->createUrl('GetKabupaten',array('encode'=>false,'namaModel'=>'PPPasienM')),
																		  'update'=>'#PPPasienM_kabupaten_id',),
															'onchange'=>"clearKecamatan();clearKelurahan();",)); ?>
				   <?php echo $form->error($modPasien, 'propinsi_id'); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($modPasien,'kabupaten_id', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php $modPasien->kabupaten_id = (!empty($modPasien->kabupaten_id))?$modPasien->kabupaten_id:Yii::app()->user->getState('kabupaten_id');?>
						<?php echo $form->dropDownList($modPasien,'kabupaten_id',CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
														  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
																'ajax'=>array('type'=>'POST',
																			  'url'=>$this->createUrl('GetKecamatan',array('encode'=>false,'namaModel'=>'PPPasienM')),
																			  'update'=>'#PPPasienM_kecamatan_id'),
																'onchange'=>"clearKelurahan();",)); ?>
						<?php echo $form->error($modPasien, 'kabupaten_id'); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($modPasien,'kecamatan_id', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php $modPasien->kecamatan_id = (!empty($modPasien->kecamatan_id))?$modPasien->propinsi_id:Yii::app()->user->getState('kecamatan_id');?>
						<?php echo $form->dropDownList($modPasien,'kecamatan_id',CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
														  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
																'ajax'=>array('type'=>'POST',
																			  'url'=>$this->createUrl('GetKelurahan',array('encode'=>false,'namaModel'=>'PPPasienM')),
																			  'update'=>'#PPPasienM_kelurahan_id'))); ?>
						<?php echo $form->error($modPasien, 'kecamatan_id'); ?>
					</div>
				</div>

				 <div class="control-group">
					<?php echo $form->labelEx($modPasien,'kelurahan_id', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id))?$modPasien->propinsi_id:Yii::app()->user->getState('kelurahan_id');?>
						<?php echo $form->dropDownList($modPasien,'kelurahan_id',CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
														  array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
						<?php echo $form->error($modPasien, 'kelurahan_id'); ?>
					</div>
				</div>

				 <?php echo $form->dropDownListRow($modPasien,'agama', LookupM::getItems('agama'),array('class'=>'span4','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
				 <?php echo $form->dropDownListRow($modPasien,'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
				 <?php echo $form->dropDownListRow($modPasien,'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
				 <?php echo $form->dropDownListRow($modPasien,'warga_negara', LookupM::getItems('warganegara'),array('class'=>'span4','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

            </div>
    </div>
    </fieldset>
</div> 
<?php 
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddPropinsi',
    'options'=>array(
        'title'=>'Menambah data Provinsi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>350,
        'resizable'=>false,
    ),
));

echo '<div class="divForForm"></div>';

$this->endWidget();
//========= end propinsi dialog =============================

// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKabupaten',
    'options'=>array(
        'title'=>'Menambah data Kabupaten',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKabupaten"></div>';

$this->endWidget();
//========= end kabupaten dialog =============================

// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKecamatan',
    'options'=>array(
        'title'=>'Menambah data Kecamatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKecamatan"></div>';

$this->endWidget();
//========= end kecamatan dialog =============================

// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKelurahan',
    'options'=>array(
        'title'=>'Menambah data Kelurahan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKelurahan"></div>';

$this->endWidget();
//========= end kelurahan dialog =============================
?>
<script type="text/javascript">
// here is the magic
function convertToUpper(obj)
{
    var string = obj.value;
    $(obj).val(string.toUpperCase());
}
//LOGIC MASIH BELUM SESUAI
function setNamaGelar()
{
    var statusperkawinan = $('#PPPasienM_statusperkawinan').val();
    var namadepan = $('#PPPasienM_namadepan');
    var umur = $("#<?php echo CHtml::activeId($modPasien,'umur');?>").val().substr(0,2);
    umur = parseInt(umur);
    if(umur <= 5){
        var namadepan = $('#PPPasienM_namadepan').val('BY. Ny.');
        if(statusperkawinan.length > 0){
            $('#PPPasienM_statusperkawinan').val('');
            myAlert('Maaf status perkawinan belum cukup usia');
        }
    }else if(umur <= 15){
        var namadepan = $('#PPPasienM_namadepan').val('An.');
        if(statusperkawinan.length > 0){
            $('#PPPasienM_statusperkawinan').val('');
            myAlert('Maaf status perkawinan belum cukup usia');
        }
    }else{
        if($('#PPPasienM_jeniskelamin_0').is(':checked')){
            if(statusperkawinan !== 'JANDA'){
                var namadepan = $('#PPPasienM_namadepan').val('Tn.');
            }else{
                myAlert('Silakan pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#PPPasienM_namadepan').val('Tn.');
            }
        }
        
        if($('#PPPasienM_jeniskelamin_1').is(':checked')){
            if(statusperkawinan !== 'DUDA'){
                if(statusperkawinan === 'KAWIN' || statusperkawinan == 'JANDA' || statusperkawinan == 'NIKAH SIRIH' || statusperkawinan == 'POLIGAMI'){
                    var namadepan = $('#PPPasienM_namadepan').val('Ny.');
                }else{
                    var namadepan = $('#PPPasienM_namadepan').val('Nn');
                }                
            }else{
                myAlert('Silakan pilih status pernikahan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('KAWIN');
                var namadepan = $('#PPPasienM_namadepan').val('Ny.');
            }
        }        
    }
    
}

function cekJenisKelamin(obj)
{
    var is_true = true;
    var namadepan = $('#PPPasienM_namadepan').val();
    if(namadepan.length != 0)
    {
        if(obj.value == 'PEREMPUAN')
        {
            if(namadepan != 'Nn.' && namadepan != 'Ny.' && namadepan != 'BY. Ny.')
            {
                myAlert('Silakan pilih Jenis kelamin yang sesuai!');
                $('#PPPasienM_jeniskelamin_0').attr('checked',true);
                is_true = false;
            }
        }else{
            if(namadepan != 'Tn.' && namadepan != 'An.' && namadepan != 'BY. Ny.')
            {
                myAlert('Silakan pilih Jenis kelamin yang sesuai!');
                $('#PPPasienM_jeniskelamin_1').attr('checked',true);
                is_true = false;
            }
        }
    }else{
        $(obj).attr('checked',false);
        myAlert('Silakan pilih gelar kehormatan terlebih dahulu!');
    }
}

function setValueStatus(obj)
{
    var gelar = obj.value;
    if(gelar === 'Tn.')
    {
        $('#PPPasienM_jeniskelamin_0').attr('checked',true);
        $('#PPPasienM_statusperkawinan').val('KAWIN');
        
    }else if(gelar === 'An.'){
        $('#PPPasienM_jeniskelamin_0').attr('checked',true);
        $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
    }else{
        if(gelar === 'Nn' || gelar === 'BY. Ny.')
        {
            $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
        }else{
            $('#PPPasienM_statusperkawinan').val('KAWIN');
        }
        $('#PPPasienM_jeniskelamin_1').attr('checked',true);
    }
}

function setStatusPerkawinan(obj)
{
    var status = obj.value;
    var namaDepan = $('#PPPasienM_namadepan').val();
    
    if(status === 'BELUM KAWIN')
    {
        if(namaDepan !== 'An.' && namaDepan !== 'Nn' && namaDepan !== 'BY. Ny.')
        {
            myAlert('Silakan pilih status perkawinan yang sesuai!');
            $('#PPPasienM_statusperkawinan').val('KAWIN');
        }
    }else{
        if(status === 'KAWIN' || status === 'NIKAH SIRIH' || status === 'POLIGAMI')
        {
            if(namaDepan !== 'Tn.' && namaDepan !== 'Ny.')
            {
                myAlert('Silakan pilih status perkawinan yang sesuai!');
                $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
            }
        }
        else if(status === 'JANDA')
        {
            if(namaDepan !== 'Ny.')
            {
                myAlert('Silakan pilih status perkawinan yang sesuai!');
                if(namaDepan === 'Tn.')
                {
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                }else{
                    $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
                }
            }
        }
        else if(status === 'DUDA')
        {
            if(namaDepan !== 'Tn.')
            {
                myAlert('Silakan pilih status perkawinan yang sesuai!');
                if(namaDepan === 'Ny.')
                {
                    $('#PPPasienM_statusperkawinan').val('KAWIN');
                }else{
                    $('#PPPasienM_statusperkawinan').val('BELUM KAWIN');
                }
            }
        }
    }
}

function cekStatusPekerjaan(obj)
{
    var namaDepan = $('#PPPasienM_namadepan').val();
    var namaPekerjaan = obj.value;
    var umur = $("#<?php echo CHtml::activeId($modPasien,'umur');?>").val().substr(0,2);
    umur = parseInt(umur);
    
    if(namaDepan.length > 0)
    {
        if(umur < 15){
            if(namaPekerjaan !== '12'){
                if(namaPekerjaan !== ''){
                    myAlert('Pasien masih di bawah umur,silakan cek kembali!');
                }
                $(obj).val('');
            }else{
                $(obj).val(namaPekerjaan);
            }
        }else{
            if(namaPekerjaan === '12'){
                if(namaDepan === 'Ny.'){
                    $(obj).val('9');
                }else if(namaDepan === 'Nn' && namaPekerjaan === '9'){
                    myAlert('Pasien belum menikah,silakan cek kembali!');
                    $(obj).val('');
                }else{
                    $(obj).val('');
                }
                myAlert('Silakan pilih pekerjaan yang tepat!');
            }else{
                if(namaPekerjaan === '9'){
                    if(namaDepan !== 'Ny.'){
                        myAlert('Pasien seorang laki-laki,silakan cek kembali!');
                        $(obj).val('');                        
                    }
                }
            }
        }
    }else{
        $(obj).val('');
        myAlert('Silakan pilih gelar kehormatan terlebih dahulu!');
    }

}
</script>
<?php
$urlGetTglLahir = $this->createUrl('GetTglLahir');
$urlGetUmur = $this->createUrl('setUmur');
$urlGetDaerah = $this->createUrl('getListDaerahPasien');
$idTagUmur = CHtml::activeId($modPasien,'umur');
$js = <<< JS
function clearKecamatan()
{
    $('#PPPasienM_kecamatan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function clearKelurahan()
{
    $('#PPPasienM_kelurahan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function getTglLahir(obj)
{   
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.post("${urlGetTglLahir}",{umur: obj.value},
        function(data){
           $('#PPPasienM_tanggal_lahir').val(data.tglLahir); 
    },"json");
}
    
function getUmur(obj)
{
    //myAlert(obj.value);
    if(obj.value == '')
        obj.value = 0;
    $.post("${urlGetUmur}",{tanggal_lahir: obj.value},
        function(data){

           $('#PPPasienM_umur').val(data.umur);
    },"json");
}
JS;
Yii::app()->clientScript->registerScript('formPasien',$js,CClientScript::POS_HEAD);

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>