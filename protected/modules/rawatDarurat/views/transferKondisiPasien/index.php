<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }
</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'lembartransfer-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="pull-right" style="font-weight: bold; color: black;">RM RI 15.b REV 03</div>
        <br />
        <div class="panel panel-success panel-shadow" style="width: 900px">
            <div class="panel-heading">
                <div class="panel-title"><strong>Riwayat Kategori & Kondisi Pasien </strong></div>
            </div> 
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view.'_riwayat',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien)); ?>
            </div>
        </div>
        <div style="font-style: italic; color: red; font-weight: bold">Lembar Transfer ini diisi oleh Perawat</div>
        <br />
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>Kategori dan Pendampingan Pasien Transfer</strong></div>
            </div> 
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                         <?php echo $form->hiddenField($model, 'formtransferpasien_id'); ?>
                        <div class="control-group ">
                            <?php  echo $form->labelEx($model, 'derajatpasien', array('class' => 'control-label')) ?>
                             <div class="controls">
                                <?php echo $form->dropDownList($model, 'derajatpasien', array('Derajat 0'=>'Derajat 0', 'Derajat 1' => 'Derajat 1', 'Derajat 2'=>'Derajat 2', 'Derajat 3' =>'Derajat 3'), array('empty' => '-- Pilih --', 'class' => 'span3','onkeypress' => "return $(this).focusNextInputField(event);")); ?>				 
                             </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Nama Petugas Pendamping', '', array('class' => 'control-label')) ?>
                             <div class="controls">
                                <?php
                                echo CHtml::hiddenField('pegawaipendamping_id','');
                                    $this->widget('MyJuiAutoComplete', array(
                                            'id' => 'pegawaipendamping_nama',
                                        'name' => 'pegawaipendamping_nama',
                                            'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                        url: "' . Yii::app()->createUrl('AutoCompletePetugasPendamping') . '",
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
                                                        $("#pegawaipendamping_id").val(ui.item.pegawai_id);
                                                        $("#pegawaipendamping_nama").val(ui.item.label);
                                                        return false;
                                                }',
                                            ),
                                            'htmlOptions' => array(
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 custom-only',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogPetugasPendamping'),
                                    ));
                                ?>
                             </div>
                            <div class="controls">
                                 <?php
                                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
                                    array('onclick' => 'inputPegawaiPendamping();return false;',
                                            'class' => 'btn btn-primary',
                                            'onkeypress' => "inputPegawaiPendamping();return $(this).focusNextInputField(event)",
                                            'rel' => "tooltip",
                                            'title' => "Klik untuk menambahkan Petugas Pendamping"));
                                ?>
                            </div>
                         </div> 
                        <br />
                        <table class="table table-striped table-bordered table-condensed" id="tblpendamping">
                            <thead>
                                <tr>
                                    <th>Petugas Pendamping</th>
                                    <th>Batal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(isset($modDetails) && count($modDetails) > 0){
                                        foreach ($modDetails as $dataPegPendamping){
                                            echo $this->renderPartial($this->path_view.'_rowPetugasPendamping',array('dataPegPendamping'=>$dataPegPendamping));
                                        }
                                    }
                                        
                                        
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php  echo $form->labelEx($model, 'catatanpendampingtransfer', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'catatanpendampingtransfer', array('class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title"><strong>VI. Kondisi Pasien (Sebelum Ditransfer)</strong></div>
            </div> 
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo $form->labelEx($model,'sebelumtransfer_tanggal', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                    $this->widget('MyDateTimePicker',array(
                                    'model'=>$model,
                                    'attribute'=>'sebelumtransfer_tanggal',
                                    'mode'=>'datetime',
                                    'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3','style'=>'width:150px;'),
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'sebelumtransfer_keadaanumum', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                        'model'=>$model,
                                        'attribute'=>'sebelumtransfer_keadaanumum',
                                        'data'=> explode(',', $model->sebelumtransfer_keadaanumum),   
                                        'debugMode'=>true,
                                        'options'=>array( 
                                                //'bricket'=>false,
                                                'json_url'=>$this->createUrl('MasterKeadaanUmum'),
                                                'addontab'=> true, 
                                                'maxitems'=> 10,
                                                'input_min_size'=> 0,
                                                'cache'=> true,
                                                'newel'=> true,
                                                'addoncomma'=>true,
                                                'select_all_text'=> "", 
                                        ),
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model,'sebelumtransfer_kesadaran', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($model,'sebelumtransfer_kesadaran',array('Compos Mentis'=>'Compos Mentis','Delirium'=>'Delirium','Somnolen'=>'Somnolen','Sopor'=>'Sopor','Koma'=>'Koma') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'statusAlergi','onclick'=>'setStatusAlergi(this);')); ?>            
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Pemeriksaan Tanda Vital', '', array('class' => 'control-label','style'=>'width: 200px; font-weight: bold;')) ?>
                        </div>
                        <div class="control-group">
                            <?php  echo CHtml::label('Tensi', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'sebelumtransfer_td_systolic', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> / 
                                <?php echo $form->textField($model, 'sebelumtransfer_td_diastolic', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> mmHg
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php  echo CHtml::label('Suhu', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'sebelumtransfer_suhutubuh', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> &#176 Celcius
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php  echo CHtml::label('Nadi', '', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'sebelumtransfer_nadi', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> x/menit 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php  echo CHtml::label('Skor EWS', '', array('class' => 'control-label','style'=>'font-weight: bold;')) ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'sebelumtransfer_skorews', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                                <?php echo $form->textField($model, 'sebelumtransfer_klasifikasi_skorews', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="font-weight: bold;">Catatan Penting<i class="<?php echo MyIcon::getIcons('info2') ?> txthitam"  data-toggle="tooltip" data-placement="top" title="" data-original-title="Perkembangan pasien selama proses rujukan (dalam perjalanan transportasi)" data-html="true"></i></label>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'sebelumtransfer_catatanpenting', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br /><br />
    <table width="100%">
            <tr>
                <td style="width:70%; text-align: left;" colspan="2">
                </td>
                <td style="width:30%; text-align: left;" colspan="2" >
            <center><strong style="color: black;">Petugas yang Menyerahkan Pasien</strong><span class="required">*</span>
                        <br><br><br><br><br><br>
                        <?php echo $form->dropDownList($model, 'sebelumtransfer_pegawaiygmenyerahkan', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState("ruangan_id")),array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 required')); ?>				 
                    </center>
                </td>
            </tr>
    </table>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); //RND-8620
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']), 
                        array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model)); ?>

<?php 
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPetugasPendamping',
    'options'=>array(
        'title'=>'Pencarian Nama Petugas Pendamping',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();

if(isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugaspendamping-grid',
	'dataProvider'=>$modPegawai->searchDialogPegRuangan(),
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
                        "onClick" => "
                                      $(\"#pegawaipendamping_id\").val(\"$data->pegawai_id\");
                                      $(\"#pegawaipendamping_nama\").val(\"$data->NamaLengkap\");
                                      $(\"#dialogPetugasPendamping\").dialog(\"close\"); 
                                      return false;
                            "))',
                ),
                array(
                    'header'=>'NIP',
                    'name'=>'nomorindukpegawai',
                    'value'=>'$data->nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modPegawai,'nomorindukpegawai',array('class'=>'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value'=>'$data->namaLengkap',
                    'filter' => Chtml::activeTextField($modPegawai,'nama_pegawai',array('class'=>'hurufs-only'))
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
            . '$(".numbers-only").keyup(function(){setNumbersOnly(this);});'
            . '$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>