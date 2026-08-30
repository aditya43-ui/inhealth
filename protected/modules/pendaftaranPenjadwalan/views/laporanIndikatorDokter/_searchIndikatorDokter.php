<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchIndikatorDokter',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),));
    ?>
    <style>
        table{
            margin-bottom: 0;
        }
        .form-actions{
            padding:4px;
            margin-top:5px;
        }
        #ruangan label{
            width: 120px;
            display:inline-block;
        }
        .nav-tabs>li>a{display:block; cursor:pointer;}
    </style>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Kunjungan', 'tglubahdokter', array('class' => 'control-label')) ?>
                    <?php echo CHtml::hiddenField('type', '', array()); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                    </div>
                </div>
                <div class="control-group">  
                    <?php echo CHtml::label('Nama Dokter', 'nama_pegawai', array('class' => 'control-label')); ?> 
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'dokterbaru_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'nama_pegawai',
                            'source' => 'js: function(request, response) {
                                                                                      $.ajax({
                                                                                              url: "' . $this->createUrl('AutocompleteDokter') . '",
                                                                                              dataType: "json",
                                                                                              data: {
                                                                                                      nama_pegawai: request.term,
                                                                                              },
                                                                                              success: function (data) {
                                                                                                              response(data);
                                                                                              }
                                                                                      })
                                                                                   }',
                            'options' => array(
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                                                                    $(this).val( "");
                                                                                    return false;
                                                                            }',
                                'select' => 'js:function( event, ui ) {
                                                                                   $(this).val( ui.item.nama_pegawai);
                                                                                   $("#' . CHtml::activeId($model, 'dokterbaru_id') . '").val(ui.item.pegawai_id);
                                                                                   return false;
                                                                           }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDokterNama'),
                            'htmlOptions' => array('placeholder' => 'Nama Dokter', 'rel' => 'tooltip', 'title' => 'Ketik nama dokter untuk mencari data dokter',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'dokterbaru_id') . '").val(""); '
                            ),
                        ));
                        ?>
                    </div>          
                </div>
            </div>
            <div class="col-sm-6">
                <div class='control-group hari'>
                    <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "span3 dtPicker3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                    </div> 

                </div>
                <div class='control-group bulan'>
                    <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                        <?php
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'bln_awal',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'class' => "span2",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                    </div> 
                </div>
                <div class='control-group tahun'>
                    <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
                <div class='control-group hari'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "span3 dtPicker3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                    </div> 
                </div>
                <div class='control-group bulan'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls"> 
                        <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                        <?php
                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'bln_akhir',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                    </div> 
                </div>
                <div class='control-group tahun'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        ); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            ?>
        </div>
    </fieldset>
</div>    
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php
//========= Dialog buat cari data dokter berdasarkan nama =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokterNama',
    'options' => array(
        'title' => 'Pencarian Data Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));
$modDialogDokter = new PPPegawaiM('searchDokter');
$modDialogDokter->unsetAttributes();
if (isset($_GET['PPPegawaiM'])) {
    $modDialogDokter->attributes = $_GET['PPPegawaiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datadokternama-grid',
    'dataProvider' => $modDialogDokter->searchDokter(),
    'filter' => $modDialogDokter,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
									"id" => "selectPendaftaran",
									"onClick" => "
										$(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");
										$(\"#' . CHtml::activeId($model, 'dokterbaru_id') . '\").val(\"$data->pegawai_id\");
										$(\"#dialogDokterNama\").dialog(\"close\");
									"))',
        ),
        array(
            'header' => 'No. Pegawai',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Dokter',
            'name' => 'nama_pegawai',
            'type' => 'raw',
            'value' => '$data->NamaLengkap',
            'htmlOptions' => array('style' => 'text-align: left')
        ),
        array(
            'header' => 'Alamat',
            'name' => 'alamat_pegawai',
            'type' => 'raw',
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
////======= end dialog dokter nama dialog =============
?>