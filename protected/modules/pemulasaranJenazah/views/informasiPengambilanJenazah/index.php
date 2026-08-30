 <?php
    $this->breadcrumbs = array(
        'Informasi Pengambilan Jenazah',
    );
    $arrMenu = array();
    $this->menu = $arrMenu;
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="entypo-info-circled"></i> Informasi <b>Pengambilan Jenazah</b>
             <span class="pull-right">
                 <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                     <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                 </a>
             </span>
         </div>
     </div>
     <div class="panel-body">
         <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'search',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'focus' => '#',
                'method' => 'get',
            ));
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
                             <?php echo CHtml::label('Tgl. Pengambilan', 'tglawal', array('class' => 'control-label')); ?>
                             <div class="controls">
                                 <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                                 <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_awal',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                            //
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'dtPicker2-5 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    ));
                                    ?>
                                 <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                             </div>
                         </div>
                         <div class="control-group">
                             <?php echo CHtml::label(' Sampai Dengan', 'tgl_akhir', array('class' => 'control-label')) ?>
                             <div class="controls">
                                 <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                                 <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tgl_akhir',
                                        'mode' => 'date',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'dtPicker2-5 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                        ),
                                    )); ?>
                                 <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                             </div>
                         </div>
                         <div class="control-group">
                             <?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran', array('class' => 'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->textField($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'autofocus' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                             </div>
                         </div>
                         <div class="control-group">
                             <?php echo CHtml::label('No. Rekam Medik', 'no_rekam_medik', array('class' => 'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->textField($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'autofocus' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                             </div>
                         </div>
                     </div>
                     <div class="col-sm-6">
                         <div class="control-group">
                             <?php echo CHtml::label('Nama Pasien', 'nama_pasien', array('class' => 'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->textField($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'autofocus' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                             </div>
                         </div>
                         <div class="control-group">
                             <?php echo CHtml::label('Nama Pengambil', 'nama_pengambiljenazah', array('class' => 'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->textField($model, 'nama_pengambiljenazah', array('placeholder' => 'Nama Pengambil', 'autofocus' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                             </div>
                         </div>
                         <div class="control-group">
                             <?php echo CHtml::label('No. Identitas Pengambil', 'noidentitas_pengjenazah', array('class' => 'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->textField($model, 'noidentitas_pengjenazah', array('placeholder' => 'No. Identitas Pengambil', 'autofocus' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                             </div>
                         </div>
                         <div class="control-group">
                             <?php echo CHtml::label('No. Telepon Pengambil', 'notelepon_pengjenazah', array('class' => 'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->textField($model, 'notelepon_pengjenazah', array('placeholder' => 'No. Telepon Pengambil', 'autofocus' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="form-actions">
                     <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                        ); ?>
                     <?php
                        echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'title' => 'Ulang',
                                'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                            )
                        );
                        ?>
                     <?php
                        $content = $this->renderPartial('/tips/informasi', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?>
                 </div>
             </div>
         </div>
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="entypo-credit-card"></i> Tabel <b>Pengambilan Jenazah</b>
                 </div>
             </div>
             <div class="panel-body table-responsive">
                 <?php
                    $this->widget('bootstrap.widgets.BootAlert');
                    Yii::app()->clientScript->registerScript('cariPasien', "
        $('#search').submit(function(){
                $('#pengambilanjenazah-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('pengambilanjenazah-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'pengambilanjenazah-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                        'columns' => array(
                            array(
                                'header' => 'No. Pendaftaran',
                                'type' => 'raw',
                                'value' => '$data->no_pendaftaran',
                            ),
                            array(
                                'header' => 'No. Rekam Medik',
                                'type' => 'raw',
                                'value' => '$data->no_rekam_medik',
                            ),
                            array(
                                'header' => 'Nama Pasien',
                                'type' => 'raw',
                                'value' => '$data->nama_pasien',
                            ),
                            array(
                                'header' => 'Tanggal Meninggal',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglmeninggal)',
                            ),
                            array(
                                'header' => 'Tanggal Pengambilan',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengambilan)',
                            ),
                            array(
                                'header' => 'Nama Pengambil Jenazah',
                                'type' => 'raw',
                                'value' => '$data->nama_pengambiljenazah',
                            ),
                            array(
                                'header' => 'Hubungan',
                                'type' => 'raw',
                                'value' => '$data->hubungan_pengjenazah',
                            ),
                            array(
                                'header' => 'No. Identitas Pengambil',
                                'type' => 'raw',
                                'value' => '$data->noidentitas_pengjenazah',
                            ),
                            array(
                                'header' => 'Alamat Pengambil',
                                'type' => 'raw',
                                'value' => '$data->alamat_pengjenazah',
                            ),
                            array(
                                'header' => 'No. Telp Pengambil',
                                'type' => 'raw',
                                'value' => '$data->notelepon_pengjenazah',
                            ),
                            array(
                                'header' => 'Keterangan Pengambil',
                                'type' => 'raw',
                                'value' => '$data->keterangan_pengambilan',
                            ),
                            array(
                                'header' => 'Detail',
                                'type' => 'raw',
                                'value' => 'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("informasiPengambilanJenazah/Print",array("id"=>$data->ambiljenazah_id,"frame"=>1)),
                                    array("class"=>"", 
                                          "target"=>"iframeAmbilJenazah",
                                          "onclick"=>"$(\"#dialogAmbilJenazah\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk lihat detail pengambilan jenazah",
                                    ))',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
             </div>
         </div>
         <?php $this->endWidget(); ?>
     </div>
 </div>
 <?php
    // Dialog buat lihat penjualan resep =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogAmbilJenazah',
        'options' => array(
            'title' => 'Detail Pengambilan Jenazah',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'minWidth' => 980,
            'height' => 610,
            'resizable' => false,
        ),
    ));
    ?>
 <iframe src="" name="iframeAmbilJenazah" width="100%" height="550">
 </iframe>
 <?php
    $this->endWidget();
    //========= end lihat penjualan resep dialog =============================
    ?>
