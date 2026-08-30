<div class="white-container">
    <?php
    //$this->breadcrumbs=array(
    //	'Ppinformasiantrianpasiens'=>array('index'),
    //	'Manage',
    //);
    //
    //$arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PPInformasiantrianpasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PPInformasiantrianpasien', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PPInformasiantrianpasien', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                
    //$this->menu=$arrMenu;
    //
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('ppinformasiantrianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>

    <?php //$this->widget('bootstrap.widgets.BootAlert'); 
    ?>

    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
    ?>

    <legend class="rim2">Informasi <b>Antrian Pasien</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Antrian Pasien</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'ppinformasiantrianpasien-grid',
            'dataProvider' => $model->searchTable(true),
            //	'filter'=>$model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Tgl. Antrian',
                    'value' => function ($data) {
                        return MyFormatter::formatDateTimeForUser($data->tglantrian);
                    }
                ),
                array(
                    'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (empty($data->tgl_pendaftaran)) return "BELUM DIDAFTARKAN";
                        return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "<br>" . $data->no_pendaftaran;
                    }
                ),
                array(
                    'name' => 'caraBayarPenjamin',
                    'value' => '$data->caraBayarPenjamin',
                    'filter' => false,
                ),
                array(
                    'header' => 'Instalasi <br> /  Ruangan',
                    'type' => 'raw',
                    'value' => '$data->instalasi_nama."<br> / ".$data->ruangan_nama',
                ),
                'no_rekam_medik',
                'nama_pasien',
                'alamat_pasien',
                array(
                    'header' => 'No. Antrian',
                    'name' => 'noantrian_loket',
                ),
                array(
                    'header' => 'Panggil',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (date('Y-m-d', strtotime($data->tglantrian)) < date('Y-m-d')) {
                            return CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array('disabled' => true, "class" => "btn btn-primary", "rel" => "tooltip", "title" => "Pemanggilan Antrian Sudah Lewat Harinya"));
                        } else {
                            if (empty($data->pendaftaran_id)) {
                                return CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array("class" => "btn btn-primary", "onclick" => "panggilAntrian(" . $data->antrian_id . "); return false;", "rel" => "tooltip", "title" => "Klik untuk memanggil nomor antrian"));
                            } else {
                                //return ($data->panggil_flaq)?"-":CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class='icon-volume-up icon-white'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(".$data->antrian_id."); return false;","rel"=>"tooltip","title"=>"Klik untuk memanggil nomor antrian"));
                                return CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array('disabled' => true, "class" => "btn btn-primary", "rel" => "tooltip", "title" => "Pasien Sudah Didaftarkan"));
                            }
                        }
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Daftar',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (empty($data->pendaftaran_id)) {
                            $antrian = AntrianT::model()->findByPk($data->antrian_id);
                            if ($antrian->loket_id != 13) {
                                return CHtml::dropDownList('dd_pendaftaran', null, array(
                                    2 => 'Penunjang',
                                    // 3 => 'Rawat Inap',
                                    1 => 'Rawat Jalan',
                                    /*1 => 'Rawat Jalan',
                                        2 => 'Penunjang',*/
                                ), array('empty' => '-- Daftar --', 'onchange' => 'daftarPasien(this, "' . $data->antrian_id . '")'));
                            } else {
                                return CHtml::dropDownList('dd_pendaftaran', null, array(
                                    2 => 'Penunjang',
                                    //  3 => 'Rawat Inap',
                                    1 => 'Rawat Jalan',
                                ), array('empty' => '-- Daftar --', 'onchange' => 'daftarPasien(this, "' . $data->antrian_id . '")'));
                            }
                        }
                        return '-';
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                // 'statusperiksa',
                //		'pasien_id',
                //		'jenisidentitas',
                //		'no_identitas_pasien',
                //		'namadepan',
                //		
                //		'nama_bin',
                /*
                    'jeniskelamin',
                    'tempat_lahir',
                    'tanggal_lahir',

                    'rt',
                    'rw',
                    'agama',
                    'golongandarah',
                    'photopasien',
                    'alamatemail',
                    'statusrekammedis',
                    'statusperkawinan',

                    'tgl_rekam_medik',
                    'propinsi_id',
                    'propinsi_nama',
                    'kabupaten_id',
                    'kabupaten_nama',
                    'kelurahan_id',
                    'kelurahan_nama',
                    'kecamatan_id',
                    'kecamatan_nama',
                    ////'pendaftaran_id',
                    array(
                            'name'=>'pendaftaran_id',
                            'value'=>'$data->pendaftaran_id',
                            'filter'=>false,
                    ),

                    'tgl_pendaftaran',

                    'transportasi',
                    'keadaanmasuk',
                    'statusperiksa',
                    'statuspasien',
                    'kunjungan',
                    'alihstatus',
                    'byphone',
                    'kunjunganrumah',
                    'statusmasuk',
                    'umur',
                    'no_asuransi',
                    'namapemilik_asuransi',
                    'nopokokperusahaan',
                    'create_time',
                    'create_loginpemakai_id',
                    'create_ruangan',
                    'carabayar_id',
                    'carabayar_nama',
                    'penjamin_id',
                    'penjamin_nama',
                    'shift_id',
                    'ruangan_id',
                    'ruangan_nama',
                    'instalasi_id',
                    'instalasi_nama',
                    'jeniskasuspenyakit_id',
                    'jeniskasuspenyakit_nama',
                    */
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
    <div class="search-form">
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.informasiantrian._search', array(
            'model' => $model, 'format' => $format
        )); ?>
        <!--search-form-->
    </div>
    <?php $this->renderPartial('pendaftaranPenjadwalan.views.informasiantrian._jsFunction', array(
        'model' => $model, 'format' => $format
    )); ?>