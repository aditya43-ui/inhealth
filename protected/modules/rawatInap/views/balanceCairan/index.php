<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .integer2, .float2, .integer-decimal, .integer-decimal-3{

      text-align: right !important;
    }
</style>
<?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>

<?php $this->renderPartial($this->path_view.'_riwayat',array('modPendaftaran'=>$modPendaftaran)); ?>

<div class="panel panel-primary panel-gradient">
  <div class="panel-heading">
      <div class="panel-title"><strong>Form Balance Cairan</strong></div>
  </div>
  <div class="panel-body">
    <?php
      $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
          'id' => 'balancecairan-t-form',
          'enableAjaxValidation' => false,
          'type' => 'horizontal',
          'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
      ));
    ?>
    <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
    <?php echo $form->hiddenField($model, 'pasien_id'); ?>

    <div class="row">
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::activeLabelEx($model, 'tanggal_pencatatan', array('class' => 'control-label','label'=>'Tanggal & Jam Pencatatan')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker', array(
                  'model' => $model,
                  'attribute' => 'tanggal_pencatatan',
                  'mode' => 'datetime',
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
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label("Petugas Pengisi <font style='color:red;'>*</font>", 'petugas_pengisi', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              echo $form->hiddenField($model, 'petugas_pengisi', array('onkeypress' => "return $(this).focusNextInputField(event);"));

              $this->widget('MyJuiAutoComplete',array(
                  'model'=>$model,
                  'attribute'=>'petugas_pengisi_nama',
                  'source' => 'js: function(request, response) {
                      $.ajax({
                          url: "' . $this->createUrl('autocompletePetugasPengisi') . '",
                          dataType: "json",
                          data: {
                              term: request.term
                          },
                          success: function (data) {
                                  response(data);
                          }
                      })
                  }',
                  'options'=>array(
                      'showAnim'=>'fold',
                      'minLength'=>2,
                       'select' => 'js:function( event, ui ) {
                          $("#'.CHtml::activeId($model, 'petugas_pengisi') . '").val(ui.item.value);
                          $("#'.CHtml::activeId($model, 'petugas_pengisi_nama') . '").val(ui.item.label);
                          return false;
                      }',
                  ),
                  'tombolDialog'=>array('idDialog'=>'dialogPetugas'),
                  'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')
                ));
              ?>
            </div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="col-sm-12">
        <div class="control-group ">
            <?php echo CHtml::activeLabelEx($model, 'tindakan_pasien', array('class' => 'control-label')); ?>
            <div class="controls" style="width: 70%">
              <?php echo $form->textArea($model,'tindakan_pasien',array('class'=>'span3','style'=>'height: 100px; width: 100%')); ?>
            </div>
        </div>
      </div>
    </div>

    <?php $this->renderPartial($this->path_view.'_riwayatTandaVital',array('modPendaftaran'=>$modPendaftaran)); ?>
    <?php $this->renderPartial($this->path_view.'_formcairanmasuk',array('modPendaftaran'=>$modPendaftaran,'modDetCairanmasuk'=>$modDetCairanmasuk)); ?>
    <?php $this->renderPartial($this->path_view.'_formcairankeluar',array('modPendaftaran'=>$modPendaftaran,'modDetCairankeluar'=>$modDetCairankeluar)); ?>

    <?php $this->renderPartial($this->path_view.'_formiwl',array('modPendaftaran'=>$modPendaftaran)); ?>

    <div class="row">
      <div class="col-sm-6">
        <?php $this->renderPartial($this->path_view.'_formoksigen',array('modPendaftaran'=>$modPendaftaran,'modDetOksigen'=>$modDetOksigen)); ?>
      </div>
      <div class="col-sm-6">
        <?php $this->renderPartial($this->path_view.'_formdiet',array('modPendaftaran'=>$modPendaftaran,'modDetDiet'=>$modDetDiet)); ?>
      </div>
    </div>
    <?php $this->renderPartial($this->path_view.'_forminfus',array('modPendaftaran'=>$modPendaftaran, 'modDetInfus'=>$modDetInfus)); ?>

    <div class="row-fluid">
        <div class="form-actions">
          <?php
            $disabledSimpan = (isset($_GET['sukses']) ? true: false);
              echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekVerifikasi();', 'onkeypress'=>'cekVerifikasi();','id'=>'btn_simpan','disabled'=>$disabledSimpan));
              echo "&nbsp;";
              echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                  $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']),
                  array('class'=>'btn btn-danger',
                    'onclick'=>'return refreshForm(this);'));

              // echo "&nbsp;".CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'onclick'=>'print();', 'disabled'=>(($disabledSimpan==true)?false:true)));
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

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modPendaftaran'=>$modPendaftaran)); ?>


<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Petugas Pengisi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => false,
    ),
));


$modPegRuangan = new PegawairuanganV();
$modPegRuangan->unsetAttributes();
$modPegRuangan->ruangan_id = Yii::app()->user->getState("ruangan_id");

if (isset($_GET['PegawairuanganV'])) {
    $modPegRuangan->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dokteranastesi-m-grid',
    'dataProvider' => $modPegRuangan->search(),
    'filter' => $modPegRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#' . CHtml::activeId($model, 'petugas_pengisi') . '\").val(\"$data->pegawai_id\");
                            $(\"#' . CHtml::activeId($model, 'petugas_pengisi_nama') . '\").val(\"$data->namaLengkap\");
                            $(\"#dialogPetugas\").dialog(\"close\");
                            return false;"
                ))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegRuangan, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegRuangan, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
              $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
              return (!empty($jabatan)?$jabatan->jabatan_nama:"");
              },
            'filter' => Chtml::activeDropdownList($modPegRuangan, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama ASC'),'jabatan_id','jabatan_nama'),array('empty' => '-Pilih-'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
       $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });'
    . ''
    . '}',
));

$this->endWidget();
?>
