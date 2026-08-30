<?php
Yii::app()->clientScript->registerScript('search', "
    $('#rencanaumumpengadaan-m-search').submit(function(){
        $.fn.yiiGridView.update('rencanaumumpengadaan-m-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Rencana Umum Pengadaan</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Informasi <strong>Rencana Umum Pengadaan</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'rencanaumumpengadaan-m-grid',
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
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Nomor dan Tanggal RUP',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            return CHtml::link($data->rencanaumumpengadaan_nomor . '<br>' . MyFormatter::formatDateTimeforUser($data->rencanaumumpengadaan_tanggal), Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/detail&id=' . $data->rencanaumumpengadaan_id), array(
                                                        'class' => 'hover',
                                                        "rel" => "tooltip",
                                                        "title" => "Klik untuk Melihat Detail Rencana Umum Pengadaan"));
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Bagian / Bidang / Instalasi',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->instalasi_nama)) {
                                            return $data->instalasi_nama;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Kategori Pengadaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->rencanaumumpengadaan_kategori)) {
                                            return $data->rencanaumumpengadaan_kategori;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Nama Pekerjaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->nama_pekerjaan)) {
                                            return $data->nama_pekerjaan;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Pagu',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->total_pagu)) {
                                            return 'Rp ' . number_format($data->dpa_pagu, 2, ',', '.');
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Total RAB/HPS',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->total_pagu)) {
                                            return 'Rp ' . number_format($data->total_pagu, 2, ',', '.');
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Tahun Anggaran',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->periodeanggaran_id)) {
                                            $periodeanggaran = PeriodeanggaranK::model()->findByPk($data->periodeanggaran_id);
                                            return $periodeanggaran->tahunanggaran . " - " . $periodeanggaran->anggaran_nama;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Sumber Dana',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if(!empty($data->daftarsumberdana)){
                                            echo $data->daftarsumberdana;
                                        }else{
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Status',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data->rencanaumumpengadaan_status)) {
                                            return $data->rencanaumumpengadaan_status;
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Ubah',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $cekLogin = Yii::app()->user->getState('pegawai_id');
                                        if (!empty($data)) {
                                            if(strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_PERSETUJUAN_PPK) && 
                                                            ($data->pegawaippk_id == $cekLogin)
                                                          ){
                                                                return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>", 
                                                                    Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/ubah&id=' . $data->rencanaumumpengadaan_id), 
                                                                    array(
                                                                        'class' => 'hover',
                                                                        "rel" => "tooltip",
                                                                        "data-placement" => "left",
                                                                        //'onclick' => 'Ubah(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                                        "title" => "Klik untuk Mengubah Rencana Umum Pengadaan"));
                                            }elseif (strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DIBATALKAN)){
                                                return "<span style='font-size:15px;'><i class='entypo-pencil'></i></span>";
                                            }else{
                                                if (strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DRAFT) || 
                                                    strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI) || 
                                                    strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI_TPP_RUP) && 
                                                    empty($data->kode_rup)) {
                                                        if(strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI) && 
                                                            ($data->pegawaippk_id == $cekLogin || $data->pegawaipa_id == $cekLogin || $data->pegawaikpa_id == $cekLogin)
                                                          ){
                                                                return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>", 
                                                                    Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/ubah&id=' . $data->rencanaumumpengadaan_id), 
                                                                    array(
                                                                        'class' => 'hover',
                                                                        "rel" => "tooltip",
                                                                        "data-placement" => "left",
                                                                        //'onclick' => 'Ubah(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                                        "title" => "Klik untuk Mengubah Rencana Umum Pengadaan"));
                                                        }else if(strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI_TPP_RUP)
                                                                && $data->pegawaipembuat_id == $cekLogin
                                                            ){
                                                                return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>", 
                                                                    Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/ubah&id=' . $data->rencanaumumpengadaan_id), 
                                                                    array(
                                                                        'class' => 'hover',
                                                                        "rel" => "tooltip",
                                                                        "data-placement" => "left",
                                                                        //'onclick' => 'Ubah(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                                        "title" => "Klik untuk Mengubah Rencana Umum Pengadaan"));
                                                        }else if(strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DRAFT)
                                                                && $data->pegawaipembuat_id == $cekLogin
                                                            ){
                                                                return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>", 
                                                                    Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/ubah&id=' . $data->rencanaumumpengadaan_id), 
                                                                    array(
                                                                        'class' => 'hover',
                                                                        "rel" => "tooltip",
                                                                        "data-placement" => "left",
                                                                        //'onclick' => 'Ubah(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                                        "title" => "Klik untuk Mengubah Rencana Umum Pengadaan"));
                                                        }else{
                                                            return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>", 
                                                                    '', 
                                                                    array(
                                                                        'class' => 'hover',
                                                                        "rel" => "tooltip",
                                                                        "data-placement" => "left",
                                                                        'onclick' => 'myAlert("Anda tidak dapat mengubah dokumen");return false;',
                                                                        "title" => "Klik untuk Mengubah Rencana Umum Pengadaan"));
                                                        }
                                                } else {
                                                    if(strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_REVISI_PPK) && $data->pegawaippk_id == $cekLogin){
                                                        return CHtml::link("<span style='font-size:15px;'><i class='entypo-pencil'></i></span>", 
                                                            Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/ubah&id=' . $data->rencanaumumpengadaan_id), 
                                                            array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                "data-placement" => "left",
                                                                //'onclick' => 'Ubah(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                                "title" => "Klik untuk Mengubah Rencana Umum Pengadaan"));
                                                    }else{
                                                        return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-pencil'></i></span>", '', array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                "data-placement" => "left",
                                                                "title" => "Klik untuk Mengubah Rencana Umum Pengadaan"));
                                                    }
                                                }
                                            }
                                        } else {
                                            return '-';
                                        }
                                        
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center; vertical-align: middle',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Review',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $cekLogin = Yii::app()->user->getState('pegawai_id');
                                        if (!empty($data)) {
                                            if (strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DIBATALKAN)){
                                                return "<span style='font-size:15px;'><i class='entypo-docs'></i></span>";
                                            }else{
                                                if (($data->rencanaumumpengadaan_status == 'Persetujuan PPK' && $data->pegawaippk_id == $cekLogin) || 
                                                    ($data->rencanaumumpengadaan_status == 'Persetujuan KPA' && $data->pegawaikpa_id == $cekLogin) ||  
                                                    ($data->rencanaumumpengadaan_status == 'Persetujuan PA'  && $data->pegawaipa_id  == $cekLogin) && 
                                                    empty($data->kode_rup)){
                                                    return CHtml::link("<span style='font-size:15px;'><i class='entypo-docs'></i></span>", Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/review&id=' . $data->rencanaumumpengadaan_id), array(
                                                            'class' => 'hover',
                                                            "rel" => "tooltip",
                                                            "data-placement" => "left",
                                                            "title" => "Klik untuk Review Rencana Umum Pengadaan"));
                                                } else {
                                                    if ($data->rencanaumumpengadaan_status == 'Persetujuan PPK' && $data->pegawaippk_id != $cekLogin) {
                                                        return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-docs'></i></span>", '', array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                'onclick' => 'myAlert("Maaf, Anda bukan PPK")',
                                                                "data-placement" => "left",
                                                                "title" => "Klik untuk Review Rencana Umum Pengadaan"));
                                                    } else if ($data->rencanaumumpengadaan_status == 'Persetujuan KPA' && $data->pegawaikpa_id != $cekLogin) {
                                                        return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-docs'></i></span>", '', array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                'onclick' => 'myAlert("Maaf, Anda bukan Kuasa Pengguna Anggaran")',
                                                                "data-placement" => "left",
                                                                "title" => "Klik untuk Review Rencana Umum Pengadaan"));
                                                    } else if ($data->rencanaumumpengadaan_status == 'Persetujuan PA' && $data->pegawaipa_id != $cekLogin) {
                                                        return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-docs'></i></span>", '', array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                'onclick' => 'myAlert("Maaf, Anda bukan Pengguna Anggaran")',
                                                                "data-placement" => "left",
                                                                "title" => "Klik untuk Review Rencana Umum Pengadaan"));
                                                    }else {
                                                        return '<i class="entypo-docs"></i></span>';
                                                    }
                                                }
                                            }
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center; vertical-align: middle',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Umumkan',
                                    'type' => 'raw',
                                    'value' => function($data)
                                    {
                                        if (!empty($data))
                                        {
                                            if (strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DIBATALKAN))
                                            {
                                                return "<span style='font-size:15px;'><i class='entypo-megaphone'></i></span>";
                                            }
                                            else
                                            {// rencanaumumpengadaan_status == 'RUP Final' --> 'Draft' untuk Test
                                                if ($data->rencanaumumpengadaan_status == 'RUP Final' && empty($data->kode_rup))
                                                {
                                                    if(Yii::app()->user->getState('pegawai_id') == $data->pegawaipa_id)
                                                    {
                                                        // return CHtml::link("<span style='font-size:15px;'><i class='entypo-megaphone'></i></span>", '', array(
                                                        //         'class' => 'hover',
                                                        //         "rel" => "tooltip",
                                                        //         "data-placement" => "left",
                                                        //         'onclick' => 'Umumkan(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                        //         "title" => "Klik untuk Umumkan Rencana Umum Pengadaan"));

                                                        return CHtml::link("<span style='font-size:15px;'><i class='entypo-megaphone'></i></span>", $this->createUrl('informasiRencanaUmum/umumkanSemua', array('id'=>$data->rencanaumumpengadaan_id)), array(
                                                                    "target"=>"frameUmumkanSemua",
                                                                    "rel" => "tooltip",
                                                                    'onclick' => 'loadUmumkan(this,'.$data->rencanaumumpengadaan_id.'); return false;',
                                                                    "title" => "Klik untuk Umumkan Rencana Umum Pengadaan"));
                                                    }
                                                    else
                                                    {
                                                        return CHtml::link("<span style='font-size:15px;'><i class='entypo-megaphone'></i></span>", '', array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                "data-placement" => "left",
                                                                'onclick' => 'myAlert("Anda Bukan Pegawai PA");return false;',
                                                                "title" => "Klik untuk Umumkan Rencana Umum Pengadaan"));
                                                    }
                                                }
                                                else
                                                {
                                                    return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-megaphone'></i></span>", '', array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                "data-placement" => "left",
                                                                "title" => "Klik untuk Umumkan Rencana Umum Pengadaan"));
                                                }
                                            }
                                        }
                                        else
                                        {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center;vertical-align: middle',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'No SiRUP',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            if (strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DIBATALKAN)){
                                                return "-";
                                            }else{
                                                if ($data->rencanaumumpengadaan_status == 'RUP Diumumkan' && empty($data->kode_rup)) {
                                                    return CHtml::link("Input Nomor", Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/isiNomor&id=' . $data->rencanaumumpengadaan_id), array(
                                                                'class' => 'btn btn-blue',
                                                                "rel" => "tooltip",
                                                                "data-placement" => "left",
                                                                "target" => "iframe2",
                                                                "onclick" => "$('#dialogNomor').dialog('open');",
                                                                "title" => "Klik untuk Input Nomor Rencana Umum Pengadaan"));
                                                } else if ($data->rencanaumumpengadaan_status == 'Persiapan Pengadaan' || !empty($data->kode_rup) || $data->kode_rup != 0) {
                                                    return $data->kode_rup;
                                                } else {
                                                    return 'Belum Diumumkan';
                                                }
                                            }
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Persiapan <br> Pengadaan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (!empty($data)) {
                                            if (Yii::app()->user->getState('pegawai_id') == $data->pegawaippk_id && $data->rencanaumumpengadaan_status == 'RUP Diumumkan' && !empty($data->kode_rup) && strtoupper($data->rencanaumumpengadaan_kategori) == Params::KATEGORI_PENGADAAN_PENYEDIA) {
                                                 return CHtml::link("<span style='font-size:15px;'><i class='entypo-box'></i></span>", '', array(
                                                                'class' => 'hover',
                                                                "rel" => "tooltip",
                                                                "data-placement" => "left",
                                                                'onclick' => 'persiapanPengadaan(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                                "title" => "Klik untuk Menambahkan Persiapan Pengadaan"));
                                            } else {
                                                return CHtml::link("<span style='font-size:15px;opacity: 0.5;'><i class='entypo-box'></i></span>", '', array(
                                                            'class' => 'hover',
                                                            "rel" => "tooltip",
                                                            "data-placement" => "left",
                                                            "title" => "Klik untuk Menambahkan Persiapan Pengadaan"));
                                            }
                                        } else {
                                            return '-';
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center; vertical-align: middle',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Revisi RUP',
                                    'type' => 'raw',
                                    'value' => function($data){
                                        if (strtolower($data->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA) && 
                                            Yii::app()->user->getState('pegawai_id') == $data->pegawaippk_id && 
                                            strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_RUP_DIUMUMKAN) &&
                                            !empty($data->kode_rup)) {
                                            return CHtml::link("<span style='font-size:15px;'><i class='fa fa-pencil-square-o'></i></span>", 
                                                                    Yii::app()->createUrl('pengadaan/InformasiRencanaUmum/revisi&id=' . $data->rencanaumumpengadaan_id.'&revisi=1'), 
                                                                    array(
                                                                        'class' => 'hover',
                                                                        "rel" => "tooltip",
                                                                        "data-placement" => "left",
                                                                        //'onclick' => 'Ubah(' . $data->rencanaumumpengadaan_id . ');return false;',
                                                                        "title" => "Klik untuk Melakukan Revisi RUP"));
                                        } else {
                                            return "<span style='font-size:15px;opacity: 0.5;'><i class='fa fa-pencil-square-o'></i></span>";
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align: center; vertical-align: middle',
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align: center',
                                    ),
                                ),
                                array(
                                    'header' => 'Batal',
                                    'value' => function($data) {
                                        if (strtolower($data->rencanaumumpengadaan_status) == strtolower(Params::STATUS_RENCANA_UMUM_PENGADAAN_DIBATALKAN)){
                                            echo "<i class='glyphicon glyphicon-remove' style='font-size: 16px;'></i>";
                                        }else{
                                            if(Yii::app()->user->getState('pegawai_id') == $data->pegawaippk_id){
                                                $cekBatal = "";
                                                if (strtolower($data->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)) {
                                                    $criteria = new CDbCriteria();
                                                    $criteria->addCondition("lower(kategori_pengadaan) = '".strtolower(Params::KATEGORI_PENGADAAN_SWAKELOLA)."' and rencanaumumpengadaan_id = ".$data->rencanaumumpengadaan_id);
                                                    $cekBatal = NotadinaspptkT::model()->find($criteria);
                                                } else if (strtolower($data->rencanaumumpengadaan_kategori) == strtolower(Params::KATEGORI_PENGADAAN_PENYEDIA)) {
                                                    $batalSPK = $jumlahRUP = $cekRUP = 0 ;
                                                    $modDokumen = InformasidokumenpengadaanV::model()->findAllByAttributes(['rencanaumumpengadaan_id' => $data->rencanaumumpengadaan_id]);
                                                    $jumlahRUP = count($modDokumen);
                                                    foreach($modDokumen as $dok){
                                                        if (!empty($dok['suratperjanjiankerja_id'])) {
                                                            $modSPK = SuratperjanjiankerjaT::model()->findByPk($dok['suratperjanjiankerja_id']);
                                                            if ($modSPK->isbatal == true) {
                                                                $batalSPK++;
                                                            }
                                                        } else {
                                                            $cekRUP++;
                                                        }
                                                    }
                                                    
                                                    if (!empty($cekRUP)) {
                                                        $cekBatal = ""; // jika belum ada SPK langsung bisa dibatalkan
                                                    } else if ($batalSPK == $jumlahRUP) {
                                                        $cekBatal = ""; 
                                                    } else {
                                                        $cekBatal = "tidak bisa dibatalkan";
                                                    }
                                                }
                                                
                                                if (empty($cekBatal)) {
                                                    return CHtml::link("<i class='glyphicon glyphicon-remove' style='font-size: 16px; color: #BF0000'></i>", Yii::app()->createUrl('pengadaan/informasiRencanaUmum/batal&rencanaumumpengadaan_id=' . $data->rencanaumumpengadaan_id), array("title" => "Klik untuk Melakukan Pembatalan", "target" => "iframe4", "onclick" => "$('#dialogBatal').dialog('open');"));
                                                } else {
                                                    echo "<i class='glyphicon glyphicon-remove' style='font-size: 16px;'></i>";
                                                }
                                            }else{
                                                echo "<i class='glyphicon glyphicon-remove' style='font-size: 16px;'></i>";
                                            }
                                        }
                                    },
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:center; vertical-align: middle'),
                                ),
                                array(
                                    'header'=> CHtml::checkBox('is_pilihsemua',false,array('onclick'=>'pilihSemua(this)','title'=>'Klik untuk pilih memilih semua atau tidak','rel'=>'tooltip')),
                                    'type'=>'raw',
                                    'value'=>function($data)
                                    { // != "RUP Final" --> "Draft" untuk Test
                                        if ($data->rencanaumumpengadaan_status != "RUP Final")
                                        {
                                            echo " ";
                                        }
                                        else
                                        {
                                            // $rup = InformasirencanaumumpengadaanV::model()->findByAttributes(array(
                                            $rup = RencanaumumpengadaanT::model()->findByAttributes(array(
                                                'rencanaumumpengadaan_id'=>$data->rencanaumumpengadaan_id
                                            )); 
                                            return CHtml::checkBox("pilihRup", false, 
                                                    array("value"=>$data->rencanaumumpengadaan_id,
                                                        "iddata"=>$data->rencanaumumpengadaan_id,
                                                        "data-sudahfinal"=>(empty($rup ? 0 : 1)),
                                                        "class"=>"cekList",
                                                        "onclick" => "setPilih(this)",
                                                        "onkeyup"=>"return $(this).focusNextInputField(event);"));
                                        }
                                    },
                                    'htmlOptions' => array(
                                        'style' => 'text-align:center;'
                                    ),
                                    'headerHtmlOptions' => array(
                                        'style' => 'text-align:center;'
                                    ),
                                )
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekCeklis();}',
                        ));
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                        </fieldset>
                    </div>
                </div>	
                
                <table id="tabel-cekrupfinal" hidden>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$urlPersiapan = Yii::app()->createAbsoluteUrl($module . '/persiapanPengadaan/index&rencanaumumpengadaan_id=');
