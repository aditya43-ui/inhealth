<?php
    $this->breadcrumbs = array(
        'Ringkasan Masuk dan Keluar',
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <b>Ringkasan Masuk dan Keluar</b>
        </div>
    </div>
    <div class="panel-body">
      <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'frm-ringkasanmasukkeluar',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        ));
      ?>
      <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
      <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>

      <div class="panel panel-success panel-shadow">
          <div class="panel-heading">
              <div class="panel-title"><strong>Data Pasien</strong></div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Pasien','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'nama_pasien', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Lahir','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'tanggal_lahir', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Pendidikan','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'pendidikan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Pekerjaan','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'pekerjaan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Alamat Lengkap','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'alamat_pasien', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('No. Telepon','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Status Perkawinan','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'statusperkawinan', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Penanggungan Jawab Pembayar','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'nama_pj', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Keluarga Terdekat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'hubungankeluarga', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label('Alamat Keluarga Terdekat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'alamat_pj', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('No. Rekam Medik','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'no_rekam_medik', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Agama','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'agama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Jenis Pasien','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'carabayar_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div><div class="control-group ">
                    <?php echo CHtml::label('Ruang Rawat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'ruangan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Kelas','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'kelaspelayanan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Masuk','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Keluar','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasienPulang, 'tglpasienpulang', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Lama Dirawat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'lamarawat', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Diagnosa Masuk','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textArea($model, 'diagnosa_masuk', array('class'=>'span3')); ?>
                    </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="panel panel-success panel-shadow">
          <div class="panel-heading">
              <div class="panel-title"><strong>Data Ringkasan</strong></div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'tanggal_penginputan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tanggal_penginputan',
                            'mode'=>'datetime',
                            'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                        )); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'dokter_yangmerawat_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php 
                        
                            echo $form->hiddenField($model, 'dokter_yangmerawat_id', array('onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'dokter_yangmerawat_id'));
                            
                            $dokter_rawat_nama = empty($model->dokteryangmerawat) ? "" : $model->dokteryangmerawat->namaLengkap;
                            
                            // echo $form->hiddenField($model, 'dokter_yangmerawat_id', CHtml::listData(DokterV::model()->findAll('instalasi_id = 4'),'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3'));
                            $this->widget('MyJuiAutoComplete', array(
                                'name'=>'dokter_yangmerawat_nama',
                                'value'=>$dokter_rawat_nama,
                                'source'=>'js: function(request, response) {
                                        $.ajax({
                                        url: "'.$this->createUrl('autocompleteDokterRawat').'",
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
                                         $(".dokter_yangmerawat_nama").val(ui.item.label); 
                                         $(".dokter_yangmerawat_id").val(ui.item.pegawai_id); 
                                         return false;
                                     }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                'htmlOptions'=>array('class'=>'dokter_yangmerawat_nama span3'),
                            )); 
                        ?>
                    </div>
                </div>

                <div class="panel panel-default panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Diagnosa Akhir</div>
                    </div>
                    <div class="panel-body">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Kelompok Diagnosa</th>
                            <th>Klasifikasi Diagnosa</th>
                            <th>Nama Diagnosa</th>
                            <th>Kode Diagnosa</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(count($pasienMorbid) > 0){
                              foreach($pasienMorbid as $pasMorbid){
                                ?>
                                <tr>
                                  <td><?php echo (isset($pasMorbid->kelompokdiagnosa)?$pasMorbid->kelompokdiagnosa->kelompokdiagnosa_nama:""); ?></td>
                                  <td><?php echo (isset($pasMorbid->diagnosa)? (isset($pasMorbid->diagnosa->klasifikasidiagnosa)? $pasMorbid->diagnosa->klasifikasidiagnosa->klasifikasidiagnosa_nama : ""):""); ?></td>
                                  <td><?php echo (isset($pasMorbid->diagnosa)?$pasMorbid->diagnosa->diagnosa_nama:""); ?></td>
                                  <td><?php echo (isset($pasMorbid->diagnosa)?$pasMorbid->diagnosa->diagnosa_kode:""); ?></td>
                                </tr>
                                <?php
                              }
                            }
                           ?>
                        </tbody>
                      </table>
                    </div>
                </div>

                <div class="panel panel-default panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Data Operasi</div>
                    </div>
                    <div class="panel-body">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Tanggal Operasi</th>
                            <th>Nama Operasi</th>
                            <th>Golongan Operasi</th>
                            <th>Jenis Anastesi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(count($modRencanaOperasi) > 0){
                              foreach($modRencanaOperasi as $rencanaOp){
                                ?>
                                <tr>
                                  <td><?php echo MyFormatter::formatDateTimeForUser($rencanaOp->tglrencanaoperasi); ?></td>
                                  <td><?php echo (isset($rencanaOp->operasi)? $rencanaOp->operasi->operasi_nama:""); ?></td>
                                  <td><?php echo (isset($rencanaOp->golonganoperasi)?$rencanaOp->golonganoperasi->golonganoperasi_nama:""); ?></td>
                                  <td><?php echo (isset($rencanaOp->pasienanastesi)? (isset($rencanaOp->pasienanastesi->jenisanastesi)?$rencanaOp->pasienanastesi->jenisanastesi->jenisanastesi_nama : ""):""); ?></td>
                                </tr>
                                <?php
                              }
                            }
                           ?>
                        </tbody>
                      </table>
                    </div>
                </div>
                
                <div class="control-group " style="padding-top: 10px !important;">
                    <?php echo $form->labelEx($model,'infeksinosokomial', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'infeksinosokomial', array('onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Imunisasi yang pernah didapat','', array('class'=>'control-label','style'=>'width: 180px')) ?>
                </div>
                <div class="control-group ">
                    <div class="controls">
                      <div class="radio inline">
                        <div class="form-inline">
                          <?php 
                          $item = LookupM::getItems('imunisasididapat');

                          foreach ($item as $idx => $res) {
                            if (empty($res)) unset($item[$idx]);
                          }

                          echo $form->checkBoxList($model, 'imunisasididapat',$item, array(
                              'template' => '<div style="display: inline-block; width: 100px;">{input} {label}</div>',
                              'onkeypress' => "return $(this).focusNextInputField(event);", 'uncheckValue'=>null,
                          )); ?>
                        </div>
                      </div>

                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Pengobatan Radio Terapi / Kedokteran Nuklir','', array('class'=>'control-label','style'=>'width: 250px')) ?>
                </div>
                <div class="control-group ">
                    <div class="controls" style="width: 100%">
                       <?php echo $form->textArea($model, 'pengobatanradioterapi', array('class'=>'')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'carakeluar_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->dropDownList($model, 'carakeluar_id', CHtml::listData(CarakeluarM::model()->findAll('carakeluar_aktif = true'),'carakeluar_id','carakeluar_nama'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Alergi','', array('class'=>'control-label','style'=>'width: 50px')) ?>
                </div>
                <div class="control-group ">
                    <div class="controls" style="width: 100%">
                       <?php echo $form->textArea($model, 'alergipasien', array('class'=>'')); ?>
                    </div>
                </div>

              </div>
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'carapenerimaan', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->dropDownList($model, 'carapenerimaan', LookupM::getItems('carapenerimaan'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'caramasuk', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->dropDownList($model, 'caramasuk', LookupM::getItems('caramasuk'), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                    </div>
                </div>

                <div class="panel panel-default panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Sebeb Kekerasan/Kecelakaan/Keracunan</div>
                    </div>
                    <div class="panel-body">
                      <div class="control-group ">
                          <?php echo $form->labelEx($model,'komplikasi', array('class'=>'control-label')) ?>
                          <div class="controls">
                             <?php echo $form->textArea($model, 'komplikasi', array('onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                          </div>
                      </div>
                      <div class="control-group ">
                          <?php echo $form->labelEx($model,'patologi', array('class'=>'control-label')) ?>
                          <div class="controls">
                             <?php echo $form->textArea($model, 'patologi', array('onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                          </div>
                      </div>
                    </div>
                </div>

                <div class="panel panel-default panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Data Tindakan</div>
                    </div>
                    <div class="panel-body">
                        <?php 
                        $tindakan = new TindakanpelayananT;
                        $tindakan->unsetAttributes();
                        $tindakan->pendaftaran_id = $model->pendaftaran_id;
                        $tindakan->pasienadmisi_id = $model->pasienadmisi_id;
                        
                        if (isset($_GET['TindakanpelayananT'])) {
                            $tindakan->attributes = $_GET['TindakanpelayananT'];
                        }
                        
                        
                        $prov_tindakan = $tindakan->searchTindakanNamaPasien();
                        $prov_tindakan->sort->defaultOrder = 'tgl_tindakan desc';
                        
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'tindakan-grid',
                            'dataProvider' => $prov_tindakan,
                            'filter' => $tindakan,
                            'template' => "{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'Pilih',
                                    'type' => 'raw',
                                    'value' => function($data) use ($model) {
                            
                                        $nilai = true;
                                        if (empty($model)) {
                                            $nilai = false;
                                            
                                        } else if (empty($model->tindakanyangdipilih)) {
                                            $nilai = false;
                                        } else if (!is_array($model->tindakanyangdipilih)) {
                                            $nilai = false;
                                        } else if (empty($model->tindakanyangdipilih[$data->tindakanpelayanan_id])) {
                                            $nilai = false;
                                        } else if ($model->tindakanyangdipilih[$data->tindakanpelayanan_id] != 1) {
                                            $nilai = false;
                                        }
                                        
                                        return CHtml::checkBox('pilih_tindakan', $nilai, array('class'=>'pilih_tindakan_'.$data->tindakanpelayanan_id." cb_pilih_tindakan", "value"=>$data->tindakanpelayanan_id));
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;',
                                    ),
                                ),
                                array(
                                    'header' => 'Tanggal Tindakan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        return MyFormatter::formatDateTimeForUser($data->tgl_tindakan);
                                    }
                                ),
                                array(
                                    'name' => 'daftartindakanNama',
                                    'header' => 'Pemeriksaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        return $data->daftartindakan->daftartindakan_nama;
                                    }
                                ),
                                array(
                                    'header' => 'Pemeriksa',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        return empty($data->dokter1) ? "-" : $data->dokter1->namaLengkap;
                                    }
                                ),

                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); loadPilihTindakan(); setEventPilihTindakan();}',
                        ));
                        ?>
                        
                    </div>
                </div>
                <div class="control-group " style="padding-top: 10px !important;">
                    <?php echo $form->labelEx($model,'penyebabinfeksi', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'penyebabinfeksi', array('onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Imunisasi yang diperoleh selama dirawat','', array('class'=>'control-label','style'=>'width: 250px')) ?>
                </div>
                <div class="control-group ">
                    <div class="controls" style="width: 100%">
                       <?php echo $form->textArea($model, 'imunisasidirawatinap', array()); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'transfusidarah', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'transfusidarah', array('onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?> cc
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'golongandarah', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'golongandarah', array('onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Catatan Keluar','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->dropDownList($model, 'catatankeluar', array(), array('empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3')); ?>
                    </div>
                </div>
              </div>
            </div>
          </div>
      </div>
        <?php 
        $model->tindakanyangdipilih = CJSON::encode($model->tindakanyangdipilih);
        echo $form->hiddenField($model, 'tindakanyangdipilih', array('class'=>'input_tindakanyangdipilih'));
        
        ?>
      <div class="row-fluid">
          <div class="form-actions">
              <?php
                $disableSimpan = (isset($_GET['sukses'])? true: false);

                  echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disableSimpan));
                  echo "&nbsp;";
                  echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                      $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                      array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
                          echo "&nbsp;";
                  echo CHtml::link(Yii::t('mds', '{icon} Print Ringkasan Masuk dan Keluar', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();",'disabled'=>(($disableSimpan==true)?false:true)));
              ?>
              <?php
                  $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                  $this->widget('UserTips',array('type'=>'admin','content'=>$content));
              ?>
          </div>
      </div>

      <?php $this->endWidget(); ?>
    </div>
  </div>
  <script type="text/javascript">
    function print()
    {
      var ringkasanmasukdankeluar_id = '<?php echo (isset($_GET['ringkasanmasukdankeluar_id'])? $_GET['ringkasanmasukdankeluar_id'] : "") ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id='+ringkasanmasukdankeluar_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
  </script>
  
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modDokter = new RIDokterV('searchDialogDokter');
$modDokter->unsetAttributes();
if (isset($_GET['RIDokterV'])) {
    $modDokter->attributes = $_GET['RIDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogDokter(),
    'filter' => $modDokter,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawai",
					"onClick"=>"$(\"#' . CHtml::activeId($model, 'dokter_yangmerawat_id') . '\").val(\"$data->pegawai_id\");
							$(\".dokter_yangmerawat_nama\").val(\"$data->NamaLengkap\");
							$(\"#dialogDokter\").dialog(\"close\");
							return false;"
					))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'value' => '$data->NamaLengkap',
            'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                    
                if (!empty($j)){
                    return $j->jabatan_nama;
                }else{
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll('jabatan_aktif = TRUE ORDER BY jabatan_nama ASC'), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),        
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); }',
));
$this->endWidget();
?>

  <script>
      
      <?php if ($model->tindakanyangdipilih == "null") : ?>
      var data_pilih = {};
      <?php else: ?>
      var data_pilih = <?php echo $model->tindakanyangdipilih; ?>;
      <?php endif; ?>
      function ceklisPilihTindakan() {
          data_pilih[$(this).val()] = $(this).is(":checked") ? 1 : 0;
          $(".input_tindakanyangdipilih").val(JSON.stringify(data_pilih));
      }
      
      function setEventPilihTindakan() {
          $("#tindakan-grid .cb_pilih_tindakan").on("click", ceklisPilihTindakan);
      }
      
      function loadPilihTindakan() {
          console.log("loader");
          $.each(data_pilih, function(idx, v) {
//              console.log("Kick");
//              console.log(idx, v, $("#tindakan-grid .pilih_tindakan_" + idx));
              if (v == 1) {
                  $("#tindakan-grid .pilih_tindakan_" + idx).attr("checked", true);
              } else {
                  $("#tindakan-grid .pilih_tindakan_" + idx).attr("checked", false);
              }
          });
      }
      
      $(document).ready(function() {
          setEventPilihTindakan();
      });
      
  </script>