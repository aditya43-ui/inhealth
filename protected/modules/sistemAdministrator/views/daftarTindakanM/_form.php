<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadaftar-tindakan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekTindakan(this);return false;'), //'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#SADaftarTindakanM_komponenunit_id',
));
?>

<style>
.row+.row {
    margin-top: 17px;
}
</style>

<?php echo $form->errorSummary(array($model, $modTarifTindakan)); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'kelompoktindakan_id', CHtml::listData($model->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class' => 'inputRequire required span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'komponenunit_id', CHtml::listData($model->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'kategoritindakan_id', CHtml::listData($model->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'daftartindakan_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'daftartindakan_nama', array('placeholder' => 'Uraian Tindakan', 'class' => 'span3', 'onkeyup' => 'namaLain(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'daftartindakan_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'tindakanmedis_nama', array('placeholder' => 'Uraian Tindakan Medis', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'daftartindakan_katakunci', array('placeholder' => 'Kata Kunci', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Kelompok Tindakan BPJS", 'kelompoktindakanbpjs_id', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo $form->dropDownList($model, 'kelompoktindakanbpjs_id', CHtml::listData(KelompoktindakanbpjsM::model()->findAll('kelompoktindakakanbpjs_aktif = true order by kelompoktindakanbpjs_nama asc'), 'kelompoktindakanbpjs_id', 'kelompoktindakanbpjs_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Ruangan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php //echo CHtml::label("",'Ruangan',array('class'=>'control-label required'));   
                    ?>
                    <div class="controls">

                        <?php
                        $arrRuangan = array();
                        /*
                                      foreach($modRuangan as $Ruangan)
                                      {
                                      $arrRuangan[] = $Ruangan['ruangan_id'];
                                      }
                                     */
                        $this->widget(
                            'application.extensions.emultiselect.EMultiSelect',
                            array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                            'ruangan_id[]',
                            $arrRuangan,
                            CHtml::listData(SARuanganM::model()->findAll(array('order' => 'ruangan_nama', 'condition' => 'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                            array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Tindakan <a class="btn btn-default" style="color:#fff;" onclick="unCheckPilihTindakan();" rel="tooltip" data-original-title="Klik untuk uncheck/membatalkan pilihan tindakan"><i class="<?php echo MyIcon::getIcons("ulang"); ?>"></i></a>
                </div>
            </div>
            <div class="panel-body" id="checktindakan">
                <?php /*
                              <div class="col-sm-3">
                              <div class="control-group">
                              <?php echo CHtml::label("",'daftartindakan_karcis', array('class' => 'control-label')) ?>
                              <div class="controls">
                              <?php echo $form->checkBox($model,'daftartindakan_karcis',array('value' => '')); ?> <label>Karcis</label>
                              </div>
                              </div>
                              </div>
                              <div class="col-sm-3">
                              <div class="control-group">
                              <?php echo CHtml::label("",'daftartindakan_visite', array('class' => 'control-label')) ?>
                              <div class="controls">
                              <?php echo $form->checkBox($model,'daftartindakan_visite',array()); ?> <label>Visite</label>
                              </div>
                              </div>
                              </div>
                              <div class="col-sm-3">
                              <div class="control-group">
                              <?php echo CHtml::label("",'daftartindakan_konsul', array('class' => 'control-label')) ?>
                              <div class="controls">
                              <?php echo $form->checkBox($model,'daftartindakan_konsul',array()); ?> <label>Konsul</label>
                              </div>
                              </div>
                              </div>
                              <div class="col-sm-3">
                              <div class="control-group">
                              <?php echo CHtml::label("",'daftartindakan_akomodasi', array('class' => 'control-label')) ?>
                              <div class="controls">
                              <?php echo $form->checkBox($model,'daftartindakan_akomodasi',array()); ?> <label>Akomodasi</label>
                              </div>
                              </div>
                              </div>
                             * 
                             */ ?>

                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_karcis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_karcis', 'id' => 'pilih_isperiksa', 'uncheckValue' => null)); ?> <label>Karcis</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_periksa', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_periksa', 'id' => 'pilih_iskarcis', 'uncheckValue' => null)); ?> <label>Pemeriksaan</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_visite', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_visite', 'id' => 'pilih_isvisite', 'uncheckValue' => null)); ?> <label>Visite</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_tindakan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_tindakan', 'id' => 'pilih_istindakan', 'uncheckValue' => null)); ?> <label>Tindakan Medis</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_konsul', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_konsul', 'id' => 'pilih_iskonsul', 'uncheckValue' => null)); ?> <label>Konsul</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_observasi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_observasi', 'id' => 'pilih_isobservasi', 'uncheckValue' => null)); ?> <label>Observasi</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_akomodasi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_akomodasi', 'id' => 'pilih_isakomodasi', 'uncheckValue' => null)); ?> <label>Akomodasi</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_alatmedis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_alatmedis', 'id' => 'pilih_isalatmedis', 'uncheckValue' => null)); ?> <label>Alat Medis</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Jenis Kegiatan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo Chtml::label('Jenis Kegiatan', 'jeniskegiatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'jeniskegiatan_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'jeniskegiatan_nama',
                            'source' => 'js: function(request, response) {
																			$.ajax({
																					url: "' . $this->createUrl('/ActionAutoComplete/JenisKegiatan') . '",
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
																							$(this).val( ui.item.value);
																							return false;
																												}',
                                'select' => 'js:function( event, ui ) { 
																														$("#' . CHtml::activeId($model, 'jeniskegiatan_id') . '").val(ui.item.jeniskegiatan_id);
																														$("#' . CHtml::activeId($model, 'jeniskegiatan_nama') . '").val(ui.item.jeniskegiatan_nama);
																														return false;
																												}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Jenis Kegiatan',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'custom-only',
                                'onchange' => 'cekJenisKegiatan();'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogJenisKegiatan'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Grup Layanan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo Chtml::label('Grup Layanan', 'jeniskegiatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'grouplayanan_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'grouplayanan_nama',
                            'source' => 'js: function(request, response) {
																			$.ajax({
																					url: "' . $this->createUrl('/ActionAutoComplete/GroupLayanan') . '",
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
																							$(this).val( ui.item.value);
																							return false;
																												}',
                                'select' => 'js:function( event, ui ) { 
																														$("#' . CHtml::activeId($model, 'grouplayanan_id') . '").val(ui.item.grouplayanan_id);
																														$("#' . CHtml::activeId($model, 'grouplayanan_nama') . '").val(ui.item.grouplayanan_nama);
																														return false;
																												}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Grup Layanan',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => '',
                                'onblur' => 'cekJenisGrupLayanan();'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogGroupLayanan'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo CHtml::checkBox('cekTarifTindakan', true, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?> Nominal Tarif
                </div>
            </div>

            <div class="panel-body" id="panel-tarif" style="overflow-x: auto;">
                <div id="divTarifTindakan" class="control-group">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td>
                                <?php echo $form->hiddenfield($modTarifTindakan, 'perdatarif_id', array('value' => Params::DEFAULT_PERDA_TARIF)); ?>
                                <?php echo $form->dropDownListRow($modTarifTindakan, 'jenistarif_id', CHtml::listData($modTarifTindakan->JenisTarifItems, 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                                <div class="control-group">
                                    <?php echo $form->labelex($modTarifTindakan, 'Cyto', array('class' => "control-label required")) ?>
                                    <div class="controls">
                                        <?php echo $form->textField($modTarifTindakan, 'persencyto_tind', array('value' => 0, 'class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> %
                                    </div>
                                </div>
                            </td>
                            <td>
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td>
                                            <div class="control-group">
                                                <?php echo $form->labelex($modTarifTindakan, 'Diskon', array('class' => "control-label required")) ?>
                                                <div class="controls">
                                                    <?php echo $form->textField($modTarifTindakan, 'persendiskon_tind', array('value' => 0, 'class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> %
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <?php echo $form->labelex($modTarifTindakan, 'Diskon', array('class' => "control-label required")) ?>
                                                <div class="controls">
                                                    <?php echo $form->textField($modTarifTindakan, 'hargadiskon_tind', array('value' => 0, 'class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Rupiah
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>




                            </td>
                        </tr>
                    </table>
                    <div class="table" id="divDaftartindakan">

                        <table width="100%" class="items table table-bordered table-striped datatable" id="tblInputTarifTindakan">
                            <thead>
                                <th>Kelas Pelayanan</th>
                                <th>Komponen Tarif</th>
                                <th>Harga Tindakan</th>
                                <th></th>
                            </thead>
                            <tbody id="tblTarifTindakan">
                                <tr>
                                    <td>
                                        <?php
                                        echo $form->dropDownList($modTarifTindakan, '[0]kelaspelayanan_id', CHtml::listData($modTarifTindakan->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array(
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'empty' => '-- Pilih Lokasi --',
                                            'class' => 'span2'
                                        ));
                                        ?>
                                        <span class="required">*</span>
                                    </td>
                                    <td>
                                        <?php
                                        $komponen = KomponentarifM::model()->findAll('komponentarif_id != :komponentarif order by komponentarif_nama', array(':komponentarif' => Params::KOMPONENTARIF_ID_TOTAL));
                                        foreach ($komponen as $hasil) :
                                            $arrHasil[] = array(
                                                'label' => $hasil->komponentarif_nama,
                                                'value' => $hasil->komponentarif_nama,
                                                'id' => $hasil->komponentarif_id,
                                            );
                                        endforeach;
                                        ?>
                                        <?php // echo CHtml::activeHiddenField($modTarifTindakan, '[0]komponentarif_id', array('readonly'=>true,'class'=>'inputFormTabel')) 
                                        ?>
                                        <?php echo CHtml::activeDropDownList($modTarifTindakan, '[0]komponentarif_id', CHtml::listData($komponen, 'komponentarif_id', 'komponentarif_nama'), array('empty' => '-- Pilih --', 'class' => 'inputFormTabel span3')) ?>
                                        <?php /* $this->widget('MyJuiAutoComplete',array(
                                          'model'=>$modTarifTindakan,
                                          'attribute'=>'[0]komponentarifNama',
                                          'source'=>$arrHasil,
                                          'options'=>array(
                                          'showAnim'=>'fold',
                                          'minLength' => 2,
                                          'focus'=> 'js:function( event, ui ) {
                                          $(this).val( ui.item.label);
                                          return false;
                                          }',
                                          'select'=>'js:function( event, ui ) {
                                          setTindakan($(this), ui.item);
                                          return false;
                                          }',

                                          ),
                                          'tombolDialog'=>array("idDialog"=>'dialogKomponenTarif','jsFunction'=>"setDialog(this);"),
                                          'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'),
                                          ));
                                         * 
                                         */ ?>
                                    </td>
                                    <td>

                                        <?php echo $form->textField($modTarifTindakan, '[0]harga_tariftindakan', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,)); ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo CHtml::link("<span class='icon-plus'></span>", '', array(
                                            'href' => '', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);return false;', 'id' => 'row1-plus', 'style' => 'text-decoration:none;'
                                        ));
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php //echo $form->checkBoxRow($model,'daftartindakan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);"));  
?>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        '',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Daftar Tindakan', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SADaftarTindakanM_daftartindakan_namalainnya').value = nama.value.toUpperCase();
        document.getElementById('SADaftarTindakanM_tindakanmedis_nama').value = nama.value;
    }
</script>
<?php
$js = <<< JS
$('#cekTarifTindakan').change(function(){
        hideShowPanelTarif();
        // $('#divTarifTindakan').slideToggle(500);
});

JS;
Yii::app()->clientScript->registerScript('JStarifTindakan', $js, CClientScript::POS_READY);
?>
<?php
Yii::app()->clientScript->registerScript('resize', "
    function resizeIframe(obj){
       $('#divTarifTindakan').slideToggle(1);
       obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
", CClientScript::POS_HEAD);
?>
<?php
/* ====================================== Widget Dialog Komponen Tarif ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKomponenTarif',
    'options' => array(
        'title' => 'Pencarian Komponen Tarif',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => true,
    ),
));
$modKomponenTarif = new KomponentarifM('search');
$modKomponenTarif->unsetAttributes();
if (isset($_GET['KomponentarifM'])) {
    $modKomponenTarif->attributes = $_GET['KomponentarifM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'komponentarif-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modKomponenTarif->search(),
    'filter' => $modKomponenTarif,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectMenuKomponenTarif",
                                    "onClick" => "var data=[\"$data->komponentarif_id\", \"$data->komponentarif_nama\"]
                                                    setTindakanAuto(data, this);
                                                    $(\"#dialogKomponenTarif\").dialog(\"close\");
                            "))',
        ),
        array(
            'header' => 'Komponen Tarif',
            //                    'filter'=>'<input type="text" name="FilterForm[komponentarif_nama]" value="'.$_GET['FilterForm'].'" attr-route ="'.$route.'" onblur="setFilter(this);">',
            'name' => 'komponentarif_nama',
            'value' => '$data->komponentarif_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Komponen Tarif ====================================== */
?>
<?php
$buttonMinus = CHtml::link('<span class="entypo-minus"></span>', '#', array('onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
// $urlGetRiwayatRuangan=Yii::app()->createUrl('ActionAjax/getRiwayatRuangan');
// $tglpenetapanruangan= CHtml::activeId($modRiwayatRuangan,'tglpenetapanruangan');
// $nopenetapanruangan=CHtml::activeId($modRiwayatRuangan,'nopenetapanruangan');
// $tentangpenetapan=CHtml::activeId($modRiwayatRuangan,'tentangpenetapan');

$js = <<< JSCRIPT
function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputTarifTindakan tr').length;
    var i = -1;
    $('#tblInputTarifTindakan tr').each(function(){
        if($(this).has('select[name$="[komponentarif_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="komponentarifNama["]').attr('name','komponentarifNama['+i+']');
        $(this).find('input[name^="komponentarif_id["]').attr('id','komponentarif_id'+i+'');
        $(this).find('input[name^="kelaspelayanan_id["]').attr('id','kelaspelayanan_id'+i+'');
    });
}

function delRow(obj)
{
    myConfirm("$confimMessage",'Perhatian!',function(r){
		if(!r) return false;
		else {
			$(obj).parent().parent().remove();
			renameInput('SATarifTindakanM','kelaspelayanan_id');
			renameInput('SATarifTindakanM','komponentarif_id');
			renameInput('SATarifTindakanM','komponentarifNama');
			renameInput('SATarifTindakanM','harga_tariftindakan');
		}
	});
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>
<script>
    var obj;

    function hideShowPanelTarif() {
        if ($("#cekTarifTindakan").is(":checked")) {
            obj.appendTo("#panel-tarif");
        } else {
            obj = $("#divTarifTindakan").detach();
        }
    }

    function addRow(obj) {
        button = '<?php echo $buttonMinus; ?>';
        var tr = $('#tblTarifTindakan tr:first').html();
        $('#tblTarifTindakan tr:last').after('<tr>' + tr + '</tr>');
        $('#tblTarifTindakan tr:last td:last').append(button);

        $("#tblTarifTindakan tr:last").find('.integer2').maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ",",
            "thousands": ".",
            "precision": 0
        });

        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
            "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
        });
        /*
         jQuery('input[name$="[komponentarifNama]"]').autocomplete(
         {
         'showAnim':'fold',
         'minLength':2,
         'focus':function(event, ui )
         {
         $(this).val( ui.item.label);
         return false;
         },
         'select':function( event, ui )
         {
         setTindakan(this, ui.item);
         return false;
         },
         'source':function(request, response)
         {
         $.ajax({
         url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/KomponenTarif'); ?>",
         dataType: "json",
         data:{
         term: request.term,
         },
         success: function (data) {
         response(data);
         }
         })
         }
         }
         );
         */
        renameInput('SATarifTindakanM', 'komponentarif_id');
        renameInput('SATarifTindakanM', 'kelaspelayanan_id');
        renameInput('SATarifTindakanM', 'komponentarifNama');
        renameInput('SATarifTindakanM', 'harga_tariftindakan');

    }

    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogKomponenTarif";
        $(dialog).attr("parent-dialogs", parent);
        $(dialog).dialog("open");
    }

    function setTindakanAuto(params) {
        dialog = "#dialogKomponenTarif";
        parent = $(dialog).attr("parent-dialogs");
        obj = $("#" + parent);
        //    console.log(params);
        $(obj).parents('tr').find('input[name$="[komponentarif_id]"]').val(params[0]);
        $(obj).parents('tr').find('input[name$="[komponentarifNama]"]').val(params[1]);
        $(dialog).dialog("close");

    }

    function setTindakan(obj, item) {
        //        myAlert(item);
        $(obj).parents('tr').find('input[name$="[komponentarifNama]"]').val(item.value);
        $(obj).parents('tr').find('input[name$="[komponentarif_id]"]').val(item.id);
    }
</script>

<?php
/* ====================================== Widget Dialog Jenis Kegiatan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisKegiatan',
    'options' => array(
        'title' => 'Pencarian Jenis Kegiatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modJenisKegiatan = new SAJenisKegiatanM('search');
$modJenisKegiatan->unsetAttributes();
if (isset($_GET['SAJenisKegiatanM'])) {
    $modJenisKegiatan->attributes = $_GET['SAJenisKegiatanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jeniskegiatan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisKegiatan->searchDialog(),
    'filter' => $modJenisKegiatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
                                    "id" => "selectJenisKegiatan",
                                    "onClick" => "  $(\"#SADaftarTindakanM_jeniskegiatan_id\").val(\"$data->jeniskegiatan_id\");
                                                    $(\"#SADaftarTindakanM_jeniskegiatan_nama\").val(\"$data->jeniskegiatan_nama\");
                                                    $(\"#dialogJenisKegiatan\").dialog(\"close\");
                            "))',
        ),
        /*   array(
          'header'=>'Kode Jenis Kegiatan',
          'name'=>'jeniskegiatan_kode',
          'value'=>'$data->jeniskegiatan_kode',
          'filter' => Chtml::activeTextField($modJenisKegiatan, 'jeniskegiatan_kode', array('class'=>'custom-only'))
          ), */
        array(
            'header' => 'Jenis Kegiatan',
            'name' => 'jeniskegiatan_nama',
            'value' => '$data->jeniskegiatan_nama',
            'filter' => Chtml::activeTextField($modJenisKegiatan, 'jeniskegiatan_nama', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Ruang Jenis Kegiatan',
            'name' => 'jeniskegiatan_ruangan',
            'value' => '$data->jeniskegiatan_ruangan',
            'filter' => Chtml::activeDropDownList($modJenisKegiatan, 'jeniskegiatan_ruangan', LookupM::getItems('jeniskegiatan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".custom-only").keyup(function() {
            setCustomOnly(this);
        });'
        . '}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Jenis Kegiatan ====================================== */
?>

<?php
/* ====================================== Widget Dialog Group Layanan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogGroupLayanan',
    'options' => array(
        'title' => 'Pencarian Grup Layanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
    ),
));

$modGroupLayanan = new GrouplayananM('search');
$modGroupLayanan->unsetAttributes();
if (isset($_GET['GrouplayananM'])) {
    $modGroupLayanan->attributes = $_GET['GrouplayananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'grouplayanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modGroupLayanan->searchGrupLayanan(),
    'filter' => $modGroupLayanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) use ($model) {
                return CHtml::Link(
                    "<i class='icon-form-check'></i>",
                    "javascript:;",
                    array(
                        "class" => "btn-small",
                        "id" => "selectbarang",
                        "onclick" => '
										$("#' . CHtml::activeId($model, 'grouplayanan_nama') . '").val("' . $data->grouplayanan_nama . '");
										$("#' . CHtml::activeId($model, 'grouplayanan_id') . '").val(' . $data->grouplayanan_id . ');
										$("#dialogGroupLayanan").dialog("close");'
                    )
                );
            },
        ),
        'grouplayanan_kode',
        'grouplayanan_nama',
        array(
            'header' => 'Pengelompokkan',
            'value' => function ($data) {
                if ($data->is_oa == true) {
                    return 'Jenis Obat dan Alkes';
                } else {
                    return 'Tindakan';
                }
            },
            'filter' => CHtml::activeDropDownList($modGroupLayanan, 'is_oa', array('is_oa' => 'Jenis Obat dan Alkes', 'is_tindakan' => 'Tindakan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Group Layanan ====================================== */
?>

<script>
    function cekJenisKegiatan() {
        var jeniskegiatan = $("#<?php echo Chtml::activeId($model, 'jeniskegiatan_nama'); ?>").val();

        if (jeniskegiatan != '') {
            return true;
        } else {
            $("#<?php echo Chtml::activeId($model, 'jeniskegiatan_id'); ?>").val('')
        }
    }

    function cekJenisGrupLayanan() {
        var gruplayanan = $("#<?php echo Chtml::activeId($model, 'grouplayanan_nama'); ?>").val();

        if (gruplayanan != '') {
            return true;
        } else {
            $("#<?php echo Chtml::activeId($model, 'grouplayanan_id'); ?>").val('');
        }
    }

    function unCheckPilihTindakan(obj) {
        var pilih = $("#<?php echo CHtml::activeId($model, 'pilihTindakan') ?>");

        $("#pilih_iskarcis").prop("checked", false);
        $("#pilih_isvisite").prop("checked", false);
        $("#pilih_iskonsul").prop("checked", false);
        $("#pilih_isakomodasi").prop("checked", false);
        $("#pilih_istindakan").prop("checked", false);
        $("#pilih_isobservasi").prop("checked", false);
        $("#pilih_periksa").prop("checked", false);

    }

    function cekTindakan(obj) {
        var cek = false;
        //alert('asdasdasdasd');
        $("[id^=pilih_]").each(function() {
            if ($(this).prop("checked")) {
                cek = true;
            }
        });

        if (cek == true) {
            if (requiredCheck($(obj))) {
                //$(obj).submit();
                //$("#btn_submit").prop('disabled', true);;
            } else {
                return false;
            }
        } else {
            alert("Tindakan harus dipilih salah satu, tidak boleh kosong!");
            return false;
        }

        //return false;	
    }
</script>