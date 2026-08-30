<?php
    $this->breadcrumbs = array(
        'Perhitungan Balance Cairan dalam 24 Jam',
    );
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>
<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .integer2, .float2, .integer-decimal, .integer-decimal-3{
      text-align: right !important;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title" style="width: 100%">
            <span style="float: left !important; width:80% !important;"><b>Perhitungan Balance Cairan dalam 24 Jam</b></span><span style="float: right !important;">
               <?php
                if (!empty(Yii::app()->request->urlReferrer)) {
                    echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', Yii::app()->request->urlReferrer, array('class'=>'btn btn-red', 'style'=>'color: white;'));
                } ?>
            </span>
        </div>
    </div>
    <div class="panel-body">
      <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
          'id'=>'rw-balancairan',
          'content'=>array(
            'content-pjpasien'=>array(
              'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan Cairan Masuk, Cairan keluar dan IWL Tanggal '.$model->balancecairan_tanggal)).'<b> Cairan Masuk, Cairan Keluar dan IWL Tanggal '.$model->balancecairan_tanggal.'</b>',
              'isi'=>$this->renderPartial($this->path_view.'_riwayatBalanceCairan',array(
                  'model'=>$model,
                  ),true),
              'active'=>true,
            ),
          ),
      )); ?>

      <?php
      $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
          'id' => 'perhitunganbalancecairan-t-form',
          'enableAjaxValidation' => false,
          'type' => 'horizontal',
          'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
      ));
      ?>
      <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>

      <br/>
      <div class="panel panel-darkk">
          <span class="group-title">
              Perhitungan Balance Cairan
          </span>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'balancecairan_tanggal', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php echo $form->textField($model,'balancecairan_tanggal',array('class'=>'span3','readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'waktu_perhitungan', array('class' => 'control-label','label'=>'Tanggal & Jam Pencatatan')); ?>
                    <div class="controls">
                      <?php
                      $this->widget('MyDateTimePicker', array(
                          'model' => $model,
                          'attribute' => 'waktu_perhitungan',
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
                <div class="control-group ">
                    <?php echo CHtml::label("Petugas Pengisi <font style='color:red;'>*</font>", 'petugas_pengisi', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php
                      echo $form->hiddenField($model, 'petugaspengisi_id', array('onkeypress' => "return $(this).focusNextInputField(event);"));

                      $this->widget('MyJuiAutoComplete',array(
                          'model'=>$model,
                          'attribute'=>'petugaspengisi_nama',
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
                                  $("#'.CHtml::activeId($model, 'petugaspengisi_id') . '").val(ui.item.value);
                                  $("#'.CHtml::activeId($model, 'petugaspengisi_nama') . '").val(ui.item.label);
                                  return false;
                              }',
                          ),
                          'tombolDialog'=>array('idDialog'=>'dialogPetugas'),
                          'htmlOptions'=>array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')
                        ));
                      ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'totalcairanmasuk', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php echo $form->textField($model,'totalcairanmasuk',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?> <label>cc</label>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'totalcairankeluar', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php echo $form->textField($model,'totalcairankeluar',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?> <label>cc</label>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'totaliwl', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php echo $form->textField($model,'totaliwl',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?> <label>cc</label>
                    </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'balancecairan_sekarang', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php echo $form->textField($model,'balancecairan_sekarang',array('class'=>'span2 integer-decimal-3','readonly'=>true)); ?> <label>cc</label>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'balancecairan_sebelumnya', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php echo $form->textField($model,'balancecairan_sebelumnya',array('class'=>'span2 integer-decimal-3', 'onblur'=>'hituangKomulatif();')); ?> <label>cc</label>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::activeLabelEx($model, 'balancecairan_komulatif', array('class' => 'control-label')); ?>
                    <div class="controls">
                      <?php echo $form->textField($model,'balancecairan_komulatif',array('class'=>'span2 integer-decimal-3')); ?> <label>cc</label>
                    </div>
                </div>

              </div>
            </div>
            <div class="row-fluid">
                <div class="form-actions">
                  <?php
                    $disabledSimpan = (isset($_GET['sukses']) ? true: false);
                      echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekVerifikasi();', 'onkeypress'=>'cekVerifikasi();','id'=>'btn_simpan','disabled'=>$disabledSimpan));
                      echo "&nbsp;";
                      echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                          $this->createUrl($this->id.'/perhitunganBalanceCairan/&pasienadmisi_id='.$_GET['pasienadmisi_id'].'&tanggal_pencatatan='.$_GET['tanggal_pencatatan']),
                          array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'));
                  ?>
                </div>
            </div>

          </div>
      </div>

      <?php $this->endWidget(); ?>

      <div style="width: 70%; background-color:#bdedbc; padding: 10px; color: black;">
         Balance Cairan Sekarang (Dalam 24 Jam) = Total Cairan Masuk - (Total Cairan Keluar + Total IWL)<br/>
         dengan : <br/>
         Total Cairan Masuk/Keluar dan Total IWL adalah Total dalam 24 Jam
         <br/><br/>
         Balance Cairan Komulatif = Balance Cairan Sekarang + Balance Cairan Sebelumnya
      </div>

    </div>
</div>


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
                "onClick"=>"$(\"#' . CHtml::activeId($model, 'petugaspengisi_id') . '\").val(\"$data->pegawai_id\");
                            $(\"#' . CHtml::activeId($model, 'petugaspengisi_nama') . '\").val(\"$data->namaLengkap\");
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

<script type="text/javascript">
  function hituangTotalSekarang(){
    unformatNumberSemua();
    var totalcairanmasuk  = parseFloat($('#<?php echo CHtml::activeId($model,'totalcairanmasuk') ?>').val());
    var totalcairankeluar  = parseInt($('#<?php echo CHtml::activeId($model,'totalcairankeluar') ?>').val());
    var totaliwl  = parseFloat($('#<?php echo CHtml::activeId($model,'totaliwl') ?>').val());
    var total = (totalcairanmasuk - (totalcairankeluar + totaliwl));
    if (total > 0){
       total = parseFloat(total.toFixed(3));
    }

    $('#<?php echo CHtml::activeId($model,'balancecairan_sekarang') ?>').val(total);
    formatNumberSemua();
  }

  function hituangKomulatif(){
    unformatNumberSemua();
    var balancecairan_sekarang  = parseFloat($('#<?php echo CHtml::activeId($model,'balancecairan_sekarang') ?>').val());
    var balancecairan_sebelumnya  = parseInt($('#<?php echo CHtml::activeId($model,'balancecairan_sebelumnya') ?>').val());
    var total = (balancecairan_sekarang + balancecairan_sebelumnya);
    if (total > 0){
       total = parseFloat(total.toFixed(3));
    }

    $('#<?php echo CHtml::activeId($model,'balancecairan_komulatif') ?>').val(total);
    formatNumberSemua();
  }

  function cekVerifikasi(){
      if(requiredCheck($("form"))){
        $(".integer2, .float2, .integer-decimal, .integer-decimal-3").each(function(){
            $(this).val(unformatNumber($(this).val()));
        });
        $('#perhitunganbalancecairan-t-form').submit();

      }
      return false;

  }

  $(document).ready(function(){
    hituangTotalSekarang();
  });
</script>
