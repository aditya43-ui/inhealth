<div class="col-sm-6">
    <div class="control-group" hidden>
        <?php echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('cari_pendaftaran_id',$modKunjungan->pendaftaran_id,array('onchange'=>"if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')",'class'=>'span3', 'placeholder'=>'Scan Barcode pada Print Status','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Pendaftaran", 'no_pendaftaran', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pendaftaran_id',$modKunjungan->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <?php
                $pasienadmisi_id = (isset($modKunjungan->pasienadmisi_id) ? $modKunjungan->pasienadmisi_id : null);
                echo CHtml::hiddenField('pasienadmisi_id',$pasienadmisi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
            ?>
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'no_pendaftaran',
                    'value'=>$modKunjungan->no_pendaftaran,
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteKunjungan').'",
                            dataType: "json",
                            data: {
                                no_pendaftaran: request.term,
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
                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                            return false;
                        }',
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogKunjungan'),
                    'htmlOptions'=>array('placeholder'=>'No. Pendaftaran','class'=>'span3 all-caps','rel'=>'tooltip','title'=>'No. pendaftaran / klik icon untuk mencari data kunjungan',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_pendaftaran',$modKunjungan->tgl_pendaftaran,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('pasien_id',$modKunjungan->pasien_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array('placeholder'=>'No. Rekam Medik','rel'=>'tooltip','title'=>'No. rekam medik untuk mencari data kunjungan',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                        'class'=>'span3 numbers-only',
                    ),
                )); 
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::hiddenField('namadepan',$modKunjungan->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
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
                            setKunjungan(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id, ui.item.penjualanresep_id);
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
</div>
<div class="col-sm-6">   
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tanggal_lahir',$modKunjungan->tanggal_lahir,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('jeniskelamin',$modKunjungan->jeniskelamin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
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
        'title'=>'Pencarian Data',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogKunjungan = new FAInformasipenjualanresepV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    if(isset($_GET['FAInformasipenjualanresepV'])) {
        $modDialogKunjungan->attributes = $_GET['FAInformasipenjualanresepV'];
        $modDialogKunjungan->no_pendaftaran = (isset($_GET['FAInformasipenjualanresepV']['no_pendaftaran']) ? $_GET['FAInformasipenjualanresepV']['no_pendaftaran'] : "");
        $modDialogKunjungan->no_rekam_medik = (isset($_GET['FAInformasipenjualanresepV']['no_rekam_medik']) ? $_GET['FAInformasipenjualanresepV']['no_rekam_medik'] : "");
        $modDialogKunjungan->nama_pasien = (isset($_GET['FAInformasipenjualanresepV']['nama_pasien']) ? $_GET['FAInformasipenjualanresepV']['nama_pasien'] : "");
        $modDialogKunjungan->ruanganasal_nama = (isset($_GET['FAInformasipenjualanresepV']['ruanganasal_nama']) ? $_GET['FAInformasipenjualanresepV']['ruanganasal_nama'] : "");
        $modDialogKunjungan->carabayar_nama = (isset($_GET['FAInformasipenjualanresepV']['carabayar_nama']) ? $_GET['FAInformasipenjualanresepV']['carabayar_nama'] : "");
		$modDialogKunjungan->noresep = (isset($_GET['FAInformasipenjualanresepV']['noresep']) ? $_GET['FAInformasipenjualanresepV']['noresep'] : "");
    }

    $prov = $modDialogKunjungan->searchDialogKunjunganSudahBayarRetur();
    // $prov->criteria->addCondition('t.carabayar_id != '.Params::CARABAYAR_ID_MEMBAYAR);
    
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datakunjungan-grid',
            'dataProvider'=>$prov,
            'filter'=>$modDialogKunjungan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            setKunjungan($data->pendaftaran_id, \"\", \"\", \"\",$data->penjualanresep_id);
                                            $(\"#dialogKunjungan\").dialog(\"close\");
                                        "))',
                    ),
                    'no_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        'filter'=> false,
                    ),
					array(
						'header' => 'No. Resep',
						'name' => 'noresep'
					),
                    array(
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                        'name'=>'nama_pasien',
                        'value'=>'$data->namadepan.$data->nama_pasien',
                    ),
//                    'jeniskelamin',
                    array(
                        'name'=>'jeniskelamin',
                        'type'=>'raw',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
                    ), /*
                    array(
                        'name'=>'instalasi_id',
                        'value'=>'$data->instalasi_nama',
                        'type'=>'raw',
//                        'filter'=>CHtml::listData(BKPendaftaranT::model()->getInstalasis(),'instalasi_id','instalasi_nama'), //dipilih dari instalasi form kunjungan
                        'filter'=>CHtml::activeHiddenField($modDialogKunjungan,'instalasi_id'),
                    ), */
                    array(
						'header'=>'Ruangan',
                        'name'=>'ruanganterakhir_id',
                        'type'=>'raw',
						'value'=>function($data) {
							$r = RuanganM::model()->findByPk($data->ruanganterakhir_id);
							return $r->ruangan_nama;
						},
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'ruanganterakhir_id', 
                                CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                    'instalasi_id'=>array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI),
                                    'ruangan_aktif'=>true,
                                ), array(
                                    'order'=>'instalasi_id, ruangan_nama',
                                )), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --'))
                    ),
                    array(
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'$data->carabayar_nama',
                        'filter'=>CHtml::activeDropDownList($modDialogKunjungan, 'carabayar_nama', 
                                CHtml::listData(CarabayarM::model()->findAllByAttributes(array(
                                    'carabayar_aktif'=>true,
                                ), array(
                                    'order'=>'carabayar_nama',
                                )), 'carabayar_nama', 'carabayar_nama'), array('empty'=>'-- Pilih --'))
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end pendaftaran dialog =============
?>