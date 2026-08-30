<?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan !");
    }
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'seleksidonordarahtandavital-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'',
)); ?>
        <div class="panel-body">
            <?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly'=>true)); ?>
           <?php echo CHtml::activeHiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly'=>true)); ?>
 
          
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Seleksi Donor Darah</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-seleksi">
                        <div class="row-fluid">
                            <?php $this->renderPartial('_formSeleksi', array('form'=>$form,
                                'model'=>$model,
                                'modKuesioner'=>$modKuesioner,
                                'modPendonor'=>$modPendonor,
                                'modDaftarDonasi'=>$modDaftarDonasi,)); 
                            ?>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <?php echo $form->hiddenField($model,'is_gagalseleksiawal',array('readony'=>true))?>
                &nbsp;<?php echo $form->checkBox($model,'is_gagalseleksi',array('onclick'=>'gagalSeleksi(this)','data-toggle' => 'tooltip', 'title' => 'Klik jika pendonor gagal seleksi')); ?> <label>Cek jika pendonor darah ditolak atau gagal</label>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Alasan Ditolak/ Gagal Seleksi</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-gagalseleksi">
                        <div class="row-fluid">
                            <?php $this->renderPartial('_formGagalSeleksi', array('form'=>$form,
                                'model'=>$model,
                                'modKuesioner'=>$modKuesioner,
                                'modPendonor'=>$modPendonor,
                                'modDaftarDonasi'=>$modDaftarDonasi,)); 
                            ?>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title"><span class='judul'>Catatan Dokter</span></div>
                </div>
                <div class="panel-body">
                    <fieldset  id="form-gagalseleksi">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="control-group">
                                    <?php echo CHtml::activeLabel($model, 'catatan_dokter', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo CHtml::activeTextArea($model, 'catatan_dokter', array('readonly'=>false,'class'=>'span4')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tanggal Seleksi <span class='required'>*</span>", 'detaknadi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php   
                                $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'tglseleksidonor',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('class'=>'dtPicker3 span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
                                )); 
                                ?>
                            </div>
                        </div>
                       <div class="control-group">
                      <?php echo CHtml::label('Nama Petugas','Nama Petugas',array('class'=>'control-label'));?>
                        <div class="controls">
                            <?php $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id); ?>
                            <?php $modPegawai = PegawaiM::model()->findByPk($modLogin->pegawai_id); ?>
                         <?php echo CHtml::textField('nama_petugas',isset($modPegawai) ? $modPegawai->nama_pegawai : " ",array('readonly'=>true))?>
                        <?php echo $form->hiddenField($model,'petugas_id',array('readonly'=>true,'value'=>$modPegawai->pegawai_id))?>
                        </div>
                        </div>
                    </div>
                    <div class="span6">
                      <div class="control-group">
                        <?php echo CHtml::label('Nama DPJP <span class="required">*</span>','',array('class'=>'control-label')); ?>
                            <div class="controls">
                            <?php 
                            if(empty($model->dokter_id)){
                                $cekSeleksi = 
                                $model->dokter_id = $model->dpjpkuesioner_id;
                                $cekDPJP = PegawaiM::model()->findByPk($model->dpjpkuesioner_id);
                                if(!empty($cekDPJP)){
                                    $model->dokter_nama = $cekDPJP->nama_pegawai;
                                }
                            }
                            echo $form->hiddenField($model,'dokter_id',array('class'=>'span3 required')) ?>
                            <?php 
                                  $this->widget('MyJuiAutoComplete', array(
                                    'name'=>'dokter_nama',
                                    'value'=>isset($model->dokter_id) ? $model->dokter_nama : '',
                                    'source'=>'js: function(request, response) {
                                       $.ajax({
                                           url: "'.$this->createUrl('AutocompletePetugas').'",
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
                                    'minLength' => 3,
                                                'focus'=> 'js:function( event, ui ) {
                                                    $(this).val("");
                                                    return false;
                                                }',
                                    'select'=>'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#dokter_nama").val(ui.item.nama_pegawai);
                                            $("#'.CHtml::activeId($model,'dokter_id').'").val(ui.item.pegawai_id);
                                            return false;
                                    }',
                                    ),
                                    'htmlOptions'=>array(
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'class'=>'span3 required',
                                    ),
                                    'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                )); 
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
                        if(!isset($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'submit','onkeypress'=>'formSubmit(this,event);'));
                            echo "&nbsp;";
                            
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('disabled'=>true,'id'=>'btn_submit','class'=>'btn btn-primary', 'type'=>'submit','onkeypress'=>'formSubmit(this,event);'));
                            echo "&nbsp;";
                           
                        }
                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '#', 
                        array('class'=>'btn btn-danger',
                            'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index',array('pendonor_id'=>$model->pendonor_id,'daftardonasi_id'=>$model->daftardonasi_id)).'";} ); return false;'));
                        echo "&nbsp;";
                        $content = $this->renderPartial('laboratorium.views.pemakaianBahan.tips.tipsPemakaianBahan',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                        ?>
                    </div>
                </div>
            </div>
            
    </div>
                

<?php $this->endWidget(); ?>
<?php
    //========= Dialog buat cari Petugas ==========
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPetugas',
        'options' => array(
            'title' => 'Daftar Petugas',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));

    $modPegawai = new PegawairuanganV('searchPegawaiCRU');
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawairuanganV']))
        $modPegawai->attributes = $_GET['PegawairuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'petugassample-m-grid',
        'dataProvider' => $modPegawai->searchPegawaiCRU(),
        'filter' => $modPegawai,
        'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($model, 'petugas_id') . '\').val(\'$data->pegawai_id\');	
						$(\'#petugas_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogPetugas\').dialog(\'close\');
						return false;"))',
            ),
             array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
     //========= Dialog buat cari Petugas ==========
    ?>
    
    <?php
    //========= Dialog buat cari Petugas ==========
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDokter',
        'options' => array(
            'title' => 'Daftar Dokter',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));

    $modPegawai = new PegawairuanganV('searchDokter');
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawairuanganV']))
        $modPegawai->attributes = $_GET['PegawairuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dokter-m-grid',
        'dataProvider' => $modPegawai->searchDokter(),
        'filter' => $modPegawai,
        'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($model, 'dokter_id') . '\').val(\'$data->pegawai_id\');	
						$(\'#dokter_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogDokter\').dialog(\'close\');
						return false;"))',
            ),
             array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
     //========= Dialog buat cari Petugas ==========
    ?>

 <?php $this->renderPartial('_jsFunctionTransaksi', array('form'=>$form,
                                'model'=>$model,
                                'modKuesioner'=>$modKuesioner,
                                'modPendonor'=>$modPendonor,
                                'modDaftarDonasi'=>$modDaftarDonasi,)); 
                            ?>