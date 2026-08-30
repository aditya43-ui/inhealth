<style type="text/css">
    .text-center{
        text-align: center !important;
    }
</style>
<?php
    $this->breadcrumbs = array(
        'Rekonsiliasi Obat',
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data Rekonsiliasi Obat berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php //$this->renderPartial($this->path_view.'_riwayatHasilPemeriksaan',array('model'=>$model)); ?>

<div class="panel panel-gradient">
  <div class="panel-heading">
      <div class="panel-title"><b>Rekonsiliasi Obat</b></div>
  </div>
  <div class="panel-body">
    <?php $this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran, 'modPasien'=>$modPasien)); ?>

    <?php
      $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
          'id' => 'rekonsiliasiobat-t-form',
          'enableAjaxValidation' => false,
          'type' => 'horizontal',
          'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
      ));
    ?>
    <?php echo $form->hiddenField($model, 'rekonsiliasiobat_id'); ?>
    <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
    <?php echo $form->hiddenField($model, 'pasien_id'); ?>

      <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Form Rekonsiliasi Obat</div>
        </div>
        <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label('Apakah Ada Alergi Obat?', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'isalergiobat', array(false=>'Tidak', true=>'Ya'), array('class'=>'span3','empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);", 'onchange'=>'changeIsAlergi(this)')); ?>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <?php echo $form->textAreaRow($model, 'namaobat', array('class'=>'span3', 'disabled'=>true)); ?>
              </div>
            </div>
            <br/>
          <div class="panel panel-primary panel-default">
            <div class="panel-heading">
                <div class="panel-title">Data Obat Yang Digunakan</div>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="control-group ">
                      <?php echo CHtml::activeLabelEx($model, 'tgl_pengisiandokter', array('class' => 'control-label')); ?>
                      <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_pengisiandokter',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
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
                </div>
                <div class="col-md-6">
                  <div class="control-group ">
                      <?php echo CHtml::label("Petugas Pengisi <font style='color:red;'>*</font>", 'dokter_pengisi', array('class' => 'control-label')); ?>
                      <div class="controls">
                          <?php echo $form->hiddenField($model, 'dokter_pengisi', array('class' => 'required')); ?>
                          <?php
                          $this->widget('MyJuiAutoComplete', array(
                              'model'=>$model,
                              'attribute' => 'dokter_pengisi_nama',
                              'source' => 'js: function(request, response) {
                                                 $.ajax({
                                                     url: "' . $this->createUrl('AutocompletePegawai') . '",
                                                     dataType: "json",
                                                     data: {
                                                         term: request.term,
                                                     },
                                                     success: function (data) {
                                                             response(data);
                                                     }
                                                 })
                                              }',
                              'options' => array(
                                  'showAnim' => 'fold',
                                  'minLength' => 3,
                                  'focus' => 'js:function( event, ui ) {
                                      $(this).val( ui.item.label);
                                      return false;
                                  }',
                                  'select' => 'js:function( event, ui ) {
                                      $("#'.Chtml::activeId($model, 'dokter_pengisi') . '").val(ui.item.pegawai_id);
                                      return false;
                                  }',
                              ),
                              'htmlOptions' => array(
                                  'class'=>'span3 pegawaimengetahui_nama required hurufs-only',
                                  'onkeyup'=>"return $(this).focusNextInputField(event)",
                                  'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'dokter_pengisi') . '").val(""); '
                              ),
                              'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                          ));
                          ?>
                      </div>
                  </div>
                </div>
              </div>
              <hr/>
              <div class="row">
                <div class="col-md-6">
                  <div class="control-group ">
                      <?php echo CHtml::label("Nama Obat", '', array('class' => 'control-label')); ?>
                      <div class="controls">
                        <?php echo CHtml::textField('namaobat','',array('class'=>'span3','maxlenght'=>'200')) ?>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label("Frekuensi dan Dosis", '', array('class' => 'control-label')); ?>
                      <div class="controls">
                        <?php echo CHtml::textField('frekuensi','',array('class'=>'span3','maxlenght'=>'100')) ?>
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="control-group ">
                      <?php echo CHtml::label("Rute", '', array('class' => 'control-label')); ?>
                      <div class="controls">
                        <?php echo CHtml::textField('rute','',array('class'=>'span3','maxlenght'=>'100')) ?>
                      </div>
                  </div>
                  <div class="control-group ">
                      <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
                      <div class="controls">
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                array('onclick'=>'tambahObat(this);return false;',
                                      'class'=>'btn btn-primary',
                                      'id'=>'tomboltambah',
                                      'onkeypress'=>"tambahObat(this);return false;",
                                      'rel'=>"tooltip",
                                      'title'=>"Klik untuk menambahkan ke tabel Obat")); ?>
                      </div>
                  </div>
                </div>
              </div>

              <br/>
              <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblObat">
                <thead>
                  <tr>
                      <th style="width:200px">Nama Obat</th>
                      <th style="width:200px">Frekuensi dan Dosis</th>
                      <th style="width:100px">Rute</th>
                      <th>Dilanjutkan saat admisi (checklist jika iya)</th>
                      <th style="width:80px">Batal</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
              <br/>
              <div class="row">

                  <div class="control-group">
                    <div class="col-md-4">
                      <?php echo CHtml::label("Tidak ada obat yang digunakan dalam 3(tiga) bulan Terakhir <font style='color:red;'>*</font>", '', array('class' => 'control-label required', 'style'=>'width: 100% !important;')); ?>
                    </div>
                    <div class="col-md-8">
                      <div class="controls">
                        <?php echo $form->dropDownList($model, 'obatdiapakai', array(false=>'Tidak', true=>'Ya'), array('class'=>'span2','empty'=>'-- Pilih --','onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                      </div>
                    </div>
                </div>

            </div>
          </div>

          <div class="row-fluid">
              <div class="form-actions">
                <?php
                    if(isset($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true));
                            echo "&nbsp;";
                    }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); //RND-8620
                            echo "&nbsp;";
                    }
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                        $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                        array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
                ?>
                <?php
                  $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                  $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                ?>
              </div>
          </div>
        </div>
      </div>
    <?php $this->endWidget(); ?>
  </div>
</div>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Dokter Pengisi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV('searchPegawaiRuangan');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState("ruangan_id");
if(isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-grid',
    'dataProvider'=>$modPegawaiMengetahui->searchPegawaiRuangan(),
    'filter'=>$modPegawaiMengetahui,
//        'template'=>"{items}\n{pager}",
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'dokter_pengisi').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($model,'dokter_pengisi_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\");
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'name' => 'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai' ,array('class' => 'numbers-only')),
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai' ,array('class' => 'hurufs-only')),
                    'name' => 'nama_pegawai',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Jabatan',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty'=>'-- Pilih --')),
                    'name' => 'jabatan_id',
                    'value'=>function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);

                        if (count($j)>0){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    },
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
            . '$(".numbers-only").keyup(function(){'
                . 'setNumbersOnly(this);'
            . '});'
            . '$(".hurufs-only").keyup(function(){'
                . 'setHurufsOnly(this);'
            . '});'
            . '}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
