<?php
if (isset($_GET['idMutasi']) && !empty($_GET['idMutasi'])) {
    Yii::app()->user->setFlash('success', ' Data ' . $model->nomutasibrg . ' berhasil disimpan.');
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-shopping-cart"></i> Transaksi <b>Mutasi Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gumutasibrg-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>
        <?php echo $form->errorSummary($model); ?>
        <?php
        if (isset($_GET['id'])) {
            $this->renderPartial('gudangUmum.views.mutasibrgT._dataPesan', array('modPesan' => $modPesan));
        }
        ?>
        <!--awal pemesanan-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Mutasi Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <?php if (!isset($_GET['id'])) { ?>
                    <div class="row">
                        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                                    ?></p>-->
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label("No. Pemesanan ", 'nopemesanan', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model' => $modPesan,
                                        'attribute' => 'nopemesanan',
                                        'source' => 'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutocompleteNoPemesanan') . '",
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
                                                $(this).val( ui.item.label);
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                $("#' . CHtml::activeId($modPesan, 'nopemesanan') . '").val(ui.item.nopemesanan);
                                                $("#' . CHtml::activeId($modPesan, 'tglpesanbarang') . '").val(ui.item.tglpesanbarang);
                                                $("#' . CHtml::activeId($modPesan, 'ruanganpemesan_id') . '").val(ui.item.ruanganpemesan_id);
                                                $("#' . CHtml::activeId($modPesan, 'ruanganpemesan_nama') . '").val(ui.item.ruanganpemesan_nama);
                                                $("#' . CHtml::activeId($modPesan, 'pegpemesan_id') . '").val(ui.item.pegpemesan_id);
                                                $("#' . CHtml::activeId($modPesan, 'pegpemesan_nama') . '").val(ui.item.pegpemesan_nama);
                                                $("#' . CHtml::activeId($model, 'pesanbarang_id') . '").val(ui.item.pesanbarang_id);
                                                listRuangan(ui.item.instalasi_id, ui.item.ruanganpemesan_id);
                                                submitMutasi();                                    
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'span3 nopsn alphanumeric-only',
                                            'placeholder' => 'No. Pemesanan',
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($modPesan, 'nopemesanan') . '").val(""); '
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPemesanan'),
                                    ));
                                    ?>
                                    <?php //echo $form->hiddenField($modPemesanan, 'nopemesanan',array('readonly'=>true)); 
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Tgl. Pesan Barang", 'tglpesanbarang', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo $form->textField($modPesan, 'tglpesanbarang', array('readonly' => true, 'class' => 'span3')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $form->hiddenField($modPesan, 'ruanganpemesan_id', array('readonly' => true)); ?>
                            <?php echo $form->textFieldRow($modPesan, 'ruanganpemesan_nama', array('class' => 'span4', 'readonly' => true)); ?>
                            <?php echo $form->hiddenField($modPesan, 'pegpemesan_id', array('readonly' => true)); ?>
                            <?php echo $form->textFieldRow($modPesan, 'pegpemesan_nama', array('class' => 'span4', 'readonly' => true)); ?>
                        </div>
                    </div>
                <?php } ?>
                <!--akhir pemesanan-->
                <div class="row">
                    <div class="col-sm-6">
                        <?php //echo $form->textFieldRow($model,'pesanbarang_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
                        ?>
                        <?php //echo $form->textFieldRow($model,'tglmutasibrg',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php echo $form->hiddenField($model, 'pesanbarang_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglmutasibrg', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($model, 'tglmutasibrg', array('class' => 'span3 realtime', 'readonly' => TRUE))
                                ?>
                                <?php echo $form->error($model, 'tglmutasibrg'); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'nomutasibrg', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textAreaRow($model, 'keterangan_mutasi', array('rows' => 4, 'cols' => 50, 'placeholder' => 'Keterangan Mutasi', 'class' => 'span3 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'ruangantujuan_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                    'empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                        'update' => '#' . CHtml::activeId($model, 'ruangantujuan_id') . ''
                                    ),
                                ));
                                ?><br>
                                <?php echo $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id' => $model->instalasi_id, 'ruangan_aktif' => true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                                <?php echo $form->error($model, 'ruangantujuan_id'); ?>
                            </div>
                        </div>
                        <?php //echo $form->textFieldRow($model,'pegpengirim_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'pegpengirim_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pegpengirim_id'); ?>
                                <?php echo $form->textField($model, 'pegpengirim_nama', array('class' => 'span4', 'readonly' => true)); ?>
                                <?php echo $form->error($model, 'pegpengirim_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Pegawai Mengetahui <span style='color:red;'>*</span>", 'pegmengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pegmengetahui_id'); ?>
                                <!--<div class="input-append" style='display:inline'>-->
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
                                            $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(pegawai_id); 
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'placeholder' => 'Nama Pegawai Mengetahui',
                                        'class' => 'span4 required hurufs-only'
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                                ));
                                ?>
                                <?php echo $form->error($model, 'pegmengetahui_id'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model,'totalhargamutasi',array('class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-credit-card"></i> Detail <b>Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('gudangUmum.views.mutasibrgT._formDetailBarang', array('model' => $model, 'form' => $form, 'modPesan' => $modPesan, 'modDetails' => $modDetails)); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Barang</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial('gudangUmum.views.mutasibrgT._tableDetailBarang', array('model' => $model, 'form' => $form, 'modDetails' => $modDetails, 'modPesan' => $modPesan)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => false, 'onclick' => 'cekValidasi();',)
                );
            }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/index') . '";}); return false;'
            ));
            ?>
            <?php
            if (isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => false));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
            }
            ?>
            <?php
            $content = $this->renderPartial('gudangUmum.views.mutasibrgT.tips.transaksi2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
        <?php
        //========= Dialog buat cari data pemesanan barang =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogPemesanan',
            'options' => array(
                'title' => 'Pencarian Data Pemesanan dari Unit Lain',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        $modPesann = new GUPesanbarangT('search');
        $modPesann->unsetAttributes();
        $modPesann->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['GUPesanbarangT'])) {
            $modPesann->attributes = $_GET['GUPesanbarangT'];
            $modPesann->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');
            $modPesann->ruanganpemesan_id = $_GET['GUPesanbarangT']['ruanganpemesan_id'];
            $modPesann->pegpemesan_id = $_GET['GUPesanbarangT']['pegpemesan_id'];
        }
        //$provider = $modPesann->searchPesanBarang();
        //$provider->criteria->addCondition('mutasibrg_id is null');
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'nopemesanan-grid',
            'dataProvider' => $modPesann->searchPesanBarang(),
            'filter' => $modPesann,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                    "href"=>"",
                                    "id" => "selectNopemesanan",
                                    "onClick" => "$(\"#' . CHtml::activeId($modPesan, 'nopemesanan') . '\").val(\"$data->nopemesanan\");
                                                  $(\"#' . CHtml::activeId($modPesan, 'tglpesanbarang') . '\").val(\"".MyFormatter::formatDateTimeForUser($data->tglpesanbarang)."\");
                                                  $(\"#' . CHtml::activeId($modPesan, 'ruanganpemesan_id') . '\").val(\"".$data->ruanganpemesan_id."\");                                                  
                                                  $(\"#' . CHtml::activeId($modPesan, 'pegpemesan_id') . '\").val(\"$data->pegpemesan_id\");                                                  
                                                  $(\"#' . CHtml::activeId($model, 'pesanbarang_id') . '\").val(\"$data->pesanbarang_id\");
                                                  $(\"#' . CHtml::activeId($model, 'instalasi_id') . '\").val(\"$data->instalasi_id\");
                                                  $(\"#' . CHtml::activeId($model, 'ruangantujuan_id') . '\").val(\"$data->ruanganpemesan_id\");
                                                  listRuangan(\"$data->instalasi_id\",\"$data->ruanganpemesan_id\");
                                                  submitMutasi();                                                  
                                                  $(\"#dialogPemesanan\").dialog(\"close\");
                                                  return false;
                                        "))',
                ),
                array(
                    'name' => 'tglpesanbarang',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanbarang)',
                    'filter' => false
                ),
                array(
                    'header' => 'No. Pemesanan',
                    'name' => 'nopemesanan',
                    'filter' => Chtml::activeTextField($modPesann, 'nopemesanan', array('class' => 'alphanumeric-only'))
                ),
                array(
                    'header' => 'Ruangan Pemesan',
                    'name' => 'ruanganpemesan_id',
                    'value' => '$data->ruanganpemesan->ruangan_nama',
                    'filter' => CHtml::activeDropDownList($modPesann, 'ruanganpemesan_id', CHtml::listData(RuanganM::model()->findAll(array('condition' => 'ruangan_aktif = true', 'order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'ruanganPemesan'))
                ),
                array(
                    'name' => 'pegpemesan_id',
                    'value' => '$data->pegawaipemesan->namaLengkap',
                    'filter' => CHtml::activeDropDownList($modPesann, 'pegpemesan_id', CHtml::listData(PegawaiM::model()->findAll(array('condition' => 'pegawai_aktif = true', 'order' => 'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --'))
                ),
                'keterangan_pesan'
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                . '$(".alphanumeric-only").keyup(function(){'
                . '  setAlphaNumericOnly(this);'
                . ' });'
                . '}',
        ));
        $this->endWidget();
        //========= end pemesanan barang dialog =============================
        ?>
        <?php
        //========= Dialog buat cari Bahan Diet =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogPegawaiMengetahui',
            'options' => array(
                'title' => 'Daftar Pegawai Mengetahui',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        $modPegawai = new GUPegawaiRuanganV('search');
        $modPegawai->unsetAttributes();
        if (isset($_GET['GUPegawaiRuanganV']))
            $modPegawai->attributes = $_GET['GUPegawaiRuanganV'];
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pegawai-m-grid',
            'dataProvider' => $modPegawai->searchDialog(),
            'filter' => $modPegawai,
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
                    'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
                ),
                array(
                    'header' => 'Jabatan',
                    'name' => 'jabatan_id',
                    'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                    'value' => function ($data) {
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                        if (!empty($j)) {
                            return $j->jabatan_nama;
                        } else {
                            return '-';
                        }
                    }
                ),
                /*
                        array(
                            'name' => 'agama',
                            'filter' => CHtml::dropDownList('GUPegawaiRuanganV[agama]',$modPegawai->agama,LookupM::getItems('agama'), array('empty'=>'-- Pilih --')),
                            'value' => '$data->agama',
                        ),
                        array(
                            'name' => 'jeniskelamin',
                            'filter' => CHtml::dropDownList('GUPegawaiRuanganV[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'), array('empty'=>'-- Pilih --')),
                            'value' => '$data->jeniskelamin',
                        ),
                       */
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
                'title' => 'Daftar Pegawai',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'height' => 500,
                'resizable' => false,
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
                                    $(\'#' . Chtml::activeId($model, 'pegpengirim_nama') . '\').val(\'$data->nama_pegawai\');
                                    $(\'#' . Chtml::activeId($model, 'pegpengirim_id') . '\').val(\'$data->pegawai_id\');
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
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printMutasi');
        $idMutasi = $model->mutasibrg_id;
        $urlGetMutasi =  $this->createUrl('getPesanBarangDariMutasi');
        $js = <<< JSCRIPT
    function submitMutasi()
    {
        idPesanbarang = $('#GUMutasibrgT_pesanbarang_id').val();
            if(idPesanbarang==''){
                alert('Silakan pilih no. pemesanan terlebih dahulu!');
            }else{
                $("#tableDetailBarang tbody tr").remove();
                $.post("${urlGetMutasi}", { idPesanbarang: idPesanbarang },
                function(data){
                    //if (typeof data.stok == "undefined") {
                    //  myAlert(data.pesan);
                   //}
                    //else{
                    $('.labelTotal').html('Total');
                    $('#GUPesanbarangT_ruanganpemesan_nama').val(data.ruangan_nama);
                    $('#GUPesanbarangT_pegpemesan_nama').val(data.nama_pegawai);
                    $('#tableDetailBarang').append(data.tr);
                    $("#tableDetailBarang tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                    renameInputRowBarang($("#tableDetailBarang"));
                   // hitungTotal();                
                  //}
                }, "json");
            }
            instalasiId = $('#GUMutasibrgT_instalasi_id').val();
    }
    function print(caraPrint)
    {
        window.open("${urlPrint}/&id=${idMutasi}&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                <?php
                if (isset($model->mutasibrg_id)) {
                ?>
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                        modul_id: <?php echo Yii::app()->session['modul_id'] ?>,
                        judulnotifikasi: 'Mutasi Barang',
                        isinotifikasi: 'Mutasi barang dari <?php echo Yii::app()->user->getState("ruangan_nama"); ?> ke <?php echo $model->ruangantujuan->ruangan_nama ?>'
                    }; // 16 
                    insert_notifikasi(params);
                <?php
                }
                ?>
            });

            function renameInputRowBarang(obj_table) {
                var row = 0;
                $(obj_table).find("tbody > tr").each(function() {
                    $(this).find("#no_urut").val(row + 1);
                    $(this).find('span').each(function() { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 3) {
                            $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                        }
                    });
                    $(this).find('input,select,textarea').each(function() { //element <input>
                        var old_name = $(this).attr("name").replace(/]/g, "");
                        var old_name_arr = old_name.split("[");
                        if (old_name_arr.length == 3) {
                            $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                            $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                        }
                    });
                    row++;
                });
            }
        </script>
        <script>
            function listRuangan(instalasi_id, ruangan_id) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('ActionDynamic/ListRuangan/'); ?>',
                    data: {
                        instalasi_id: instalasi_id,
                        ruangan_id: ruangan_id
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $('#GUMutasibrgT_ruangantujuan_id').html(data.listRuangan);
                        $('#GUMutasibrgT_ruangantujuan_id').val(data.ruangan_id);
                        $('#GUMutasibrgT_instalasi_id').val(data.instalasi_id);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }

            function cekValidasi() {
                if (requiredCheck($('#gumutasibrg-t-form'))) {
                    var is_cukup = true;
                    var is_mutasinol = true;
                    var is_stoknol = true;
                    var is_pesannol = true;
                    var is_pesanlebih = true;
                    var is_mutasikurang = true;
                    var ms_pesannol = '';
                    var ms_stoknol = '';
                    var ms_mutasinol = '';
                    var ms_cukup = '';
                    var ms_pesanlebih = '';
                    var ms_mutasikurang = '';
                    $("#tableDetailBarang tbody tr").each(function() {
                        $(this).removeClass("yellow");
                        $(this).removeClass("green");
                        $(this).removeClass("marron");
                        $(this).removeClass("hitam");
                        $(this).removeClass("blue");
                        $(this).removeClass("ungu");
                        var qty = parseFloat(unformatNumber($(this).find(".mutasi").val()));
                        var stok = parseFloat(unformatNumber($(this).find(".stok").val()));
                        var pesan_id = parseFloat($(this).find(".id").val());
                        var pesan_qty = parseFloat($(this).find(".pesan").val());
                        // console.log(qty, stok);
                        if (pesan_id > 0 && pesan_qty == 0) {
                            $(this).addClass("yellow");
                            is_pesannol = false;
                            ms_pesannol = "<span style='background:yellow;'>&nbsp;</span> Jumlah barang yang dipesan tidak boleh 0.<br>";
                        }
                        if (stok == 0) {
                            $(this).addClass("green");
                            is_stoknol = false;
                            ms_stoknol = "<span style='background:green;'>&nbsp;</span> Jumlah stok tidak mencukupi.<br>";
                        }
                        if (qty > stok) {
                            if (stok != 0) {
                                $(this).addClass("marron");
                                is_cukup = false;
                                ms_cukup = "<span style='background:maroon;'>&nbsp;</span> Jumlah mutasi tidak boleh melebihi jumlah stok.<br>";
                            }
                        }
                        if (qty == 0) {
                            $(this).addClass("hitam");
                            is_mutasinol = false;
                            ms_mutasinol = "<span style='background:#333;'>&nbsp;</span> Jumlah mutasi tidak boleh 0.<br>";
                        }
                    });
                    if (!is_mutasinol || !is_pesannol || !is_cukup || !is_stoknol) {
                        myAlert(ms_pesannol + ms_stoknol + ms_cukup + ms_mutasinol);
                        return false;
                    } else {
                        $("#tableDetailBarang tbody tr").each(function() {
                            $(this).removeClass("blue");
                            $(this).removeClass("ungu");
                            var qty = parseFloat(unformatNumber($(this).find(".mutasi").val()));
                            var stok = parseFloat(unformatNumber($(this).find(".stok").val()));
                            var pesan_id = parseFloat($(this).find(".id").val());
                            var pesan_qty = parseFloat($(this).find(".pesan").val());
                            if (pesan_qty != 0 && stok != 0) {
                                //alert(qty);
                                //alert(pesan_qty);
                                if (qty != pesan_qty) {
                                    $(this).addClass("ungu");
                                    is_mutasikurang = false;
                                    ms_mutasikurang = "<span style='background:purple;'>&nbsp;</span> Jumlah mutasi tidak sama dengan jumlah pesan.<br>";
                                }
                                if (pesan_qty > stok) {
                                    $(this).addClass("ungu");
                                    is_pesanlebih = false;
                                    ms_pesanlebih = "<span style='background:purple;'>&nbsp;</span> Jumlah pemesanan melebihi stok.<br>";
                                }
                            }
                        });
                        //alert(is_mutasikurang);
                        //alert(is_pesanlebih);
                        if (!is_mutasikurang || !is_pesanlebih) {
                            myConfirm(ms_pesanlebih + ms_mutasikurang + "Apakah Anda yakin, tetap melanjutkan transaksi ini?", "Perhatian", function(r) {
                                if (r) {
                                    $('#gumutasibrg-t-form').submit();
                                }
                            });
                        } else {
                            $('#gumutasibrg-t-form').submit();
                        }
                    }
                    // return false;
                }
                return false;
            }
        </script>
    </div>
</div>