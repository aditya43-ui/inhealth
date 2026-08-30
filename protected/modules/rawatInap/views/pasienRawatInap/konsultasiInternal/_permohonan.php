<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Permohonan Konsultasi</b>
        </div>
    </div>
    <div class="panel-body form-horizontal">
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Tanggal dan Jam Konsul</label>
                <div class="controls">
                    <?= CHtml::textField('tglkonsulpoli', $model->tglkonsulpoli, array('class' => '', 'style' => 'text-align:right', 'readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Dokter Pengirim</label>
                <div class="controls">
                    <?= CHtml::textField('tglkonsulpoli', !empty($model->create_loginpemakai_id) ? LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id)->pegawai->namaLengkap : "", array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
        <?php 
        if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
        ?>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Dokter Tujuan Konsul</label>
                <div class="controls">
                    <?= CHtml::textField('doktertujuankonsul', $model->pegawai->namaLengkap, array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
                <div class="controls pensil-ubah-dokter">
                    <?= CHtml::link('<i class="icon-form-ubah"></i>', 'javascript:;', ['onclick' => 'ubahDokter(this)', 'class' => 'pensil-ubah-dokter']) ?>
                </div>
                <div class="controls centang-ubah-dokter hide">
                    <?= CHtml::link('<i class="icon-form-check"></i>', 'javascript:;', ['onclick' => 'saveUbahDokter(this)', 'class' => 'centang-ubah-dokter']) ?>
                </div>
            </div>
            <div class="control-group ubahdokter hide">
                <label for="" class="control-label">&nbsp;</label>
                <div class="controls">
                    <?php 
                         $listDokterKonsul = PegawaiM::model()->findAllByAttributes(array(
                            'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                            'pegawai_aktif'=>true,
                        ), array(
                            'order'=>'nama_pegawai'
                        ));

                        echo CHtml::hiddenField('konsulpoli_id_t', $model->konsulpoli_id);
                    ?>
                    <?= CHtml::dropDownList('doktertujuandiubah', $model->pegawai_id, CHtml::listData($listDokterKonsul, 'pegawai_id', 'namaLengkap') , ['class' => 'search-dropdown']) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Keterangan Klinik</label>
                <div class="controls">
                    <?= CHtml::textArea('tglkonsulpoli', $model->uraian_konsul, array('class' => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="clear"></div>
        <?php 
        if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){
        ?>
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Riwayat Diagnosa</div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal Diagnosa</th>
                                <th>Kelompok Diagnosa</th>
                                <th>Kode</th>
                                <th>Nama Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count((array)$pasienMorbiditas) > 0) {
                                foreach ($pasienMorbiditas as $key => $value) {
                                    echo "
                                        <tr>
                                            <td>" . MyFormatter::formatDateTimeForUser($value->tglmorbiditas) . "</td>
                                            <td>" . $value->kelompokdiagnosa->kelompokdiagnosa_nama . "</td>
                                            <td>" . $value->diagnosa->diagnosa_kode . "</td>
                                            <td>" . $value->diagnosa->diagnosa_nama . "</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php 
    if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){
    ?>
    <div class="panel-body form-horizontal" id="rm-tag">
        <div class="col-sm-12">
            <div class="control-group">
                <div class="controls" style="width:80%;">
                    <?php echo CHtml::activeTextArea($model, 'uraian_konsul', array('style' => 'width: 960px; height: 200px; ', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<script>
    function ubahDokter() {
        $('.centang-ubah-dokter').removeClass('hide');
        $('.ubahdokter').removeClass('hide');
        $('.pensil-ubah-dokter').addClass('hide');
    }

    function saveUbahDokter() {
        var pegawai_id = $('#doktertujuandiubah').val();
        var nama_pegawai = $('#doktertujuandiubah option:selected').text();
        var konsulpoli_id = $('#konsulpoli_id_t').val();
        $.post('<?= $this->createUrl('ubahdoktertujuankonsul') ?>', {
            pegawai_id:pegawai_id,
            konsulpoli_id:konsulpoli_id
        }, function(data){
            if(data.sukses == 1) {
                $('#doktertujuankonsul').val(nama_pegawai);
                $('.centang-ubah-dokter').addClass('hide');
                $('.ubahdokter').addClass('hide');
                $('.pensil-ubah-dokter').removeClass('hide');
            } else {
                window.parent.myAlert("Data dokter gagal diubah");
            }
        }, 'json');
    }

    $(function(){
        var classDrop = jQuery('.search-dropdown');
     
        jQuery(classDrop).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                onDropdownShown: function(even) {
                    setTimeout(function(){
                        $('.search-dropdown').parent().find("input[type='text'].multiselect-search").focus();
                    }, 100);
                },
                enableCaseInsensitiveFiltering: true
        }).hide();
    })
</script>