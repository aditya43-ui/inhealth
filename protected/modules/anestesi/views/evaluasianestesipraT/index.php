<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'evaluasianestesipra-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
$this->widget('bootstrap.widgets.BootAlert');

$myicon = new MyIcon();
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> Evaluasi Pra Anestesi / Pra Sedasi</div>
    </div>
    <div class="panel panel-body">
        <div class="anamnesa">
            <?php $this->renderPartial($this->path_form . 'formAnamnesa', array('model' => $model, 'form' => $form)); ?>
        </div>
        <div class="fisik">
            <?php $this->renderPartial($this->path_form . 'formFisik', array('model' => $model, 'form' => $form)); ?>
        </div>
        <div class="clear"></div>
        <div class="sistem-organ">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title"> Fungsi Sistem Organ  </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_form . 'formSistemOrgan', array('model' => $model, 'form' => $form)); ?>
                </div>
            </div>
        </div>
        <div class="row-fluid catatan">
            <?php $this->renderPartial($this->path_form . '_formCatatan', array('model' => $model, 'form' => $form)); ?>
        </div>
        <div class="row-fluid">
            <div class="control-group">
                <?php
                echo CHtml::label("Tanggal / Jam <i style='color: red'> * </i>", "tanggalpemeriksaan", array(
                    'class' => 'control-label'
                ));
                ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggalpemeriksaan',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                        <?php echo CHtml::label("Diperiksa Oleh <i style='color: red'> * </i>", 'koordinatormutu_id', array('class' => 'control-label')) ?>
                <div class = "controls">
                    <div class="control-group ">
                        <?php
                        echo $form->hiddenField($model, 'pegawai_id');
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'pegawai_nama',
                            'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.nama_pegawai);
                                                return false;
                                            }',
                                'select' => 'js:function( event, ui ) {
                                                return false;
                                            }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Ketikan Nama Pegawai Pengirim',
                                'class' => 'span3 required hurufs-only'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger required', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl('index'), array('class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'));
                    ?>
                    <?php
                    $tips = array(
                        '0' => 'tanggal',
                        '1' => 'cari',
                        '2' => 'ulang'
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.transaksi', array('tips' => $tips), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->renderPartial($this->path_view . 'jsFunctions', array('model' => $model)); ?>
    <?php $this->endWidget(); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogPegawai',
        'options' => array(
            'title' => 'Pencarian Data Petugas',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'height' => 500,
            'resizable' => false,
        ),
    ));

    $modDialogPetugas = new PegawairuanganV('search');
    $modDialogPetugas->unsetAttributes();
    $modDialogPetugas->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['PegawairuanganV'])) {
        $modDialogPetugas->attributes = $_GET['PegawairuanganV'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'datakunjungan-grid',
        'dataProvider' => $modDialogPetugas->searchDialogPegRuangan(),
        'filter' => $modDialogPetugas,
        'template' => "{summaryNonPage}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectAmbulans",
                    "onClick" => "
                        $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                        $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->nama_pegawai\");
                        $(\"#dialogPegawai\").dialog(\"close\");
                "))',
            ),
            'nomorindukpegawai',
            'nama_pegawai'
        ),
        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
    ));
    $this->endWidget();
    ?>
