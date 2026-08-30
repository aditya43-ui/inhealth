<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Jenis Penjualan", 'jenispenjualan', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php
            if(!empty($modPenjualan->penjualanresep_id)){
                echo CHtml::textField('jenispenjualan',$modPenjualan->jenispenjualan,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
            }else{
                echo CHtml::dropDownList('jenispenjualan',$modPenjualan->jenispenjualan,LookupM::model()->getItems('jenispenjualan'),array('empty'=>'-- Pilih --','onchange'=>'setPenjualanReset();refreshDialogPenjualan();','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",));
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Penjualan", 'noresep', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pendaftaran_id',$modPenjualan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('penjualanresep_id',$modPenjualan->penjualanresep_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
                $this->widget('MyJuiAutoComplete', array(
					'name'=>'noresep',
					'value'=>$modPenjualan->noresep,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompletePenjualan').'",
							dataType: "json",
							data: {
								noresep: request.term,
								jenispenjualan: $("#jenispenjualan").val(),
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
							$(this).val( ui.item.value);
							$("#pendaftaran_id").val(ui.item.pendaftaran_id);
							setPenjualan(ui.item.penjualanresep_id, ui.item.noresep, ui.item.no_rekam_medik, "");
							return false;
						}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogPenjualan'),
					'htmlOptions'=>array('placeholder'=>'Ketik No. Penjualan','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. penjualan / klik icon untuk mencari data penjualan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
				));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Penjualan', 'tglpenjualan', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tglpenjualan',$modPenjualan->tglpenjualan,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::hiddenField('tglpelayanan',$modPenjualan->tglpelayanan,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Apotek", 'ruangan_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('ruangan_id',$modPenjualan->getPenunjangAkhir()->ruangan_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('ruangan_nama',$modPenjualan->getPenunjangAkhir()->ruangan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('carabayar_id',$modPenjualan->carabayar_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('carabayar_nama',$modPenjualan->carabayar_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penjamin_id',$modPenjualan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('penjamin_nama',$modPenjualan->penjamin_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group dpjp" hidden>
        <?php echo CHtml::label("Dokter Penerima", 'dokterpenerima', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('dokterpenerima', null, array('class'=>'span3', 'readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group dpjp" hidden>
        <?php echo CHtml::label("Dokter PJP 1", 'dpjp1_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('dpjp1', null, array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group dpjp" hidden>
        <?php echo CHtml::label("Dokter PJP 2", 'dpjp2_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('dpjp2', null, array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group dpjp" hidden>
        <?php echo CHtml::label("Dokter PJP 3", 'dpjp3_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('dpjp3', null, array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modPenjualan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php // echo CHtml::textField('no_rekam_medik',$modPenjualan->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
                $this->widget('MyJuiAutoComplete', array(
					'name'=>'no_rekam_medik',
					'value'=>$modPenjualan->no_rekam_medik,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompletePenjualan').'",
							dataType: "json",
							data: {
								no_rekam_medik: request.term,
								instalasi_id: $("#instalasi_id").val(),
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
							$(this).val( ui.item.value);
							$("#pendaftaran_id").val(ui.item.pendaftaran_id);
							setPenjualan(ui.item.penjualanresep_id, ui.item.noresep, ui.item.no_rekam_medik, "");
							return false;
						}',
					),
					'htmlOptions'=>array('placeholder'=>'Ketik No. Rekam Medik','class'=>'all-caps','rel'=>'tooltip','title'=>'Ketik no. rekam medik untuk mencari data penjualan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
				));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php
            if (!empty($modPenjualan->pasienpegawai_id)) {
                $p = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
                $modPenjualan->nama_pasien = $p->namaLengkap;
                $modPenjualan->tanggal_lahir = MyFormatter::formatDateTimeForUser($p->tgl_lahirpegawai);
                $modPenjualan->jeniskelamin = $p->jeniskelamin;
            }
            //var_dump($modPenjualan->attributes); die;
            echo CHtml::hiddenField('namadepan',$modPenjualan->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
                $this->widget('MyJuiAutoComplete', array(
					'name'=>'nama_pasien',
					'value'=>$modPenjualan->nama_pasien,
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('AutocompletePenjualan').'",
							dataType: "json",
							data: {
								nama_pasien: request.term,
								instalasi_id: $("#instalasi_id").val(),
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
							$(this).val( ui.item.value);
							$("#pendaftaran_id").val(ui.item.pendaftaran_id);
							setPenjualan(ui.item.penjualanresep_id, ui.item.noresep, ui.item.no_rekam_medik, "");
							return false;
						}',
					),
					'htmlOptions'=>array('placeholder'=>'Ketik Nama Pasien','rel'=>'tooltip','title'=>'Ketik nama pasien untuk mencari data penjualan',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
					),
				));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modPenjualan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modPenjualan->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('umur',$modPenjualan->umur,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modPenjualan->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('penanggungjawab_id',$modPenjualan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::textField('nama_pj',$modPenjualan->nama_pj,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modPenjualan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div align="center">
        <?php
        $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory()."kecil_".$modPasien->photopasien : Params::urlPhotoPasienDirectory()."no_photo.jpeg");
        ?>
        <img id="photo-preview" src="<?php echo $url_photopasien?>"width="128px"/>
    </div><br>
</div>


<?php
//========= Dialog buat cari data pendaftaran / penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPenjualan',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogPenjualan = new BKInformasipenjualanaresepV('searchDialog');
    $modDialogPenjualan->unsetAttributes();
    $modDialogPenjualan->jenispenjualan = $modPenjualan->jenispenjualan;
    if(isset($_GET['BKInformasipenjualanaresepV'])) {
        $modDialogPenjualan->attributes = $_GET['BKInformasipenjualanaresepV'];
        $modDialogPenjualan->jenispenjualan = $_GET['BKInformasipenjualanaresepV']['jenispenjualan'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datapenjualan-grid',
            'dataProvider'=>$modDialogPenjualan->searchDialogPenjualanResep(),
            'filter'=>$modDialogPenjualan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small",
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#pendaftaran_id\").val($data->pendaftaran_id);
                                            $(\"#ruangan_id\").val($data->ruangan_id);
                                            setPenjualan($data->penjualanresep_id, \"\", \"\", \"\");
                                            $(\"#dialogPenjualan\").dialog(\"close\");
                                        "))',
                    ),
                    array(
                        'header' => 'No. Penjualan',
                        'name' => 'noresep',
                        'value' => '$data->noresep',
                        'filter' => Chtml::activeTextField($modDialogPenjualan, 'noresep', array('class'=>'angkahuruf-only'))
                    ),
                    array(
                        'name'=>'tglpenjualan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpenjualan)',
                        'filter'=>$this->widget('MyDateTimePicker', array(
                            'model'=>$modDialogPenjualan,
                            'attribute'=>'tglpenjualan',
                            'mode' => 'date',
                            //'language' => 'ja',
                            // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                            'htmlOptions' => array(
                                'id' => 'datepicker_for_due_date',
                                'size' => '10',
                                'style'=>'width:80%'
                            ),
                            'options' => array(  // (#3)
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),

                        ),
                        true),
                    ),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                        'filter' => CHtml::activeHiddenField($modDialogPenjualan,'jenispenjualan', array('readonly'=>true)).Chtml::activeTextField($modDialogPenjualan, 'no_rekam_medik', array('class'=>'numbers-only'))
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'value'=>function($data){
                            $penjualanMod = PenjualanresepT::model()->findByPk($data->penjualanresep_id);
                            $valPegawai = "";
                            if(isset($penjualanMod) && !empty($penjualanMod)){
                              $valPegawai = (isset($penjualanMod->pasienpegawai)?$penjualanMod->pasienpegawai->namaLengkap:"");
                            }

                            return (($data->jenispenjualan == "PENJUALAN PEGAWAI" || $data->jenispenjualan == "PENJUALAN KARYAWAN" || $data->jenispenjualan == "PENJUALAN DOKTER")?$valPegawai:$data->namadepan." ".$data->nama_pasien);
                          },
                        // 'value'=>'',
                        //'value'=>'$data->namadepan." ".$data->nama_pasien',
                        'filter' => Chtml::activeTextField($modDialogPenjualan, 'nama_pasien', array('class'=>'hurufs-only'))
                    ),
                   array(
                       'header' => 'Jenis Penjamin / Penjamin',
                       'name' => 'carabayar_id',
                       'type' => 'raw',
                       'value' => '$data->carabayar_nama." <br/> / ".$data->penjamin_nama',
                       'filter' => Chtml::activeDropDownList($modDialogPenjualan, 'carabayar_id', Chtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_aktif ASC"), 'carabayar_id', 'carabayar_nama'),array('empty' => '-- Pilih --'))
                   ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
        . '$(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
            setAngkaHurufsOnly(this);
            });
            reinstallDatePicker();'
        . '}',
    ));

$this->endWidget();
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
////======= end pendaftaran dialog =============
?>
