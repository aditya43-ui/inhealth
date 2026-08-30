    <?php
    $link_batal = Yii::app()->controller->id;
    ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gupesanbarang-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )); ?>
    <?php
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        Yii::app()->user->setFlash('success', ' Data ' . $model->nopemesanan . ' berhasil disimpan.');
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Pemesanan Barang</b>
            </div>
        </div>
        <div class="panel-body">
            <?php
            echo $form->errorSummary(array($model));
            ?>
            <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                        ?></p>-->
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglpesanbarang', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->textField($model, 'tglpesanbarang', array('readonly' => TRUE, 'class' => 'span3 realtime'));
                            ?>
                            <?php echo $form->error($model, 'tglpesanbarang'); ?>
                        </div>
                    </div>

                    <?php echo $form->hiddenField($model, 'nopemesanan', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>

                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglmintadikirim', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmintadikirim',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    // 'minDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                            ));
                            ?>
                            <?php echo $form->error($model, 'tglmintadikirim'); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label('Ruangan Tujuan <span style="color:red;">*</span>', 'ruangantujuan_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                'autofocus' => true, 'empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => '#' . CHtml::activeId($model, 'ruangantujuan_id') . ''
                                ),
                            ));
                            ?><br>
                            <?php echo $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $model->instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama ASC')), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'required span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'refreshDialogBarang();')); ?>
                            <?php echo $form->hiddenField($model, 'ruanganpemesan_id', array('readonly' => true)); ?>
                            <?php echo $form->error($model, 'ruanganpemesan_id'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'pegpemesan_id', array('class' => 'control-label required')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegpemesan_id'); ?>
                            <?php echo $form->textField($model, 'pegpemesan_nama', array('class' => 'span4 required', 'readonly' => true)); ?>
                            <?php

                            ?>
                            <?php echo $form->error($model, 'pegpemesan_id'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo Chtml::label("Pegawai Mengetahui <span style='color:red'>*</span>", 'pegmengetahui_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegmengetahui_id', array('class' => 'required')); ?>
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'pegmengetahui_nama',
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
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span4 required hurufs-only',
                                    'placeholder' => 'Pegawai Mengetahui',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textAreaRow($model, 'keterangan_pesan', array('placeholder' => 'Keterangan Pesan', 'rows' => 4, 'cols' => 50, 'class' => 'span4 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

                    <?php //echo $form->textFieldRow($model,'pegpemesan_id',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>

                    <?php //echo $form->textFieldRow($model,'pegmengetahui_id',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                    ?>
                    <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
                    ?>
                    <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-credit-card"></i> Detail <b>Barang</b>
            </div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('gudangUmum.views.pesanbarangT._formDetailBarang', array('model' => $model, 'form' => $form, 'modDetail' => $modDetail)); ?>
            <?php $this->renderPartial('gudangUmum.views.pesanbarangT._tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetail' => $modDetail)); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php
        if (isset($_GET['sukses'])) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
            );
        } else {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => false)
            );
        }
        ?>
        <?php //if ($model->isNewRecord) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                //                                      'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
            )
        );
        ?>
        <?php //} 
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => false));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
        }
        ?>
        <?php
        $content = $this->renderPartial('gudangUmum.views.pesanbarangT.tips.transaksi2', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php
    //========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPegawaiMengetahui',
        'options' => array(
            'title' => 'Daftar Pegawai',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => true,
        ),
    ));

    $modPegawai = new GUPegawaiRuanganV('search');
    $modPegawai->unsetAttributes();
    //$modPegawai->ruangan_id = 0;
    if (isset($_GET['GUPegawaiRuanganV']))
        $modPegawai->attributes = $_GET['GUPegawaiRuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai-m-grid',
        'dataProvider' => $modPegawai->searchDialog(),
        'filter' => $modPegawai,
        // 'template' => "{items}\n{pager}",
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => "
                                            $(\'#' . Chtml::activeId($model, 'pegmengetahui_nama') . '\').val(\'$data->nama_pegawai\');
                                            $(\'#' . Chtml::activeId($model, 'pegmengetahui_id') . '\').val(\'$data->pegawai_id\');
                                            $(\'#dialogPegawaiMengetahui\').dialog(\'close\');
                                            return false;"))',
            ),
            array(
                'header' => 'NIP',
                'name' => 'nomorindukpegawai',
                'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
            ),
            array(
                'header' => 'Nama Pegawai',
                'name' => 'nama_pegawai',
                'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
            ),
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'value' => function ($data) {
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    if (!empty($j)) {
                        return $j->jabatan_nama;
                    } else {
                        return '-';
                    }
                },
                'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
            ),
            /* 'alamat_pegawai',
            'agama',
            array(
                'name' => 'jeniskelamin',
                'filter' => CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
                'value' => '$data->jeniskelamin',
            ),*/

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
            . '$(".numbers-only").keyup(function(){'
            . 'setNumbersOnly(this);'
            . '});'
            . '$(".hurufs-only").keyup(function(){'
            . 'setHurufsOnly(this);'
            . '});'
            . '}',
    ));

    $this->endWidget();
    ?>
    <?php
    //========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogPegawai',
        'options' => array(
            'title' => 'Daftar Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => true,
        ),
    ));

    $modPegawai2 = new GUPegawaiM('search');
    $modPegawai2->unsetAttributes();
    //$modPegawai->ruangan_id = 0;
    if (isset($_GET['GUPegawaiM']))
        $modPegawai2->attributes = $_GET['GUPegawaiM'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pegawai-m-grid2',
        'dataProvider' => $modPegawai2->searchDialog(),
        'filter' => $modPegawai2,
        //'template' => "{items}\n{pager}",
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                        "id" => "selectBahan",
                                        "onClick" => "
                                        $(\'#' . Chtml::activeId($model, 'pegpemesan_nama') . '\').val(\'$data->nama_pegawai\');
                                        $(\'#' . Chtml::activeId($model, 'pegpemesan_id') . '\').val(\'$data->pegawai_id\');
                                        $(\'#dialogPegawai\').dialog(\'close\');
                                        return false;"))',
            ),
            'nama_pegawai',
            'nomorindukpegawai',
            'alamat_pegawai',
            'agama',
            array(
                'name' => 'jeniskelamin',
                'filter' => CHtml::dropDownList('GUPegawaiM[jeniskelamin]', $modPegawai->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
                'value' => '$data->jeniskelamin',
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ?>
    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '',
            'precision' => 0,
        )
    ));
    ?>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $idPesan = $model->pesanbarang_id;
    $js = <<< JSCRIPT
    function print(caraPrint)
    {
        window.open("${urlPrint}/&id=${idPesan}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
    <script type="text/javascript">
        function print(caraPrint) {
            var pesanbarang_id = '<?php echo (!empty($model->pesanbarang_id)) ? $model->pesanbarang_id : null; ?>';
            window.open('<?php echo $this->createUrl('print'); ?>&id=' + pesanbarang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
        }
        $(document).ready(function() {
            <?php
            if (isset($model->pesanbarang_id)) {
            ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Params::MODUL_ID_GUDANGUMUM; ?>,
                    judulnotifikasi: 'Pesan Barang',
                    isinotifikasi: 'Pemesanan barang dari <?php echo Yii::app()->user->getState("ruangan_nama"); ?> ke <?php echo $model->ruanganpemesan->ruangan_nama ?>'
                }; // 16 
                insert_notifikasi(params);
            <?php } ?>

            refreshDialogBarang();
        })

        function refreshDialogBarang() {
            $("#namaBarang").addClass("animation-loading-1");
            var ru = $("#GUPesanbarangT_ruangantujuan_id option:selected").html();

            setTimeout(function() {
                $("#dialog_ruangan").html(ru);
                $("#namaBarang").removeClass("animation-loading-1");
            }, 500);
        }

        $('#tombolDialogBarang').click(function() {
            refreshDialogBarang();
            var ruangan_id = $('#<?php echo CHtml::activeId($model, "ruangantujuan_id") ?>').val();
            //alert(ruangan_id);
            $(".dialog_ruangan_id").val(ruangan_id);
            $.fn.yiiGridView.update('barang-m-grid', {
                data: {
                    "GUInformasistokbarangV[ruangan_id]": ruangan_id,
                }
            });
        });
    </script>