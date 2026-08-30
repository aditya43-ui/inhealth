<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Dokumen Rekam Medis</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $i = 0;
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'retensidokrm-v-grid',
            'dataProvider' => $modDok->searchBerkasRekamMedis(),
            'template' => "{items}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih' . CHtml::checkBox('pilihSemua', false, array('onchange' => 'cekSemua(this); $("#RKRetensirekammedikV_no_rekam_medik").blur();')),
                    'type' => 'raw',
                    'value' => function ($data) use ($modDet, &$i) {


                        $modDet->pasien_id = $data->pasien_id;
                        $modDet->tglkunjunganterakhir = $data->tgl_pendaftaran;
                        $modDet->instalasiterakhir_id = $data->daftarinstalasiakhir_id;
                        $modDet->ruanganterakhir_id = $data->daftarruanganakhir_id;
                        if (!empty($data->tgl_pendaftaran)) {
                            $modDet->masafungsirm = CustomFunction::hitungUmur($data->tgl_pendaftaran, 2);
                        }
                        $modDet->dokrekammedis_id = $data->dokrekammedis_id;
                        $modDet->pendaftaran_id = $data->pendaftaran_id;
                        echo  CHtml::activeHiddenField($modDet, '[' . $i . ']pasien_id', array('readonly' => true));
                        echo  CHtml::activeHiddenField($modDet, '[' . $i . ']tglkunjunganterakhir', array('readonly' => true));
                        echo  CHtml::activeHiddenField($modDet, '[' . $i . ']instalasiterakhir_id', array('readonly' => true));
                        echo  CHtml::activeHiddenField($modDet, '[' . $i . ']ruanganterakhir_id', array('readonly' => true));
                        echo  CHtml::activeHiddenField($modDet, '[' . $i . ']masafungsirm', array('readonly' => true));
                        echo  CHtml::activeHiddenField($modDet, '[' . $i . ']dokrekammedis_id', array('readonly' => true));
                        echo  CHtml::activeHiddenField($modDet, '[' . $i . ']pendaftaran_id', array('readonly' => true));
                        echo  CHtml::activeCheckBox($modDet, '[' . $i . ']pilih', array('class' => 'pilihdata', 'onclick' => 'pilihCeklis(this);'));

                        $i++;
                    }
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'name' => 'no_rekam_medik',
                    'value' => '$data->no_rekam_medik'
                ),
                array(
                    'header' => 'Nama Pasien',
                    'name' => 'nama_pasien',
                    'value' => '$data->nama_pasien'
                ),
                array(
                    'header' => 'Tanggal Lahir',
                    'name' => 'tanggal_lahir',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)'
                ),
                array(
                    'header' => 'Jenis Kelamin',
                    'name' => 'jeniskelamin',
                    'value' => '$data->jeniskelamin'
                ),
                array(
                    'header' => 'Alamat Pasien',
                    'name' => 'alamat_pasien',
                    'value' => '$data->alamat_pasien'
                ),
                array(
                    'header' => 'Instalasi Akhir/ Ruangan Akhir',
                    'type' => 'raw',
                    'name' => 'daftar_instalasiakhir_nama',
                    'value' => '$data->daftar_instalasiakhir_nama."/<br/>".$data->daftar_ruanganakhir_nama'
                ),
                array(
                    'header' => 'Kunjungan Terakhir',
                    'name' => 'tgl_pendaftaran',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
                ),
                array(
                    'header' => 'Masa Fungsi',
                    //'name' => 'tgl_pendaftaran',
                    'value' => function ($data) {
                        return CustomFunction::hitungUmur($data->tgl_pendaftaran, 2);
                    }
                ),
                array(
                    'header' => 'Status',
                    'value' => '$data->statusrekammedis'
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){    
                                cekSemua($("#pilihSemua"));
                                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});                                
                }',
        )); ?>
    </div>
</div>