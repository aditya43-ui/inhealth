<?php
$this->breadcrumbs = array(
    'Apache II Score',
);
?>

<style>
    .boxPertanyaan .control-label {
        width: 450px;
        text-align: left;
        margin-left: 60px;
    }

    .inline label {
        display: inline;
        margin-left: 10px;

    }

    label a:hover {
        cursor: pointer;
        text-decoration: none;
    }

    .inline input {

        margin-bottom: 5px;
    }
</style>
<!--<div class="white-container">
    <legend class="rim2">Transaksi Apache <b>II Score</b></legend>-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Apache II Score</b>
        </div>
    </div>
    <div class="panel-body">
        

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'ripasienapachescore-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#',
        )); ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'tgl_pendaftaran', array('readonly' => true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modPasien, 'tgl_admisi', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasienPIV, 'pasienadmisi_id', array('readonly' => true)); ?>
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
                        <label class="control-label">Jenis Kasus Penyakit</label>
                        <div class="controls">
                            <?php echo CHtml::textField('jeniskasuspenyakit', '', array('readonly' => true)); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <div class="control-label"> <?php echo CHtml::Label('No Rekam Medik <span class="required">*</span>', 'no_rekam_medik', array('class' => 'no_rek')); ?></div>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPasien,
                                'attribute' => 'no_rekam_medik',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('AutocompletePasien'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);

                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                          $("#' . CHtml::activeId($modPasien, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'umur') . '").val(ui.item.umur);     

                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                          $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                          $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id);   
                                          $("#' . CHtml::activeId($model, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);   
                                          $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);   

                                          $("#diagnosa_nama").val(ui.item.diagnosa); 
                                          $("#jeniskasuspenyakit").val(ui.item.jeniskasuspenyakit_nama); 
                                          if (!jQuery.isNumeric(ui.item.diagnosa_id)){
                                              ui.item.diagnosa_id = 0;
                                          }

                                          $("#apachescore_id_2").val(ui.item.usia).click();
                                          $("#apachescore_id_4").val(ui.item.meanarteripressure).click();
                                          $("#apachescore_id_6").val(ui.item.detaknadi).click();
                                          $("#apachescore_id_13").val(ui.item.gcs).parents("tr").find(".poin").val(15-ui.item.gcs);
                                          $("#' . CHtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id); 
                                          setRiwayat();
                                          }',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'No. Rekam Medik',
                                    'size' => 20,
                                    'class' => 'span3 required',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDaftarPasien', 'idTombol' => 'tombolPasienDialog'),
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
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'diagnosa_id', array('class' => 'control-label')); ?>
                        <label class="control-label">Diagnosa</label>
                        <div class="controls">
                            <?php echo CHtml::textField('diagnosa_nama', '', array('readonly' => true)); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('cekRiwayatPasien', false, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?> Riwayat Apache Score
                </div>
            </div>
            <div id="divRiwayatPasien" class="panel-body" style="display:none;">
                <iframe style="border: none;" src="" id="riwayatApacheScore" width="100%" onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>
        <hr>
        <table style="width: 100%; border: none;">
            <tr>
                <td width="107">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglscoring', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglscoring',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                            ));
                            ?>
                        </div>
                    </div>
                </td>
                <td width="60" rowspan="3">
                    <div class="control-group">
                        <?php echo CHtml::activeLabelEx($model, 'catatanapachescore', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextArea($model, 'catatanapachescore', array('rows' => 6)); ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Dokter <span class="required">*</span>', 'pegawai_nama', array('class' => 'control-label')) ?>
                        <?php echo CHtml::activeHiddenField($model, 'pegawai_id'); ?>
                        <!--<div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'pegawai_nama',
                        'sourceUrl' => $this->createUrl('AutocompleteDokter'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                     $(this).val( ui.item.label);
                                     $(this).val(ui.item.nama_pegawai);
                                     return false;
                                 }',
                            'select' => 'js:function( event, ui ) {
                                             $(this).val(ui.item.nama_pegawai);
                                             $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                 return false;
                                           }'
                        ),
                        // 'tombolDialog'=>array('idDialog'=>'dialogDaftarPasien','idTombol'=>'tombolPasienDialog'),
                    ));
                    ?>
                    </div>-->
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pegawai_nama',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('AutocompleteDokter'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        $(this).val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.nama_pegawai);
                                                $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                    return false;
                                              }'
                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'Nama Dokter',
                                    'size' => 20,
                                    'class' => 'span3 required',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogDokter'), //'idTombol'=>'tombolPasienDialog'),
                            ));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'paramedis_nama', array('class' => 'control-label')) ?>
                        <?php echo CHtml::activeHiddenField($model, 'paramedis_id'); ?>
                        <!--<div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'paramedis_nama',
                        'sourceUrl' => $this->createUrl('AutocompletePerawat'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nama_pegawai);
                                    return false;
                                }',
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($model, 'paramedis_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                          }'
                        ),
                    ));
                    ?>
                    </div>-->
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'paramedis_nama',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('AutocompletePerawat'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        $(this).val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.nama_pegawai);
                                                $("#' . CHtml::activeId($model, 'paramedis_id') . '").val(ui.item.pegawai_id);
                                                    return false;
                                              }'
                                ),
                                'htmlOptions' => array(
                                    'readonly' => false,
                                    'placeholder' => 'Nama Paramedis',
                                    'size' => 20,
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogParamedis'), //'idTombol'=>'tombolPasienDialog'),
                            ));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <div class='boxPertanyaan'>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Apache II Score
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-condensed" id="apache">
                        <?php foreach ($modApacheScore as $row) {
                            $explode = explode(' ', strtolower($row->varfisiologik_nama));
                            if ($row->apachescore_id == 1) {
                                echo '<tr><td width="20%"><label class="control-label">' . $row->varfisiologik_nama . '</label></td>';
                                echo '<td>';
                                echo CHtml::radioButtonList(
                                    'apachescore_id_' . $row->apachescore_id,
                                    '',
                                    CHtml::listData(PIScorepointM::model()->findAllByAttributes(array('apachescore_id' => $row->apachescore_id), array('order' => 'scorepoint_id ASC')), 'point_score', 'point_nama'),
                                    array('onclick' => '$("#point_' . $row->apachescore_id . '").val($(this).val());', 'template' => '<div class="inline" style="display:inline">{input}{label}</div>')
                                );
                                echo '</td>';
                                echo '<td>';
                                echo CHtml::TextField('point_' . $row->apachescore_id, '', array('class' => 'span1 poin', 'style' => 'margin-right:100px;', 'readonly' => true));
                                echo '</td>';
                                echo '</tr>';
                                echo '<tr><td width="20%"><label class="control-label">Apakah Pasien mempunyai Gagal Ginjal Akut ?</label></td>';
                                echo '<td colspan="2">';
                                echo '<div class="inline">' . CHtml::activeCheckBox($model, 'gagalginjalakut', array('onclick' => "getScore(this);")) . '<label>Ya</label></div>';
                                echo '</td>';
                                echo '</tr>';
                            } else {
                                if (in_array(strtolower('Glasgow'), $explode)) {
                                    echo '<tr><td><label class="control-label"><a class=gcs onclick=$("#dialogGCS").dialog("open"); return false;>' . $row->varfisiologik_nama . '</a></label></td>';
                                } else {
                                    echo '<tr><td><label class="control-label">' . $row->varfisiologik_nama . '</label></td>';
                                }
                                echo '<td>';
                                echo CHtml::TextField('apachescore_id_' . $row->apachescore_id, '', array('class' => 'span2'));
                                if (!empty($row->varfisiologik_satuan)) {
                                    echo ' ' . $row->varfisiologik_satuan;
                                }
                                echo '</td>';
                                echo '<td>';
                                echo CHtml::TextField('point_' . $row->apachescore_id, '', array('class' => 'span1 poin', 'style' => 'margin-right:100px;', 'readonly' => true));
                                echo '</td>';
                                echo '</tr>';
                            }
                        } ?>
                    </table>
                </div>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'apachescore_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>

        <?php //echo $form->checkBoxRow($model,'gagalginjalakut', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'point_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
        ?>
        <?php //echo $form->textFieldRow($model,'point_nilai',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'point_score',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textFieldRow($model,'paramedis_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->textAreaRow($model,'catatanapachescore',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan',  'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)',
                    'disabled' => (isset($_GET['sukses'])) ? true : false
                )
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/Pasienapachescore/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>

        </div>

        <?php $this->endWidget(); ?>

        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogGCS',
            'options' => array(
                'title' => '',
                'autoOpen' => false,
                'width' => 600,
                'height' => 500,
                'modal' => true,
                //'hide'=>'explode',
                'resizelable' => false,
            ),
        ));

        ?>
        <table id="GCS">
            <?php foreach ($modPIMetodeGSCM as $i => $item) :
                if ($item->metodegcs_nilai == '') {
                    echo "<tr bgcolor='#E5ECF9'>
                    <td>" . $item->metodegcs_nama . "</td>
                    <td>&nbsp;</td>    
                  </tr>";
                } else {
                    echo "<tr>
                    <td>" . $item->metodegcs_nama . "</td>
                    <td><div id=\"divTombol\">" . CHtml::button($item->metodegcs_nilai, array(
                        'class' => 'btn btn-prymari',
                        'onclick' => 'SetNilai(this)',
                        'id' => $item->metodegcs_singkatan,
                    )) . "</div></td>    
                  </tr>";
                }
            endforeach; ?>
        </table>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$gagalGinjal = CHtml::activeId($model, 'gagalginjalakut');
