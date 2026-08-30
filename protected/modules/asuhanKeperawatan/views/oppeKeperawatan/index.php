<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>OPPE Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $pegawailogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

        $criteria2 = new CDbCriteria;
        //        $criteria2->addInCondition("t.pegawai_id", $kepalaunit);
        $criteria2->addCondition("t.pegawai_id = " . $pegawailogin->pegawai_id);
        $modPegawai = PegawaiM::model()->find($criteria2);

        if (!empty($modPegawai)) {
            $is_kepalaunit = 1;
            $unitkerja_id = $modPegawai->unitkerja_id;
            $unitkerja_nama = !empty($modPegawai->unitkerja->namaunitkerja) ? $modPegawai->unitkerja->namaunitkerja : null;
            $pegawai_id = $modPegawai->pegawai_id;
            $pegawai_nama = $modPegawai->nama_pegawai;
        } else {
            $is_kepalaunit = 0;
            $unitkerja_id = "";
            $unitkerja_nama = "";
            $pegawai_id = "";
            $pegawai_nama = "";
        }
        echo CHtml::hiddenField('is_kepalaunit', $is_kepalaunit);
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    OPPE Keperawatan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="col-sm-12">
                    <table style="width: 100%; border: none;">
                        <tr>
                            <td width="10%"><label class='control-label'>Ka. Unit Kerja</label></td>
                            <td style="padding-bottom: 10px">
                                <?php echo CHtml::hiddenField('unitkerja_id', $unitkerja_id, array('readonly' => true, 'class' => 'span3')); ?>
                                <?php echo CHtml::textField('unitkerja_nama', $unitkerja_nama, array('readonly' => true, 'class' => 'span3')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%"><label class='control-label'>Nama Ka. Unit</label></td>
                            <td>
                                <?php echo CHtml::hiddenField('pegawai_id', $pegawai_id, array('readonly' => true, 'class' => 'span3')); ?>
                                <?php echo CHtml::textField('pegawai_nama', $pegawai_nama, array('readonly' => true, 'class' => 'span3')); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>

        <iframe id="frame" class='biru' src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>