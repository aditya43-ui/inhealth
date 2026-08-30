<?php
    $this->breadcrumbs = array(
        'Kriteria Masuk ICU',
    );

?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title"><strong>Kriteria Masuk ICU</strong></div>
	</div>
	<div class="panel-body">
    <?php
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
     ?>
     <div class="panel panel-success">
         <div class="panel-heading">
             <div class="panel-title"><strong>Riwayat</strong></div>
         </div>
         <div class="panel-body">
             <?php echo $this->renderPartial($this->path_view.'_riwayat', array('modPendaftaran'=>$modPendaftaran)); ?>
         </div>
     </div>
<style>
  .tab {
  display: none;
}

button {
  background-color: #04AA6D;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
}

.step.active {
  opacity: 0.5;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
}
</style>
     <?php
     $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
         'id' => 'kriteriamasukicu-t-form',
         'enableAjaxValidation' => false,
         'type' => 'horizontal',
         'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
     ));
     ?>
     <?php echo $form->hiddenField($model,'pendaftaran_id'); ?>
     <?php echo $form->hiddenField($model,'pasienadmisi_id'); ?>
<br><br>

     <div class="row">
       <div class="col-sm-6">
         <div class="control-group ">
             <?php echo $form->labelEx($model, 'tanggal_pemeriksaan', array('class' => 'control-label')) ?>
             <div class="controls">
                 <?php
                 $this->widget('MyDateTimePicker', array(
                     'model' => $model,
                     'attribute' => 'tanggal_pemeriksaan',
                     'value' => null,
                     'mode' => 'date',
                     'options' => array(
                         'dateFormat' => Params::DATE_FORMAT,
                         'maxDate' => 'd',
                     ),
                     'htmlOptions' => array(
                         'readonly' => true,
                         'onkeypress' => "return $(this).focusNextInputField(event)",
                         'class' => 'span3',
                     ),
                 ));
                 ?>
             </div>
         </div>
       </div>
       <div class="col-sm-6">
         <div class="control-group">
             <?php echo $form->labelEx($model,'petugas_pemeriksa', array('class'=>'control-label')) ?>
             <div class="controls">
                 <?php
                 $this->widget('MyJuiAutoComplete',array(
                     'model'=>$model,
                     'attribute'=>'petugas_pemeriksa',
                     'source' => 'js: function(request, response) {
                         $.ajax({
                             url: "' . $this->createUrl('autocompletePetugasRuangan') . '",
                             dataType: "json",
                             data: {
                                 term: request.term,
                                 tipe: 1,
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
                             $("#'.CHtml::activeId($model, 'petugas_pemeriksa') . '").val(ui.item.label);
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
     </div>
 
        <div class="row-fluid">
            <div class="col-sm-12">
                <div class="form-wizard form-required-wizard" id="rootwizardICU">
                    <div class="steps-progress">
                      <div class="progress-indicator"></div>
                    </div>

                <ul>
                    <li class="step" >
                            <a href="#done1" data-toggle="tab"><span>1</span>Kardiovaskular</a>
                    </li>
                    <li class="step">
                            <a href="#done2" data-toggle="tab"><span>2</span>Respirasi</a>
                    </li>
                    <li class="step">
                        <a href="#done3" data-toggle="tab"><span>3</span><?php echo "Gastroinestina"; ?></a>
                    </li>
                    <li class="step">
                        <a href="#done4" data-toggle="tab"><span>4</span><?php echo "Renal"; ?></a>
                    </li>
                    <li class="step">
                        <a href="#done5" data-toggle="tab"><span>5</span>Endokri</a>
                    </li>
                    <li class="step">
                        <a href="#done6" data-toggle="tab"><span>6</span>Hematologi</a>
                    </li>
                    <li class="step">
                        <a href="#done7" data-toggle="tab"><span>7</span>Saraf Pusat</a>
                    </li>
                    <li class="step">
                        <a href="#done8" data-toggle="tab"><span>8</span>Sepsis dan Syok Sepsis</a>
                    </li>
                    <li class="step">
                        <a href="#done9" data-toggle="tab"><span>9</span>Pemantauan sebelum dan sesudah pembedahan</a>
                    </li>
                    <li class="step">
                        <a href="#done10" data-toggle="tab"><span>10</span>Luka Bakar</a>
                    </li>
                    <li class="step" >
                        <a href="#end" data-toggle="tab"><span><?php echo "11"; ?></span><?php echo "Gangguan kondisi lain"; ?></a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active">
			                   <?php
                           $this->renderPartial($this->path_view.'kriteria/_formKardiovaskular',array(

                               'form'=>$form,'model'=>$model));
                          ?>
                    </div>
                   <div class="tab-pane">
                     <?php
                       $this->renderPartial($this->path_view.'kriteria/_formRespirasi',array('form'=>$form,'model'=>$model));
                      ?>
                    </div>
                    <div class="tab-pane">
                        <?php $this->renderPartial($this->path_view.'kriteria/_formGastro',array('form'=>$form,'model'=>$model)) ?>
                    </div>
                    <div class="tab-pane">
                      <?php
                          $this->renderPartial($this->path_view.'kriteria/_formRenal',array('form'=>$form,'model'=>$model));
                       ?>
                    </div>
                    <div class="tab-pane">
                        <?php $this->renderPartial($this->path_view.'kriteria/_formEndokri',array('form'=>$form,'model'=>$model)) ?>
                    </div>
                    <div class="tab-pane">
                      <?php
                        $this->renderPartial($this->path_view.'kriteria/_formHematologi',array('form'=>$form,'model'=>$model));
                       ?>
                    </div>
                    <div class="tab-pane">
                      <?php
                        $this->renderPartial($this->path_view.'kriteria/_formSaraf',array('form'=>$form,'model'=>$model));
                       ?>
                    </div>
                    <div class="tab-pane">
                      <?php
                        $this->renderPartial($this->path_view.'kriteria/_formSepsis',array('form'=>$form,'model'=>$model));
                       ?>
                    </div>
                      <div class="tab-pane">
                          <?php $this->renderPartial($this->path_view.'kriteria/_formPemantauan',array('form'=>$form,'model'=>$model)) ?>
                      </div>
                    <div class="tab-pane">
                        <?php $this->renderPartial($this->path_view.'kriteria/_formLuka',array('form'=>$form,'model'=>$model)) ?>
                    </div>
                    <div class="tab-pane">
                        <?php $this->renderPartial($this->path_view.'kriteria/_formGangguan',array('form'=>$form,'model'=>$model)) ?>
                    </div>

                    <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>

                </div>
                </div>
            </div>
        </div>

    

     <div class="row-fluid">
         <div class="form-actions">
             <?php
               $disabledSukses = (isset($_GET['sukses'])? true:false);
                 echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>$disabledSukses));
                 echo "&nbsp;";
                 echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                     $this->createUrl($this->id.'/index', array('pendaftaran_id'=>$_GET['pendaftaran_id'],'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""))),
                     array('class'=>'btn btn-danger',
                         'onclick'=>'return refreshForm(this);'));

                   // $kriteriamasukicu_id = (isset($_GET['kriteriamasukicu_id'])? $_GET['kriteriamasukicu_id']:"");
                   // echo "&nbsp;". CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print('.$kriteriamasukicu_id.');', 'disabled'=>(($disabledSukses==true)?false:true)));
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

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>
<?php $this->renderPartial('kriteria/_jsFunctionsKriteria',array('model'=>$model)); ?>


<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Pencarian Petugas',
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
                "onClick"=>"$(\"#' . CHtml::activeId($model, 'petugas_pemeriksa') . '\").val(\"$data->namaLengkap\");
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
