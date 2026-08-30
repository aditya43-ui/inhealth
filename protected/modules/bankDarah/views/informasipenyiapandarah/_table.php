<?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'permintaandarah-r-grid',
        'replaceUrl' => true,
        'dataProvider' => $model->searchInformasi(),
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
                'header' => 'Tanggal Pengiriman',
                'value' => function ($data) {
                    echo MyFormatter::formatDateTimeForUser($data['tglpenyiapandarah']);
                },
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
                    
                    echo $data['instalasiasal_nama'] . ' / <br>' .$data['ruanganasal_nama'] . " /  <br>" . $data['namaLengkap'];
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
                'header' => 'Gol. Darah / Rhesus',
                'value' => function ($data) {
                    echo $data['kesimpulan'];
                }
            ),
            [
                'header' => 'Jenis Darah',
                'type' => 'raw',
                'value' => '$data->jeniskomponenedarah_nama'
            ],
            [
                'header' => 'Jumlah',
                'type' => 'raw',
                'value' => '$data->jumlah_kantong'
            ],
            [
                'header' => 'Diambil',
                'type' => 'raw',
                'value' => '$data->diambil'
            ],
            [
                'header' => 'Dititip',
                'type' => 'raw',
                'value' => '$data->dititip'
            ],
            [
                'header' => 'Nomor Kantong / <br> Jenis Darah',
                'type' => 'raw',
                'value' => '$data->nomorbarcode . "/ <br>" . $data->singkatan_komp '
            ],
            [
                'header' => 'Lihat Hasil',
                'type' => 'raw',
                'value' => function($data) {
                    echo CHtml::link("<i class='icon-form-eye'></i>", '', array("rel" => "tooltip", "title" => "Klik untuk lihat Hasil",  "onclick" => "window.parent.myAlert('Cooming Soon');"));
                }
            ],
            [
                'header' => 'Tanggal Terima',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_terimadarah)'
            ],
            [
                'header' => 'Petugas Penerima',
                'type' => 'raw',
                'value' => function ($data) {
                    $modPegawai = PegawaiM::model()->findByPk($data->peg_penerimapermintaan_id);
                    if(!empty($modPegawai)) {
                        echo $modPegawai->namaLengkap;
                    }
                }
            ],
            [
                'header' => 'Lihat Reaksi Setelah Transfusi',
                'type' => 'raw',
                'value' => function ($data) {
                    return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-pencil'></i></span>", 'javascript:;', array(
                        "rel" => "tooltip",
                        "title" => "Klik untuk Ubah",
                        'onclick' => 'openDialog(' . $data->pasienkirimkeunitlain_id. ')',
            ));
                }
            ],
            

        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>