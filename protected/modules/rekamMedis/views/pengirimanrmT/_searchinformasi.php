<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rmpengirimanrm-t-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
    <div class="col-sm-12">
        <?php /*//echo $form->textFieldRow($model, 'tglrekammedis', array('class' => 'span4')); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pengiriman','tglpengirimanrm',array('class'=>'control-label')); ?>
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
                        </div>
						 * 
						 */ ?>
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pengiriman", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <!--<?php // echo CHtml::label('No. Rekam Medik','no_rekam_medik',array('class'=>'control-label')); 
            ?>
                        <div class="controls">
                            <?php
                            //                    $this->widget('MyJuiAutoComplete', array(
                            //                        'model' => $model,
                            //                        'attribute' => 'no_rekam_medik',
                            //                        'value' => '',
                            //                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekamMedikInformasi'),
                            //                        'options' => array(
                            //                            'showAnim' => 'fold',
                            //                            'minLength' => 2,
                            //                            'focus' => 'js:function( event, ui ) {
                            //                                    $(this).val(ui.item.label);
                            //                                    return true;
                            //                                }',
                            //                            'select' => 'js:function( event, ui ) {
                            //                                $(this).val(ui.item.label);
                            //                                     return true;
                            //                                          }',
                            //                        ),
                            //                        'htmlOptions'=>array(
                            //                            'onkeypress'=>'return $(this).focusNextInputField(event)',
                            //                            'disabled'=>($model->isNewRecord)?'':'disabled',
                            //                            'class'=>'span1',
                            //                        ),
                            //                        'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                            //
                            //                    ));
                            ?>
                        </div>-->
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span4 hurufs-only', 'autofocus' => true, 'placeholder' => 'Nama Pasien')); ?>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span4 numbers-only', 'placeholder' => 'No. Rekam Medik', 'maxlength' => 6)); ?>
        <div class="control-group">
            <?php echo Chtml::label('Petugas Pengirim', 'create_loginpemakai_id', array('class' => 'control-label'));
            ?>
            <div class="controls">
                <?php
                echo $form->DropDownList($model, 'create_loginpemakai_id', Chtml::ListData(RKPegawaiM::model()->getPegawai(), 'loginpemakai_id', 'namaLengkap'), array('class' => 'span4', 'empty' => '-- Pilih --')) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Status Print', 'printpengiriman', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->DropDownList($model, 'printpengiriman', array(null => '-- Pilih ---', '1' => 'Sudah diprint', '0' => 'Belum diprint'), array('class' => 'span4')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi Asal', 'instalasipengirim_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'instalasipengirim_id',
                    CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuanganAsal', array('encode' => false, 'model_nama' => get_class($model))),
                            'update' => "#" . CHtml::activeId($model, 'ruanganpengirim_id'),
                        )
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan Asal', 'ruanganpengirim_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruanganpengirim_id', array(), array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); //CHtml::listData($model->getRuanganItems($model->instalasipengirim_id), 'ruangan_id', 'ruangan_nama')
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi Tujuan', 'instalasitujuan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList(
                    $model,
                    'instalasitujuan_id',
                    CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'),
                    array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownRuanganTujuan', array('encode' => false, 'model_nama' => get_class($model))),
                            'update' => "#" . CHtml::activeId($model, 'ruangantujuan_id'),
                        )
                    )
                ); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan Tujuan', 'ruangantujuan_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'ruangantujuan_id', array(), array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); //CHtml::listData($model->getRuanganItems($model->instalasitujuan_id), 'ruangan_id', 'ruangan_nama') 
                ?>
            </div>
        </div>
        <?php // echo CHtml::label('Nama Pasien','nama_pasien',array('class'=>'control-label')); 
        ?>
        <!--<div class="controls">
                        <?php
                        //                $this->widget('MyJuiAutoComplete', array(
                        //                    'model' => $model,
                        //                    'attribute' => 'nama_pasien',
                        //                    'value' => '',
                        //                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/PasienInformasi'),
                        //                    'options' => array(
                        //                        'showAnim' => 'fold',
                        //                        'minLength' => 2,
                        //                        'focus' => 'js:function( event, ui ) {
                        //                                $(this).val(ui.item.label);
                        //                                return true;
                        //                            }',
                        //                        'select' => 'js:function( event, ui ) {
                        //                            $(this).val(ui.item.label);
                        //                                 return true;
                        //                                      }',
                        //                    ),
                        //                    'htmlOptions'=>array(
                        //                        'onkeypress'=>'return $(this).focusNextInputField(event)',
                        //                        'disabled'=>($model->isNewRecord)?'':'disabled',
                        //                        'class'=>'span2',
                        //                    ),
                        //                    'tombolDialog'=>array('idDialog'=>'dialogPasien'),
                        //
                        //                ));
                        ?>
                    </div>-->
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    );
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/pengirimanrmT/informasi'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.informasi', array(), true);
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
//
//$modPasien = new PasienM(); 
//$modPasien->unsetAttributes();
//if (isset($_GET['LoginpemakaiK'])){
//    $modPasien->attributes = $_GET['PasienM'];
//}
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
//
//$modPasien = new PasienM(); 
//$modPasien->unsetAttributes();
//if (isset($_GET['LoginpemakaiK'])){
//    $modPasien->attributes = $_GET['PasienM'];
//}
// $this->widget('ext.bootstrap.widgets.BootGridView',array(
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
// $this->endWidget(); 
?>
<!--=============================== endWidget Dialog Rekam Medik ============================-->