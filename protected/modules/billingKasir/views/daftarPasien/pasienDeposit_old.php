<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Deposit</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Daftar Pasien' => array('/billingKasir/daftarPasien'),
        'PasienKarcis',
    ); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'caripasien-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#BKBayaruangmukaT_no_rekam_medik',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Deposit</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pencarianpasien-grid',
            'dataProvider' => $model->searchPasienDeposit(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tanggal Deposit',
                    'name' => 'tgluangmuka',
                    'type' => 'raw',
                    'value' => '$data->tgluangmuka',
                ),
                array(
                    'header' => 'Instalasi Asal',
                    'name' => 'instalasi',
                    'type' => 'raw',
                    'value' => 'isset($data->pendaftaran->instalasi_id)?$data->pendaftaran->instalasi->instalasi_nama:" - "',
                ),
                array(
                    'header' => 'No. Pendaftaran<br>No. RM',
                    'type' => 'raw',
                    'value' => '$data->pendaftaran->no_pendaftaran . " <br> " . $data->pasien->no_rekam_medik',
                ),
                array(
                    'name' => 'nama_pasien',
                    'type' => 'raw',
                    'value' => '$data->pasien->nama_pasien',
                ),
                array(
                    'header' => 'Alias',
                    'name' => 'nama_bin',
                    'type' => 'raw',
                    'value' => '$data->pasien->nama_bin',
                ),
                array(
                    'header' => 'Jenis Penjamin',
                    'name' => 'carabayar_nama',
                    'type' => 'raw',
                    'value' => '$data->pendaftaran->carabayar->carabayar_nama',
                ),
                array(
                    'header' => 'Penjamin',
                    'name' => 'penjamin_nama',
                    'type' => 'raw',
                    'value' => '$data->pendaftaran->penjamin->penjamin_nama',
                ),
                //            array(
                //                'header'=>'Kasus Penyakit',
                //                'name'=>'jeniskasuspenyakit_nama',
                //                'type'=>'raw',
                //                'value'=>'$data->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama',
                //            ),
                //            array(
                //                'name'=>'umur',
                //                'type'=>'raw',
                //                'value'=>'$data->pendaftaran->umur',
                //            ),
                //            array(
                //                'header'=>'Alamat',
                //                'name'=>'alamat_pasien',
                //                'type'=>'raw',
                //                'value'=>'$data->pasien->alamat_pasien',
                //            ),
                array(
                    'header' => 'Jumlah Uang Muka (Rp)',
                    'name' => 'jumlahuangmuka',
                    'type' => 'raw',
                    'value' => 'number_format($data->jumlahuangmuka,0,",",".")',
                    'htmlOptions' => array('style' => 'text-align: left; width:80px')
                ),
                array(
                    'header' => 'Pemakaian Uang Muka (Rp)',
                    'type' => 'raw',
                    'value' => 'number_format($data->pemakaianuangmuka,0,",",".")',
                    'htmlOptions' => array('style' => 'text-align: left; width:80px')
                ),
                array(
                    'header' => 'Sisa Uang Muka (Rp)',
                    'type' => 'raw',
                    'value' => 'number_format($data->sisauangmuka,0,",",".")',
                    'htmlOptions' => array('style' => 'text-align: left; width:80px')
                ),
                //                    array(
                //                        'header'=>'Jumlah Pembayaran (Rp)',
                //                        'type'=>'raw',
                //                        'value'=>'number_format($data->jmlpembayaran,0,",",".")',
                //                        'htmlOptions'=>array('style'=>'text-align: left; width:80px')
                //                    ),
                array(
                    'header' => 'Sisa Pembayaran',
                    'type' => 'raw',
                    'value' => '$data->sisaPembayaran($data->jmlpembayaran,$data->jumlahuangmuka)',
                    'htmlOptions' => array('style' => 'text-align: left; width:80px')
                ),
                array(
                    'name' => 'keteranganuangmuka',
                    'type' => 'raw',
                    'value' => '$data->keteranganuangmuka',
                ),
                array(
                    'header' => 'Pembatalan',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("pembatalanUangMuka/index",array("idBayarUangMuka"=>$data->bayaruangmuka_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogBatalUangMuka\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk membatalkan uang muka",
                                    ))',          'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
    <?php //echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);  
    ?>

    <fieldset class="box">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
                                ?>
                                <?php echo CHtml::label('Tgl. Pendaftaran', 'tglPendaftaran', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_awal',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>

                                </div>
                            </div>
                            <div class="control-group">
                                <?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
                                ?>
                                <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label inline')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_akhir',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            //                                                    'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>

                                </div>
                            </div>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </td>
                        <td>
                            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <div class="control-group">
                                <?php echo CHtml::label('Alias', 'nama_bin', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'nama_bin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

                                </div>

                            </div>
                        </td>
                    </tr>
                </table>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('billingKasir.views.daftarPasien/tips/informasi2', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogBatalUangMuka',
        'options' => array(
            'title' => 'Pembatalan Uang Muka',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 980,
            'zIndex' => 1001,
            'height' => 610,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
					data: $(this).serialize()
				}); }",
        ),
    ));
    ?>
    <iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
    ?>

    <?php
    $this->beginWidget(
        'zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'dialogEditUangMuka',
            'options' => array(
                'title' => 'Edit Uang Muka',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 980,
                'zIndex' => 1001,
                'height' => 610,
                'resizable' => true,
            ),
        )
    );
    ?>
    <iframe src="" name="iframeUangMuka" style="width: 100%; height: 98%;"></iframe>
    <?php
    $this->endWidget();
    ?>
</div>