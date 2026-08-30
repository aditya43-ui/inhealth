<fieldset>
        <legend>Detail Jadwal Kunjungan</legend> 
        Lama Terapi : <b><?php echo $modJadwalKunjungan->lamaterapikunjungan ?> Kunjungan</b>  &nbsp; Sisa terapi : <b><?php echo $sisaTerapi ?> Kunjungan Lagi</b>
        <table class="table table-bordered table-condensed" id="tblDetailjadwal">
            <tr>
                <th>No Urut</th>
                <th>Tgl. Jadwal Kunjungan</th>
                <th>Jenis - Tindakan</th>
                <th>Paramedis</th>
                <th>Status</th>
                <th>Dokter</th>
                <th></th>
            </tr>
            <tr id="jadwal_<?php echo $i; ?>">
                <?php $modHasilPemeriksaanrm = HasilpemeriksaanrmT::model()->findAll('jadwalKunjunganrm_id = '.$modJadwalKunjungan->jadwalkunjunganrm_id.'') ?>
                <td>
                    <?php 
                        echo $modJadwalKunjungan->nourutjadwal; 
                        echo CHtml::hiddenField("JadwalKunjungan[jadwalKunjunganrm_id][$i]", $modJadwalKunjungan->jadwalkunjunganrm_id ,array('class'=>'inputFormTabel','readonly'=>true));
                    ?>
                    <?php foreach ($modHasilPemeriksaanrm as $hasilPemeriksaanid)
                        {
                            echo CHtml::hiddenField("JadwalKunjungan[hasilpemeriksaanrm_id][$i][]", $hasilPemeriksaanid->hasilpemeriksaanrm_id ,array('class'=>'inputFormTabel','readonly'=>true));
                        } 
                    ?>
                </td>
                <td>
                    <?php echo CHtml::textField('JadwalKunjungan[tgljadwalrm]['.$i.']',$modJadwalKunjungan->tgljadwalrm,array('readonly'=>true,'class'=>'inputFormTabel lebar3'))?>
                </td>
                <td>
                    <?php foreach ($modHasilPemeriksaanrm as $tindakanrm)
                        {
                            echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakanrm->tindakanrm_id)->jenistindakanrm->jenistindakanrm_nama.'-';
                            echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakanrm->tindakanrm_id)->tindakanrm_nama.'</br>';
                            echo CHtml::hiddenField("JadwalKunjungan[tindakanrm_id][$i][]", $tindakanrm->tindakanrm_id,array('class'=>'inputFormTabel','readonly'=>true));
                        } 
                    ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('JadwalKunjungan[paramedis1_id]['.$i.']', $modJadwalKunjungan->paramedis1_id , CHtml::listData(PendaftaranT::model()->getParamedisItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Paramedis 1 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                    <?php echo CHtml::dropDownList('JadwalKunjungan[paramedis2_id]['.$i.']', $modJadwalKunjungan->paramedis2_id , CHtml::listData(PendaftaranT::model()->getParamedisItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Paramedis 2 --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                </td>
                <td>
                    <?php echo ($modJadwalKunjungan->statusterapi) ? 'Sudah' : 'Belum' ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('JadwalKunjungan[pegawai_id]['.$i.']', $modJadwalKunjungan->pegawai_id , CHtml::listData(PendaftaranT::model()->getDokterItems(Params::RUANGAN_ID_FISIOTERAPI), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2')); ?>
                </td>
                <td>
                    <?php echo CHtml::checkBox('JadwalKunjungan[ceklis][]',1,array('value'=>0)) ?> 
                </td>
            </tr>
        </table>
</fieldset>

