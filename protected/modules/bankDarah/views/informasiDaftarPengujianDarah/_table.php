<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'permintaandarah-r-grid',
        'replaceUrl' => true,
        'dataProvider' => $model->searchInformasiDaftarPengujianDarah(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '($this->grid->dataProvider->pagination) ? 
                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                    : ($row+1)',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align:left;'),
            ),
            array(
                'header' => 'Tanggal Pendaftaran / Nomor Pendaftaran',
                'value' => function ($data) {
                    echo MyFormatter::formatDateTimeForUser($data['tgl_pendaftaran']) . " / " . $data['no_pendaftaran'];
                },
            ),
            array(
                'header' => 'Tanggal Permintaan / No. Permintaan',
                'value' => function ($data) {
                    echo MyFormatter::formatDateTimeForUser($data['tglmasukpenunjang']) . " / " . $data['no_masukpenunjang'];
                }
            ),
            array(
                'header' => 'Instalsi Asal / Ruangan Asal / DPJP ',
                'value' => function ($data) {
                    
                    echo $data['instalasi_nama'] . ' / <br>' .$data['ruangan_nama'] . " /  <br>" . $data['nama_pegawai'];
                }
            ),
            array(
                'header' => 'No. RM',
                'value' => '$data["no_rekam_medik"]',
            ),
            array(
                'header' => 'Nama Pasien',
                'value' => '$data["nama_pasien"]',
            ),
            array(
                'header' => 'Jenis Kelamin',
                'value' => '$data["jeniskelamin"]',
            ),
            array(
                'header' => 'Alamat',
                'value' => '$data["alamat_pasien"]',
            ),
            array(
                'header' => 'Umur',
                'value' => '$data["umur"]',
            ),
            array(
                'header' => 'Gol. Darah / Rhesus',
                'value' => function ($data) {
                    echo $data['golongandarah'] . " / " . $data['rhesus'];
                }
            ),
            [
                'header' => 'Cara Bayar',
                'value' => function($data) {
                    echo $data->carabayar_nama ?? '';
                }
            ],
            [
                'header' => 'Status',
                'type' => 'raw',
                'value' => function($data) {
                    $html = '';
                    if($data->is_progressgoldarah === true) {
                        $html = "<a class='btn nohover' style='background-color:blue'> Progress</a>";
                    } else if($data->is_progressgoldarah === false && $data->is_progressgoldarah !== null) {
                        $html = "<a class='btn nohover' style='background-color:green'> Done</a>";
                    } else {
                        $html = "<a class='btn btn-default nohover'> To Do</a>";
                    }

                    echo $html;
                }
            ],
            array(
                'header' => 'Jenis Permintaan',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function ($data) {
                    echo $data->jenis_permintaan;
                }
            ),
            array(
                'header' => 'Tagihan',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'type' => 'raw',
                'value' => function ($data) {
                    $tindakanpelayanan = TindakanpelayananT::model()->findAllByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'tindakansudahbayar_id' => null]);

                    $modTindakanTerkhir = TindakanpelayananT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')], ['order' => 'tgl_tindakan desc']);

                    $nopelayanan = '';

                    if(!empty($modTindakanTerkhir)) {
                        $nopelayanan = $modTindakanTerkhir->nopelayanan;
                    }

                    if(empty($tindakanpelayanan)) {
                        echo CHtml::link("<i class='icon-form-rincianbayar'></i>", '', array("rel" => "tooltip", "title" => "Klik untuk Print Tagihan", 'onclick' => 'printTagihan(' . $data->pendaftaran_id.', "' . $nopelayanan.'")')) . ' <br> <b>Sudah Bayar</b>';
                    
                    } else {
                        echo CHtml::link("<i class='icon-form-rincianbayar'></i>", '', array("rel" => "tooltip", "title" => "Klik untuk Print Tagihan", 'onclick' => 'printTagihan(' . $data->pendaftaran_id.', "' . $nopelayanan.'")')) . ' <br> <b>Belum Bayar</b>';
                    }
                }
            ),
            array(
                'header' => 'Pengujian Darah',
                'type' => 'raw',
                'htmlOptions' => array('style' => 'text-align: center;'),
                'value' => function($data) {
                    echo CHtml::link("<i class='icon-strukturorg'></i>", Yii::app()->createUrl('bankDarah/pengujianGolonganDarah/index', ['pendaftaran_id' => $data->pendaftaran_id, 'pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id]), array('target' => '_new', 'onclick' => 'updateProgress(' . $data->pasienkirimkeunitlain_id .')'));
                },
            ),
            
                    
            array(
                'header' => 'Lihat Hasil',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                'value' => function ($data) {
                   
                    echo CHtml::link("<i class='icon-form-eye'></i>", '', array("rel" => "tooltip", "title" => "Klik untuk lihat Hasil",  "onclick" => "window.parent.myAlert('Cooming Soon');"));
                    
                }
            ),
            array(
                'header' => 'Penyiapan Darah',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                'value' => function ($data) {
                    echo CHtml::link("<i class='entypo-water' class='font-size:20px'></i>", '', array("rel" => "tooltip", "title" => "Klik untuk lihat Hasil",  "onclick" => "cekStatus('" . $data->pasienkirimkeunitlain_id . "', '" . $data->pendaftaran_id. "')"));
                    
                }
            ),

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>