<?php 

class InformasiOrderBatalTindakanController extends MyAuthController
{
    public function actionIndex()
    {
        $modInfoOrderBatal = new InfoorderbataltindakanV();
        $modInfoOrderBatal->tgl_awal = date('Y-m-d');
        $modInfoOrderBatal->tgl_akhir = date('Y-m-d');
        $format = new MyFormatter;
        if (Yii::app()->request->isAjaxRequest) {
            
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'pencarianverifikasi-grid') {
                if(isset($_GET['InfoorderbataltindakanV'])) {
                    $modInfoOrderBatal->attributes = $_GET['InfoorderbataltindakanV'];
                    $modInfoOrderBatal->tgl_awal = $format->formatDateTimeForDb($_GET['InfoorderbataltindakanV']['tgl_awal']);
                    $modInfoOrderBatal->tgl_akhir = $format->formatDateTimeForDb($_GET['InfoorderbataltindakanV']['tgl_akhir']);

                    $this->renderPartial('_table', [
                        'modInfoOrderBatal' => $modInfoOrderBatal,
                        'format' => $format
                    ]);

                    Yii::app()->end();
                }
            }
        }
        $this->render('index', [
            'modInfoOrderBatal' => $modInfoOrderBatal
        ]);
    }

    public function actionVerifBatalTindakan()
    {
        $data =[];
        $data['pesan'] = 'Tidak Ada Kiriman Data';
        $data['sukses'] = 0;
        if(isset($_POST['pendaftaran_id'])) {

            $trans = Yii::app()->db->beginTransaction();
            $ok = true;

            $pendaftaran_id = $_POST['pendaftaran_id'];
            $petugasbatal_id = $_POST['petugasbatal_id'];

            $info = InfoorderbataltindakanV::model()->findAll("pendaftaran_id = $pendaftaran_id and petugasbatal_id = $petugasbatal_id and isverif = false");

            $modTindakanPelayanan = null;
            $verifBatal = null;

            if(!empty($info)) {

                foreach($info as $in) {

                    $modTindakanPelayanan = TindakanpelayananT::model()->findByPk($in->tindakanpelayanan_id);
                    $verifBatal = VerifbataltindakanT::model()->findByPk($modTindakanPelayanan->verifbataltindakan_id);
                    
                    $del_penjualan = true;

                    if(!empty($modTindakanPelayanan->penjualanresep_id)) {
                        $id_penjualan = $modTindakanPelayanan->penjualanresep_id;
                        
                        // tindakan
                        $modTindakanPelayanan->penjualanresep_id = null;
                        $ok = $ok && $modTindakanPelayanan->save(false, array('penjualanresep_id'));

                        // reseptur
                        $reseptur = ResepturT::model()->findByAttributes(array(
                            'penjualanresep_id'=>$id_penjualan
                        ));
                        if (!empty($reseptur)) {
                            $reseptur->penjualanresep_id = null;
                            $ok = $ok && $reseptur->save(false, array('penjualanresep_id'));
                        }




                        $ok_oa = true;

                        
                        $oa = ObatalkespasienT::model()->findAllByAttributes(array(
                            'penjualanresep_id'=>$id_penjualan,
                        ));

                        foreach ($oa as $item) {
                            $ok_oa = StokobatalkesT::model()->deleteAllByAttributes(array(
                                'obatalkespasien_id'=>$item->obatalkespasien_id,
                            ));
                            // var_dump($ok_oa);

                            // HAPUS CATATAN PEMBELIAN OBAT SEBELUM HAPUS DATA OBATALKESPASIEN_T
                            $catatan = CatatanpemberianobatT::model()->findAllByAttributes(array(
                                'obatalkespasien_id'=>$item->obatalkespasien_id,
                            ));

                            foreach ($catatan as $item2) {
                                $ok_det = CatatanpemberianobatdetT::model()->deleteAllByAttributes(array(
                                    'catatanpemberianobat_id'=>$item2->catatanpemberianobat_id
                                ));
                                $ok_det = $item2->delete();
                            }


                            $ok_oa = ObatalkespasienT::model()->deleteByPk($item->obatalkespasien_id);
                            // var_dump($ok_oa);
                        }

                        $del_penjualan = PenjualanresepT::model()->deleteByPk($id_penjualan);
                        // var_dump($del_penjualan);
                    }

                    $verifBatal->petugas_verif_id = Yii::app()->user->getState('pegawai_id');
                    $verifBatal->isverif = true;

                    $ok = $ok && $verifBatal->save(false, array('petugas_verif_id', 'isverif'));
                    $ok = $ok && $del_penjualan;

                    $modTindakanPelayanan->isverifbataltindakan = true;
                    $modTindakanPelayanan->save(false, array('isverifbataltindakan'));


                    
                    /*
                    if($modTindakanPelayanan->save() && $verifBatal->save() && $del_penjualan) {
                        $data['pesan'] = 'Data Berhasil Di Verifikasi Batal Tindakan';
                        $data['sukses'] = 1;
                    }
                    */
                }

                // var_dump($ok); die;

                if ($ok) {
                    $trans->commit();
                    $data['pesan'] = 'Data Berhasil Di Verifikasi Batal Tindakan';
                    $data['sukses'] = 1;
                } else {
                    $trans->rollback();
                    $data['pesan'] = 'Data Gagal Di Verifikasi Batal Tindakan';
                    $data['sukses'] = 0;
                }



            } else {
                $trans->rollback();
                $data['pesan'] = 'Tindakan Pelayanan Tidak tidak ditemukan';
                $data['sukses'] = 0;
                
            }

        }

        echo CJSON::encode($data);

        // echo json_encode($data);
    }

    public function actionDetail($pendaftaran_id)
    {
        $this->layout = '//layouts/iframe';

        $model = InfoorderbataltindakanV::model()->findAll("pendaftaran_id = $pendaftaran_id");
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $pasien = $pendaftaran->pasien;

     

        $this->render('detail', array(
        'model' => $model, 
        'pendaftaran' => $pendaftaran, 'pasien' => $pasien));
    }
}