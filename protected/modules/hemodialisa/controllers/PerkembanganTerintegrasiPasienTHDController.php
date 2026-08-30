<?php

/**
 *   - Extend Dari Asesment Edukasi Rawat Inap
 *   @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *   @website	<.com>
 *  @issue      RSST-1700
 */
Yii::import('rawatInap.controllers.PerkembanganTerintegrasiPasienTController');
Yii::import('rawatInap.models.*');

class PerkembanganTerintegrasiPasienTHDController extends PerkembanganTerintegrasiPasienTController {

    
    public $init = 'HD';

    public function actionStopTindakanDialisis() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = $_POST['id'];
            $konsulpoli_id = isset($_POST['konsulpoli_id']) ? $_POST['konsulpoli_id'] : null;
            $ok = true;
            $trans = Yii::app()->db->beginTransaction();
            try {
                $modPendaftaran = PendaftaranT::model()->findByPk($id);
                $modPendaftaran->status_hd = 'TIDAK SELESAI';
                $ok = $ok && $modPendaftaran->update();

                $konsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
                if (!empty($konsul)) {
                    if (in_array($konsul->poliasal->instalasi_id, RuanganrawatinapV::loadInstalasi())) {
                        $konsul->statusperiksa = 'TIDAK SELESAI';
                        $ok &= $konsul->save();
                    }
                }

                if ($ok) {
                    $data['sukses'] = 1;
                    $data['pesan'] = "Tindakan Dialisis Telah diStop";
                    $trans->commit();
                } else {
                    $data['sukses'] = 0;
                    $data['pesan'] = "Tindakan Dialisis Gagal diStop";
                    $trans->rollback();
                }
            } catch (Exception $ex) {
                $data['sukses'] = 0;
                $data['pesan'] = "Tindakan Dialisis Gagal diStop";
                $trans->rollback();
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

}
