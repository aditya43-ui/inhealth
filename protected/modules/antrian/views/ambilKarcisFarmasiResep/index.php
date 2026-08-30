<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-ticket"></i> Karcis <b>Antrian Ke Farmasi</b>
            <span class='tombol'><?php echo CHtml::link(Yii::t('mds', '{icon} Kembali Ke informasi', array('{icon}' => '<i class="fas fa-external-link-alt"></i>')),
                                        $this->createUrl('InformasiPasienResep' . '/index'),
                                        array(
                                            'class' => 'btn btn-default',
                                            // 'target'=>"_blank"
                                        )
                                     ); ?>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Tiket Antrian Farmasi ',
        );
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', 'Data karcis farmasi berhasil disimpan!');
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-ticket"></i> Buat Karcis
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'anantrianfarmasi-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#' . CHtml::activeId($model, 'racikan_id'),
                ));
                ?>

                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->

                <?php echo $form->errorSummary($model); ?>

                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model, 'url_referrer'); ?>
                        <?php echo $form->hiddenField($model, 'is_tambah'); ?>
                        <?php echo $form->textFieldRow($model, 'tglambilantrian', array('class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php // echo $form->textFieldRow($model,'racikan_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));  
                        ?>

                        <?php#endregion
                        
                            echo CHtml::hiddenField('is_tambah', "tes");
                        ?>

                        <div class="control-group">
                            <?php echo CHtml::label("No. Resep <span class='required'>*</span>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'noresep',
                                    'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutocompleteResep') . '",
                                                dataType: "json",
                                                data: {
                                                    noresep: request.term,
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
                                                    $("#ANAntrianfarmasiT_reseptur_id").val(ui.item.reseptur_id);
                                                    $("#ANAntrianfarmasiT_noresep").val(ui.item.noreseptur);
                                                    return false;
                                                }',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogResep'),
                                    'htmlOptions' => array(
                                        'placeholder' => 'No. Resep', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'No. Resep / klik icon untuk mencari data resep',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                    ),
                                ));

                                echo $form->hiddenField($model, 'reseptur_id', array('class' => 'span2 reseptur_id', 'readonly' => true));
                                ?>
                                
                            </div>
                            <div class="controls">
                            <?php
                                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                                        'class' => 'btn btn-primary', 'onclick' => "$('#ANAntrianfarmasiT_is_tambah').val('yes');$('#dialogResep').dialog('open');",
                                        'id' => 'btnAddResep', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah No. Resep'
                                    ))
                                ?>
                            </div>
                        </div>

                        <?php echo $form->dropDownListRow($model, 'racikan_id', $model->getListRacikans(), array('class' => 'span3', 'empty' => '-- Pilih --')) ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'noantrian', array('readonly' => true, 'placeholder' => 'Otomatis', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label("Loket Antrian <span class='required'>*</span>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->radioButtonList($model, 'modelantrian_id', CHtml::listData(ModelantrianM::model()->findAll("modelantrian_singkatan <> 'K' AND modelantrian_aktif=TRUE ORDER BY modelantrian_id"), 'modelantrian_id', 'modelantrian_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                        <?php /*
                                <div class="control-group">
                                    <?php echo CHtml::label("No. Antrian Kasir", 'noantrian_kasir', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'noantrian_kasir', array('readonly' => true, 'placeholder' => 'Otomatis', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
                                    </div>
                                </div>
                                 * 
                                 */ ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php
                    if ($model->isNewRecord) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                        );
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'disabled' => true, 'class' => 'btn btn-danger', 'type' => 'button', 'style' => 'cursor:not-allowed;')
                        );
                    }
                    ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                        'class' => 'btn btn-default',
                        'title' => 'Ulang',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = ' . $this->createUrl($this->id . '/index') . '}); return false;'
                    ));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Karcis Terakhir</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_tableKarcisTerakhir'); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (isset($_GET['id'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn btn-info', 'type' => 'button', 'onclick' => 'printKarcisFarmasi(' . $model->antrianfarmasi_id . ',\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn btn-info', 'disabled' => true, 'type' => 'button', 'style' => 'cursor:not-allowed;'));
            }
            echo ' ';
            ?>
            <?php
            if (isset($_GET['id'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Resep', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn btn-info', 'type' => 'button', 'onclick' => 'printKarcisFarmasiResep(' . $model->reseptur_id . ',\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Resep', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn btn-info', 'disabled' => true, 'type' => 'button', 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
    <?php echo $this->renderPartial($this->path_view . '_jsFunctions'); ?>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogResep',
    'options' => array(
        'title' => 'Pencarian Data Resep Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 630,
        'resizable' => false,
    ),
));
$modResep = new FAInformasiresepturV('searchPasienRumahsakitV');
$modResep->unsetAttributes();
if (isset($_GET['FAInformasiresepturV'])) {
    $modResep->attributes = $_GET['FAInformasiresepturV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'resep-grid',
    'dataProvider' => $modResep->searchAntrianResep(),
    'filter' => $modResep,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                "id" => "selectPendaftaran",
                "onClick" => "

                    // if(\"$data->antrianfarmasi_id\" != \"\"){
                    //     myAlert(\"Resep pasien sudah dibuatkan cetak antrian\");
                    //     return false;
                    // }

                    var data = $(\"#ANAntrianfarmasiT_noresep\").val();
                    var data_id = $(\"#ANAntrianfarmasiT_reseptur_id\").val();

                    console.log(data);
                    console.log(\"$data->noreseptur\");

                    var is_tbh = $(\"#ANAntrianfarmasiT_is_tambah\").val();

                    console.log(\"tbh: \" + is_tbh);

                    if(is_tbh == \"yes\") {
                        if(data == \"\") {
                            $(\"#ANAntrianfarmasiT_noresep\").val(\"$data->noreseptur\");
                            $(\"#ANAntrianfarmasiT_reseptur_id\").val(\"$data->reseptur_id\");
                        } else {
                            $(\"#ANAntrianfarmasiT_noresep\").val(data + \", \" + \"$data->noreseptur\");
                            $(\"#ANAntrianfarmasiT_reseptur_id\").val(data_id + \", \" + \"$data->reseptur_id\");
                        }
                        $(\"#ANAntrianfarmasiT_is_tambah\").val(\"no\");
                    } else {
                        $(\"#ANAntrianfarmasiT_noresep\").val(\"$data->noreseptur\");
                        $(\"#ANAntrianfarmasiT_reseptur_id\").val(\"$data->reseptur_id\");

                    }
                    $(\"#dialogResep\").dialog(\"close\");
                "))',
        ),
        array(
            'header' => 'Tgl. Resep/<br>No. Resep',
            'name' => 'noreseptur',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglreseptur)."<br>".$data->noreseptur',
        ),
        array(
            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
            'type' => 'raw',
            'name' => 'no_pendaftaran',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran',
        ),
        'no_rekam_medik',
        array(
            'name' => 'nama_pasien',
            'value' => '$data->namadepan.$data->nama_pasien',
        ),
        array(
            'header' => 'Jenis Kelamin/<br>Umur',
            'type' => 'raw',
            'value' => '$data->jeniskelamin."/<br>".$data->umur',
        ),
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>