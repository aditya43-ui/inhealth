<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Pasien Say Hello</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pasien Say Hello',
        );
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('cari wew', "
    $('#pasienSayHello-form').submit(function(){
            $('#pasienSayHello-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('pasienSayHello-grid', {
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
            <div class="panel-body form-search">
                <?php echo $this->renderPartial('_formPencarian', array('modSayHello' => $modSayHello)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Say Hello</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pasienSayHello-grid',
                    'dataProvider' => $modSayHello->searchSayHello(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        'no_rekam_medik',
                        array(
                            'header' => 'No. Pendaftaran/<br>Tgl. Pendaftaran',
                            'value' => '$data->no_pendaftaran."/<br>".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
                        'nama_pasien',
                        'jeniskelamin',
                        array(
                            'header' => 'Tgl. Lahir',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        ),
                        'alamat_pasien',
                        'statusperkawinan',
                        'agama',
                        array(
                            'header' => 'No. Telepon',
                            'value' => '$data->no_telepon_pasien',
                        ),
                        array(
                            'header' => 'No. Handphone',
                            'value' => '$data->no_mobile_pasien',
                        ),
                        'alamatemail',
                        array(
                            'header' => 'Tgl. Admisi',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgladmisi)',
                        ),
                        'ruangan_nama',
                        array(
                            'header' => 'Tgl. Pasien Pulang',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpasienpulang)',
                        ),
                        'carakeluar_nama',
                        'kondisikeluar_nama',
                        array(
                            'name' => 'Program Say Hello',
                            'type' => 'raw',
                            'value' => '($data->pasiensayhello_id == NULL) ? 
                                                        CHtml::link("<i class=\'icon-form-ubah\'></i> Belum - Say Hello", Yii::app()->controller->createUrl("/informasi/InformasiSayHello/inputSayHello",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Input Say Hello"))
                                                        : CHtml::link("<i class=\'icon-comment\'></i> Sudah - Say Hello", Yii::app()->controller->createUrl("/informasi/InformasiSayHello/inputSayHello",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"pasiensayhello_id"=>$data->pasiensayhello_id,"edit"=>1)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk melihat Say Hello"))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>