$js = <<< JSCRIPT
    function cekForm(obj){
        $("#rencanaumumpengadaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
        window.open("${urlPrint}/"+$('#rencanaumumpengadaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
// ===========================Dialog Isi Nomor=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogNomor',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Masukkan Nomor SiRUP',
        'autoOpen' => false,
        'width' => 500,
        'height' => 300,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframe2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog isi Nomor================================
?>
<?php
// ===========================Dialog Details Perizinan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogBatal',
    // additional javascript options for the dialog plugin
    'options'=>array(
    'title'=>'Batal Rencana Umum Pengadaan',
    'autoOpen'=>false,
    'width'=>500,
    'height'=>400,
    'resizable'=>true,
    'scroll'=>false,
    'close'=>"js:function(){ $.fn.yiiGridView.update('rencanaumumpengadaan-m-grid', {
            data: $('#rencanaumumpengadaan-m-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe4" width="100%" height="100%">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Perizinan================================
?>
<?php
// ===========================Dialog Umumkan RUP=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
'id'=>'dialogUmumkanSemua',
    'options'=>array(
        'title'=>'Umumkan Rencana Umum Pengadaan',
        'autoOpen'=>false,
        'modal' => true,
        'width'=>1300,
        'height'=>500,
        'resizable'=>true,
        'scroll'=>true,
        'close'=>"js:function(){ $.fn.yiiGridView.update('rencanaumumpengadaan-m-grid', {
                data: $('#rencanaumumpengadaan-m-search').serialize()
        }); }",  
     ),
));
?>
<iframe src="" name="frameUmumkanSemua" id="frameUmumkanSemua" width="100%" height="100%">
</iframe>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Umumkan RUP================================
?>

<script>
    function reloadTabel(string) {
        $.fn.yiiGridView.update('rencanaumumpengadaan-m-grid');
        if (string == 'nosirup') {
            myAlert('No SiRUP berhasil disimpan');
        } else {
            myAlert('No SiRUP gagal disimpan');
        }
    }

// Umumkan 1 data RUP Final
function Umumkan(id) {
    var id = id;
        var url = '<?php echo $url."/umumkan"; ?>';
        myConfirm('Anda yakin untuk mengumumkan rencana umum ini ?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                myAlert('Data berhasil di umumkan');
                                $.fn.yiiGridView.update('rencanaumumpengadaan-m-grid');
                            }else{
                                myAlert('Data Gagal di Ubah');
                            }
                },"json");
           }
        });
}

