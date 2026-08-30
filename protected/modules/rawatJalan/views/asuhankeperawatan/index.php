<style>
    .groupUkurans{
        display:inline;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjasuhankeperawatan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#'.CHtml::activeId($modPasien,'no_rekam_medik'),
        ));
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>

<fieldset>
    <legend class="rim2">Transaksi Asuhan keperawatan</legend>
    
    <br>
    <table class="table table-condensed">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php //echo CHtml::activeTextField($modPasien, 'tgl_pendaftaran', array('readonly' => true)); ?>
                        <span id="tgl_pendaftaran"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'umur', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                     <div class="control-label"> <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'no_rek')); ?> </div>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasien,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienRawatJalan'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);

                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                   // $("#' . CHtml::activeId($modPasien, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                           $("#tgl_pendaftaran").text(ui.item.tgl_pendaftaran);
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'umur') . '").val(ui.item.umur);     
                                          $("#' . CHtml::activeId($modPasien, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                          $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                          $("#' . CHtml::activeId($modPasien, 'nama_bin') . '").val(ui.item.nama_bin);   
                                          $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);     
                                          $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id);    
                                          $("#' . CHtml::activeId($model, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);
                                          $("#' . CHtml::activeId($modMasukKamar, 'masukkamar_id') . '").val(ui.item.masukkamar_id); 
                                          $("#' . CHtml::activeId($modMasukKamar, 'tglmasukkamar') . '").val(ui.item.tglmasukkamar); 
                                          $("#diagnosa_nama").val(ui.item.diagnosa); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'keluhanutama') . '").val(ui.item.keluhanutama); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'keluhantambahan') . '").val(ui.item.keluhantambahan); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitterdahulu') . '").val(ui.item.riwayatpenyakitterdahulu); 
                                          $("#' . CHtml::activeId($modAnamnesa, 'riwayatpenyakitkeluarga') . '").val(ui.item.riwayatpenyakitkeluarga); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'tekanandarah') . '").val(ui.item.tekanandarah); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'detaknadi') . '").val(ui.item.detaknadi); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'pernapasan') . '").val(ui.item.pernapasan); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'suhutubuh') . '").val(ui.item.suhutubuh); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'paramedis_nama') . '").val(ui.item.pegawai); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'beratbadan_kg') . '").val(ui.item.beratbadan); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'tinggibadan_cm') . '").val(ui.item.tinggibadan); 
                                          $("#' . CHtml::activeId($modPeriksaFisik, 'kelainanpadabagtubuh') . '").val(ui.item.kelainanpadabagtubuh); 
                                          if (!jQuery.isNumeric(ui.item.diagnosa_id)){
                                              ui.item.diagnosa_id = 0;
                                          }
                                          $("#' . CHtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id); 
                                          setRiwayat();
                                              }',
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                                'htmlOptions'=>array(
                                    'class'=>'span3',
                                    'placeholder'=>'No. Rekam Medik',
                                    ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pasien_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pendaftaran_id', array('readonly' => true)); ?>
                        <?php echo CHtml::activeHiddenField($model, 'pasienadmisi_id', array('readonly' => true)); ?>
                        
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?>
                    </div>
                </div>
            </td>
        </tr>
        <tr class='detailDiagnosa'>
            <td width="50%">
                <div class="control-group">
                    <?php echo $form->hiddenField($model, 'diagnosa_id', array('class' => 'control-label')); ?>
                <label class="control-label">Diagnosa</label>
                    <div class="controls">
                        <?php echo CHtml::textField('diagnosa_nama', '', array('readonly' => true)); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($modAnamnesa, 'keluhanutama', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($modAnamnesa, 'keluhantambahan', array('rows' => 3, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($modAnamnesa, 'riwayatpenyakitterdahulu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($modAnamnesa, 'riwayatpenyakitkeluarga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>    
            </td>
            <td width="50%">
                <?php echo $form->textFieldRow($modPeriksaFisik, 'tekanandarah', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
				 <?php echo $form->textFieldRow($modPeriksaFisik, 'detaknadi', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
				 <?php echo $form->textFieldRow($modPeriksaFisik, 'suhutubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                 <div class="groupUkurans">
				<?php echo $form->textFieldRow($modPeriksaFisik, 'beratbadan_kg', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10));
                echo $form->textFieldRow($modPeriksaFisik, 'tinggibadan_cm', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?> 
				</div>
                <?php echo $form->textFieldRow($modPeriksaFisik, 'pernapasan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                <?php echo $form->textFieldRow($modPeriksaFisik, 'paramedis_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($modPeriksaFisik, 'kelainanpadabagtubuh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
            </td>
        </tr>
    </table>
</fieldset>


<fieldset>
    <legend class="accord1" style="width:460px;"> <?php echo CHtml::checkBox('cekRiwayatPasien',false, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?> Riwayat Asuhan Keperawatan</legend>
    <div id="divRiwayatPasien" class="control-group hide">
        <iframe src="" id="riwayatAsuhanKeperawatan" width="100%" onload="javascript:resizeIframe(this);">
        </iframe>        
        <div id="alertriwayat">
            <div class="alert alert-block alert-error">
                Data Riwayat Asuhan Keperawatan tidak ditemukan.
            </div>
        </div>
    </div>
</fieldset>

<br>

<?php 
/**
Diubah oleh : David Yanuar
Tgl.         : 14 April 2014
Subyek      : untuk menampilkan efek "well"
*/
?>

<br>
<div class="row well">
<legend class="rim">Tabel Rencana dan Implementasi Keperawatan</legend>
<table width="311" border="0" style="margin-left:-20px; ">
  <tr>
    <td width="22"><?php echo $form->labelEx($model, 'tglaskep', array('class' => 'control-label')) ?></td>
    <td width="85" style="padding-right:30px;"><?php /*echo date("Y-m-d H:i:s");*/ echo $form->textField($model,'tglaskep',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
               </td>
    <td width="17" style="padding-left:30px;">
                <?php echo $form->labelEx($model, 'paramedis_nama', array('class' => 'control-label')) ?>
                <?php echo CHtml::activeHiddenField($model, 'pegawai_id'); ?>    
    </td>
    <td width="106" style="padding-right:50px;">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'paramedis_nama',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/getPerawat'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val(ui.item.nama_pegawai);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.nama_pegawai);
                                        $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                      }'
                    ),
                ));
                ?>
    </td>
  </tr>
</table>

<!--
          
<?php echo $form->textFieldRow($model, 'ruangan_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'pegawai_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'shift_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'pasienadmisi_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'diagnosakeperawatan_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'tglaskep', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textAreaRow($model, 'evaluasi_subjektif', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textAreaRow($model, 'evaluasi_objektif', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'tglassesment', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($model, 'evaluasi_assesment', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo $form->textAreaRow($model, 'askep_tujuan', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textAreaRow($model, 'askep_kriteriahasil', array('rows' => 6, 'cols' => 50, 'class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>  
-->

<style>
    table ul{
        margin-top:10px;
    }
    #asuhankeperawatan ul li,
    .boxtindakan .isi_inter ul li, 
    .boxtindakan .ambil_inter ul li, 
    .boxtindakan .ambil_kolab ul li, 
    .boxtindakan .isi_kolab ul li{
        list-style: none;
        margin-left:-20px;
        margin-right:5px;
        padding:5px;
        margin-bottom: 1px;
    }
    li.warna{
      -webkit-border-radius:3px;;
      -moz-border-radius:3px;;
      -o-border-radius:3px;;
      background:#DDD;
    }
    
    input[type="checkbox"]{
        margin-right:5px;
        line-height: 10px;
                margin-top:-5px;
    }
    .boxtindakan{
        width: 300px;
        max-width: 400px;
    }
    table .span2{
        float: left;
    }
    </style>
<table width="300" class="table table-bordered" id='asuhankeperawatan'>
    <thead>
        <tr>
            <th>Diagnosa </th>
            <th width="200">Intervensi</th>
            <th width="200">Implementasi</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <td width="67">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'diagnosakeperawatan_nama',
                    'value' => 'dialogDetailData',
                    'sourceUrl' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/getDiagnosaKeperawatan').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           idDiagnosa: $("#'.Chtml::activeId($model, 'diagnosa_id').'").val(),
                                       },
                                       success: function (data) {
                                               response(data);                        
                                       }
                                   })
                                }',
                    'options' => array(
                        
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                            
                                  submitDiagnosa(ui.item.diagnosakeperawatan_id);
                                      }'
                        
                    ),
                    'htmlOptions'=>array('class'=>'span2'), 'tombolDialog'=>array('idDialog'=>'dialogDetailData','jsFunction'=>"updateGrid();$('#dialogDetailData').dialog('open');"),
                ));
                ?>            </td>
            <td colspan ="2">
                
            </td>
           
        </tr>
    </tfoot>
</table>
</div>

<br>
<div class="row well">
<legend class="rim">Tabel Evaluasi Keperawatan</legend>
<table class="table table-bordered" id='asuhankeperawatan2'>
    <thead>
        <tr>
            <th>Diagnosa</th>
            <th>Subjektif</th>
            <th>Objektif</th>
            <th>Assesment</th>
            <!--<th>Planning</th>-->
            <th>Tujuan</th>
            <th>Kriteria Hasil</th>
        </tr>
    </thead>
    <tbody>
       
    </tbody>
</table>
</div>

<br>
<div class="row well">
<legend class="rim">Tabel Planning Keperawatan</legend>
<table class="table table-bordered" id="asuhankeperawatan3">
    <thead>
        <tr>
            <th>Diagnosa</th>
            <th colspan='2'>Planning</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="form-actions"> 
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
     <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                $this->createUrl($this->module->id.'/index'), 
                                array('class' => 'btn btn-default',
                                    'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;')); ?>
	<?php
$content = $this->renderPartial('../tips/transaksi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div> 
</div>

<?php $this->endWidget(); ?>
<?php
$noRekamMedik = CHtml::activeId($modPasien, 'no_rekam_medik');
$pendaftaran_id = CHtml::activeId($model, 'pendaftaran_id');
$tglAskep = Chtml::activeId($model, 'tglaskep');
$paramedis = CHtml::activeId($model, 'paramedis_nama');
$diagnosaKeperawatan = CHtml::activeId($model, 'diagnosakeperawatan_nama');
$idDiagnosaKeperawatan = CHtml::activeId($model, 'diagnosakeperawatan_id');
$urlHalamanIni = Yii::app()->createUrl($this->module->id.'/asuhankeperawatan/index');
$diagnosa_id = CHtml::activeId($model, 'diagnosa_id');
$getDiagnosaKeperawatan = Yii::app()->createUrl('actionAjax/getDiagnosaKeperawatan');
$getRiwayatPasienDariAsuhanKeperawatan = Yii::app()->createUrl('actionAjax/getRiwayatAsuhan');
$getDataAsuhanKeperawatan = Yii::app()->createUrl('actionAjax/getDataAsuhanKeperawatan');
$urlRiwayat = Yii::app()->createUrl($this->module->id.'/asuhankeperawatan/getRiwayatPasien');
?>
<?php Yii::app()->clientScript->registerScript('onready', "
    $(document).ready(function(){
        $('#asuhankeperawatan').find('.inputAutoComplete').addClass('span2');
        $('.detailDiagnosa').find('input, textarea').attr('readOnly','true');
        $('form').submit(function(){     
                if (cekValidasi() == false)
                    return false;
                else{
                    return true;
                }
        });
        
        $('#cekRiwayatPasien').click(function(){
            if ($(this).is(':checked')){
                $('#divRiwayatPasien').slideDown();
                $('#RJ1206110002').trigger('click');
            }
            else{
                $('#divRiwayatPasien').slideUp();
            }
        });
    });
        
    function warnai(obj){
        if ($(obj).is('checked')){
            $(obj).parent('li').addClass('warna');
        }
        else{
            $(obj).parent('li').addClass('warna');
        }
    }
        
    function getRiwayat(){
        var noRekamMedik = $('#${noRekamMedik}').val();
        var noRekamMedik = noRekamMedik.split(' - ');
        var noRekamMedik = noRekamMedik[0];
        $.post('${getRiwayatPasienDariAsuhanKeperawatan}',{noRekamMedik:noRekamMedik}, function(data){
            if (data.tr != ''){
                $('#alertriwayat').addClass('hide');
                $('#tablehide').removeClass('hide');
                $('#divRiwayatPasien table tbody tr').remove();
                $('#divRiwayatPasien table tbody').append(data.tr);
                $('#testing').redactor({'autoresize':false,'fixed':true,'lang':'en','toolbar':'smini'});
            }
            else{
                $('#tablehide').addClass('hide');
                $('#alertriwayat').removeClass('hide');
            }
        }, 'json');
        getUpdateData(noRekamMedik);
    }
        
    function getUpdateData(value){
        var pendaftaran_id = $().val();
        $.post('${getDiagnosaKeperawatan}', {noRekamMedik:value}, function(data){
           
        }, 'json');
    }
        
    function updateGrid(){
        var diagnosa_id = $('#${diagnosa_id}').val();
        if (diagnosa_id == ''){
            diagnosa_id =0;
        }else if (diagnosa_id == 0){
            diagnosa_id = '';
        }
        var url = document.URL+'&RJDiagnosakeperawatanM%5Bdiagnosa_id%5D='+diagnosa_id;
        $.fn.yiiGridView.update('rjdiagnosakeperawatan-m-grid', {
            url: url,
        }); 
    }
        
    function submitDiagnosa(bata){
        $.post('${getDiagnosaKeperawatan}',{idDiagnosaKeperawatan:bata}, function(data){
            var validasi = true;
            $('#asuhankeperawatan').find('#AsuhankeperawatanT_diagnosakeperawatan_id').each(function(){
                if ($(this).val() == data.id){
                    validasi = false;
                };
            });
            if (validasi == false){
                myAlert('Data Diagnosa kperawatan telah ada');
            }else{
                $('#asuhankeperawatan').append(data.tr);
                $('#asuhankeperawatan2').append(data.tr2);
                $('#asuhankeperawatan3').append(data.tr3);
                 noUrut = 1;
                 $('.urutan').parents('#asuhankeperawatan').find('.urutan').each(function() {
                      $(this).parents('tr').find('.intervensi_check').attr('name', 'rencana_intervensi['+(noUrut-1)+'][]');
                      $(this).parents('tr').find('.implementasi_check').attr('name', 'rencana_implementasi['+(noUrut-1)+'][]');
                      $(this).val(noUrut);
                      noUrut = noUrut + 1;
                 });
//                $('#asuhankeperawatan2').find('textarea').redactor({
//       
//                   toolbar : 'smini'
//            
//                });
                 noUrut = 1;
                 $('.urutan').parents('#asuhankeperawatan2').find('.urutan').each(function() {
                      $(this).val(noUrut);
                      noUrut = noUrut + 1;
                 });
                 noUrut = 1;
                 $('.urutan').parents('#asuhankeperawatan3').find('.urutan').each(function() {
                      $(this).parents('tr').find('.isi_inter ul').addClass(''+noUrut+'');
                      $(this).parents('tr').find('.isi_kolab ul').addClass(''+noUrut+'');
                      $(this).parents('tr').find('.ambil_inter ul').addClass(''+noUrut+'');
                      $(this).parents('tr').find('.ambil_kolab ul').addClass(''+noUrut+'');
                      $(this).val(noUrut);
                      noUrut = noUrut + 1;
                 });
            }
        },'json');
    }
        
    function submitIntervensi(obj){
        var value = $(obj).val();
        var urutan = $(obj).parents('tr').find('#urutan').val();
        var text = $(obj).attr('textdata');
        var isKolab = $(obj).attr('kolaborasi');
        var valuedata = $(obj).attr('valuedata');
        var intervensi = '<input type=checkbox id=evaluasi_inter kolaborasi='+isKolab+' name=evaluasi_intervensi['+(urutan-1)+'][] onclick=ambilIntervensi(this) textData=\"'+text+'\" value='+value+' valuedata='+valuedata+'>';
        
        if (isKolab == 1){
            isKolab = 'kolab';
        }else{
            isKolab = 'inter';
        }
        
        if ($(obj).is(':checked')){
                $(obj).parent('li').addClass('warna');
                $('#asuhankeperawatan3 tbody tr').find('.isi_'+isKolab+' ul.'+urutan+'').append('<li>'+intervensi+text+'</li>');
        }
        else{
            $(obj).parent('li').removeClass('warna');
            $('#asuhankeperawatan3').find('.isi_'+isKolab+' ul.'+urutan+' input[valuedata='+valuedata+']').parent('li').remove();
            $('#asuhankeperawatan3').find('.block .ambil_'+isKolab+' ul.'+urutan+' input[valuedata='+valuedata+']').parent('li').remove();
        }
    }
        
    function ambilIntervensi(obj){
        var value = $(obj).val();
        var urutan = $(obj).parents('tr').find('#urutan').val();
        var text = $(obj).attr('textData');
        var isKolab = $(obj).attr('kolaborasi');
        var valuedata = $(obj).attr('valuedata');
        var intervensi = '<input type=checkbox id=ambil_intervensi kolaborasi='+isKolab+' name=ambil_intervensi['+(urutan-1)+'][] onclick=remove(this) textData=\"'+text+'\" value='+value+' valuedata='+valuedata+' checked=checked>';
        
        if (isKolab == 1){
            isKolab = 'kolab';
        }else{
            isKolab = 'inter';
        }
       
        if ($(obj).is(':checked')){
            $(obj).parent('li').addClass('warna');
            $('#asuhankeperawatan3 tbody tr').find('.ambil_'+isKolab+' ul.'+urutan+'').append('<li>'+intervensi+text+'</li>');
        }
        else{
            $(obj).parent('li').removeClass('warna');
            $('#asuhankeperawatan3').find('.block .ambil_'+isKolab+' ul.'+urutan+' input[valuedata='+valuedata+']').parent('li').remove();
        }
    }
    
    function remove(obj){
        var urutan = $(obj).parents('tr').find('#urutan').val();
        var text = $(obj).attr('textData');
        var valuedata = $(obj).attr('valuedata');
        if ($(obj).is(':checked')){
        }
        else{
            $(obj).parents('tr').find('input[valuedata='+valuedata+']').parent('li').removeClass('hide');
            $(obj).parent('li').remove();
        }
    }
        
    function setRiwayat(){
        var id = $('#${pendaftaran_id}').val();
        $('#alertriwayat').addClass('hide');
        $('#cekRiwayatPasien').attr('checked','checked');
        $('#riwayatAsuhanKeperawatan').attr('src','${urlRiwayat}&id='+id);
        $('#divRiwayatPasien').slideDown('medium');
    }
        
    function cekValidasi(){
        var valueDiagnosa = $('#AsuhankeperawatanT_diagnosakeperawatan_id').length;
        var valueRM = $('#${noRekamMedik}').val();
        var valueParam = $('#${paramedis}').val();
        var valueTglAskep = $('#${tglAskep}').val();
        
        if (valueRM == ''){
            myAlert('No. Rekam Medik Pasien Belum Diisi');
            return false;
        }
        else if (valueTglAskep == ''){
            myAlert('Tanggal Asuhan Keperawatan Belum Diisi');
            return false;
        }
        else if (valueParam == ''){
            myAlert('Nama Paramedis Belum Diisi');
            return false;
        }
        else if (valueDiagnosa < 1){
            myAlert('Belum Ada Diagnosa Keperawatan yang dipilih!');
            return false;
        }
        else{
            return true;
        }
    }
        
    function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }

", CClientScript::POS_HEAD); ?>

<?php
$modDiagnosaKeperawatan = new RJDiagnosakeperawatanM('search');
$modDiagnosaKeperawatan->unsetAttributes();
//$modDiagnosaKeperawatan->diagnosa_id = Null;
if (isset($_GET['RJDiagnosakeperawatanM'])) {
    $modDiagnosaKeperawatan->attributes = $_GET['RJDiagnosakeperawatanM'];
}
?>
<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjdiagnosakeperawatan-m-grid',
    'dataProvider' => $modDiagnosaKeperawatan->search(),
    'filter' => $modDiagnosaKeperawatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'diagnosakeperawatan_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectObat",
                            "onClick" => "submitDiagnosa($data->diagnosakeperawatan_id);$(\'#dialogDetailData\').dialog(\'close\');return false;"))',
        ),
        //'diagnosa_id',
        'diagnosakeperawatan_kode',
        'diagnosa_medis',
        'diagnosa_keperawatan',
        'diagnosa_tujuan',
    /*
      'diagnosa_keperawatan_aktif',
     */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?> 
