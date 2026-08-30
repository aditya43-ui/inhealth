<?php

    $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
        'id' => 'pencarianverifikasi-grid',
        'dataProvider' => $modInfoOrderBatal->searchInformasi(),
        'template' => "{pager}{summary}\n{items}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'name' => 'tglverifikasibatal',
                'type' => 'raw',
                'value' => function ($data) use ($format) {
                    return $format->formatDateTimeForUser($data->tglverifikasibatal);
                }
            ),
            array(
                'header' => 'No. Verifikasi',
                'type' => 'raw',
                'value' => function ($data) use ($format) {

                    $info = InfoorderbataltindakanV::model()->findAll(array('condition' => 'pendaftaran_id = ' . $data->pendaftaran_id, 'order' => 'noverifikasi_batal', 'limit' => 1));

                    foreach($info as $in) {

                        echo CHtml::link(
                            "<icon class='icon-form-verifikasi'></icon>",
                            Yii::app()->controller->createUrl('detail', array('pendaftaran_id' => $data->pendaftaran_id)),
                            array(
                                'target' => 'iframeDetail',
                                'data-toggle' => 'tooltip',
                                'title' => 'Detail Verifikasi Tindakan',
                                'onclick' => '$("#dialogDetail").dialog("open");'
                            )
                        );

                        echo '<br>';

                    }

                    
                },
                'htmlOptions' => array('style' => 'text-align: center;'),
                'headerHtmlOptions' => array('style' => 'text-align: center; width: 100px;')
            ),
            array(
                'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
                'type' => 'raw',
                'value' => function ($data) use ($format) {
                    return $format->formatDateTimeForUser($data->tgl_pendaftaran) . "<br>" . $data->no_pendaftaran;
                }
                //'$data->tgl_pendaftaran."<br>".$data->no_pendaftaran',
            ),
            'nama_pasien',
            array(
                'header' => 'Jenis Penjamin/</br>Penjamin',
                'type' => 'raw',
                'value' => '$data->carabayar_nama."<br>".$data->penjamin_nama',
            ),
            array(
                'header' => 'Verifikator',
                'type' => 'raw',
                'value' => function($data) {
                    echo $data->petugasbatal_nama;
                }
            ),
            array(
                'header' => 'Aksi',
                'type' => 'raw',
                'value' => function($data) {

                    $info = InfoorderbataltindakanV::model()->find("pendaftaran_id = $data->pendaftaran_id and petugasbatal_id = $data->petugasbatal_id and (isverif = false or petugas_verif_id is null)");

                    if(empty($info)) {
                        echo CHtml::link('SUDAH DIBATAL <br> TINDAKAN', '',[
                            'class' => 'btn btn-warning'
                        ]);
                    } else {
                        return CHtml::link(
                            '<i class="icon-form-check"></i>',
                            '',
                            array(
                               
                                'data-toggle' => 'tooltip',
                                'title' => 'Verif Batal Tindakan',
                                'onclick' => 'verifOrderBatalTindakan("'. $data->pendaftaran_id .'", "'.$data->petugasbatal_id.'")'
                            )
                        );
                    }
                }
            )
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
?>
