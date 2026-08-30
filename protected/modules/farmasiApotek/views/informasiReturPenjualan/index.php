<?php
$this->breadcrumbs = array(
    'Informasi Retur Penjualan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Retur Penjualan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'search',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($modInfoReturPenjualan, 'noreturresep'),
            'method' => 'get',
            'htmlOptions' => array(),
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
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label("Tgl. Retur", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modInfoReturPenjualan->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modInfoReturPenjualan->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d F Y', strtotime($modInfoReturPenjualan->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modInfoReturPenjualan->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($modInfoReturPenjualan, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($modInfoReturPenjualan, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('No. Retur', 'noreturresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modInfoReturPenjualan, 'noreturresep', array('placeholder' => 'No. Retur Resep', 'class' => 'span4', 'autofocus' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Pendaftaran', 'noreturresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modInfoReturPenjualan, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'autofocus' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('No. Rekam Medik', 'noreturresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modInfoReturPenjualan, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'autofocus' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama Pasien', 'noreturresep', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modInfoReturPenjualan, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'autofocus' => true)); ?>
                            </div>
                        </div>
                        <?php
                        $carabayar = CarabayarM::model()->findAll(array(
                            'condition' => 'carabayar_aktif = true',
                            'order' => 'carabayar_nama ASC',
                        ));
                        foreach ($carabayar as $idx => $item) {
                            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                                'carabayar_id' => $item->carabayar_id,
                                'penjamin_aktif' => true,
                            ));
                            if (empty($penjamins)) unset($carabayar[$idx]);
                        }
                        $penjamin = PenjaminpasienM::model()->findAll(array(
                            'condition' => 'penjamin_aktif = true',
                            'order' => 'penjamin_nama',
                        ));
                        echo $form->dropDownListRow($modInfoReturPenjualan, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modInfoReturPenjualan))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modInfoReturPenjualan, "penjamin_id") . '").html(data); }',
                            ),
                        ));
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->dropDownListRow($modInfoReturPenjualan, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span4'));
                        ?>
                        <?php
                        $instalasi = InstalasiM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                        ));
                        $ruangan = RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id' => array(2, 3, 4),
                            'ruangan_aktif' => true,
                        ), array(
                            'order' => 'instalasi_id, ruangan_nama',
                        ));
                        echo $form->dropDownListRow($modInfoReturPenjualan, 'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span4',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('/actionDynamic/GetRuanganAsalDariInstalasiAsal', array('encode' => false, 'namaModel' => get_class($modInfoReturPenjualan))),
                                'success' => 'function(data){$("#' . CHtml::activeId($modInfoReturPenjualan, "ruanganasal_id") . '").html(data); }',
                            ),
                        ));
                        echo $form->dropDownListRow($modInfoReturPenjualan, 'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span4', 'maxlength' => 50));
                        ?>
                        <?php
                        $pegawai = CHtml::listData(DokterV::model()->findAllByAttributes(array(), array(
                            'order' => 'nama_pegawai asc',
                        )), 'pegawai_id', 'namaLengkap');
                        echo $form->dropDownListRow($modInfoReturPenjualan, 'dokterresep_id', $pegawai, array(
                            'empty' => '-- Pilih --', 'class' => 'span4'
                        ));
                        ?>
                        <?php
                        $peg = CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                            'ruangan_id' => Yii::app()->user->getState('instalasi_id')
                        ), array(
                            'order' => 'nama_pegawai asc',
                        )), 'pegawai_id', 'namaLengkap');
                        echo $form->dropDownListRow($modInfoReturPenjualan, 'pegretur_id', $peg, array(
                            'empty' => '-- Pilih --', 'class' => 'span4'
                        ));
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                    ); ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    ); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Retur Penjualan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php
                    $this->widget('bootstrap.widgets.BootAlert');
                    Yii::app()->clientScript->registerScript('cariPasien', "
                            $('#search').submit(function(){
                                $('#informasipenjualanresep-grid').addClass('animation-loading');
                                $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasipenjualanresep-grid',
                        'dataProvider' => $modInfoReturPenjualan->searchReturPenjualan(),
                        //        'filter'=>$modInfo,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Tanggal Retur/No. Retur',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->penjualanresep_id)) {
                                        return  CHtml::Link(
                                            "<u>" . MyFormatter::formatDateTimeForUser($data->tglretur) . '/ ' . $data->noreturresep . "</u>",
                                            Yii::app()->controller->createUrl("informasiPenjualanResep/detailRetur", array("returresep_id" => $data->returresep_id)),
                                            array(
                                                "class" => "",
                                                "target" => "iframeDetailRetur",
                                                "onclick" => '$("#dialogDetailRetur").dialog("open");',
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk lihat Detail Retur Penjualan",
                                            )
                                        );
                                    }
                                    return CHtml::Link(
                                        "<u>" . MyFormatter::formatDateTimeForUser($data->tglretur) . '/ ' . $data->noreturresep . "</u>",
                                        Yii::app()->controller->createUrl("ReturResepPasien/printRincian", array("returresep_id" => $data->returresep_id, "frame" => 1)),
                                        array(
                                            "class" => "",
                                            "target" => "iframeDetailRetur",
                                            "onclick" => '$("#dialogDetailRetur").dialog("open");',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk lihat Detail Retur Resep Pasien",
                                        )
                                    );
                                },
                            ),
                            array(
                                'header' => 'Tanggal Penjualan/No Penjualan',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->penjualanresep_id)) {
                                        return  CHtml::Link(
                                            "<u>" . MyFormatter::formatDateTimeForUser($data->tglpenjualan) . '/ ' . $data->noresep . "</u>",
                                            Yii::app()->controller->createUrl("InformasiPenjualanResep/detailPenjualan", array("id" => $data->penjualanresep_id, 'pasien_id' => $data->pasien_id)),
                                            array(
                                                "class" => "",
                                                "target" => "iframeDetailRetur",
                                                "onclick" => '$("#dialogDetailRetur").dialog("open");',
                                                "rel" => "tooltip",
                                                "title" => "Klik untuk lihat Detail Retur Penjualan",
                                            )
                                        );
                                    }
                                },
                            ),
                            array(
                                'header' => 'Tanggal Pendaftaran/No. Pendaftaran',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "/<br>" . $data->no_pendaftaran;
                                }
                            ),
                            array(
                                'header' => 'No. Rekam Medik',
                                'value' => '$data->no_rekam_medik',
                            ),
                            array(
                                'header' => 'Nama Pasien',
                                'value' => '$data->nama_pasien',
                            ),
                            array(
                                'header' => 'Jenis Penjamin/Penjamin',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->penjualanresep_id)) {
                                        return $data->carabayar_nama . "/<br> " . $data->penjamin_nama;
                                    }
                                }
                            ),
                            array(
                                'header' => 'Instalasi/Ruangan',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->penjualanresep_id)) {
                                        return $data->instalasiasal_nama . "/<br>" . $data->ruanganasal_nama;
                                    }
                                }
                            ),
                            array(
                                'header' => 'Dokter Resep',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    if (!empty($data->penjualanresep_id)) {
                                        $d = PegawaiM::model()->findByPk($data->dokterresep_id);
                                        if (!empty($d)) {
                                            return $d->namaLengkap;
                                        }
                                    }
                                }
                            ),
                            array(
                                'header' => 'Petugas Farmasi',
                                'value' => function ($data) {
                                    $d = PegawaiM::model()->findByPk($data->pegretur_id);
                                    if (!empty($d)) {
                                        return $d->namaLengkap;
                                    }
                                }
                            ),
                            // array(
                            //	'header'=>'Tanggal Pendaftaran/No. Pendaftaran'
                            //),
                            /* array(
                                        'header'=>'Detail Retur',
                                        'type'=>'raw', 
                                        'value'=>function($data) {
                                            if (!empty($data->penjualanresep_id)) {
                                                return  CHtml::Link('<i class="icon-form-rincianretur"></i>',Yii::app()->controller->createUrl("informasiPenjualanResep/detailRetur",array("returresep_id"=>$data->returresep_id)),
                                                array("class"=>"", 
                                                    "target"=>"iframeDetailRetur",
                                                    "onclick"=>'$("#dialogDetailRetur").dialog("open");',
                                                    "rel"=>"tooltip",
                                                    "title"=>"Klik untuk lihat Detail Retur Penjualan",
                                                ));
                                            }
                                            return CHtml::Link('<i class="icon-form-rincianretur"></i>',Yii::app()->controller->createUrl("ReturResepPasien/printRincian",array("returresep_id"=>$data->returresep_id,"frame"=>1)),
                                            array("class"=>"", 
                                                "target"=>"iframeDetailRetur",
                                                "onclick"=>'$("#dialogDetailRetur").dialog("open");',
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk lihat Detail Retur Resep Pasien",
                                            ));
                                        },
                                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                    ),*/
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailRetur',
    'options' => array(
        'title' => 'Detail Retur Penjualan Resep',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetailRetur" width="100%" height="550" style="border: none; overflow-x"></iframe>
<?php
$this->endWidget();
//========= end lihat penjualan resep dialog =============================
?>
<!--/div-->