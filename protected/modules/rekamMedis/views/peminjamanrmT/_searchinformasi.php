<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rmpeminjamanrm-t-search',
    'type' => 'horizontal',
)); ?>
<?php //echo $form->textFieldRow($model,'peminjamanrm_id',array('class'=>'span5')); 
?>
<div class="row">
    <div class="col-sm-6">
        <?php /*
                            <div class="control-label">
                                <?php echo CHtml::label('Tgl. Peminjaman','tgl_awal'); ?>
                            </div>
                            <div class="controls">
                                <?php   
                                        $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                                        $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'tgl_awal',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                )); 
                                        ?>
                            </div>
                            <?php echo CHtml::label('Sampai dengan','tgl_akhir',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$model,
                                                        'attribute'=>'tgl_akhir',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                )); ?>
                            </div>
							 * 
							 */ ?>
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Peminjaman", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nodokumenrm', array('placeholder' => 'No. Dokumen', 'class' => 'span4 numbers-only', 'autofocus' => true)); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 6)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'untukkepentingan', array('placeholder' => 'Untuk Kepentingan', 'cols' => 4, 'rows' => 3)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList(
                    $model,
                    'ruangan_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                );
                ?>
            </div>
        </div>
        <?php //echo CHtml::label('No. Urut Pinjam','',array('class'=>'control-label')); 
        ?>
        <!--<div class="controls">
                                <?php //echo $form->textField($model,'nourut_pinjam',array('class'=>'span1','maxlength'=>6)); 
                                ?>
                            </div>-->
    </div>
</div>
<!--<div class="control-label">
                    <?php // echo CHtml::label('Nama Pasien','nama_pasien'); 
                    ?>
                </div>
                <div class="controls">
                    <?php
                    //                                    $this->widget('MyJuiAutoComplete', array(
                    //                                        'model' => $model,
                    //                                        'attribute' => 'nama_pasien',
                    //                                        'value' => '',
                    //                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienInformasi'),
                    //                                        'options' => array(
                    //                                            'showAnim' => 'fold',
                    //                                            'minLength' => 2,
                    //                                            'focus' => 'js:function( event, ui ) {
                    //                                                    $(this).val(ui.item.label);
                    //                                                    return true;
                    //                                                }',
                    //                                            'select' => 'js:function( event, ui ) {
                    //                                                $(this).val(ui.item.label);
                    //                                                     return true;
                    //                                                          }',
                    //                                        ),
                    //                                        'htmlOptions'=>array(
                    //                                            'onkeypress'=>'return $(this).focusNextInputField(event)',
                    //                                            'disabled'=>($model->isNewRecord)?'':'disabled',
                    //                                            'class'=>'span2',
                    //                                        ),
                    //                                        'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                    //
                    //                                    ));
                    ?>
                    </div>-->
<!--<div class="control-label">
                    <?php // echo CHtml::label('No. Rekam Medik','no_rekam_medik'); 
                    ?>
                </div>
                <div class="controls">
                    <?php
                    //                                    $this->widget('MyJuiAutoComplete', array(
                    //                                        'model' => $model,
                    //                                        'attribute' => 'no_rekam_medik',
                    //                                        'value' => '',
                    //                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekamMedikInformasi'),
                    //                                        'options' => array(
                    //                                            'showAnim' => 'fold',
                    //                                            'minLength' => 2,
                    //                                            'focus' => 'js:function( event, ui ) {
                    //                                                    $(this).val(ui.item.label);
                    //                                                    return true;
                    //                                                }',
                    //                                            'select' => 'js:function( event, ui ) {
                    //                                                $(this).val(ui.item.label);
                    //                                                     return true;
                    //                                                          }',
                    //                                        ),
                    //                                        'htmlOptions'=>array(
                    //                                            'onkeypress'=>'return $(this).focusNextInputField(event)',
                    //                                            'disabled'=>($model->isNewRecord)?'':'disabled',
                    //                                            'class'=>'span1',
                    //                                        ),
                    //                                        'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                    //
                    //                                    ));
                    ?>
                </div>-->