$getScore = Yii::app()->createUrl($this->module->id . '/pasienapachescore/getScoreApachePI');
$idParamedis = CHtml::activeId($model, 'paramedis_id');
$idPegawai = CHtml::activeId($model, 'pegawai_id');
$pendaftaran_id = CHtml::activeId($model, 'pendaftaran_id');
$urlRiwayat = Yii::app()->createUrl($this->module->id . '/pasienapachescore/getRiwayatPasien');
$noRekamMedik = CHtml::activeId($modPasien, 'no_rekam_medik');
Yii::app()->clientScript->registerScript('ready', "
    
    $('.gcs').parents('tr').find('input').not('.poin').attr('readonly',true);
    $('.poin').each(function(){
        $(this).val(0);
    });
    $('.poin').parents('tr').find('input').not('.poin').each(function(){
        if ($(this).attr('readonly') != 'readonly'){
            $(this).attr('onclick','getScore(this);').attr('onkeyup','getScore(this);');
            $(this).addClass('numbers-only');
        }
    });
    
    $('#cekRiwayatPasien').click(function(){
        if ($(this).is(':checked')){
            $('#divRiwayatPasien').slideDown('medium');
        }else{
            $('#divRiwayatPasien').slideUp('medium');
        }
    });
    
    $('form').submit(function(){     
        if (cekValidasi() == false)
            return false;
        else{
            return true;
        }
    });
",  CClientScript::POS_READY);

$js = <<< JS
function SetNilai(obj)
{
    var value = 0;
    idTombol=obj.id;
    i=0;
    if(idTombol=='E'){
        $('#RJPemeriksaanFisikT_gcs_eye').val(obj.value);
    }else if(idTombol=='M'){
        $('#RJPemeriksaanFisikT_gcs_motorik').val(obj.value);
    }else if(idTombol=='V'){
        $('#RJPemeriksaanFisikT_gcs_verbal').val(obj.value);
    } 
    
    $('#divTombol #'+idTombol).each(function() {
        $(this).attr("class","btn"); 
    });

//    jumlah=$('#divTombol #'+idTombol).length;

    $(obj).attr("class","btn btn-success"); 
    $(obj).removeAttr('onmouseout');
    $(obj).removeAttr('onmouseover');
    
    $(obj).parents("#GCS").find('.btn-success').each(function(){
        valueObj = parseFloat($(this).val());
        value = value+valueObj;
    });

    $('#apachescore_id_13').val(value).attr('readonly','true');
    $('#point_13').val(15-value);
}

function resizeIframe(obj){
       obj.style.height = '0px';
       obj.style.height = obj.contentWindow.document.body.scrollHeight +10+ 'px';
}

function getScore(obj){
    var value = $(obj).val();
    var attrId = $(obj).attr('id');
    if (attrId == '${gagalGinjal}'){
        attrId = $('#apachescore_id_10').attr('id');
        value = $('#apachescore_id_10').val();
        obj = '#apachescore_id_10';
    }

    if ($('#${gagalGinjal}').is(':checked')){
        attrId = attrId+'_1';
    }
    if (jQuery.isNumeric(value)){
        $.post('${getScore}', {score:value, id:attrId}, function(data){
            if (!jQuery.isNumeric(data.pointscore)){
               data.pointscore = 0;
            }
            $(obj).parents('tr').find('input.poin').val(data.pointscore);
        }, 'json');
    }
    else{
        $(obj).parents('tr').find('input.poin').val(0);
    }
}

function setRiwayat(){
    var id = $('#${pendaftaran_id}').val();
    $('#alertriwayat').addClass('hide');
    $('#cekRiwayatPasien').attr('checked','checked');
    $('#riwayatApacheScore').attr('src','${urlRiwayat}&id='+id);
    $('#divRiwayatPasien').slideDown('medium');
}      
        
function cekValidasi(){
    var lanjut = true;
    $('#apache').find('input[name*="apachescore_id_"]').each(function(){
        var value = $(this).val();
        if (value == ''){
            lanjut = false;
        }
    });
    

    if($('#${idPegawai}').val() == ''){
        window.parent.myAlert("Silakan isi inputan dokter dengan benar!");
        return false;
    }
    else if ($('#${idParamedis}').val() == ''){
        window.parent.myAlert("Silakan isi inputan paramedis dengan benar!");
        return false;
    }
    else{
        return true;
    }
    
}
JS;

Yii::app()->clientScript->registerScript('fungsi', $js,  CClientScript::POS_HEAD);
?>

<!--if (lanjut == false){
        window.parent.myAlert("Silakan isi semua apache score !!");
        return false;
    }-->

<?php

//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDaftarPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
    ),
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienPIV->searchPIDialog(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'filter' => $modPasienPIV,
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
						"id" => "selectPendaftaran",
						"onClick" => "
							$(\"#dialogDaftarPasien\").dialog(\"close\");

							$(\"#PIPasienM_tgl_pendaftaran\").val(\"".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."\");
							$(\"#PIPasienM_no_pendaftaran\").val(\"$data->no_pendaftaran\");
							$(\"#PIPasienM_umur\").val(\"$data->umur\");
							$(\"#PIInfopasienmasukkamarV_pasienadmisi_id\").val(\"".MyFormatter::formatDateTimeForUser($data->tgladmisi)."\");

							$(\"#jeniskasuspenyakit\").val(\"$data->jeniskasuspenyakit_nama\");

							$(\"#PIPasienM_jeniskelamin\").val(\"$data->jeniskelamin\");
							$(\"#PIPasienM_no_rekam_medik\").val(\"$data->no_rekam_medik\");
							$(\"#PIPasienM_nama_pasien\").val(\"$data->nama_pasien\"); 
							$(\"#PIPasienM_nama_bin\").val(\"$data->nama_bin\");
							$(\"#PIMasukKamarT_tglmasukkamar\").val(\"$data->tglmasukkamar\");
							$(\"#PIMasukKamarT_masukkamar_id\").val(\"$data->masukkamar_id \");
							$(\"#PIPasienapachescoreT_pendaftaran_id\").val(\"$data->pendaftaran_id \");
							$(\"#PIPasienapachescoreT_pasien_id\").val(\"$data->pasien_id \");
							$(\"#PIPasienapachescoreT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");

							$(\"#apachescore_id_2\").val(\"$data->umur \");

							setRiwayat();
						"))',

        ),
        'no_rekam_medik',
        array(
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => false,
            // CHtml::activeTextField($modPasienPIV, 'tgl_pendaftaran', array('class'=>'span3','readonly'=>true)),
            /*$this->widget('MyDateTimePicker', array(
				'model' => $modPasienPIV,
				'attribute' => 'tgl_pendaftaran',
				'mode' => 'date', //date / datetime
				'gridFilter' => true,
				'options' => array(
				'dateFormat' => Params::DATE_FORMAT,
				'maxDate'=>'d',
				),
				'htmlOptions' => array('readonly' => true, 'class' => "span2",
				'onkeypress' => "return $(this).focusNextInputField(event)"),
				),true),*/
        ),
        'no_pendaftaran',
        'nama_pasien',
        array(
            'header' => 'Nama Alias',
            'type' => 'raw',
            'name' => 'nama_bin',
            'value' => '"$data->nama_bin"',
        ),
        array(
            'header' => 'Penjamin',
            'type' => 'raw',
            'name' => 'penjamin_nama',
            'value' => '$data->penjamin_nama',
        ),
        array(
            'header' => 'Jenis Penjamin',
            'type' => 'raw',
            'name' => 'carabayar_nama',
            'value' => '$data->carabayar_nama',
        ),
        array(
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'name' => 'nama_pegawai',
            'value' => '"$data->nama_pegawai"',
        ),
        // 'ruangan_nama',
        'jeniskasuspenyakit_nama',
        // 'statusperiksa',                
    ),
    'afterAjaxUpdate' => 'function(id, data){
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//			jQuery("#' . CHtml::activeId($modPasienPIV, 'tgl_pendaftaran') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//			jQuery("#' . CHtml::activeId($modPasienPIV, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modPasienPIV, 'tgl_pendaftaran') . '").datepicker("show");});
                        jQuery("#' . CHtml::activeId($modPasienPIV, 'tgl_pendaftaran') . '").daterangepicker({
                            "maxDate": "' . date('m/d/Y') . '",
                            "showDropdowns": true,
                        });
		}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<?php
$modDokter = new PIDokterV('searchDialogDokter');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PIDokterV'])) {
    $modDokter->attributes = $_GET['PIDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogDokter(),
    'filter' => $modDokter,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                "id" => "selectDokter",
                                "href"=>"",
                                "onClick"=>"$(\"#PIPasienapachescoreT_pegawai_id\").val(\"$data->pegawai_id \");
                                  $(\"#dialogDokter\").dialog(\"close\");
                                  $(\"#PIPasienapachescoreT_pegawai_nama\").val(\"$data->nama_pegawai\");
                                  return false;
                                ",
                               ))',
        ),
        //            'pegawai_id',
        'gelardepan',
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
        ),
        'gelarbelakang_nama',
        'jeniskelamin',
        'agama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//========= Dialog buat cari data pemeriksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogParamedis',
    'options' => array(
        'title' => 'Daftar Paramedis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<?php
$modParamedis = new PIParamedisV('searchDialog');
$modParamedis->unsetAttributes();
$modParamedis->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PIParamedisV'])) {
    $modParamedis->attributes = $_GET['PIParamedisV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'paramedisYangMengajukan-m-grid',
    'dataProvider' => $modParamedis->searchDialog(),
    'filter' => $modParamedis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                "id" => "selectDokter",
                                "href"=>"",
                                "onClick"=>"$(\"#PIPasienapachescoreT_paramedis_id\").val(\"$data->pegawai_id \");
                                  $(\"#dialogParamedis\").dialog(\"close\");
                                  $(\"#PIPasienapachescoreT_paramedis_nama\").val(\"$data->nama_pegawai\");
                                  return false;
                                ",
                               ))',
        ),
        //            'pegawai_id',
        array(
            'name' => 'gelardepan',
            'header' => 'Gelar Depan',
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Paramedis',
        ),
        array(
            'name' => 'gelarbelakang_nama',
            'header' => 'Gelar Belakang',
        ),
        array(
            'name' => 'jeniskelamin',
            'header' => 'Jenis Kelamin',
        ),
        'agama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    $(document).ready(function() {
        setPickerRangeTanggal();
    });

    $('form').bind('click keyup select change', function(event) {
        cekDisabled(this);
    });
    $(document).on('click keyup select change', function() {
        cekDisabled('form');
    });
    cekDisabled('form');

    function setPickerRangeTanggal() {
        $('input[name="PIInfopasienmasukkamarV[tgl_pendaftaran]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "format": "DD/MM/YYYY",
            "applyClass": "btn-primary btn_pendaftaran_apply",
            "showDropdowns": true,
        });

        $(".btn_pendaftaran_apply").on("click", function() {
            setTimeout(function() {
                $.fn.yiiGridView.update("daftarpasien-v-grid", {
                    data: $("#daftarpasien-v-grid :input").serialize()
                });
            }, 100);
        });
    }
</script>