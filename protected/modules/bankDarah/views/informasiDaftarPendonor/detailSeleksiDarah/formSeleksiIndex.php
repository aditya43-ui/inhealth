<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'seleksidonordarah-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '',
        ));
?>
<div class="panel-body">
    <?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly' => true)); ?>
    <?php echo CHtml::activeHiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly' => true)); ?>
    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title"><span class='judul'>Kuesioner Donor Darah</span></div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="span12">
                    <table class="table table-bordered table-condensed table-striped" id="tabel_kuesioner">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan</th>
                                <th>Jawab</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($modKuesioner) > 0) {
                                $no = 1;
                                foreach ($modKuesioner as $data) {
                                    $modPertanyaan = KuesionerdonorM::model()->findByPk($data->kuesionerdonor_id);
                                    echo '<tr>';
                                    echo '<td><label>' . $no . '</label></td>';
                                    echo '<td><label>' . $modPertanyaan->kuesioner_desc . '</label></td>';
                                    echo '<td>' . CHtml::radioButtonList('', ($data->ceklist == 1) ? '1' : '0', array('1' => 'YA', '0' => 'TIDAK'), array('disabled' => true, 'labelOptions' => array('style' => 'display:inline', 'readonly' => true))) . '</td>';
                                    echo '</tr>';
                                    $no++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            if ($model->is_gagalseleksi == true) {
                ?>
                <span class="span12" style="text-align: center" id="label_status"><h3>Tidak Lolos Seleksi</h3></span>
                <?php
            }
            if (!empty($model->petugaskuesioner_id)) {
                $pegawai = PegawaiM::model()->findByPk($model->petugaskuesioner_id);
                if (!empty($pegawai)) {
                    $petugaskuesioner_nama = $pegawai->namaLengkap;
                }
            }
            ?>
            <div class="panel-body overflow-x" >    
                <table>
                    <tr>
                        <td>
                            <?php echo CHtml::label('Tanggal &nbsp;&nbsp;', 'Tanggal', array('class' => 'control-label')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($model, 'tglseleksikuesioner', array('readonly' => true, 'class' => 'span3')) ?>
                        </td>
                        <td>
                            <?php echo CHtml::label('Petugas Koreksi &nbsp;&nbsp;', '', array('class' => 'control-label')); ?>
                        </td>
                        <td>
                            <?php
                            if (empty($model->seleksidonor_id)) {
                                echo CHtml::checkBox('cek_ppds', '', array('onclick' => 'ubahDialog();'));
                            } else {
                                if (!empty($model->ppds_id)) {
                                    echo CHtml::checkBox('cek_ppds', true, array('disabled' => true, 'readonly' => true, 'onclick' => 'ubahDialog();'));
                                } else {
                                    echo CHtml::checkBox('cek_ppds', false, array('disabled' => true, 'readonly' => true, 'onclick' => 'ubahDialog();'));
                                }
                            }
                            if (!empty($model->petugaskoreksi_id)) {
                                $petugasKoreksi = PegawaiM::model()->findByPk($model->petugaskoreksi_id);
                                if (!empty($petugasKoreksi)) {
                                    $model->petugaskoreksi_nama = $petugasKoreksi->namaLengkap;
                                } else {
                                    $model->petugaskoreksi_nama = '-';
                                }
                            } else if (!empty($model->ppds_id)) {
                                $ppds = PpdsM::model()->findByPk($model->ppds_id);
                                if (!empty($ppds)) {
                                    $model->ppds_nama = $ppds->ppds_nama;
                                } else {
                                    $model->ppds_nama = '-';
                                }
                            }
                            ?> <label>PPDS</label>
                        </td>
                        <td>
                            <div class="controls" id="petugaskoreksi">
                                <?php echo $form->hiddenField($model, 'petugaskoreksi_id', array('class' => 'required')) ?>
                                <div id="panelpetugaskoreksi_edit" hidden>
                                    <?php
                                    echo $form->textField($model, 'petugaskoreksi_nama', array('readonly' => true, 'class' => 'span3'));
                                    ?>
                                </div>
                                <div id="panelpetugaskoreksi" hidden>
                                    <?php
                                    echo $form->textField($model, 'petugaskoreksi_nama', array('readonly' => true, 'class' => 'span3'));
                                    ?>
                                </div>
                            </div>
                            <div class="controls" id="ppds" hidden>
                                <?php echo $form->hiddenField($model, 'ppds_id', array('class' => '')) ?>
                                <div id="panelppds_edit" hidden>
                                    <?php
                                    echo $form->textField($model, 'ppds_nama', array('readonly' => true, 'class' => 'span3'));
                                    ?>
                                </div>
                                <div id="panelppds" hidden>
                                    <?php
                                    echo $form->textField($model, 'ppds_nama', array('readonly' => true, 'class' => 'span3'));
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo CHtml::label('Nama Petugas &nbsp;&nbsp;', 'Nama Petugas', array('class' => 'control-label')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::textField('petugaskuesioner_nama', $petugaskuesioner_nama, array('readonly' => true, 'class' => 'span3')) ?>
                        </td>
                        <td>
                            <?php echo CHtml::label('Nama DPJP &nbsp;&nbsp;', 'Nama DPJP', array('class' => 'control-label')); ?>
                        </td>
                        <td colspan="2">
                            <?php echo CHtml::textField('dpjpkuesioner_nama', $dpjpkuesioner_nama, array('readonly' => true, 'style' => 'width:260px !important')) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

</div>


<?php $this->endWidget(); ?>

<script>

    function setDPJPAktif(type) {
        if (type == 'create' || type == 'edit') {
            $("#dpjp_edit").show();
            $("#dpjp").hide();
        } else {
            $("#dpjp_edit").hide();
            $("#dpjp").show();
        }
    }

    function setPetugasKoreksi(type) {
        if (type == "create" || type == 'edit') {
            $("#panelpetugaskoreksi").hide();
            $("#panelpetugaskoreksi_edit").show();
            $("#panelppds").hide();
            $("#panelppds_edit").show();
        } else {
            $("#panelppds_edit").show();
            $("#panelpetugaskoreksi").show();
            $("#panelpetugaskoreksi_edit").hide();
            $("#panelppds").show();
            $("#panelppds_edit").hide();
        }
    }
    $(document).ready(function () {
        setPetugasKoreksi('load');
        setDPJPAktif('load');
    });
</script>