<?php /* echo '<table>
                                                        <tr>
                                                            <td>'.CHtml::hiddenField('filter', 'instalasi', array('disabled'=>'disabled')).'<label>Instalasi Ruangan</label></td>
                                                            <td>'.$form->dropDownList($model, 'instalasi_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                'ajax' => array('type' => 'POST',
                                                                    'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' =>get_class($model))),
                                                                    'update' => '#ruangan',  //selector to update
                                                                ),
                                                            )).'
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label>Ruangan</label>
                                                            </td>
                                                            <td>
                                                                <div id="ruangan">
                                                                   <label>Pilih Instalasi terlebih dahulu</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                     </table>';  */ ?>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    );
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/peminjamanrmT/informasi'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang2',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<!--======================== Begin Widget Dialog Login Pemakai =============================-->
<?php
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//    'id' => 'dialogPasien',
//    'options' => array(
//        'title' => 'Data Pasien',
//        'autoOpen' => false,
//        'modal' => true,
//        'width' => 1000,
//        'height' => 550,
//        'resizable' => false,
//    ),
//));
?>
<?php
//$modPasien = new PasienM(); 
//$modPasien->unsetAttributes();
//if (isset($_GET['LoginpemakaiK'])){
//    $modPasien->attributes = $_GET['PasienM'];
//}
?>
<?php
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//    'id'=>'pasien-grid',
//    'dataProvider'=>$modPasien->search(),
//    'filter'=>$modPasien,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'columns'=>array(
//                        array(
//                            'header'=>'Pilih',
//                            'type'=>'raw',
//                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
//                                            array(
//                                                    "class"=>"btn-small",
//                                                    "id" => "selectPasien",
//                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
//                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
//                                                                          \$(\"#dialogPasien\").dialog(\"close\");"
//                                             )
//                             )',
//                        ),
//                        'nama_pasien',
//                        'no_rekam_medik',
//                        'jeniskelamin',
//                        'tanggal_lahir',
//        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
?>
<?php
//$this->endWidget(); 
?>
<!--=============================== endWidget Dialog Login Pemakai ============================-->
<!--=============================== BeginWidget Dialog Rekam Medik ============================-->
<?php
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//    'id' => 'dialogNoRekamMedik',
//    'options' => array(
//        'title' => 'Data Pasien',
//        'autoOpen' => false,
//        'modal' => true,
//        'width' => 1000,
//        'height' => 550,
//        'resizable' => false,
//    ),
//));
?>
<?php
//$modPasien = new PasienM(); 
//$modPasien->unsetAttributes();
//if (isset($_GET['LoginpemakaiK'])){
//    $modPasien->attributes = $_GET['PasienM'];
//}
?>
<?php
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//    'id'=>'norekammedik-grid',
//    'dataProvider'=>$modPasien->search(),
//    'filter'=>$modPasien,
//        'template'=>"{summary}\n{items}\n{pager}",
//        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//    'columns'=>array(
//                        array(
//                            'header'=>'Pilih',
//                            'type'=>'raw',
//                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
//                                            array(
//                                                    "class"=>"btn-small",
//                                                    "id" => "selectPasien",
//                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
//                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
//                                                                          \$(\"#dialogNoRekamMedik").dialog(\"close\");"
//                                             )
//                             )',
//                        ),
//                        'nama_pasien',
//                        'no_rekam_medik',
//                        'jeniskelamin',
//                        'tanggal_lahir',
//        ),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
?>
<?php //$this->endWidget(); 
?>
<!--=============================== endWidget Dialog Rekam Medik ============================-->
<script>
    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#ruangan input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#ruangan input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
    $(document).ready(function() {
        jQuery("#RKInformasipeminjamanrmV_instalasi_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var brands = jQuery('#RKInformasipeminjamanrmV_instalasi_id option:selected');
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                jQuery("#RKInformasipeminjamanrmV_ruangan_id").addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").html(data.ruangan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").multiselect('rebuild');
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").multiselect({
                                includeSelectAllOption: true,
                                buttonClass: "form-control",
                                maxHeight: 300,
                                buttonWidth: '182px',
                                enableCaseInsensitiveFiltering: true,
                            }).hide();
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onSelectAll: function() {
                var brands = jQuery('#RKInformasipeminjamanrmV_instalasi_id option:selected');
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                jQuery("#RKInformasipeminjamanrmV_ruangan_id").addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").html(data.ruangan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").multiselect('rebuild');
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").multiselect({
                                includeSelectAllOption: true,
                                buttonClass: "form-control",
                                maxHeight: 300,
                                buttonWidth: '182px',
                                enableCaseInsensitiveFiltering: true,
                            }).hide();
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onDeselectAll: function() {
                var brands = jQuery('#RKInformasipeminjamanrmV_instalasi_id option:selected');
                var selected = '';
                jQuery("#RKInformasipeminjamanrmV_ruangan_id").addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").html(data.ruangan);
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").multiselect('rebuild');
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").multiselect({
                                includeSelectAllOption: true,
                                buttonClass: "form-control",
                                maxHeight: 300,
                                buttonWidth: '182px',
                                enableCaseInsensitiveFiltering: true,
                            }).hide();
                            jQuery("#RKInformasipeminjamanrmV_ruangan_id").removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        }).hide();
        jQuery("#RKInformasipeminjamanrmV_ruangan_id").multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    });
</script>