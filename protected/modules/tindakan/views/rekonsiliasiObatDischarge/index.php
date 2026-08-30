<style type="text/css">
    .text-center{
        text-align: center !important;
    }
</style>
<?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    }
    $this->widget('bootstrap.widgets.BootAlert');
?>


<div class="panel panel-gradient">
  <div class="panel-heading">
      <div class="panel-title"><b>Form Rekonsiliasi Obat</b></div>
  </div>
  <div class="panel-body">
    <?php
      $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
          'id' => 'rekonsiliasiobatdischarge-t-form',
          'enableAjaxValidation' => false,
          'type' => 'horizontal',
          'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit'=>'return requiredCheck(this);'),
      ));
    ?>
    <?php echo $form->hiddenField($model, 'pendaftaran_id'); ?>
    <?php echo $form->hiddenField($model, 'pasien_id'); ?>
    <?php echo $form->hiddenField($model, 'pasienadmisi_id'); ?>
    <div class="row">
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::activeLabelEx($model, 'tanggal_pengisian', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker', array(
                  'model' => $model,
                  'attribute' => 'tanggal_pengisian',
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
        <div class="control-group ">
            <?php echo CHtml::label("Petugas Pengisi <font style='color:red;'>*</font>", 'dokter_pengisi', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php echo $form->hiddenField($model, 'petugas_id', array('class'=>'pegawai')); ?>
              <?php
              $this->widget('MyJuiAutoComplete', array(
                  'model'=>$model,
                  'attribute' => 'petugas_nama',
                  'source' => 'js: function(request, response) {
                      $.ajax({
                          url: "' . $this->createUrl('AutocompletePegawaiRuangan') . '",
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
                      'minLength' => 2,
                      'focus' => 'js:function( event, ui ) {
                          $(this).val( ui.item.label);
                          return false;
                      }',
                      'select' => 'js:function( event, ui ) {
                          $("#'.Chtml::activeId($model, 'petugas_id') . '").val(ui.item.pegawai_id);
                          return false;
                      }',
                  ),
                  'htmlOptions' => array(
                      'class'=>'span3',
                      'onkeyup' => "return $(this).focusNextInputField(event)",
                      'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'petugas_id') . '").val(""); '
                  ),
                  'tombolDialog' => array('idDialog' => 'dialogPetugas'),
              ));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::activeLabelEx($model, 'rujukansebelumnya', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php echo $form->dropDownList($model,'rujukansebelumnya', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true and instalasi_id = '.Params::INSTALASI_ID_RI.' ORDER BY ruangan_nama ASC'),'ruangan_nama','ruangan_nama'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100,'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::activeLabelEx($model, 'rujukanke', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php echo $form->dropDownList($model,'rujukanke', LookupM::getItems("rekonsiliasirujukandischarge"),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100,'class'=>'span3')); ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-pjpasien',
            'content'=>array(
              'content-pjpasien'=>array(
                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan penanggung jawab pasien')).'<b> Penanggung Jawab Pasien</b>',
                'isi'=>$this->renderPartial($this->path_view.'_formPenanggungJawabPasien',array(
                    'form'=>$form,
                    'modPenanggungJawab'=>$modPenanggungJawab,
                    ),true),
                'active'=>true,
              ),
            ),
        )); ?>
      </div>
      <div class="clear"></div>
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Obat', 'nama_obat', array('class' => 'control-label')); ?>
            <div class="controls">
              <div id="obat_original">
                <?php
                   echo CHtml::textField('nama_obat', '',array('class'=>'span3','maxlength'=>'100'));
                ?>
              </div>
              <div id="obat_pelayanan">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'id'=>'namaobat_pel',
                    'name'=>'namaobat_pel',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('AutocompleteObatPelayanan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                pendaftaran_id: '.$model->pendaftaran_id.',
                                '.(!empty($model->pasienadmisi_id)? 'pasienadmisi_id: '.$model->pasienadmisi_id.",": "").'
                                '.((Yii::app()->user->getState("ruangan_id") != 59)? 'instalasi_id: '.Yii::app()->user->getState("instalasi_id").",": "").'
                                '.((Yii::app()->user->getState("ruangan_id") != 59)? 'ruangan_nama: "'.Yii::app()->user->getState("ruangan_nama").'"': "").'
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#namaobat_pel").val(ui.item.value);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class'=>'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#namaobat_pel").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObatPel'),
                ));
                ?>
              </div>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
              <div class="checkbox">
                <?php
                   echo CHtml::checkBox('ischeckObat', false,array('onchange'=>'setChangeCekObat();'));
                ?>
                <label>Menggunakan Data Obat Pasien</label>
              </div>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Dosis', 'dosis', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('dosis', '',array('class'=>'span3','maxlength'=>'100'));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Frekuensi', 'frekuensi', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('frekuensi', '',array('class'=>'span3','maxlength'=>'100'));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Cara Pemberian', 'cara_pemberian', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('cara_pemberian', '',array('class'=>'span3','maxlength'=>'100'));
              ?>
            </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Waktu Pemberian Terakhir', 'waktu_pemberian', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
              $this->widget('MyDateTimePicker', array(
                  'id' => 'waktu_pemberian',
                  'name' => 'waktu_pemberian',
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
        <div class="control-group ">
            <?php echo CHtml::label('Jumlah', 'jumlah_obat', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textField('jumlah_obat', '',array('class'=>'span3','maxlength'=>'100'));
              ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Tindak Lanjut', 'frekuensi', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php echo CHtml::dropDownList('tindaklanjut','', LookupM::getItems("tindaklanjut"),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength' => 100,'class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Keterangan', 'keterangan', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php
                 echo CHtml::textArea('keterangan', '',array('class'=>'span3','maxlength'=>'100'));
              ?>
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
    <div style="overflow: auto;">
      <table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblObat">
        <thead>
          <tr>
              <th style="width:200px">Nama Obat</th>
              <th style="width:200px">Frekuensi</th>
              <th style="width:10px">Dosis</th>
              <th style="width:200px">Cara Pemberian</th>
              <th style="width:200px">Waktu Pemberian</th>
              <th style="width:100px">Jumlah</th>
              <th style="width:200px">Tindak Lanjut</th>
              <th style="width:100px">Diteruskan dari Transfer</th>
              <th style="width:80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            if(count($detailRekObatTransfer)>0){
                $htmlRekTransfer = "";
              foreach ($detailRekObatTransfer as $i => $dataRekTransfer) {
                $dataRekTransfer->waktu_pemberian = (!empty($dataRekTransfer->waktu_pemberian)? MyFormatter::formatDateTimeForUser($dataRekTransfer->waktu_pemberian): "");
                $htmlRekTransfer .= "<tr>";
                $htmlRekTransfer .= "<td>";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_nama_obat' name='RekonobattransferdetT[".$i."][nama_obat]' class='nama_obat' value='".$dataRekTransfer->nama_obat."' />";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_dosis' name='RekonobattransferdetT[".$i."][dosis]' class='dosis' value='".$dataRekTransfer->dosis."' />";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_frekuensi' name='RekonobattransferdetT[".$i."][frekuensi]' class='frekuensi' value='".$dataRekTransfer->frekuensi."' />";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_cara_pemberian' name='RekonobattransferdetT[".$i."][cara_pemberian]' class='cara_pemberian' value='".$dataRekTransfer->cara_pemberian."' />";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_waktu_pemberian' name='RekonobattransferdetT[".$i."][waktu_pemberian]' class='waktu_pemberian' value='".$dataRekTransfer->waktu_pemberian."' />";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_jumlah_obat' name='RekonobattransferdetT[".$i."][jumlah_obat]' class='jumlah_obat' value='".$dataRekTransfer->jumlah_obat."' />";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_tindaklanjut' name='RekonobattransferdetT[".$i."][tindaklanjut]' class='tindaklanjut' value='".$dataRekTransfer->tindaklanjut."' />";
                $htmlRekTransfer .= "<input type='hidden' id='RekonobattransferdetT_".$i."_keterangan' name='RekonobattransferdetT[".$i."][keterangan]' class='keterangan' value='".$dataRekTransfer->keterangan."' />";
                $htmlRekTransfer .= "<span>".$dataRekTransfer->nama_obat."</span>";
                $htmlRekTransfer .= "</td>";
                $htmlRekTransfer .= "<td><span>".$dataRekTransfer->frekuensi."</span></td>";
                $htmlRekTransfer .= "<td><span>".$dataRekTransfer->dosis."</span></td>";
                $htmlRekTransfer .= "<td><span>".$dataRekTransfer->cara_pemberian."</span></td>";
                $htmlRekTransfer .= "<td><span>".$dataRekTransfer->waktu_pemberian."</span></td>";
                $htmlRekTransfer .= "<td><span>".$dataRekTransfer->jumlah_obat."</span></td>";
                $htmlRekTransfer .= "<td><span>".$dataRekTransfer->tindaklanjut."</span></td>";
                $htmlRekTransfer .= "<td style='text-align: center;'><span>Ya</span></td>";
                $htmlRekTransfer .= "<td style='text-align: center;'>";
                $htmlRekTransfer .= "<a onclick='batalObat(this);return false;'' rel='tooltip' href='javascript:void(0);'' title='Klik untuk membatalkan obat'><i class='icon-remove'></i></a>";
                $htmlRekTransfer .= "</td>";
                $htmlRekTransfer .= "</tr>";
              }
              echo $htmlRekTransfer;
            }
           ?>
        </tbody>
      </table>
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
    <?php $this->endWidget(); ?>
  </div>
</div>

<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>


<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV('searchDialogPegawai');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['PegawairuanganV'])){
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPegawai->searchDialogPegawai(),
    'filter'=>$modPegawai,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
      array(
          'header'=>'Pilih',
          'type'=>'raw',
          'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
              "href"=>"",
              "id" => "selectPegawai",
              "onClick" => "$(\"#'.CHtml::activeId($model,'petugas_id').'\").val(\"$data->pegawai_id\");
                            $(\"#'.CHtml::activeId($model,'petugas_nama').'\").val(\"$data->NamaLengkap\");
                            $(\"#dialogPetugas\").dialog(\"close\");
                            return false;
                  "))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name'=>'jeniskelamin',
            'filter'=> CHtml::dropDownList('GFPegawaiV[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'--Pilih--')),
            'value'=>'$data->jeniskelamin',
        ),

    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatPel',
    'options' => array(
        'title' => 'Data Obat Pelayanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modOa = new RJObatalkesPasienT('searchDialogOaPelayanan');
$modOa->unsetAttributes();
if(Yii::app()->user->getState('ruangan_id') != 59){
  $modOa->ruangan_nama = Yii::app()->user->getState('ruangan_nama');
  $modOa->pendaftaran_id = $model->pendaftaran_id;
  if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI){
      $modOa->pasienadmisi_id = $model->pasienadmisi_id;
  }
}else{
  $modOa->pendaftaran_id = $model->pendaftaran_id;
}

if(isset($_GET['RJObatalkesPasienT'])){
    $modOa->attributes = $_GET['RJObatalkesPasienT'];
    $modOa->obatalkes_kode = $_GET['RJObatalkesPasienT']['obatalkes_kode'];
    $modOa->obatalkes_nama = $_GET['RJObatalkesPasienT']['obatalkes_nama'];
    $modOa->obatalkes_namalain = $_GET['RJObatalkesPasienT']['obatalkes_namalain'];
    $modOa->ruangan_nama = (!empty($_GET['RJObatalkesPasienT']['ruangan_nama'])?$_GET['RJObatalkesPasienT']['ruangan_nama']:null);
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'oa-m-grid',
    'dataProvider'=>$modOa->searchDialogOaPelayanan(),
    'filter'=>$modOa,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
      array(
          'header'=>'Pilih',
          'type'=>'raw',
          'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
              "href"=>"",
              "id" => "selectPegawai",
              "onClick" => "$(\"#namaobat_pel\").val(\"$data->obatalkes_nama\");
                            $(\"#dialogObatPel\").dialog(\"close\");
                            return false;
                  "))',
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        'obatalkes_namalain',
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>
<?php $this->endWidget(); ?>
