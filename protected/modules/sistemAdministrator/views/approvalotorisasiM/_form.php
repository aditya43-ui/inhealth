<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabahanmakanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
?>
<?php echo $form->errorSummary($model); ?>

<table style="width: 100%; border: none;">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <!--gizi-->
                <div class="control-group">
                    <?php echo CHtml::label("Kepala Instalasi Gizi", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kepalagizi_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'instalasi_gizi',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'instalasi_gizi') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'instalasi_gizi') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiGizi'),
                        ));
                        ?>
                    </div>
                </div>

                <!--farmasi-->
                <div class="control-group">
                    <?php echo CHtml::label("Kepala Instalasi Farmasi", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kepalafarmasi_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'penanggungjawab_apoterker_nama',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'penanggungjawab_apoterker_nama') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'penanggungjawab_apoterker_nama') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiFarmasi'),
                        ));
                        ?>
                    </div>
                </div>

                <!--Gudang Umum-->
                <div class="control-group">
                    <?php echo CHtml::label("Kepala Instalasi Gudang Umum", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kepalaumum_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'instalasi_gudang_umum',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'instalasi_gudang_umum') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'instalasi_gudang_umum') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiGudangUmum'),
                        ));
                        ?>
                    </div>
                </div>

                <!--Kasi Personalia-->
                <div class="control-group">
                    <?php echo CHtml::label("Kasi Personalia", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kasipersonalia_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'kasi_personalia',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'kasi_personalia') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'kasi_personalia') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKasiPersonalia'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <!--Manager Umum-->
                <div class="control-group">
                    <?php echo CHtml::label("Manager Umum", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'managerumum_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'manager_umum',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'manager_umum') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'manager_umum') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogManagerUmum'),
                        ));
                        ?>
                    </div>
                </div>

                <!--Manager Keuangan-->
                <div class="control-group">
                    <?php echo CHtml::label("Manager Keuangan", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'managerkeuangan_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'manager_keuangan',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'manager_keuangan') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'manager_keuangan') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogManagerKeuangan'),
                        ));
                        ?>
                    </div>
                </div>

                <!--Direktur RS-->
                <div class="control-group">
                    <?php echo CHtml::label("Direktur RS", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'direkturrs_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'direktur_rs',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'direktur_rs') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'direktur_rs') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDirekturRS'),
                        ));
                        ?>
                    </div>
                </div>

                <!--Direktur PT-->
                <div class="control-group">
                    <?php echo CHtml::label("Direktur PT", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'direkturpt_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'direktur_pt',
                            // 'value'=>$pegawai_nama,
                            'source' => 'js: function(request, response) {
	                                       $.ajax({
	                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
	                                    $(this).val("");
	                                    return false;
	                                }',
                                'select' => 'js:function( event, ui ) {
	                                    $("#' . CHtml::activeId($model, 'direktur_pt') . '").val(ui.item.value)
	                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
	                                    return false;
	                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'direktur_pt') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDirekturPT'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</table>
<div class="clear"></div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/approvalotorisasiM/create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('gudangFarmasi.views.tips.tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
/**
 * Dialog Kepala Instalasi Gizi
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepalaInstalasiGizi',
    'options' => array(
        'title' => 'Kepala Instalasi Gizi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiGizi = new SAPegawaiM();
$PegawaiGizi->unsetAttributes();
$PegawaiGizi->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiGizi->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaigizi-m-grid',
    'dataProvider' => $PegawaiGizi->searchDialog(),
    'filter' => $PegawaiGizi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#instalasi_gizi\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kepalagizi_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogKepalaInstalasiGizi\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiGizi, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiGizi, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiGizi, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiGizi, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Dialog Kepala Instalasi Farmasi
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepalaInstalasiFarmasi',
    'options' => array(
        'title' => 'Kepala Instalasi Farmasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiFarmasi = new SAPegawaiM();
$PegawaiFarmasi->unsetAttributes();
$PegawaiFarmasi->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiFarmasi->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaifarmasi-m-grid',
    'dataProvider' => $PegawaiFarmasi->searchDialog(),
    'filter' => $PegawaiFarmasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#penanggungjawab_apoterker_nama\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kepalafarmasi_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogKepalaInstalasiFarmasi\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiFarmasi, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiFarmasi, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiFarmasi, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiFarmasi, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Dialog Kepala Instalasi Gudang Umum
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepalaInstalasiGudangUmum',
    'options' => array(
        'title' => 'Kepala Instalasi Gudang Umum',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiGudangUmum = new SAPegawaiM();
$PegawaiGudangUmum->unsetAttributes();
$PegawaiGudangUmum->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiGudangUmum->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaigudangumum-m-grid',
    'dataProvider' => $PegawaiGudangUmum->searchDialog(),
    'filter' => $PegawaiGudangUmum,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#instalasi_gudang_umum\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kepalaumum_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogKepalaInstalasiGudangUmum\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiGudangUmum, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiGudangUmum, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiGudangUmum, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiGudangUmum, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Kasi Personalia
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKasiPersonalia',
    'options' => array(
        'title' => 'Kasi Personalia',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiKasiProsonalia = new SAPegawaiM();
$PegawaiKasiProsonalia->unsetAttributes();
$PegawaiKasiProsonalia->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiKasiProsonalia->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kasipersonalia-m-grid',
    'dataProvider' => $PegawaiKasiProsonalia->searchDialog(),
    'filter' => $PegawaiKasiProsonalia,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#kasi_personalia\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kasipersonalia_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogKasiPersonalia\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiKasiProsonalia, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiKasiProsonalia, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiKasiProsonalia, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiKasiProsonalia, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Manager Umum
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogManagerUmum',
    'options' => array(
        'title' => 'Manager Umum',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiManagerUmum = new SAPegawaiM();
$PegawaiManagerUmum->unsetAttributes();
$PegawaiManagerUmum->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiManagerUmum->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'managerumum-m-grid',
    'dataProvider' => $PegawaiManagerUmum->searchDialog(),
    'filter' => $PegawaiManagerUmum,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#manager_umum\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'managerumum_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogManagerUmum\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiManagerUmum, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiManagerUmum, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiManagerUmum, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiManagerUmum, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>


<?php
/**
 * Manager Keuangan
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogManagerKeuangan',
    'options' => array(
        'title' => 'Manager Keuangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiManagerKeuangan = new SAPegawaiM();
$PegawaiManagerKeuangan->unsetAttributes();
$PegawaiManagerKeuangan->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiManagerKeuangan->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'managerkeuangan-m-grid',
    'dataProvider' => $PegawaiManagerKeuangan->searchDialog(),
    'filter' => $PegawaiManagerKeuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#manager_keuangan\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'managerkeuangan_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogManagerKeuangan\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiManagerKeuangan, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiManagerKeuangan, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiManagerKeuangan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiManagerKeuangan, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Direktur RS
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDirekturRS',
    'options' => array(
        'title' => 'Direktur RS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiDirekturRS = new SAPegawaiM();
$PegawaiDirekturRS->unsetAttributes();
$PegawaiDirekturRS->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiDirekturRS->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'direkturrs-m-grid',
    'dataProvider' => $PegawaiDirekturRS->searchDialog(),
    'filter' => $PegawaiDirekturRS,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#direktur_rs\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'direkturrs_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogDirekturRS\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiDirekturRS, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiDirekturRS, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiDirekturRS, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiDirekturRS, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Direktur PT
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDirekturPT',
    'options' => array(
        'title' => 'Direktur PT',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiDirekturPT = new SAPegawaiM();
$PegawaiDirekturPT->unsetAttributes();
$PegawaiDirekturPT->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiDirekturPT->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'direkturpt-m-grid',
    'dataProvider' => $PegawaiDirekturPT->searchDialog(),
    'filter' => $PegawaiDirekturPT,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#direktur_pt\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'direkturpt_id') . '\").val(\"$data->pegawai_id\");
                      
                      $(\"#dialogDirekturPT\").dialog(\"close\");   
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiDirekturPT, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiDirekturPT, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiDirekturPT, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiDirekturPT, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>