// Tampilkan open dialog Umumkan RUP yang dipilih
function loadUmumkan(obj, idrup)
{
    var id = '';
    var format_id = "";
    var url = '<?php echo $this->createUrl('informasiRencanaUmum/umumkanSemua'); ?>';

    if ($(obj).parents('tr').find('input:checkbox').prop("checked") == false)
    {
        $(obj).parents('tr').find('input:checkbox').prop("checked",true);
        setPilih($(obj).parents('tr').find('input:checkbox'));
    }
    
    $("#tabel-cekrupfinal > tbody > tr").each(function()
    {
        id += '&RencanaumumpengadaanT[id][]='+$(this).find('.tampung_id').val();
    });

    if (length > 0)
    {
        format_id = id;
    }
    else
    {
        format_id = idrup;
    }

    $("#frameUmumkanSemua").prop("src", url + format_id);
    $("#dialogUmumkanSemua").dialog("open");
}

function pilihSemua(obj)
{
    if ($(obj).prop("checked") == true)
    {
        $("#rencanaumumpengadaan-m-grid tbody .cekList").each(function()
        {
            $(this).prop("checked",true);
            setPilih(this); // Tambahkan data yang dipilih ke tabel tampung "RUP Final" yang hidden
        });
    }
    else
    {
        $("#rencanaumumpengadaan-m-grid .cekList").each(function()
        {
            $(this).prop("checked",false);
            setPilih(this);
        });
    }
}

