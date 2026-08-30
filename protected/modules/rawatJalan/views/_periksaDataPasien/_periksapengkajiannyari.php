<?php
$mod = new PengkajiannyeriT;
$mod->pasien_id = $model->pendaftaran->pasien_id;
$mod->tgl_awal_kaji = $mod->tgl_awal_daftar = date('Y-m-d', strtotime('-1 week'));
$mod->tgl_akhir_kaji = $mod->tgl_akhir_daftar = date('Y-m-d');

if (isset($_GET['PengkajiannyeriT'])) {
    $mod->attributes = $_GET['PengkajiannyeriT'];

    $mod->tgl_awal_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_awal_kaji']);
    $mod->tgl_akhir_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_akhir_kaji']);
    
    if (isset($_GET['PengkajiannyeriT']['is_ceklis']) && $_GET['PengkajiannyeriT']['is_ceklis'] == 1) {
        $mod->is_ceklis = $_GET['PengkajiannyeriT']['is_ceklis'];
        $mod->tgl_awal_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_awal_daftar']);
        $mod->tgl_akhir_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajiannyeriT']['tgl_akhir_daftar']);
    }
}
?>
<?php
$skoring = array(
    "wbs" => "Wong Baker Faces Pain Scale",
    "flaccs" => "Skala FLACCS",
    "nrs" => "Numerical Rating Scale (NRS)",
    "vas" => "Visual Analog Scale (VAS)",
    "bps_tanpaventilator" => "Behavioural Pain Scale Tanpa Ventilator",
    "bps_ventilator" => "Behavioural Pain Scale Ventilator",
    "nips" => "Neonatal Infant Pain Score",
);
$prov = $model->search();
$prov->sort->defaultOrder = 'waktupengkajian desc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pengkajian-nyeri-grid',
    'dataProvider' => $prov,
    'template'=>"{summary}\n{items}\n{pager}", 
    'itemsCssClass' => 'table table-bordered table-condensed',
    'htmlOptions' => array(
        'style' => 'width: 100%;',
    ),
    'columns' => array(
        array(
            'header' => 'Tanggal Pendaftaran/<br/>No. Pendaftran',
            'type' => 'raw',
            'value' => function($data) {
                $d = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                return MyFormatter::formatDateTimeForUser($d->tgl_pendaftaran) . "/<br/>" . $d->no_pendaftaran;
            }
        ),
        array(
            'header' => 'Instalasi/<br/>Ruangan',
            'type' => 'raw',
            'value' => function($data) {
                $ruangan = RuanganM::model()->findByPk($data->ruangan_id);
                return $ruangan->ruangan_nama . "/<br/>" . $ruangan->instalasi->instalasi_nama;
            }
        ),
        array(
            'header' => 'Waktu<br/>Tanggal/Jam',
            'type' => 'raw',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($data->waktupengkajian))) . "/" . date('H:i:s', strtotime($data->waktupengkajian));
            }
        ),
        array(
            'header' => 'Nama, Profesi, dan TTD',
            'type' => 'raw',
            'value' => function($data) {
                $peg = PegawaiM::model()->findByPk($data->petugaspengkaji_id);
                $jenis = JenistenagamedisM::model()->findByPk($peg->jenistenagamedis_id);
                
                $str = $peg->namaLengkap;
                
                if (!$data->isverifikasipetugas) {
                    $str .= CHtml::link('<i class="icon-form-verifikasi"></i>', 'javascript:void(0)', array(
                        'onclick'=>"verifikasiNyeri(".$data->pengkajiannyeri_id.", '".$peg->namaLengkap."'); return false;",
                    ));
                } else {
                    $alert_msg = "Sudah diverifikasi oleh \\n ".$peg->namaLengkap."\\n"
                        .(empty($jenis) ? "" : $jenis->tenagamedis_nama)."\\n"
                        ."Tanggal : ".MyFormatter::formatDateTimeForUser($data->verifikasipetugas_tanggal)."\\n"
                        ."Catatan : ".$data->verifikasipetugas_catatan;
                    $str .= CHtml::link('<i class="icon-form-verifikasi"></i>', '#', array(
                        'onclick'=>"myAlert('".$alert_msg."'); return false;",
                    ));
                }
                

                return $str;
            }
        ),
        array(
            'header' => 'Sistem Skoring',
            'type' => 'raw',
            'value' => function($data) use ($skoring) {
                return empty($data->sistemskoring) ? "-" : $skoring[$data->sistemskoring];
            }
        ),
        array(
            'header' => 'Skala Nyeri',
            'type' => 'raw',
            'value' => function($data) {
                return $data->skalanyeri . " : " . $data->keterangan_skalanyeri;
            }
        ),
    ),
));
?>