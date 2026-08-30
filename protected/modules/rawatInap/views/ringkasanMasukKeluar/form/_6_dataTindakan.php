<div class="panel panel-default panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Data Tindakan</div>
    </div>
    <div class="panel-body">
        <?php 
        echo $form->hiddenField($model, 'tindakanyangdipilih', array('class'=>'input_tindakanyangdipilih'));
        
        $tindakan = new TindakanpelayananT;
        $tindakan->unsetAttributes();
        $tindakan->pendaftaran_id = $model->pendaftaran_id;
        $tindakan->pasienadmisi_id = $model->pasienadmisi_id;

        if (isset($_GET['TindakanpelayananT'])) {
            $tindakan->attributes = $_GET['TindakanpelayananT'];
        }


        $prov_tindakan = $tindakan->searchTindakanNamaPasien();
        $prov_tindakan->sort->defaultOrder = 'tgl_tindakan desc';

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'tindakan-grid',
            'dataProvider' => $prov_tindakan,
            'filter' => $tindakan,
            'template' => "{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => function($data) use ($model) {

                        $nilai = true;
                        if (empty($model)) {
                            $nilai = false;

                        } else if (empty($model->tindakanyangdipilih)) {
                            $nilai = false;
                        } else if (!is_array($model->tindakanyangdipilih)) {
                            $nilai = false;
                        } else if (empty($model->tindakanyangdipilih[$data->tindakanpelayanan_id])) {
                            $nilai = false;
                        } else if ($model->tindakanyangdipilih[$data->tindakanpelayanan_id] != 1) {
                            $nilai = false;
                        }

                        return CHtml::checkBox('pilih_tindakan', $nilai, array('class'=>'pilih_tindakan_'.$data->tindakanpelayanan_id." cb_pilih_tindakan", "value"=>$data->tindakanpelayanan_id));
                    },
                    'htmlOptions' => array(
                        'style' => 'text-align: center;',
                    ),
                ),
                array(
                    'header' => 'Tanggal Tindakan',
                    'type' => 'raw',
                    'value' => function($data) {
                        return MyFormatter::formatDateTimeForUser($data->tgl_tindakan);
                    }
                ),
                array(
                    'name' => 'daftartindakanNama',
                    'header' => 'Pemeriksaan',
                    'type' => 'raw',
                    'value' => function($data) {
                        return $data->daftartindakan->daftartindakan_nama;
                    }
                ),
                array(
                    'header' => 'Pemeriksa',
                    'type' => 'raw',
                    'value' => function($data) {
                        return empty($data->dokter1) ? "-" : $data->dokter1->namaLengkap;
                    }
                ),

            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); loadPilihTindakan(); setEventPilihTindakan();}',
        ));
        ?>

    </div>
</div>