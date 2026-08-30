<style>
    .button-all {
        float: right;
        color: black;
        margin-right: 100px;
        margin-top: 10px;
    }
</style>
<?php 
// mengambil data pegawai
$criteria = new CDbCriteria();
$criteria->addInCondition('gelarbelakang_id', [35, 154, 175, 186, 316, 317, 318]);
$criteria->addCondition('pegawai_aktif is true');
$criteria->order = 'nama_pegawai ASC';
$modPegawai = PegawaiM::model()->findAll($criteria);
$dataPegawai = CHtml::listData($modPegawai, 'pegawai_id', 'namaLengkap');
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penjadwalan Dokter Poliklinik</b>
        </div>
        
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-striped table-bordered table-condensed" border="1">
            <thead>
                <tr>
                    <?php
                    foreach ((array)CustomFunction::getNamaHari() as $key => $value) {
                        echo '<th>' . $value . '</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $jumlah = 1;
                for ($x = 1; $x <= ceil($jumlahHari / count((array)CustomFunction::getNamaHari())); $x++) {
                    echo '<tr>';
                    foreach ((array)CustomFunction::getNamaHari() as $key => $value) {
                        $tgl = Yii::app()->dateFormatter->formatDateTime(strtotime($tahun . '-' . $bulan . '-' . $jumlah), 'full', null);
                        $tglDB = $tahun . '-' . $bulan . '-' . $jumlah;
                        $tanggal = explode(',', $tgl);
                        if ($jumlah > $jumlahHari) {
                            echo '<td class="disabled"></td>';
                        } else {
                            if (strtolower(trim($value)) == strtolower(trim($tanggal[0]))) {
                                
                                echo '<td>';
                                    echo $tgl;
                                    // dripdown dokter mod
                                    $mod = JadwaldoktermodM::model()->findByAttributes(['tanggaljaga' => $tglDB, 'is_mod' => true]);
                                    if(!empty($modPegawai)) {
                                        echo '<div class="control-group">';
                                            echo CHtml::label('Dokter Mod ', '', ['class' => 'control-label']);
                                            echo '<div class="controls">';
                                                echo CHtml::dropDownList('DokterMod[' . $tglDB . '][pegawai_id]', $mod->pegawai_id ?? '', $dataPegawai, ['empty' => ' -- Pilih --', 'class' => 'span3']);  
                                            echo '</div>';
                                        echo '</div>';

                                    }

                                    // dropdown dokter spv
                                    $spv = JadwaldoktermodM::model()->findByAttributes(['tanggaljaga' => $tglDB, 'is_spvcadangan' => true]);
                                    if(!empty($modPegawai)) {
                                        echo '<div class="control-group">';
                                            echo CHtml::label('Dokter SPV', '', ['class' => 'control-label']);
                                            echo '<div class="controls">';
                                                echo CHtml::dropDownList('DokterSPV[' . $tglDB . '][pegawai_id]', $spv->pegawai_id ?? '', $dataPegawai, ['empty' => ' -- Pilih --', 'class' => 'span3']);  
                                            echo '</div>';
                                        echo '</div>'; 
                                    }

                                echo '</td>';
                                $jumlah++;
                            } else {
                                echo '<td class="disabled"></td>';
                            }
                        }
                    }
                    if ($x == ($jumlahHari / count((array)CustomFunction::getNamaHari()))) {
                        if ($jumlah <= $jumlahHari) {
                            $x--;
                        }
                    }
                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
</div>

<script>
    function getjadwaldokter() {
        var jadwal = $('#PPJadwaldokterM_jadwaldokter_mulai').val()
        var ruangan_id = JSON.parse(<?php echo json_encode(isset($_GET['PPJadwaldokterM']['ruangan_id']) ? $_GET['PPJadwaldokterM']['ruangan_id'] : ""); ?>)
        $.ajax({
            url: '<?php echo $this->createUrl('/pendaftaranPenjadwalan/InfoDokterPoliKlinik/GetAllJadwalDokter'); ?>',
            type: "post",
            dataType: "json",
            data: {
                jadwal: jadwal,
                ruangan_id: ruangan_id
            },
            success: function(data) {
                if (data != '') {
                    myAlert(data.msg);
                    if (data.sukses == 1) {
                        window.location = window.location.href;
                    }
                }
               
            }
        });
    }
</script>