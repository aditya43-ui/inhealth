<?php
$this->breadcrumbs = array(
    'Informasi Asuransi Pasien',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Asuransi Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'cariasuransipasien-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'method' => 'GET',
            'focus' => '#' . CHtml::activeId($modAsuransi, 'nopeserta'),
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        Yii::app()->clientScript->registerScript('cariPasien', "
    $('#cariasuransipasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianasuransipasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsuransi, 'Perusahaan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modAsuransi, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = true order by penjamin_nama'), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Perusahaan'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsuransi, 'Kelas Tanggungan Asuransi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modAsuransi, 'kelastanggunganasuransi_id', CHtml::listData($modAsuransi->getKelasTanggungan(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array(
                                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsuransi, 'No Peserta', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAsuransi, 'nopeserta', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Peserta')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsuransi, 'Pemilik Asuransi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAsuransi, 'namapemilikasuransi', array('class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pemilik Asuransi')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsuransi, 'No. Rekam Medik', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAsuransi, 'no_rekam_medik', array('class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'No. Rekam Medik')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsuransi, 'Nama Pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAsuransi, 'nama_pasien', array('class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pasien')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsuransi, 'Status Asuransi Pasien', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modAsuransi, 'asuransipasien_aktif', array('1' => 'Aktif', '0' => 'Non-aktif'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:176px')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="control-group" hidden>
                            <?php echo $form->labelEx($modAsuransi, 'Pegawai Penanggung Jawab', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modAsuransi, 'pegawaipenanggung_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'placeholder' => 'Nama Pegawai Penjamin')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                        )
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiAsuransiPasien', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Asuransi Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pencarianasuransipasien-grid',
                    'dataProvider' => $modAsuransi->searchInformasi(),
                    //                'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    'columns' => array(
                        array(
                            'header' => 'Perusahaan',
                            'name' => 'namaperusahaan',
                            'type' => 'raw',
                            'value' => '(($data->namaperusahaan)?$data->namaperusahaan:"-")'
                        ),
                        array(
                            'header' => 'Kelas Tanggungan',
                            'name' => 'kelastanggunganasuransi_nama',
                            'type' => 'raw',
                            'value' => '$data->kelastanggunganasuransi_nama'
                        ),
                        array(
                            'header' => 'No. Peserta',
                            'name' => 'nopeserta',
                            'type' => 'raw',
                            'value' => '$data->nopeserta'
                        ),
                        array(
                            'header' => 'Pemilik Asuransi',
                            'name' => 'namapemilikasuransi',
                            'type' => 'raw',
                            'value' => '$data->namapemilikasuransi'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik'
                        ),
                        array(
                            'header' => 'Pasien',
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => '$data->NamaLengkap'
                        ),
                        array(
                            'header' => 'Tanggal Lahir',
                            'name' => 'tanggal_lahir',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)'
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'name' => 'jeniskelamin',
                            'type' => 'raw',
                            'value' => '$data->jeniskelamin'
                        ), /*
                              array(
                              'header'=>'Pegawai Penjamin',
                              'name'=>'pegawaipenanggung_nama',
                              'type'=>'raw',
                              'value'=>'$data->NamaLengkapPegawai'
                              ), */
                        array(
                            'header' => 'Hubungan Keluarga',
                            'name' => 'hubkeluarga',
                            'type' => 'raw',
                            'value' => '(($data->hubkeluarga)?$data->hubkeluarga:"-")'
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            //						'value'=>($data->asuransipasien_aktif),
                            //						'value'=>'($data->asuransipasien_aktif == 1 ) ? CHtml::link("Aktif"),"javascript:removeTemporary($data->menu_id)",array("id"=>"$data->menu_id","rel"=>"tooltip","title"=>"Menonaktifkan Menu")."  : "Non-Aktif"',
                            'value' => '($data->asuransipasien_aktif == 1) ? CHtml::link("Aktif","javascript:nonaktifTemporary($data->asuransipasien_id)",array("id"=>"asuransipasien_id","rel"=>"tooltip","title"=>"Klik untuk menonaktifkan asuransi pasien")) : CHtml::link("Non-aktif", "javascript:aktifTemporary($data->asuransipasien_id)",array("id"=>"asuransipasien_id","rel"=>"tooltip","title"=>"Klik untuk mengaktifkan asuransi pasien"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        array(
                            'header' => 'Lihat',
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("informasiAsuransiPasien/view",array("id"=>$data->asuransipasien_id,"frame"=>1)),
                                                                            array("class"=>"", 
                                                                                      "target"=>"iframeDetail",
                                                                                      "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                                                                      "rel"=>"tooltip",
                                                                                      "title"=>"Klik untuk lihat detail ",
                                                                            ))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
    <?php $this->endWidget(); ?>
    <?php
    // Dialog buat detail asuransi pasien =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Asuransi Pasien',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 980,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe src="" name="iframeDetail" width="100%" height="300">
    </iframe>
    <?php
    $this->endWidget();
    //========= end asuransi pasien =============================
    ?>
    <script type="text/javascript">
        function nonaktifTemporary(id) {
            var url = '<?php echo $url . "/nonaktifTemporary"; ?>';
            myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('pencarianasuransipasien-grid');
                            } else {
                                myAlert('Data gagal dinonaktifkan!')
                            }
                        }, "json");
                }
            });
        }

        function aktifTemporary(id) {
            var url = '<?php echo $url . "/aktifTemporary"; ?>';
            myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('pencarianasuransipasien-grid');
                            } else {
                                myAlert('Data Gagal di Aktifkan')
                            }
                        }, "json");
                }
            });
        }
    </script>
</div>