<?php
$this->endWidget();

//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailData2',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailData2" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php
//========= Dialog buat cari data Pasien=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
        
    ),
));

$modPasien = new RJInfokunjunganrjV('searchKunjunganPasien');
$modPasien->statusperiksa = "SEDANG PERIKSA";
if(isset($_GET['RJInfokunjunganrjV'])){
    $modPasien->attributes = $_GET['RJInfokunjunganrjV'];
    $format = new MyFormatter();
    $modPasien->tgl_pendaftaran  = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_pendaftaran']);
    $modPasien->statusperiksa  = $_REQUEST['RJInfokunjunganrjV']['statusperiksa'];
}

// $modPasien = new InfokunjunganrjV('searchRJ');
// $modPasien->unsetAttributes();
// if (isset($_GET['InfokunjunganrjV'])) {
//     $modPasien->attributes = $_GET['InfokunjunganrjV'];
// }
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->searchKunjunganPasien(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#RJInfokunjunganrjV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                                          $(\"#RJInfokunjunganrjV_jeniskelamin\").val(\"$data->jeniskelamin\");
                                                          $(\"#RJInfokunjunganrjV_nama_pasien\").val(\"$data->nama_pasien\");
                                                          $(\"#RJInfokunjunganrjV_nama_bin\").val(\"$data->nama_bin\");
                                                      // $(\"#RJInfokunjunganrjV_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
                                                      $(\"#tgl_pendaftaran\").text(\"$data->tgl_pendaftaran\");
                                                          $(\"#RJInfokunjunganrjV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                                          $(\"#RJInfokunjunganrjV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                                          $(\"#RJInfokunjunganrjV_umur\").val(\"$data->umur\");
                                                          $(\"#RJAsuhankeperawatanT_pasien_id\").val(\"$data->pasien_id\");
                                                          $(\"#RJAsuhankeperawatanT_pendaftaran_id\").val(\"$data->pendaftaran_id\");
                                                          setRiwayat();
                                                          $(\"#dialogPasien\").dialog(\"close\");    
                                                          
                                                "))',
        ),
        'no_rekam_medik',   
                //tgl_pendaftaran',
                array(
                    'name'=>'tgl_pendaftaran',
                    'value'=>'$data->tgl_pendaftaran',
                    'filter'=>$this->widget('MyDateTimePicker',array(
                    'model'=>$modPasien,
                    'attribute'=>'tgl_pendaftaran',
                    'mode'=>'date',
                    'options'=> array(
                        'dateFormat'=>Params::DATE_FORMAT
                    ),
                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3'),
                    ),true
                    ),
                    'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                ),
                'no_pendaftaran',
                'nama_pasien', 
                'alamat_pasien',
                'penjamin_nama',
                'nama_pegawai',
                'jeniskasuspenyakit_nama',
                array(
                    'name'=>'statusperiksa',
                    'type'=>'raw',
                    'value'=>'$data->statusperiksa',
                    'filter' =>CHtml::activeDropDownList($modPasien,'statusperiksa',
                        LookupM::getItems('statusperiksa'),array('options' => array('ANTRIAN'=>array('selected'=>true)))),
                ),
               
    ),
     'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});

            jQuery(\'#RJInfokunjunganrjV_tgl_pendaftaran\').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[\'id\'], {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
        }',

));

$this->endWidget();
//========= end Dialog Pasien =============================
?>