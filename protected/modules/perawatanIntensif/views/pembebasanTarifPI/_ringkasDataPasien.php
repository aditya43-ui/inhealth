<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly' => true)); ?></td>

                <td>
                    <label class="no_rek" style="padding-left:40px;">No. Rekam Medik <span class="required">*</span></label>
                </td>
                <td>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'PIPasienM[no_rekam_medik]',
                        'value' => $modPasien->no_rekam_medik,
                        'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . Yii::app()->createUrl('perawatanIntensif/ActionAutoComplete/daftarPasienTindakanRuangan') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
                                                isiDataPasien(ui.item);
                                                return false;
                                            }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 required'),
                        'tombolDialog' => array('idDialog' => 'dialogRekamedik', 'idTombol' => 'tombolDialogRekamedik'),
                    ));
                    ?>
                </td>
                <td rowspan="5">
                    <?php
                    if (!empty($modPasien->photopasien)) {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPasienM[jeniskelamin]', $modPasien->jeniskelamin, array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPendaftaranT[umur]', $modPendaftaran->umur, array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPendaftaranT[jeniskasuspenyakit_nama]', !(empty($modPendaftaran->jeniskasuspenyakit_id)) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : '', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPasienM[nama_bin]', $modPasien->nama_bin, array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'instalasi_id', array('class' => 'control-label')); ?></td>
                <td>
                    <?php echo CHtml::textField('PIPendaftaranT[instalasi_nama]', !empty($modPendaftaran->instalasi_id) ? $modPendaftaran->instalasi->instalasi_nama : '', array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('PIPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
                    <?php echo CHtml::hiddenField('PIPendaftaranT[pasien_id]', $modPendaftaran->pasien_id, array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::textField('PIPendaftaranT[ruangan_nama]', (!empty($modPendaftaran->ruangan_id)) ? $modPendaftaran->ruangan->ruangan_nama : '', array('readonly' => true)); ?></td>
            </tr>
        </table>

    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRekamedik',
    'options' => array(
        'title' => 'No. Rekamedik',
        'autoOpen' => false,
        'resizable' => false,
        'width' => 600,
        'height' => 420,
        'modal' => true,
    ),
));

$criteria = new CDbCriteria();
$criteria->compare('LOWER(no_rekam_medik)', strtolower(isset($_GET['term']) ? $_GET['term'] : ''), true);
$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
$models = PIInfokunjunganriV::model()->findAll($criteria);
$dataProvider = new CActiveDataProvider('InfokunjunganriV', array(
    'criteria' => $criteria,
));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rirekamedik-alkes-m-grid',
    'dataProvider' => $dataProvider,
    //'filter'=>$moObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                        isiDataPasien_fungsi(\"$data->no_rekam_medik\", \"$data->pendaftaran_id\");
                                        $(\"#dialogRekamedik\").dialog(\"close\");
                                        return false;
                                    "))',
        ),

        array(
            'header' => 'No. Rekamedik',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Tgl. Pendaftaran',
            'value' => '$data->tgl_pendaftaran',
        ),
        array(
            'header' => 'No. Pendaftaran',
            'value' => '$data->pendaftaran_id',
        ),
    )
));

$this->endWidget('ext.bootstrap.widgets.BootGridView');
?>

<script type="text/javascript">
    function isiDataPasien(data) {
        $('#PIPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
        $('#PIPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
        $('#PIPendaftaranT_umur').val(data.umur);
        $('#PIPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
        $('#PIPendaftaranT_instalasi_nama').val(data.instalasi_nama);
        $('#PIPendaftaranT_ruangan_nama').val(data.ruangan_nama);
        $('#PIPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#PIPendaftaranT_pasien_id').val(data.pasien_id);

        $('#PIPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#PIPasienM_nama_pasien').val(data.nama_pasien);
        $('#PIPasienM_nama_bin').val(data.nama_bin);

        $.post('<?php echo Yii::app()->createUrl('perawatanIntensif/ActionAjax/loadTindakanKomponenPasien'); ?>', {
            pendaftaran_id: data.pendaftaran_id
        }, function(data) {
            //$('#tblTindakanPasien tbody').html(data.formTindakanKomponen);
            $('#divTarifPasien').html(data.tabelPembebasanTarif);
            $("#tblTindakanPasien .integer").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ".",
                "thousands": ",",
                "precision": 0
            });
            $("#tblTindakanPasien .integer").each(function() {
                this.value = formatNumber(this.value)
            });
        }, 'json');

    }

    function isiDataPasien_fungsi(params, pendaftaran_id) {
        $.post("<?php echo Yii::app()->createUrl('perawatanIntensif/ActionAjax/loadDataPasien'); ?>", {
                no_rekam_medik: params
            },
            function(data) {
                $('#PIPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
                $('#PIPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                $('#PIPendaftaranT_umur').val(data.umur);
                $('#PIPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit_nama);
                $('#PIPendaftaranT_instalasi_nama').val(data.instalasi_nama);
                $('#PIPendaftaranT_ruangan_nama').val(data.ruangan_nama);
                $('#PIPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                $('#PIPendaftaranT_pasien_id').val(data.pasien_id);

                $('#PIPasienM_jeniskelamin').val(data.jeniskelamin);
                $('#PIPasienM_nama_pasien').val(data.nama_pasien);
                $('#PIPasienM_nama_bin').val(data.nama_bin);
                $('#PIPasienM_no_rekam_medik').val(params);
            }, "json");

        $.post('<?php echo Yii::app()->createUrl('perawatanIntensif/ActionAjax/loadTindakanKomponenPasien'); ?>', {
            pendaftaran_id: pendaftaran_id
        }, function(data) {
            $('#divTarifPasien').html(data.tabelPembebasanTarif);
            $("#tblTindakanPasien .integer").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ".",
                "thousands": ",",
                "precision": 0
            });
            $("#tblTindakanPasien .integer").each(function() {
                this.value = formatNumber(this.value)
            });
        }, 'json');
    }
</script>