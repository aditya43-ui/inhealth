<?php
Yii::import('gudangFarmasi.controllers.FakturPembelianController');
Yii::import('gudangFarmasi.models.*');
Yii::import('rawatJalan.controllers.TindakanController'); //UNTUK MENGGUNAKAN FUNCTION saveJurnalRekening()
class FakturPembelianTController extends FakturPembelianController
{
    public $path_view = 'gudangFarmasi.views.fakturPembelian.';
    public function actionIndex($penerimaanbarang_id = null, $fakturpembelian_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1413);
        return FakturPembelianController::actionIndex($penerimaanbarang_id, $fakturpembelian_id, $linkHalaman);
    }
    public function actionRetur($idFakturPembelian)
    {
        $this->layout = '//layouts/frameDialog';
        $modFaktur = GFFakturPembelianT::model()->findByPk($idFakturPembelian);
        $modFakturDetail = GFFakturDetailT::model()->findAll('fakturpembelian_id=' . $idFakturPembelian . '');
        $modRetur = new GFReturPembelianT;
        $modRetur->fakturpembelian_id = $modFaktur->fakturpembelian_id;
        $modRetur->noretur =  MyGenerator::noRetur();
        $modRetur->totalretur = 0;
        $modRetur->tglretur = date('Y-m-d H:i:s');
        $modRetur->supplier_id = $modFaktur->supplier_id;
        $modRetur->create_loginpemakai_id = Yii::app()->user->id;
        $modRetur->update_loginpemakai_id = Yii::app()->user->id;
        $modRetur->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modRetur->create_time = date('Y-m-d H:i:s');
        $modRetur->update_time = date('Y-m-d H:i:s');
        $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modReturDetails = new GFReturDetailT;
        $tersimpan = false;
        $modRekenings = array();
        if (isset($_POST['GFReturPembelianT'])) {
            //                
            $modRetur->attributes = $_POST['GFReturPembelianT'];
            $modRetur->penerimaanbarang_id = $modFaktur->penerimaanbarang_id;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //                                 
                $jumlahCekList = 0;
                $jumlahSave = 0;
                $modRetur = new GFReturPembelianT;
                $modRetur->attributes = $_POST['GFReturPembelianT'];
                $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modRetur->penerimaanbarang_id = $modFaktur->penerimaanbarang_id;
                $modRetur->create_loginpemakai_id = Yii::app()->user->id;
                $modRetur->update_loginpemakai_id = Yii::app()->user->id;
                $modRetur->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modRetur->create_time = date('Y-m-d H:i:s');
                $modRetur->update_time = date('Y-m-d H:i:s');
                if ($modRetur->save()) {
                    $jumlahObat = count((array)$_POST['GFReturDetailT']['obatalkes_id']);
                    for ($i = 0; $i <= $jumlahObat; $i++) :
                        if ($_POST['checkList'][$i] == '1') {
                            $jumlahCekList++;
                            $modReturDetails = new GFReturDetailT;
                            $modReturDetails->penerimaandetail_id = $_POST['GFReturDetailT']['penerimaandetail_id'][$i];
                            $modReturDetails->obatalkes_id = $_POST['GFReturDetailT']['obatalkes_id'][$i];
                            $modReturDetails->satuanbesar_id = $_POST['GFReturDetailT']['satuanbesar_id'][$i];
                            $modReturDetails->fakturdetail_id = $_POST['GFReturDetailT']['fakturdetail_id'][$i];
                            $modReturDetails->sumberdana_id = $_POST['GFReturDetailT']['sumberdana_id'][$i];
                            $modReturDetails->returpembelian_id = $modRetur->returpembelian_id;
                            $modReturDetails->satuankecil_id = $_POST['GFReturDetailT']['satuankecil_id'][$i];
                            $modReturDetails->jmlretur = $_POST['GFReturDetailT']['jmlretur'][$i];
                            $modReturDetails->harganettoretur = $_POST['GFReturDetailT']['harganettoretur'][$i];
                            $modReturDetails->hargappnretur = $_POST['GFReturDetailT']['hargappnretur'][$i];
                            $modReturDetails->hargapphretur = $_POST['GFReturDetailT']['hargapphretur'][$i];
                            $modReturDetails->jmldiscount = $_POST['GFReturDetailT']['jmldiscount'][$i];
                            $modReturDetails->hargasatuanretur = $_POST['GFReturDetailT']['hargasatuanretur'][$i];
                            //ini digunakan untuk mendapatkan jumalah terima dari tabel faktur detail
                            $fd = FakturdetailT::model()->findByPk($modReturDetails->fakturdetail_id);
                            $idfd = $fd->fakturdetail_id;
                            $jum1 = $fd->jmlterima;
                            $jum2 = $modReturDetails->jmlretur;
                            $jumupdate = $jum1 - $jum2;
                            if ($modReturDetails->save()) {
                                $jumlahSave++;
                                GFPenerimaanDetailT::model()->updateByPk(
                                    $modReturDetails->penerimaandetail_id,
                                    array('returdetail_id' => $modReturDetails->returdetail_id)
                                );
                                //ini digunakan untuk mengupdata tabel faktur detail dan penerimaan detail ketika terjadi retur
                                FakturdetailT::model()->updateByPk($idfd, array('jmlterima' => $jumupdate));
                                PenerimaandetailT::model()->updateByPk($modReturDetails->penerimaandetail_id, array('jmlterima' => $jumupdate));
                                //========================================================
                                $idStokObatAlkes = GFPenerimaanDetailT::model()->findByPk($modReturDetails->penerimaandetail_id)->stokobatalkes_id;
                                $stokObatAlkesIN = GFStokObatAlkesT::model()->findByPk($idStokObatAlkes)->qtystok_in;
                                $stokCurrent = GFStokObatAlkesT::model()->findByPk($idStokObatAlkes)->qtystok_current;
                                $stokINBaru = $stokObatAlkesIN - $modReturDetails->jmlretur;
                                $stokCurrentBaru = $stokCurrent - $modReturDetails->jmlretur;
                                GFStokObatAlkesT::model()->updateByPk($idStokObatAlkes, array(
                                    'qtystok_in' => $stokINBaru,
                                    'qtystok_current' => $stokCurrentBaru
                                ));
                            }
                        }
                    endfor;
                }
                if (($jumlahCekList == $jumlahSave) and ($jumlahCekList > 0)) {
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
                    $tersimpan = true;
                } else {
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                    $transaction->rollback();
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        $this->render($this->path_view . 'retur', array(
            'modFaktur' => $modFaktur,
            'modFakturDetail' => $modFakturDetail,
            'modRetur' => $modRetur,
            'modReturDetails' => $modReturDetails,
            'tersimpan' => $tersimpan,
            'modRekenings' => $modRekenings
        ));
    }
}