// Tampung data dari grid yang di checklist untuk open dialog "RUP Final"
function setPilih(obj)
{
    var cek = $(obj).prop("checked");

    if (cek == true)
    {
        $("#tabel-cekrupfinal").append("<tr><td><input type='hidden' value='"+$(obj).attr('value')+"' class='tampung_id'></td></tr>");
    }
    else
    {
        $("#tabel-cekrupfinal > tbody > tr").each(function()
        {
            if ($(this).find('.tampung_id').val() == $(obj).val())
            {
                $(this).detach();
            }
        });
    }
}

// Clear tabel tampung "RUP Final"
function clearCekLis()
{
    $("#tabel-cekrupfinal").html('');
    toastr.success("Data <b>Berhasil Disimpan</b>");
}

function cekCeklis()
{
    $(".cekList").each(function()
    {
        var cek = $(this);
        var val = cek.val();
        //var lulus = $(this).parents("tr").
                        
        $("#tabel-cekrupfinal > tbody > tr").each(function()
        {
            if ($(this).find('.tampung_id').val() == val)
            {
                cek.prop("checked",true);
            }
        });
    });
}

function persiapanPengadaan(id) {
    var id = id;
        var url = '<?php echo $url."/cekPersiapan"; ?>';
//        myConfirm('Anda yakin untuk menambahkan persiapan pengadaan?','Perhatian!',function(r){
//            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.ok == 0){
                                toastr.error(data.msg, 'Perhatian!');
                            }else{
                                window.open("<?= $urlPersiapan?>"+id, '_blank');
                            }
                },"json");
//           }
//        });
}
</script>
