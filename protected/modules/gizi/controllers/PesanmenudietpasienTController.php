<?php

/**
 * Digunakan untuk menyimpan transaksi pemesanan menu diet
 * Di-clone untuk RSWB-1092, RSWB-1094, RSWB-1095 
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @author Aida Rahmawati <aidarahmawati@/com>
 * @package application.modules.gizi
 * @subpackage controllers
 */
class PesanmenudietpasienTController extends MyAuthController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    protected $path_view = 'gizi.views.pesanmenudietpasienT.';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render($this->path_view . 'view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionIndex($id = null)
    {
        $model = new GZPesanmenudietT;

        $modBahan = new BahanMenuDietM;
        $model->tglpesanmenu = date('d M Y H:i:s');

        $model->ruangan_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) ? "" : Yii::app()->user->getState('ruangan_id');
        $model->instalasi_id = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) ? "" : Yii::app()->user->getState('instalasi_id');

        $modPasienPulang = new GZPendaftaranT('searchPasienPulang');
        $modPasienPulang->default = 'kosong';

        $modPasienBaru = new GZPendaftaranT('searchPasienBaru');
        $modPasienBaru->default = 'kosong';

        $modRiwayatPemesanan = new PesanmenudietR('searchRiwayat');

        $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
        $model->temp_no = '- Otomatis -';

        $pegawai_nama = ""; //PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->nama_pegawai;
        $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
        $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
        $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
        $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
        //$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
        //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->nama_pemesan = Yii::app()->user->getState('nama_pegawai');
        $model->disabled = true;
        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
            $model->disabled = false;
        }

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

        $loadData = array();

        if (!empty($id)) {
            $model = GZPesanmenudietT::model()->findByPk($id);
            $model->instalasi_id = $model->ruangan->instalasi_id;
            $model->nopesanmenu = $model->nopesanmenu;
            $model->tglpesanmenu = date("d M Y H:i:s", strtotime($model->tglpesanmenu));
            // echo '<pre>';var_dump($model);die;
        }

        if (!empty($model->pesanmenudiet_id)) {
            $modPasienPulang->default = null;
            $modPasienPulang->instalasi_id = $model->instalasi_id;
            $modPasienPulang->ruangan_id = $model->ruangan_id;

            $modPasienBaru->default = null;
            $modPasienBaru->instalasi_id = $model->instalasi_id;
            $modPasienBaru->ruangan_id = $model->ruangan_id;
        }

        // Mencari Pasien Pulang
        if (isset($_GET['GZPendaftaranT'])) {
            $modPasienPulang->attributes = $_GET['GZPendaftaranT'];
            $modPasienPulang->ruangan_id = $_GET['GZPendaftaranT']['ruangan_id'];
            $modPasienPulang->instalasi_id = $_GET['GZPendaftaranT']['instalasi_id'];
            $modPasienPulang->no_pendaftaran = $_GET['GZPendaftaranT']['no_pendaftaran'];
            $modPasienPulang->no_rekam_medik = $_GET['GZPendaftaranT']['no_rekam_medik'];
            $modPasienPulang->nama_pasien = $_GET['GZPendaftaranT']['nama_pasien'];
            $modPasienPulang->default = null;
        }

        // Mencari Pasien Baru
        if (isset($_GET['GZPendaftaranT'])) {
            $modPasienBaru->attributes = $_GET['GZPendaftaranT'];
            $modPasienBaru->ruangan_id = $_GET['GZPendaftaranT']['ruangan_id'];
            $modPasienBaru->instalasi_id = $_GET['GZPendaftaranT']['instalasi_id'];
            $modPasienBaru->no_pendaftaran = $_GET['GZPendaftaranT']['no_pendaftaran'];
            $modPasienBaru->no_rekam_medik = $_GET['GZPendaftaranT']['no_rekam_medik'];
            $modPasienBaru->nama_pasien = $_GET['GZPendaftaranT']['nama_pasien'];
            $modPasienBaru->default = null;
            // echo '<pre>';var_dump($modPasienBaru);die;
        }

        // Mencari Riwayat Pemesanan
        if (isset($_GET['PesanmenudietR'])) {
            $modRiwayatPemesanan->attributes = $_GET['PesanmenudietR'];
            $modRiwayatPemesanan->ruangan_id = $_GET['PesanmenudietR']['ruangan_id'];
            $modRiwayatPemesanan->instalasi_id = $_GET['PesanmenudietR']['instalasi_id'];
        }

        if (!empty($_GET['jenis'])){
            if ($_GET['jenis'] == 'pesan-ulang'){
                $model->tglpesanmenu = date('d M Y H:i:s');
            }
        }

        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienbaru-m-grid') {
                $this->renderPartial($this->path_view . '._dataPasienBaru', array('modPasienPulang' => $modPasienPulang, 'model' => $model));
                Yii::app()->end();
            }
        }
        if(Yii::app()->request->isAjaxRequest) {
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'gzmenudiet-m-grid') {
                $this->renderPartial($this->path_view . '_dialog', array('model' => $model));
                Yii::app()->end();
            }
            if(isset($_GET['ajax']) && $_GET['ajax'] == 'grid-jenisdiet' || $_GET['ajax'] == 'grid-menudiet') {
                $this->renderPartial($this->path_view . '_dialogUbahMenu', array('model' => $model));
                Yii::app()->end();
            }
        }

        if (isset($_POST['GZPesanmenudietT'])) {

            // var_dump($_POST);
            // echo '<pre>';var_dump($_POST);die;

            $transaction = Yii::app()->db->beginTransaction();
            $success = true;

            try {
                $model->attributes = $_POST['GZPesanmenudietT'];
                if (!empty($_GET['jenis'])){
                    if ($_GET['jenis'] == 'pesan-ulang'){
                        unset($model->pesanmenudiet_id);
                        $model->kirimmenudiet_id = null;
                        $model->isNewRecord = true;
                    }
                }
                $model->ruangan_id = !empty($_POST['temp_instalasi_id']) ? $_POST['temp_ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                $model->instalasi_id = !empty($_POST['temp_instalasi_id']) ? $_POST['temp_instalasi_id'] : Yii::app()->user->getState('instalasi_id');
                $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
                $model->tglpesanmenu = MyFormatter::formatDateTimeForDb($model->tglpesanmenu);
                $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
                $model->pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
                $model->pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
                if (empty($model->pesanmenudiet_id)) {                    
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->create_time = date('Y-m-d');
                } else {
                    $model->update_loginpemakai_id = Yii::app()->user->id;
                    $model->update_time = date('Y-m-d');
                }
                if(isset($_POST['GZPesanmenudetailT'])){
                    $model->adaalergimakanan = isset($_POST['GZPesanmenudetailT'][0]['adaalergimakanan']) ? $_POST['GZPesanmenudetailT'][0]['adaalergimakanan'] : '';
                    $model->keterangan_pesan = isset($_POST['GZPesanmenudetailT'][0]['keterangan']) ? $_POST['GZPesanmenudetailT'][0]['keterangan'] : '';
                }

                // var_dump($model->attributes, $_POST['GZPesanmenudietT']); die;

                $success &= $model->save();    
                
                $model = $model;                
                
                if (!$success) {
                    echo "<pre>";
                    var_dump("model :");
                    var_dump($model->getErrors());
                }

                if ($success) {
                    if(!empty($id)){
                    //   $delete = GZPesanmenudetailT::model()->deleteAllByAttributes(array('pesanmenudiet_id' => $id));
                    }

                    foreach ($_POST['GZPesanmenudetailT'] as $i => $v) {
                        // vaR_dump($v);
                        if ($v['ceklis_baris'] == 1) {
                            $modDetail = new GZPesanmenudetailT();
                            $cekDet = GZPesanmenudetailT::model()->findByPk($v['pesanmenudetail_id']);
                            if (!empty($cekDet)) {
                                $modDetail = $cekDet;
                            }   
                            $modDetail->attributes = $v;
                            $modDetail->pesanmenudiet_id = $model->pesanmenudiet_id;
                            $modDetail->tipediet_id = !empty($v['tipediet_id']) ? $v['tipediet_id'] : '';
                            $modDetail->adaalergimakanan = !empty($v['adaalergimakanan']) ? $v['adaalergimakanan'] : '';
                            $modDetail->keterangan = !empty($v['keterangan']) ? $v['keterangan'] : '';
                            $modDetail->pesanmenudetail_id = !empty($v['pesanmenudetail_id']) ? $v['pesanmenudetail_id'] : null;
                            $modDetail->status_menu = !empty($v['status_menu']) ? $v['status_menu'] : '';
                            
                            $menu = GZMenuDietM::model()->findByPk($modDetail->menudiet_id);
                            if (!empty($menu)) {
                                $modDetail->jenisdiet_id = $menu->jenisdiet_id;
                            }
                            
                            // $modDetail->jenisdiet_id = $modDetail->tipediet->jenisdiet_id;
                            

                            
                            $success &= $modDetail->save();


                            // var_dump($modDetail->attributes);

                            if((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RI || Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD) && $success){
                                $this->notifPemesananMenuDiet($model, $modDetail, $id);
                            }

                            if (!$success) {
                                echo "<pre>";
                                var_dump("modDetail :");
                                var_dump($modDetail->getErrors());
                            }

                            
                            $modRiwayat = new PesanmenudietR;
                            $cekR = PesanmenudietR::model()->findByPk($v['pesanmenudiet_riwayat_id']);
                            if (!empty($cekR)) {
                                $modRiwayat = $cekR;
                            }
                            $modRiwayat->attributes = $modDetail->attributes;
                            $modRiwayat->tipediet_id = !empty($v['tipediet_id']) ? $v['tipediet_id'] : '';
                            $modRiwayat->jenisdiet_id = !empty($v['jenisdiet_id']) ? $v['jenisdiet_id'] : '';
                            $modRiwayat->jenismakanan_id = $modDetail->jenismakanan_id;
                            $modRiwayat->alatmakanan_id = $modDetail->alatmakanan_id;
                            $modRiwayat->ruangan_id = $model->ruangan_id;

                            if (empty($modRiwayat->jenisdiet_id)) {
                                $modRiwayat->jenisdiet_id = $modDetail->jenisdiet_id;
                            }

                            $success &=  $modRiwayat->save();

                            // var_dump($modRiwayat->attributes, $v);

                            if (!$success) {
                                var_dump($modRiwayat->attributes, $v);
                                echo "<pre>";
                                var_dump("modRiwayat :");
                                var_dump($modRiwayat->jenismakanan_id . " / " .$modDetail->jenismakanan_id);
                                var_dump($modRiwayat->alatmakanan_id . " / " .$modDetail->alatmakanan_id);
                                var_dump($modRiwayat->getErrors());
                                die;
                            }
                        }
                    }


                    if (isset($_POST['deleteriwayat'])) {
                        $criDel = new CDbCriteria();
                        $criDel->addInCondition(" pesanmenudiet_riwayat_id ", $_POST['deleteriwayat']);
                        $success = $success && PesanmenudietR::model()->deleteAll($criDel);
                    }

                    if (isset($_POST['deletedetail'])) {
                        $criDel = new CDbCriteria();
                        $criDel->addInCondition(" pesanmenudetail_id ", $_POST['deletedetail']);
                        $criDel2 = clone $criDel;
                        $success = $success && GZPesanmenudetailT::model()->deleteAll($criDel);

                        // $del = BahanmenudietdetT::model()->deleteAll($criDel2);
                    }
                } else {
                    $success = false;
                }

                // vaR_dump($success); die;

                if ($success) {
                    Yii::app()->user->setFlash('success', 'Data Berhasil Disimpan!');
                    $transaction->commit();
                    $this->redirect(array('index', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                }
            } catch (Exception $ex) {
                var_dump($ex);
                die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
            }
        }

        $this->render($this->path_view . 'index', array(
            'model' => $model,
            'modBahan' => $modBahan,
            'modPasienPulang' => $modPasienPulang,
            'loadData' => $loadData
        ));
    }

    //-- Gizi -- 
    //Get List Jenis Diet untuk Pemesanan Menu Diet
    public function actionJenisDiet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(jenisdiet_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'jenisdiet_id';
            $models = JenisdietM::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->jenisdiet_nama;
                $returnVal[$i]['value'] = $model->jenisdiet_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    //-- Gizi -- 
    //Get List Pasien untuk Pemesanan Menu Diet
    public function actionPasienUntukMenuDiet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_GET['ruangan_id'];
            if (!empty($ruangan_id)) {
                $criteria = new CDbCriteria();
                //                $criteria->with =array('pasien', 'ruangan');  
                $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['term']), true);
                if (!empty($ruangan_id)) {
                    $criteria->compare('ruangan_id', $ruangan_id);
                }
                $criteria->order = 'nama_pasien';
                $models = InfokunjunganriV::model()->findAll($criteria);
                $returnVal = array();
                foreach ($models as $i => $model) {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j => $attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $model->penjamin_id);
                    $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . ' - ' . $model->ruangan_nama;
                    $returnVal[$i]['value'] = $model->pasien_id;
                    $returnVal[$i]['jenistarif_id'] = isset($modJenisTarif->jenistarif_id) ? $modJenisTarif->jenistarif_id : null;
                }

                echo CJSON::encode($returnVal);
            }
        }
        Yii::app()->end();
    }

    //-- Gizi -- 
    //Get List Menu Diet untuk Pemesanan Menu Diet
    public function actionMenuDiet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $penjamin_id = null;
            if (isset($_GET['penjamin_id'])) {
                $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
            }

            $jenisdiet_id = isset($_GET['jenisdiet_id']) ? $_GET['jenisdiet_id'] : null;
            $jenismakanan_id = isset($_GET['jenismakanan_id']) ? $_GET['jenismakanan_id'] : null;

            


            $criteria = new CDbCriteria();
            $criteria->select = "  t.*";
            //$criteria->join = " JOIN jenismenudiet_m jenismenu ON jenismenu.jenismenudiet_id = t.jenismenudiet_id ";

            if (empty($jenisdiet_id)) {
                $criteria->addCondition(" t.menudiet_id is null ");
            } else {
                if (!empty($jenisdiet_id)) {
                    $criteria->addCondition(" t.jenisdiet_id = " . $jenisdiet_id . " ");
                }

                if (!empty($jenismakanan_id)) {
                    $criteria->addCondition(" t.jenismakanan_id = " . $jenismakanan_id . " ");
                }
            }
            $criteria->compare('LOWER(t.menudiet_nama)', strtolower($_GET['term']), true);
            // if (!empty($_GET['kelaspelayanan_id'])) {
            //     $criteria->compare('tariftindakan_m.kelaspelayanan_id', $_GET['kelaspelayanan_id']);
            // }
            // if (!empty($_GET['jenisdiet_id'])) {
            //     $criteria->compare('t.jenisdiet_id', $_GET['jenisdiet_id']);
            // }
            /*
            if (!empty($penjamin_id)) {
                $jt = JenistarifpenjaminM::model()->findByAttributes(array(
                    'penjamin_id' => $penjamin_id
                ));
                $criteria->compare('tariftindakan_m.jenistarif_id', $jt->jenistarif_id);
            }
            */
            $criteria->order = 't.menudiet_nama';
            /*
            $criteria->join = 'JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id
							   JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id 
                                                         JOIN jenismenudiet_m jenismenu ON jenismenu.jenismenudiet_id = t.jenismenudiet_id  ';
            */
            //$criteria->addCondition('tariftindakan_m.komponentarif_id = 6');


            // var_dump($criteria); die;

            $criteria->limit = 5;
            $models = MenuDietM::model()->findAll($criteria);
            $returnVal = array();
            foreach ($models as $i => $model) {
                $attributes = $model->attributeNames();
                foreach ($attributes as $j => $attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->menudiet_nama;
                $returnVal[$i]['value'] = $model->menudiet_id;
                $returnVal[$i]['menudiet_nama'] = $model->menudiet_nama;
            }


            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    /**
     * set dropdown ruangan dari instalasi_id
     * @param type $encode
     * @param type $namaModel
     */
    public function actionSetDropdownRuangan($encode = false, $namaModel = '')
    {
        if (Yii::app()->request->isAjaxRequest) {
            $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
            if ($encode) {
                echo CJSON::encode($ruangan);
            } else {
                if (empty($instalasi_id)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                } else {
                    $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama ASC'));
                    if (count($ruangan) > 1) {
                        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
                    }
                    $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
                    foreach ($ruangan as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }

    /**
     * Meluluskan ppds
     */
    public function actionHapusPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = explode(",", $_POST['id']);
            $jumlah = count(explode(",", $_POST['id']));
            for ($i = 0; $i < $jumlah; $i++) {
                $model = PesanmenudietR::model()->deleteAllByAttributes(array('pendaftaran_id' => $id[$i]));
            }
            if ($model) {
                $data['sukses'] = 'sukses';
            } else {
                $data['sukses'] = 'gagal';
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * Mendapatkan daftar ppds yang akan diluluskan
     */
    public function actionIsiPasienPulang()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $jumlah = count($_POST['id']);
            if ($jumlah > 1) {
                $data['id'] = $_POST['id'];
                $data['message'] = $jumlah . ' Pasien';
            } else {
                $data['id'] = $_POST['id'][0];
                $data['message'] = 'Pasien ini';
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * menegenerate kantong darah
     */
    public function actionGetWaktu()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $jeniswaktu_id = isset($_POST['jeniswaktu_id']) ? $_POST['jeniswaktu_id'] : null;

            $cri = new CDbCriteria();
            if (is_array($jeniswaktu_id)) {
                $cri->addInCondition("jeniswaktu_id", $jeniswaktu_id);
            } else {
                $cri->addCondition("jeniswaktu_id = '" . $jeniswaktu_id . "' ");
            }
            $modWaktu = JeniswaktuM::model()->findAll($cri);

            $kanUtama = array();

            foreach ($modWaktu as $d) {
                $kanUtam[$d->jeniswaktu_id]['jeniswaktu_id'] = $d->jeniswaktu_id;
                $kanUtam[$d->jeniswaktu_id]['jeniswaktu_nama'] = $d->jeniswaktu_nama;
            }

            $tr = '';
            $no = 0;
            foreach ($kanUtam as $det) {
                $modDetail = new PesanmenudetailT();
                $modDetail->jeniswaktu_id = $det['jeniswaktu_id'];
                $tr .= $this->renderPartial($this->path_view . '_detailPemesanan', array('no' => $no + 1, 'modWaktu' => $det, 'modDetail' => $modDetail), true);
                $no++;
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    public function actionGetMenuDietPegawai()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $modDetail = new PesanmenupegawaiT();

            $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : Yii::app()->user->getState('pegawai_id'));
            $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);

            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];
            $pegawaiId = (isset($_POST['pegawaiId']) ? $_POST['pegawaiId'] : null);

            $jumlahPesan = count($pegawaiId);
            if ($jumlahPesan < 1) {
                $pegawaiId = array($pegawai_id);
            }
            $tr = '';
            foreach ($pegawaiId as $i => $pegawai_id) {
                $model = PegawaiM::model()->findByPk($pegawai_id);
                $nama = $model->nama_pegawai;
                $jeniskelamin = $model->jeniskelamin;
                $tr .= '<tr>
                            <td>'
                    . CHtml::checkBox('PesanmenupegawaiT[][' . $ruangan_id . '][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                    . CHtml::activeHiddenField($modDetail, '[][' . $ruangan_id . ']pegawai_id', array('value' => $model->pegawai_id))
                    . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][ruangan_id]', $ruangan_id)
                    . '</td>
                            <td>' . RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama . '/<br/>' . RuanganM::model()->findByPk($ruangan_id)->ruangan_nama . '</td>
                            <td>' . CHtml::textField('nama', $nama, array('readonly' => true, 'class' => 'span2 nama')) . '</td>
                            <td>' . $jeniskelamin . '</td>';
                foreach (JeniswaktuM::getJenisWaktu() as $v) {
                    if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
                        $tr .= '<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                            . CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array($menudiet_id => array("selected" => "selected")))) . '</td>';
                    } else {
                        $tr .= '<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
                            . CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
                    }
                }
                $tr .= '<td>' . CHtml::activeTextField($modDetail, '[][' . $ruangan_id . ']jml_pesan_porsi', array('value' => $jumlah, 'class' => ' span1 numbersOnly',)) . '</td>
                            <td>' . CHtml::activeDropDownList($modDetail, '[][' . $ruangan_id . ']satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array($urt => array("selected" => "selected")))) . '</td>
                            </tr>';
            }
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

    /**
     * actionAjax untuk mengambil menudiet
     */
    public function actionGetMenuDietDetail()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $jenisdiet_id = (isset($_POST['jenisdiet_id']) ? $_POST['jenisdiet_id'] : null);
            $jenismakanan_id = (isset($_POST['jenismakanan_id']) ? $_POST['jenismakanan_id'] : null);
            $alatmakan = (isset($_POST['alatmakan']) ? $_POST['alatmakan'] : null);

            $urt = $_POST['urt'];
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];
            $pendaftaranId = (isset($_POST['pendaftaranId']) ? $_POST['pendaftaranId'] : null);
            $pasienAdmisi = (isset($_POST['pasienAdmisi']) ? $_POST['pasienAdmisi'] : null);

            $cekTabelDetail = isset($_POST['cekTabelDetail']) ? $_POST['cekTabelDetail'] : null;

            $modDetail = new GZPesanmenudetailT();
            $modJenisWaktu = JeniswaktuM::model()->findAllByAttributes(array('jenismakanan_id' => $jenismakanan_id, 'jeniswaktu_aktif' => 'true'));
            $diet = MenuDietM::model()->findByPK($menudiet_id);
            $jnsDiet = JenisdietM::model()->findByPk($jenisdiet_id);
            $cekAlatmakan = AlatmakananM::model()->findByPk($alatmakan);
            $cekJenisMakanan = JenismakananM::model()->findByPk($jenismakanan_id);
            $jumlahPasien = isset($pasienAdmisi) ? $pasienAdmisi : " ";
            if ($jumlahPasien == 0) {
                $jumlahPasien = 1;
            }
            $dt = array();
            $tr = '';
            for ($i = 0; $i < $jumlahPasien; $i++) {
                $a = 0;
                foreach ($jeniswaktu as $v) {
                    $modDetail = new GZPesanmenudetailT();
                    $no_pendaftarans = "";
                    $no_rekammediks = "";
                    $nama_pasiens = "";
                    $jeniskelamins = "";
                    $umurs = "";
                    if (empty($pasienAdmisi)) {
                        $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienadmisi_id));
                        $no_pendaftarans = $model->no_pendaftaran;
                        $no_rekammediks = $model->no_rekam_medik;
                        $nama_pasiens = $model->nama_pasien;
                        $jeniskelamins = $model->jeniskelamin;
                        $umurs = $model->umur;
                    } else {
                        $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i], 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienAdmisi[$i]));
                        $no_pendaftarans = $model->no_pendaftaran;
                        $no_rekammediks = $model->no_rekam_medik;
                        $nama_pasiens = $model->nama_pasien;
                        $jeniskelamins = $model->jeniskelamin;
                        $umurs = $model->umur;
                    }
                    $cekWaktu = JeniswaktuM::model()->findByPk($v);
                    $tr .= '<tr pendaftaran-data ="' . $pendaftaran_id . '">';
                    if ($cekTabelDetail == 0 && $a == 0) {
                        $tr .= '<td rowspan="' . count($jeniswaktu) . '">'
                            . CHtml::checkBox('PesanmenudetailT[][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                            . '</td>
                                                <td rowspan="' . count($jeniswaktu) . '">' . RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->ruangan_nama . '</td>
                                                <td rowspan="' . count($jeniswaktu) . '">' . $no_pendaftarans . '</td>
                                                <td rowspan="' . count($jeniswaktu) . '">' . $no_rekammediks . '</td>
                                                <td rowspan="' . count($jeniswaktu) . '">' . $nama_pasiens . '</td>
                                                <td rowspan="' . count($jeniswaktu) . '">' . $jeniskelamins . '/ <br/>' . $umurs . '</td>"';
                    }
                    $tr .= '<td>' . $cekJenisMakanan->jenismakanan_nama . CHtml::dropDownList('PesanmenudetailT[][jenismakanan_id]', '', Chtml::listData(JenismakananM::model()->findAllByAttributes(array('jenismakanan_aktif' => true)), 'jenismakanan_id', 'jenismakanan_nama'), array(
                        'empty' => '-- Pilih --', 'class' => 'span2', 'style' => 'display: none',
                        'options' => array("$jenismakanan_id" => array("selected" => "selected"))
                    )) .
                        CHtml::activeHiddenField($modDetail, '[]pendaftaran_id', array('value' => $pendaftaran_id, 'class' => 'daftar_id'))
                        . CHtml::activeHiddenField($modDetail, '[]pasien_id', array('value' => $pasien_id, 'class' => 'pasienNama'))
                        . CHtml::activeHiddenField($modDetail, '[]pasienadmisi_id', array('value' => $pasienadmisi_id))
                        . CHtml::activeHiddenField($jnsDiet, '[]jenisdiet_id', array('value' => $jenisdiet_id, 'class' => 'jenisDiet jenisdiet_id')) . '</td>
                                            
                                            <td>' . $jnsDiet->jenisdiet_nama . '</td>
                                            <td>' . $cekWaktu->jeniswaktu_nama . CHtml::dropDownList('PesanmenudetailT[][jeniswaktu_id]', '', Chtml::listData(JeniswaktuM::model()->findAllByAttributes(array('jeniswaktu_aktif' => true)), 'jeniswaktu_id', 'jeniswaktu_nama'), array(
                            'empty' => '-- Pilih --', 'class' => 'span2 jeniswaktu_id', 'style' => 'display: none',
                            'options' => array("$v" => array("selected" => "selected"))
                        )) . '</td>
                                            <td>' . CHtml::dropDownList('PesanmenudetailT[][alatmakan_id]', '', Chtml::listData(AlatmakananM::model()->findAllByAttributes(array('alatmakanan_aktif' => true)), 'alatmakanan_id', 'alatmakanan_nama'), array(
                            'empty' => '-- Pilih --', 'class' => 'span2',
                            'options' => array("$alatmakan" => array("selected" => "selected"))
                        )) . '</td>
                                            <td>' . CHtml::activeTextField($modDetail, '[]jml_pesan_porsi', array('value' => $jumlah, 'class' => ' span1 numbersOnly', 'style' => 'text-align: right;')) . '</td>
                                            <td>' . CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array("$urt" => array("selected" => "selected")))) . '</td>';
                    if ($cekTabelDetail == 0 && $a == 0) {
                        $tr .= '<td rowspan="' . count($jeniswaktu) . '">' . CHtml::link("<i class='icon-form-detail'>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/detailBahanmenudiet', array('pendaftaran_id' => $model->pendaftaran_id, 'pasienadmisi_id' => $model->pasienadmisi_id, 'jeniswaktu_id' => $v)), array(
                            "target" => "frameDetail",
                            "onclick" => '$("#dialogDetail").dialog("open");',
                        )) . '</td>';
                    }
                    $tr .= '</tr>';
                    $a++;
                }
            }
            $dt['tr'] = $tr;
            $dt['jenisDietPasien'] = $jenisdiet_id . '-' . $pasien_id;
            $dt['namaPasien'] = $model->nama_pasien;
            $dt['jenisDiet'] = $jnsDiet->jenisdiet_nama;
            echo json_encode($dt);
            Yii::app()->end();
        }
    }

    /**
     * actionAjax untuk mengambil menudiet
     */
    public function actionGetMenuDietJenisWaktu()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $jenisdiet_id = (isset($_POST['jenisdiet_id']) ? $_POST['jenisdiet_id'] : null);
            $jenismakanan_id = (isset($_POST['jenismakanan_id']) ? $_POST['jenismakanan_id'] : null);
            $alatmakan = (isset($_POST['alatmakan']) ? $_POST['alatmakan'] : null);
            $menudiet_lain_id = (isset($_POST['menudiet_lain_id']) ? $_POST['menudiet_lain_id'] : null);
            $tipediet_id = (isset($_POST['tipediet_id']) ? $_POST['tipediet_id'] : null);
            $alergi = (isset($_POST['alergi']) ? $_POST['alergi'] : null);
            $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);

            $urt = isset($_POST['urt']) ? $_POST['urt'] : null;
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];

            $totalJenisWaktu = count($jeniswaktu);

            $cekTabelDetail = isset($_POST['cekTabelDetail']) ? $_POST['cekTabelDetail'] : null;

            $dt = array();
            $tr = '';

            

            $modDetail = new GZPesanmenudetailT();
            $modAdmisi = GZPasienAdmisiT::model()->findByPk($pasienadmisi_id);

            $modPendaftaran = GZPendaftaranT::model()->findByPk($pendaftaran_id);

            if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD){
                $pasien_id = $modPendaftaran->pasien_id;
            }

            $modPasien = GZPasienM::model()->findByPK($pasien_id);

            $jenisMakanan = JenismakananM::model()->findByPk($jenismakanan_id);

            $jenisDiet = GZJenisdietM::model()->findByPk($jenisdiet_id);

            $dropAlatMakanan = CHtml::listData(AlatmakananM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'alatmakanan_aktif' => true), array('order' => 'alatmakanan_nama ASC')), 'alatmakanan_id', 'alatmakanan_nama'); //'kelaspelayanan_id'=>$kelaspelayanan_id

            $modAlatMakan = GZAlatmakananM::model()->findByPk($alatmakan);

            $menuDiet = GZMenuDietM::model()->findByPk($menudiet_id);
            $menuDietLain = GZMenuDietM::model()->findByPk($menudiet_lain_id);

            $hasil = array_filter($jeniswaktu);

            $cri1 = new CDbCriteria();
            $cri1->addInCondition("jeniswaktu_id", $hasil);
            $modJnsWaktu = JenisWaktuM::model()->findAll($cri1);

            if (!empty($modJnsWaktu)) {
                foreach ($modJnsWaktu as $i => $det) {
                    $modDetail->ruangan_nama = (!empty($modAdmisi) ? $modAdmisi->ruangan->ruangan_nama : $modPendaftaran->ruangan->ruangan_nama);
                    $modDetail->no_pendaftaran = $modPendaftaran->no_pendaftaran;
                    $modDetail->no_rekam_medik = $modPasien->no_rekam_medik;
                    $modDetail->nama_pasien = $modPasien->nama_pasien;
                    $modDetail->jeniskelamin = $modPasien->jeniskelamin;
                    $modDetail->umur = $modPendaftaran->umur;
                    $modDetail->kelaspelayanan_id = $kelaspelayanan_id;
                    $modDetail->adaalergimakanan = $alergi;
                    $modDetail->keterangan = $keterangan;

                    $modDetail->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modDetail->pasien_id = $modPasien->pasien_id;
                    $modDetail->pasienadmisi_id = (!empty($modAdmisi) ? $modAdmisi->pasienadmisi_id : null);

                    $modDetail->jenisdiet_id = $jenisDiet->jenisdiet_id;
                    $modDetail->jenisdiet_nama = $jenisDiet->jenisdiet_nama;

                    if (!empty($jenisMakanan)){
                        $modDetail->jenismakanan_id = $jenisMakanan->jenismakanan_id;
                        $modDetail->jenismakanan_nama = $jenisMakanan->jenismakanan_nama;
                    }


                    $modDetail->alatmakanan_id = !empty($modAlatMakan->alatmakanan_id) ? $modAlatMakan->alatmakanan_id : '';
                    $modDetail->alatmakanan_nama = !empty($modAlatMakan->alatmakanan_nama) ? $modAlatMakan->alatmakanan_nama : '';

                    $modDetail->jeniswaktu_id = $det->jeniswaktu_id;
                    $modDetail->jeniswaktu_nama = $det->jeniswaktu_nama;

                    $modDetail->alatmakanan_id = !empty($modAlatMakan->alatmakanan_id) ? $modAlatMakan->alatmakanan_id : '';
                    $modDetail->alatmakanan_nama = !empty($modAlatMakan->alatmakanan_nama) ? $modAlatMakan->alatmakanan_nama : '';

                    $modDetail->jml_pesan_porsi = $jumlah;
                    $modDetail->satuanjml_urt = $urt;

                    $modDetail->checkList = true;
                    $modDetail->ceklis_baris = true;

                    if (!empty($menuDiet)){
                        $modDetail->menudiet_nama = $menuDiet->menudiet_nama;
                        $modDetail->menudiet_id = $menuDiet->menudiet_id;
                    }
                    $modDetail->tipediet_id = $tipediet_id;
                    $cektipediet = TipeDietM::model()->findByPk($tipediet_id);
                    $modDetail->tipediet_nama = !empty($cektipediet) ? $cektipediet->tipediet_nama : '-';

                    if (!empty($jenisDiet)) {
                        $modDetail->jenismenudiet_id = $jenisDiet->jenisdiet_id;
                        $modDetail->jenismenudiet_nama = $jenisDiet->jenisdiet_nama;
                    }

                    $tr .= $this->renderPartial($this->path_view . '_rowDetailPesanMenu', array(
                        'countJnsWaktu' => count($jeniswaktu),
                        'cekTabelDetail' => $cekTabelDetail,
                        'model' => $modDetail,
                        'dropAlatMakanan' => $dropAlatMakanan,
                        'i' => $i
                    ), true);
                }
            }

            // echo "<pre>";
            // var_dump($tr);
            // die;
            $dt['sukses'] = 1;
            $dt['tr'] = $tr;
            $dt['totalJenisWaktu'] = $totalJenisWaktu;
            $dt['cekTabelDetail'] = $cekTabelDetail;
            echo json_encode($dt);
            Yii::app()->end();
        }
    }
    public function actionGetMenuDietPerJenisWaktu()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
            $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $jenisdiet_id = (isset($_POST['jenisdiet_id']) ? $_POST['jenisdiet_id'] : null);
            $jenismakanan_id = (isset($_POST['jenismakanan_id']) ? $_POST['jenismakanan_id'] : null);
            $alatmakan = (isset($_POST['alatmakan']) ? $_POST['alatmakan'] : null);
            $menudiet_lain_id = (isset($_POST['menudiet_lain_id']) ? $_POST['menudiet_lain_id'] : null);
            $tipediet_id = (isset($_POST['tipediet_id']) ? $_POST['tipediet_id'] : null);
            $alergi = (isset($_POST['alergi']) ? $_POST['alergi'] : null);
            $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);

            $urt = isset($_POST['urt']) ? $_POST['urt'] : null;
            $jumlah = $_POST['jumlah'];
            $jeniswaktu = $_POST['jeniswaktu'];

            $totalJenisWaktu = count($jeniswaktu);

            $cekTabelDetail = isset($_POST['cekTabelDetail']) ? $_POST['cekTabelDetail'] : null;

            $dt = array();
            $tr = '';

            // echo '<pre>';var_dump($menudiet_id, $jenisdiet_id);die;
            

            $modDetail = new GZPesanmenudetailT();
            $modAdmisi = GZPasienAdmisiT::model()->findByPk($pasienadmisi_id);

            $modPendaftaran = GZPendaftaranT::model()->findByPk($pendaftaran_id);

            if(Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_RD){
                $pasien_id = $modPendaftaran->pasien_id;
            }

            $modPasien = GZPasienM::model()->findByPK($pasien_id);

            $jenisMakanan = JenismakananM::model()->findByPk($jenismakanan_id);

            $jenisDiet = GZJenisdietM::model()->findByPk($jenisdiet_id);

            $dropAlatMakanan = CHtml::listData(AlatmakananM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'alatmakanan_aktif' => true), array('order' => 'alatmakanan_nama ASC')), 'alatmakanan_id', 'alatmakanan_nama'); //'kelaspelayanan_id'=>$kelaspelayanan_id

            $modAlatMakan = GZAlatmakananM::model()->findByPk($alatmakan);

            $menudiet_id = array_filter($menudiet_id);
            $critMenu = new CDbCriteria();
            $critMenu->addInCondition("menudiet_id", $menudiet_id);
            $menuDiet = GZMenuDietM::model()->findAll($critMenu);
            $menuDietLain = GZMenuDietM::model()->findByPk($menudiet_lain_id);

            $hasil = array_filter($jeniswaktu);

            $cri1 = new CDbCriteria();
            $cri1->addInCondition("jeniswaktu_id", $hasil);
            $modJnsWaktu = JenisWaktuM::model()->findAll($cri1);

            if (!empty($modJnsWaktu)) {
                foreach ($modJnsWaktu as $i => $det) {
                    $modDetail->ruangan_nama = (!empty($modAdmisi) ? $modAdmisi->ruangan->ruangan_nama : $modPendaftaran->ruangan->ruangan_nama);
                    $modDetail->no_pendaftaran = $modPendaftaran->no_pendaftaran;
                    $modDetail->no_rekam_medik = $modPasien->no_rekam_medik;
                    $modDetail->nama_pasien = $modPasien->nama_pasien;
                    $modDetail->jeniskelamin = $modPasien->jeniskelamin;
                    $modDetail->umur = $modPendaftaran->umur;
                    $modDetail->kelaspelayanan_id = $kelaspelayanan_id;
                    $modDetail->adaalergimakanan = $alergi;
                    $modDetail->keterangan = $keterangan;

                    $modDetail->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                    $modDetail->pasien_id = $modPasien->pasien_id;
                    $modDetail->pasienadmisi_id = (!empty($modAdmisi) ? $modAdmisi->pasienadmisi_id : null);

                    $modDetail->jenisdiet_id = $jenisDiet->jenisdiet_id;
                    $modDetail->jenisdiet_nama = $jenisDiet->jenisdiet_nama;

                    if (!empty($jenisMakanan)){
                        $modDetail->jenismakanan_id = $jenisMakanan->jenismakanan_id;
                        $modDetail->jenismakanan_nama = $jenisMakanan->jenismakanan_nama;
                    }


                    $modDetail->alatmakanan_id = !empty($modAlatMakan->alatmakanan_id) ? $modAlatMakan->alatmakanan_id : '';
                    $modDetail->alatmakanan_nama = !empty($modAlatMakan->alatmakanan_nama) ? $modAlatMakan->alatmakanan_nama : '';

                    $modDetail->jeniswaktu_id = $det->jeniswaktu_id;
                    $modDetail->jeniswaktu_nama = $det->jeniswaktu_nama;

                    $modDetail->alatmakanan_id = !empty($modAlatMakan->alatmakanan_id) ? $modAlatMakan->alatmakanan_id : '';
                    $modDetail->alatmakanan_nama = !empty($modAlatMakan->alatmakanan_nama) ? $modAlatMakan->alatmakanan_nama : '';

                    $modDetail->jml_pesan_porsi = $jumlah;
                    $modDetail->satuanjml_urt = $urt;

                    $modDetail->checkList = true;
                    $modDetail->ceklis_baris = true;

                    if (!empty($menuDiet[$i])){
                        $modDetail->menudiet_nama = $menuDiet[$i]->menudiet_nama;
                        $modDetail->menudiet_id = $menuDiet[$i]->menudiet_id;
                    }
                    $modDetail->tipediet_id = $tipediet_id;
                    $cektipediet = TipeDietM::model()->findByPk($tipediet_id);
                    $modDetail->tipediet_nama = !empty($cektipediet) ? $cektipediet->tipediet_nama : '-';

                    if (!empty($jenisDiet)) {
                        $modDetail->jenismenudiet_id = $jenisDiet->jenisdiet_id;
                        $modDetail->jenismenudiet_nama = $jenisDiet->jenisdiet_nama;
                    }

                    $tr .= $this->renderPartial($this->path_view . '_rowDetailPesanMenu', array(
                        'countJnsWaktu' => count($jeniswaktu),
                        'cekTabelDetail' => $cekTabelDetail,
                        'model' => $modDetail,
                        'dropAlatMakanan' => $dropAlatMakanan,
                        'i' => $i
                    ), true);
                }
            }

            // echo "<pre>";
            // var_dump($tr);
            // die;
            $dt['sukses'] = 1;
            $dt['tr'] = $tr;
            $dt['totalJenisWaktu'] = $totalJenisWaktu;
            $dt['cekTabelDetail'] = $cekTabelDetail;
            echo json_encode($dt);
            Yii::app()->end();
        }
    }

    /**
     * tambah jenis diet
     */
    public function actionTambahJenisDiet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $jenismakanan_id = isset($_POST['jenismakanan_id']) ? $_POST['jenismakanan_id'] : null;
            $menudiet_id = isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null; //field jenis diet
            $alatmakanan_id = isset($_POST['alatmakanan_id']) ? $_POST['alatmakanan_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $jeniswaktu_id = isset($_POST['jeniswaktu_id']) ? $_POST['jeniswaktu_id'] : null;
            $tot_data = isset($_POST['tot_data']) ? $_POST['tot_data'] : null;
            $tr = '';

            $modPasien = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'ruangan_id' => $ruangan_id));

            $modJenisMakan = JenismakananM::model()->findByPk($jenismakanan_id);

            $cri = new CDbCriteria();
            $cri->addInCondition(" jeniswaktu_id = '" . $jeniswaktu_id . "' ");
            $modJenisWaktu = GZJenisWaktuM::model()->findAll($cri);

            $dropAlatMakanan = GZAlatmakananM::model()->findAllByAttributes();

            foreach ($modJenisWaktu as $det) {
                $modDetail = new GZPesanmenudetailT;
                $modDetail->instalasi_nama = $modPasien->instalasi_nama;
                $modDetail->ruangan_nama = $modPasien->ruangan_nama;
                $modDetail->no_pendaftaran = $modPasien->no_pendaftaran;
                $modDetail->no_rekam_medik = $modPasien->no_rekam_medik;
                $modDetail->nama_pasien = $modPasien->nama_pasien;
                $modDetail->jeniskelamin = $modPasien->jeniskelamin;
                $modDetail->umur = $modPasien->umur;
                $modDetail->jenismakanan_nama = $modJenisMakan->jenismakanan_nama;
                $modDetail->alatmakanan_id = $alatmakanan_id;
                $modDetail->pasienadmisi_id =  !empty($modPasien->pasienadmisi_id) ? $modPasien->pasienadmisi_id : null;
                $modDetail->pendaftaran_id = $modPasien->pendaftaran_id;
                $modDetail->ruangan_id = $ruangan_id;
                $modDetail->jeniswaktu_id = $det->jeniswaktu_id;
                $modDetail->jeniswaktu_nama = $det->jeniswaktu_nama;


                $tr .= $this->renderPartial($this->path_view . '_rowTabel', array('model' => $modDetail, 'dropAlatMakanan' => $dropAlatMakanan, 'tot_data' => $tot_data), true);
            }

            $data['tr'] = $tr;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * load detail bahan menu diet
     * @param type $pendaftaran_id
     * @param type $pasienadmisi_id
     * @param type $jeniswaktu_id
     */
    public function actionDetailBahanmenudiet($pendaftaran_id, $pasienadmisi_id, $jeniswaktu_id, $menudiet_id, $jenismakanan_id, $kelaspelayanan_id)
    {

        $this->layout = '//layouts/iframe';

        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modBahan = $this->loadDetailBahan($pasienadmisi_id, $jeniswaktu_id, $menudiet_id, $jenismakanan_id, $kelaspelayanan_id);

        $this->render($this->path_view . '_detail', array(
            'modPendaftaran' => $modPendaftaran,
            'modBahan' => $modBahan
        ));
    }

    public function loadDetailBahan($pasienadmisi_id, $jeniswaktu_id, $menudiet_id, $jenismakanan_id, $kelaspelayanan_id)
    {
        $cekPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);

        $date = date('d');

        if (date('d') < 10) {
            $date = '0' . $date;
        }

        $cri = new CDbCriteria();
        $cri->select = " t.* ";
        $cri->addCondition("t.menudiet_id = " . $menudiet_id);
        $modBahan = BahanMenuDietM::model()->findAll($cri);

        return $modBahan;
    }

    /**
     * generate form untuk tambah menu diet
     */
    public function actionGenerateForm()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
            $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;
            $tipediet_id = isset($_POST['tipediet_id']) ? $_POST['tipediet_id'] : null;
            $tipediet_nama = isset($_POST['tipediet_nama']) ? $_POST['tipediet_nama'] : null;
            $rowdata = isset($_POST['rowdata']) ? $_POST['rowdata'] : null;
            $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
            $jenismakanan_id = isset($_POST['jenismakanan_id']) ? $_POST['jenismakanan_id'] : null;
            $menudiet_id = isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null;
            $jenisdiet_id = isset($_POST['jenisdiet_id']) ? $_POST['jenisdiet_id'] : null;
            $alatmakanan_id = isset($_POST['alatmakanan_id']) ? $_POST['alatmakanan_id'] : null;
            $jeniswaktu_id = isset($_POST['jeniswaktu_id']) ? $_POST['jeniswaktu_id'] : null;
            $alergi = isset($_POST['alergi']) ? $_POST['alergi'] : null;
            $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : null;

            $modAdm = GZPasienAdmisiT::model()->findByPk($pasienadmisi_id);

            $tr = '';

            $menu_nama = null;
            if (!empty($menudiet_id)) {
                $menu_nama = GZMenuDietM::model()->findByPk($menudiet_id)->menudiet_nama;
            }


            $cektipediet = TipeDietM::model()->findByPk($tipediet_id);
            if (!empty($cektipediet)) {
                $tipedietnama = $cektipediet->tipediet_nama;
            } else {
                $tipedietnama = '';
            }

            if (empty($jenisdiet_id)) {
                $jenisdiet_id = Params::JENIS_DIET_ID_MAKANAN_PASIEN;
            }


            $menuDiet = JenisdietM::model()->findByPk($jenisdiet_id);                
            
            $arr = array(
                'pendaftaran_id' => $modAdm->pendaftaran_id,
                'pasien_id' => $modAdm->pasien_id,
                'kelaspelayanan_id' => $kelaspelayanan_id,
                'pasienadmisi_id' => $pasienadmisi_id,
                'tipediet_id' => $tipediet_id,
                'tipediet_nama' => $tipedietnama,
                'rowdata' => $rowdata,
                'jenismakanan_id' => $jenismakanan_id,
                'menudiet_id' => $menudiet_id,
                'jenisdiet_id'=> $jenisdiet_id,
                'jenisdiet_nama'=>!empty($menuDiet)?$menuDiet->jenisdiet_nama:null,
                'alatmakanan_id' => $alatmakanan_id,
                'jeniswaktu_id' => $jeniswaktu_id,
                'alergi' => $alergi,
                'keterangan' => $keterangan,
                'jenis' => $jenis
            );

            $dropAlatByKelas = CHtml::listData(AlatmakananM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'alatmakanan_aktif' => true), array('order' => 'alatmakanan_nama ASC')), 'alatmakanan_id', 'alatmakanan_nama'); //,
            $dropJenisWaktuByAlat = CHtml::listData(JenisWaktuM::model()->findAllByAttributes(array('jeniswaktu_aktif' => true), array('order' => 'jeniswaktu_nama ASC')), 'jeniswaktu_id', 'jeniswaktu_nama'); //,'kelaspelayanan_id'=>$kelaspelayanan_id

            if ($jenis == 'tambah') {
                
                $arr = array_replace($arr, [                  
                    'tipediet_id' => null,
                    'tipediet_nama' => null,
                    'jenismakanan_id' => null,
                    'menudiet_id' => null,                    
                    'alatmakanan_id' => null,
                    'jeniswaktu_id' => null,                    
                ]);
                $tr .= $this->renderPartial($this->path_view . '_formTambahMenuDiet', array('arr' => $arr, 'dropAlatByKelas' => $dropAlatByKelas), true);
            } else {
                $tr .= $this->renderPartial($this->path_view . '_formUbahMenuDiet', array('arr' => $arr, 'dropAlatByKelas' => $dropAlatByKelas, 'dropJenisWaktuByAlat' => $dropJenisWaktuByAlat), true);
            }

            $data['sukses'] = 1;
            $data['html'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * load riwayat menu diet pasien
     */
    public function actionLoadRiwayatMenuDiet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pesanmenudiet_id = isset($_POST['pesanmenudiet_id']) ? $_POST['pesanmenudiet_id'] : null;
            $modDetail = new GZPesanmenudetailT();
            $criteria = new CDbCriteria();
            $criteria->select = 't.*';
            $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
            $criteria->addCondition("pesanmenudiet_id = ".$pesanmenudiet_id);
            $criteria->addCondition("pasienpulang_id IS NULL");
            $modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
            $tr = '';
            $pendaftaran_id = '';
            $kelaspelayanan_id = '';
            $pasien_id = '';
            $pasienadmisi_id = '';
            $nama_pasien = '';
            foreach ($modDetailPesan as $k => $det) {
                $jumlah = count($modDetailPesan);
                $cekTabelDetail = 0;
                $modDetail->ruangan_nama = $det->pasienadmisi->ruangan->ruangan_nama;
                $modDetail->no_pendaftaran = $det->pendaftaran->no_pendaftaran;
                $modDetail->no_rekam_medik = $det->pasien->no_rekam_medik;
                $modDetail->nama_pasien = $det->pasien->nama_pasien;
                $modDetail->jeniskelamin = $det->pasien->jeniskelamin;
                $modDetail->umur = $det->pendaftaran->umur;
                $modDetail->kelaspelayanan_id = $det->pendaftaran->kelaspelayanan_id;
                $modDetail->pesanmenudiet_id = $det->pesanmenudiet_id;
                $modDetail->pesanmenudetail_id = $det->pesanmenudetail_id;
                $modDetail->verifikasi_id = $det->verifikasi_id;

                $modDetail->pendaftaran_id = $det->pendaftaran_id;
                $modDetail->pasien_id = $det->pasien_id;
                $modDetail->pasienadmisi_id = (isset($det->pasienadmisi_id) ? $det->pasienadmisi_id : null);

                $pendaftaran_id = $modDetail->pendaftaran_id;
                $kelaspelayanan_id = $modDetail->kelaspelayanan_id;
                $pasien_id = $modDetail->pasien_id;
                $pasienadmisi_id = $modDetail->pasienadmisi_id;
                $nama_pasien = $modDetail->nama_pasien;

                $modDetail->jenisdiet_id = (isset($det->jenisdiet_id) ? $det->jenisdiet_id : null);
                $modDetail->jenisdiet_nama = (isset($det->menudiet) ? $det->menudiet->jenisdiet->jenisdiet_nama : null);

                $modDetail->jenismakanan_id = (isset($det->jenismakanan_id) ? $det->jenismakanan_id : null);
                $modDetail->jenismakanan_nama = (isset($det->jenismakanan_id) ? $det->jenismakanan->jenismakanan_nama : null);

                $modDetail->jeniswaktu_id = (isset($det->jeniswaktu_id) ? $det->jeniswaktu_id : null);
                $modDetail->jeniswaktu_nama = (isset($det->jeniswaktu_id) ? $det->jeniswaktu->jeniswaktu_nama : null);

                $modDetail->alatmakanan_id = (isset($det->alatmakanan_id) ? $det->alatmakanan_id : null);
                $modDetail->alatmakanan_nama = (isset($det->alatmakanan_id) ? $det->alatmakanan->alatmakanan_nama : null);

                $modDetail->jml_pesan_porsi = $det->jml_pesan_porsi;
                $modDetail->satuanjml_urt = $det->satuanjml_urt;

                $modDetail->checkList = true;
                $modDetail->ceklis_baris = true;

                $modDetail->menudiet_nama = (isset($det->menudiet_id) ? $det->menudiet->menudiet_nama : null);
                $modDetail->menudiet_id = (isset($det->menudiet_id) ? $det->menudiet_id : null);

                $modDetail->tipediet_nama = (isset($det->tipediet_id) ? $det->tipediet->tipediet_nama : null);
                $modDetail->tipediet_id = (isset($det->tipediet_id) ? $det->tipediet_id : null);


                $dropAlatMakanan = CHtml::listData(AlatmakananM::model()->findAllByAttributes(array('kelaspelayanan_id' => $det->kelaspelayanan_id, 'alatmakanan_aktif' => true), array('order' => 'alatmakanan_nama ASC')), 'alatmakanan_id', 'alatmakanan_nama');

                $tr .= $this->renderPartial($this->path_view . '_rowDetailPesanMenu', array(
                    'cekTabelDetail' => $cekTabelDetail,
                    'model' => $modDetail,
                    'dropAlatMakanan' => $dropAlatMakanan,
                    'countJnsWaktu' => $jumlah,
                    'i' => $k
                ), true);
            }
            $data['sukses'] = 1;
            $data['html'] = $tr;
            $data['biodata']['nama_pasien'] = $nama_pasien;
            $data['biodata']['kelaspelayanan_id'] = $kelaspelayanan_id;
            $data['biodata']['pendaftaran_id'] = $pendaftaran_id;
            $data['biodata']['pasien_id'] = $pasien_id;
            $data['biodata']['pasienadmisi_id'] = $pasienadmisi_id;

            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    /**
     * load riwayat menu diet pasien
     */
    public function actionPesanKembali($id, $admisiId)
    {
        if (Yii::app()->request->isAjaxRequest) {                        

            $pesan = PesanmenudetailT::model()->find(" pasien_id = ".$id." ORDER BY pesanmenudiet_id DESC ");
            
            $cri = new CDbCriteria();
            $cri->select = "t.*, r.ruangan_nama, p.no_pendaftaran, pas.no_rekam_medik, pas.nama_pasien, pas.jeniskelamin,"
                . " p.umur, jns.jenisdiet_nama, jns_mkn.jenismakanan_nama, waktu.jeniswaktu_nama, "
                . " tipediet.tipediet_nama, "
                . " alat.alatmakanan_nama, menu.menudiet_nama, adm.kelaspelayanan_id";
            $cri->join = " LEFT JOIN pasienadmisi_t adm ON adm.pasienadmisi_id = t.pasienadmisi_id "
                . " LEFT JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id "
                . " LEFT JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
                . " LEFT JOIN pasien_m pas ON pas.pasien_id = t.pasien_id "
                . " LEFT JOIN jenisdiet_m jns ON jns.jenisdiet_id = t.jenisdiet_id "
                . " LEFT JOIN jenismakanan_m jns_mkn ON jns_mkn.jenismakanan_id = t.jenismakanan_id "
                . " LEFT JOIN jeniswaktu_m waktu ON waktu.jeniswaktu_id = t.jeniswaktu_id "
                . " LEFT JOIN alatmakanan_m alat ON alat.alatmakanan_id = t.alatmakanan_id "
                . " LEFT JOIN menudiet_m menu ON menu.menudiet_id = t.menudiet_id "
                . " LEFT JOIN tipediet_m tipediet ON tipediet.tipediet_id = t.tipediet_id ";
            if (!empty($pesan)) {
                $cri->join .= " JOIN pesanmenudiet_t psn ON psn.pesanmenudiet_id = t.pesanmenudiet_id 
                                LEFT JOIN pesanmenudetail_t detpesan ON t.pesanmenudiet_id  = detpesan.pesanmenudiet_id AND 
                                    t.pendaftaran_id  = detpesan.pendaftaran_id AND 
                                    t.pasien_id  = detpesan.pasien_id AND 
                                    t.jenismakanan_id  = detpesan.jenismakanan_id AND 
                                    t.jenisdiet_id  = detpesan.jenisdiet_id AND 
                                    t.pasienadmisi_id  = detpesan.pasienadmisi_id AND 
                                    t.alatmakanan_id  = detpesan.alatmakanan_id AND 
                                    t.menudiet_id  = detpesan.menudiet_id AND 
                                    t.jeniswaktu_id   = detpesan.jeniswaktu_id
                                     ";
                $cri->select .= ', detpesan.pesanmenudetail_id ';
                $cri->addCondition(" psn.pesanmenudiet_id = " . $pesan->pesanmenudiet_id . " ");
            }else{
                $cri->addCondition(" t.pesanmenudiet_riwayat_id IS NULL ");
            }
            $cri->order = " pas.nama_pasien ASC, waktu.jeniswaktu_nama ASC ";
            $getRiwayat = PesanmenudietR::model()->findAll($cri);

            $arr = array();

            $tr = '';

            $admisi = InfokunjunganriV::model()->findByAttributes([
                'pasienadmisi_id'=>$admisiId
            ]);
            foreach ($getRiwayat as $d) {  
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['kelaspelayanan_id'] = $admisi->kelaspelayanan_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pasien_id'] = $admisi->pasien_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pendaftaran_id'] = $admisi->pendaftaran_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pasienadmisi_id'] = $admisi->pasienadmisi_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['ruangan_nama'] = $admisi->ruangan_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['no_pendaftaran'] = $admisi->no_pendaftaran;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['no_rekam_medik'] = $admisi->no_rekam_medik;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['nama_pasien'] = $admisi->nama_pasien;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jeniskelamin'] = $admisi->jeniskelamin;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['umur'] = $admisi->umur;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenisdiet_id'] = $d->jenisdiet_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenisdiet_nama'] = $d->jenisdiet_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenismakanan_id'] = $d->jenismakanan_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenismakanan_nama'] = $d->jenismakanan_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jeniswaktu_id'] = $d->jeniswaktu_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jeniswaktu_nama'] = $d->jeniswaktu_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['alatmakanan_id'] = $d->alatmakanan_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['alatmakanan_nama'] = $d->alatmakanan_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jml_pesan_porsi'] = $d->jml_pesan_porsi;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['satuanjml_urt'] = $d->satuanjml_urt;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['checkList'] = true;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['menudiet_id'] = $d->menudiet_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['menudiet_nama'] = $d->menudiet_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pesanmenudiet_riwayat_id'] = null;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pesanmenudiet_id'] = null;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pesanmenudetail_id'] = $d->pesanmenudetail_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['tipediet_id'] = $d->tipediet_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['tipediet_nama'] = $d->tipediet_nama;

            }
            
            foreach ($arr as $load) {
                $cekTabelDetail = 0;
                $i = 0;
                foreach ($load['det'] as $det) {
                    $modDetail = new GZPesanmenudetailT();
                    if (!empty($det['pesanmenudetail_id'])) {
                        $modDetail = GZPesanmenudetailT::model()->findByPk($det['pesanmenudetail_id']);
                    }
                    $modDetail->attributes = $det;
                    $modDetail->pesanmenudiet_riwayat_id = $det['pesanmenudiet_riwayat_id'];
                    $modDetail->ruangan_nama = $det['ruangan_nama'];
                    $modDetail->no_pendaftaran = $det['no_pendaftaran'];
                    $modDetail->no_rekam_medik = $det['no_rekam_medik'];
                    $modDetail->nama_pasien = $det['nama_pasien'];
                    $modDetail->jeniskelamin = $det['jeniskelamin'];
                    $modDetail->umur = $det['umur'];
                    $modDetail->kelaspelayanan_id = $det['kelaspelayanan_id'];
                    $modDetail->pesanmenudetail_id = null;
                    
                    $modDetail->pendaftaran_id = $det['pendaftaran_id'];
                    $modDetail->pasien_id = $det['pasien_id'];
                    $modDetail->pasienadmisi_id = (isset($det['pasienadmisi_id']) ? $det['pasienadmisi_id'] : null);

                    $modDetail->jenisdiet_id = $det['jenisdiet_id'];
                    $modDetail->jenisdiet_nama = $det['jenisdiet_nama'];

                    $modDetail->jenismakanan_id = $det['jenismakanan_id'];
                    $modDetail->jenismakanan_nama = $det['jenismakanan_nama'];

                    $modDetail->jeniswaktu_id = $det['jeniswaktu_id'];
                    $modDetail->jeniswaktu_nama = $det['jeniswaktu_nama'];

                    $modDetail->alatmakanan_id = $det['alatmakanan_id'];
                    $modDetail->alatmakanan_nama = $det['alatmakanan_nama'];

                    $modDetail->jml_pesan_porsi = $det['jml_pesan_porsi'];
                    $modDetail->satuanjml_urt = $det['satuanjml_urt'];

                    $modDetail->checkList = true;
                    $modDetail->ceklis_baris = true;

                    $modDetail->menudiet_nama = $det['menudiet_nama'];
                    $modDetail->menudiet_id = $det['menudiet_id'];

                    $modDetail->tipediet_nama = $det['tipediet_nama'];
                    $modDetail->tipediet_id = $det['tipediet_id'];

                    $dropAlatMakanan = CHtml::listData(AlatmakananM::model()->findAllByAttributes(array('kelaspelayanan_id' => $det['kelaspelayanan_id'], 'alatmakanan_aktif' => true), array('order' => 'alatmakanan_nama ASC')), 'alatmakanan_id', 'alatmakanan_nama');

                    $tr .= $this->renderPartial($this->path_view . '_rowDetailPesanMenu', array(
                        'cekTabelDetail' => $cekTabelDetail,
                        'model' => $modDetail,
                        'dropAlatMakanan' => $dropAlatMakanan,
                        'countJnsWaktu' => count($load['det']),
                        'i' => $i
                    ), true);
                    $i++;
                }
            }

            $data['sukses'] = 1;
            $data['html'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    /**
     * load riwayat menu diet pasien
     */
    public function actionLoadDetailMenuDiet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $pesanmenudiet_id = isset($_POST['pesanmenudiet_id']) ? $_POST['pesanmenudiet_id'] : null;

            $cri = new CDbCriteria();
            $cri->select = "t.*, r.ruangan_id,  r.ruangan_nama, p.no_pendaftaran, pas.no_rekam_medik, pas.nama_pasien, pas.jeniskelamin,"
                . " p.umur, jns.jenisdiet_nama, jns_mkn.jenismakanan_nama, waktu.jeniswaktu_nama, "
                . " alat.alatmakanan_nama, menu.menudiet_nama, adm.kelaspelayanan_id, jenismenu.jenismenudiet_nama, jenismenu.jenismenudiet_id ";
            $cri->join = " JOIN pesanmenudiet_t psn ON psn.pesanmenudiet_id = t.pesanmenudiet_id "
                . " JOIN pasienadmisi_t adm ON adm.pasienadmisi_id = t.pasienadmisi_id "
                . " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id "
                . " JOIN ruangan_m r ON r.ruangan_id = psn.ruangan_id "
                . " JOIN pasien_m pas ON pas.pasien_id = t.pasien_id "
                . " JOIN jenisdiet_m jns ON jns.jenisdiet_id = t.jenisdiet_id "
                . " JOIN jenismakanan_m jns_mkn ON jns_mkn.jenismakanan_id = t.jenismakanan_id "
                . " JOIN jeniswaktu_m waktu ON waktu.jeniswaktu_id = t.jeniswaktu_id "
                . " JOIN alatmakanan_m alat ON alat.alatmakanan_id = t.alatmakanan_id "
                . " JOIN menudiet_m menu ON menu.menudiet_id = t.menudiet_id "
                . " JOIN jenismenudiet_m jenismenu ON jenismenu.jenismenudiet_id = menu.jenismenudiet_id "
                . " ";
            $cri->order = " pas.nama_pasien ASC, waktu.jeniswaktu_nama ASC ";
            $cri->addCondition(" psn.pesanmenudiet_id = " . $pesanmenudiet_id . " ");
            $getRiwayat = GZPesanmenudetailT::model()->findAll($cri);

            $arr = array();

            $tr = '';


            foreach ($getRiwayat as $d) {
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pesanmenudiet_riwayat_id'] = $d->pesanmenudiet_riwayat_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['kelaspelayanan_id'] = $d->kelaspelayanan_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pasien_id'] = $d->pasien_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pendaftaran_id'] = $d->pendaftaran_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pasienadmisi_id'] = $d->pasienadmisi_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['ruangan_nama'] = $d->ruangan_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['no_pendaftaran'] = $d->no_pendaftaran;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['no_rekam_medik'] = $d->no_rekam_medik;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['nama_pasien'] = $d->nama_pasien;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jeniskelamin'] = $d->jeniskelamin;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['umur'] = $d->umur;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenisdiet_id'] = $d->jenisdiet_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenisdiet_nama'] = $d->jenisdiet_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenismakanan_id'] = $d->jenismakanan_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenismakanan_nama'] = $d->jenismakanan_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jeniswaktu_id'] = $d->jeniswaktu_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jeniswaktu_nama'] = $d->jeniswaktu_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['alatmakanan_id'] = $d->alatmakanan_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['alatmakanan_nama'] = $d->alatmakanan_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jml_pesan_porsi'] = $d->jml_pesan_porsi;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['satuanjml_urt'] = $d->satuanjml_urt;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['checkList'] = true;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['menudiet_id'] = $d->menudiet_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['menudiet_nama'] = $d->menudiet_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pesanmenudiet_id'] = $d->pesanmenudiet_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenismenudiet_id'] = $d->jenismenudiet_id;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['jenismenudiet_nama'] = $d->jenismenudiet_nama;
                $arr[$d->pasienadmisi_id]['det'][$d->jeniswaktu_id]['pesanmenudetail_id'] = $d->pesanmenudetail_id;
            }

            foreach ($arr as $load) {
                $cekTabelDetail = 0;
                $i = 0;
                foreach ($load['det'] as $det) {
                    $modDetail = GZPesanmenudetailT::model()->findByPk($det['pesanmenudetail_id']);
                    $modDetail->attributes = $det;
                    $modDetail->pesanmenudiet_riwayat_id = $det['pesanmenudiet_riwayat_id'];
                    $modDetail->ruangan_nama = $det['ruangan_nama'];
                    $modDetail->no_pendaftaran = $det['no_pendaftaran'];
                    $modDetail->no_rekam_medik = $det['no_rekam_medik'];
                    $modDetail->nama_pasien = $det['nama_pasien'];
                    $modDetail->jeniskelamin = $det['jeniskelamin'];
                    $modDetail->umur = $det['umur'];
                    $modDetail->kelaspelayanan_id = $det['kelaspelayanan_id'];

                    $modDetail->pendaftaran_id = $det['pendaftaran_id'];
                    $modDetail->pasien_id = $det['pasien_id'];
                    $modDetail->pasienadmisi_id = isset($det['pasienadmisi_id']) ? $det['pasienadmisi_id'] : null;

                    $modDetail->jenisdiet_id = $det['jenisdiet_id'];
                    $modDetail->jenisdiet_nama = $det['jenisdiet_nama'];

                    $modDetail->jenismakanan_id = $det['jenismakanan_id'];
                    $modDetail->jenismakanan_nama = $det['jenismakanan_nama'];

                    $modDetail->jeniswaktu_id = $det['jeniswaktu_id'];
                    $modDetail->jeniswaktu_nama = $det['jeniswaktu_nama'];

                    $modDetail->alatmakanan_id = $det['alatmakanan_id'];
                    $modDetail->alatmakanan_nama = $det['alatmakanan_nama'];

                    $modDetail->jml_pesan_porsi = $det['jml_pesan_porsi'];
                    $modDetail->satuanjml_urt = $det['satuanjml_urt'];

                    $modDetail->checkList = true;
                    $modDetail->ceklis_baris = true;

                    $modDetail->menudiet_nama = $det['menudiet_nama'];
                    $modDetail->menudiet_id = $det['menudiet_id'];

                    $modDetail->jenismenudiet_id = $det['jenismenudiet_id'];
                    $modDetail->jenismenudiet_nama = $det['jenismenudiet_nama'];


                    $dropAlatMakanan = CHtml::listData(AlatmakananM::model()->findAllByAttributes(array('kelaspelayanan_id' => $det['kelaspelayanan_id'], 'alatmakanan_aktif' => true), array('order' => 'alatmakanan_nama ASC')), 'alatmakanan_id', 'alatmakanan_nama');

                    $tr .= $this->renderPartial($this->path_view . '_rowDetailPesanMenu', array(
                        'cekTabelDetail' => $cekTabelDetail,
                        'model' => $modDetail,
                        'dropAlatMakanan' => $dropAlatMakanan,
                        'countJnsWaktu' => count($load['det']),
                        'i' => $i
                    ), true);
                    $i++;
                }
            }

            $data['sukses'] = 1;
            $data['html'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionUbahDetailPerMenu()
    {
        if (Yii::app()->request->isAjaxRequest) {

            parse_str($_POST['formdata'], $arr);

            $dt = $arr['dlg'];
            $menu = GZMenuDietM::model()->findByPk($dt['menudiet_id']);
            $waktu = (!empty($dt['jeniswaktu_id'])) ? GZJenisWaktuM::model()->findBYPk($dt['jeniswaktu_id']) : null;
            $alat = GZAlatmakananM::model()->findByPk($dt['alatmakanan_id']);
            $modJenisMakan = JenismakananM::model()->findByPk($dt['jenismakanan_id']);
            $modJenisDiet = JenisdietM::model()->findByPk($dt['jenisdiet_id']);
            $modTipeDiet = TipeDietM::model()->findByPk($dt['tipediet_id']);

            $data['menudiet_id'] = $dt['menudiet_id'];
            $data['jenismenudiet_nama'] = !empty($menu->jenismenudiet->jenismenudiet_nama) ? $menu->jenismenudiet->jenismenudiet_nama : null;
            $data['jenismakanan_id'] = $dt['jenismakanan_id'];
            $data['jenismakanan_nama'] = !empty($modJenisMakan)?$modJenisMakan->jenismakanan_nama:null;
            $data['alatmakanan_id'] = $dt['alatmakanan_id'];
            $data['alatmakanan_nama'] = !empty($alat->alatmakanan_nama) ? $alat->alatmakanan_nama : null;
            $data['jenisdiet_id'] = $dt['jenisdiet_id'];
            $data['jenisdiet_nama'] = $menu->menudiet_nama;
            $data['jeniswaktu_id'] = (!empty($dt['jeniswaktu_id'])) ? $dt['jeniswaktu_id'] : null;
            $data['jeniswaktu_nama'] = (!empty($waktu->jeniswaktu_nama)) ? $waktu->jeniswaktu_nama : null;
            $data['adaalergimakanan'] = $dt['adaalergimakanan'];
            $data['keterangan'] = $dt['keterangan'];
            $data['tipediet_id'] = $dt['tipediet_id'];
            $data['tipediet_nama'] = (!empty($modTipeDiet->tipediet_nama)) ? $modTipeDiet->tipediet_nama : null;

            $pendaftaran_id = $dt['pendaftaran_id'];
            $pasienadmisi_id = $dt['pasienadmisi_id'];
            $jeniswaktu_id = (!empty($dt['jeniswaktu_id'])) ? $dt['jeniswaktu_id'] : null;
            $menudiet_id = $dt['menudiet_id'];
            $jenismakanan_id = $dt['jenismakanan_id'];
            $tipediet_id = $dt['tipediet_id'];



            //data detail

            $cri = new CDbCriteria();
            $cri->select = " t.* ";
            //  Menu Graha Amerta
            $cri->join = " JOIN menudiet_m md ON md.menudiet_id = t.menudiet_id ";
            if (!empty($menudiet_id)) {
                $cri->addCondition("t.menudiet_id = " . $menudiet_id);
            }
            $modBahan = BahanMenuDietM::model()->findAll($cri);


            $ada = false;
            $modBahan = BahanMenuDietM::model()->findAll($cri);
            $menumakanan_id = array();
            foreach ($modBahan as $bhn) {
                $menumakanan_id[] = $bhn['menumakanan_id'];
            }


            $data['detail'] = '';

            if ($ada) {
            }
            $data['detail'] .= $this->renderPartial($this->path_view . 'linkdetail', array(
                "pendaftaran_id" => $pendaftaran_id,
                "pasienadmisi_id" => $pasienadmisi_id,
                "jeniswaktu_id" => $jeniswaktu_id,
                "menudiet_id" => $menudiet_id,
                "jenismakanan_id" => $jenismakanan_id,
                "tipediet_id" => $tipediet_id
            ), true);

            $data['sukses'] = 1;
            echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionGetMenuDiet()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $jenisdiet_id = $_POST['jenisdiet_id'];

            $drop = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            if (!empty($jenisdiet_id)) {
                $menudiet = MenuDietM::model()->findAllByAttributes(array('jenisdiet_id' => $jenisdiet_id));
                if (!empty($menudiet)) {
                    foreach ($menudiet as $det) {
                        $drop .= CHtml::tag('option', array('value' => $det->menudiet_id), CHtml::encode($det->menudiet_nama), true);
                    }
                }
            }

            $data['sukses'] = 1;
            $data['drop'] = $drop;

            echo json_encode($data);
        }
        Yii::app()->end();
    }

    public function notifPemesananMenuDiet($model, $modDetail, $id = null) {
        $pasien = PasienM::model()->findByPk($modDetail->pasien_id);
        $judul = "Pemesanan Menu Diet Pasien";
        $isi = "Telah dilakukan pemesanan menu diet" . "<br/>";
        $pesanan = 'Pemesanan';
        
        if(!empty($id)){
            $judul = $pasien->no_rekam_medik . ' - ' . $pasien->nama_pasien ." - Ubah Pesan Menu Diet";
            $isi = "Telah dilakukan ubah pemesanan menu diet" . "<br/>";
            $pesanan = 'Update';
        }

        $isi .= "Nama Pasien : " . $pasien->nama_pasien . ' / ' . $pasien->no_rekam_medik .  "<br/>";
        $isi .= "Tgl. ".$pesanan." : " . MyFormatter::formatDateTimeForUser($model->tglpesanmenu). "<br/>";
        $isi .= "Ruangan : " . Yii::app()->user->getState("instalasi_nama") . ' / ' . Yii::app()->user->getState("ruangan_nama");
        $link = $this->createUrl('/gizi/PesanmenudietT/InformasiPasien', array(
            'GZPesanmenudietT[tgl_awal]' => date('Y-m-d', strtotime($model->tglpesanmenu)),
            'GZPesanmenudietT[tgl_akhir]' => date('Y-m-d', strtotime($model->tglpesanmenu))
        ));
        $ruangan_gizi = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
        CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruangan_gizi->instalasi_id, 'ruangan_id' => $ruangan_gizi->ruangan_id, 'modul_id' => $ruangan_gizi->modul_id, 'link_proses' => $link),
        ));
    }

    public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->addCondition('instalasi_id = ' . Yii::app()->user->getState('instalasi_id'));
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = InfokunjunganrdV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . "-" . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->pendaftaran_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  function actionUbahMenuDiet() {

    $pesanmenudiet_id = $_POST['pesanmenudiet_id'];
    $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $pasienadmisi_id = $_POST['pasienadmisi_id'];
    $pasien_id = $_POST['pasien_id'];

    $criteria = new CDbCriteria();
    $criteria->select = 't.*';
    $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
    $criteria->addCondition("pesanmenudiet_id = ".$pesanmenudiet_id);
    $criteria->addCondition("pasienpulang_id IS NULL");
    $modDetailPesan = PesanmenudetailT::model()->findAll($criteria);



    $arr = array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasien_id' => $pasien_id,
        'kelaspelayanan_id' => $kelaspelayanan_id,
        'pasienadmisi_id' => $pasienadmisi_id
    );

    $jeniswaktu = [];
    $arr_pesanmenudetail_id = [];
    if(!empty($modDetailPesan)) {
        foreach ($modDetailPesan as $i => $val) {
            $jeniswaktu[] = $val->jeniswaktu_id;
            $arr_pesanmenudetail_id[] = $val->pesanmenudetail_id;
        }
    }

    $data['html'] = $this->renderPartial($this->path_view . '_ubahMenuDiet', [
        'arr' => $arr,
        'jeniswaktu' => $jeniswaktu,
        'arr_pesanmenudetail_id' => implode(',', $arr_pesanmenudetail_id)
    ], true);

    echo json_encode($data);
  }

  function actionSimpanPerubahanMenu() {
    $pesanmenudetail_id = $_POST['pesanmenudetail_id'];
    $jenisdiet_id = isset($_POST['jenisdiet_id']) ? $_POST['jenisdiet_id'] : null;
    $pesanmenudiet_id = null;
    $menudiet_id = $_POST['menudiet_id'];
    $jeniswaktu_id = $_POST['jeniswaktu_id'];
    $pesanmenudetail_id = explode(',', $pesanmenudetail_id);
    $kelaspelayanan_id = null;

    $save = false;
    if(count($pesanmenudetail_id) > 0) {

        $trans = Yii::app()->db->beginTransaction();

        // var_dump($pesanmenudetail_id, $jeniswaktu_id); die;

        $arr_jenis = array();
        foreach ($jeniswaktu_id as $item) {
            $arr_jenis[$item] = null;
        }

        $model = null;

        foreach ($pesanmenudetail_id as $i => $pk) {
            $modDetail = PesanmenudetailT::model()->findByPk($pk);
            $model = PesanmenudietT::model()->findByPk($modDetail->pesanmenudiet_id);

            $kelaspelayanan_id = $modDetail->kelaspelayanan_id;

            if(!empty($modDetail->pesanmenudiet_id)) {
                $pesanmenudiet_id = $modDetail->pesanmenudiet_id;
            }
            if(in_array($modDetail->jeniswaktu_id, $jeniswaktu_id)) {
                $modDetail->jeniswaktu_id = $jeniswaktu_id[$i];
                $modDetail->menudiet_id = $menudiet_id[$i];
                $modDetail->jenisdiet_id = $jenisdiet_id;
                
                if($modDetail->update()) {
                    $save = true;

                    $modRiwayat = new PesanmenudietR;
                    $modRiwayat->attributes = $model->attributes;
                    $modRiwayat->attributes = $modDetail->attributes;
                    $modRiwayat->jenismakanan_id = $modDetail->jenismakanan_id;
                    $modRiwayat->alatmakanan_id = $modDetail->alatmakanan_id;
                    $modRiwayat->ruangan_id = $model->ruangan_id;
                    $modRiwayat->tipediet_id = $modDetail->tipediet_id;
                    $modRiwayat->jenisdiet_id = $jenisdiet_id;


                    $save = $save && $modRiwayat->save();

                    $arr_jenis[$modDetail->jeniswaktu_id] = $modDetail->pesanmenudetail_id;

                    // var_dump($modDetail->attributes); die;


                } else {
                    $save = false;
                }



            } else {
                if (empty($modDetail->verifikasi_id)) {
                    if($modDetail->delete()){
                        $save = true;
                    } else {
                        $save = false;
                    }
                }
            }
        }

        if (!empty($model)) {
            $cnt = 0;
            foreach ($arr_jenis as $waktu_id => $detail_id) {
                if (!empty($arr_jenis[$waktu_id])) {

                    $cnt++;
                    continue;
                }

                $modDetail = new PesanmenudetailT();
                $modDetail->attributes = $model->attributes;
                $modDetail->pasien_id = $modDetail->pendaftaran->pasien_id;
                $modDetail->pasienadmisi_id = $modDetail->pendaftaran->pasienadmisi_id;
                $modDetail->jeniswaktu_id = $waktu_id;
                $modDetail->menudiet_id = $menudiet_id[$cnt];
                $modDetail->jenisdiet_id = $jenisdiet_id;
                $modDetail->jml_pesan_porsi = 1;
                $modDetail->satuanjml_urt = '';
                $modDetail->status_menu = '';
                $modDetail->kelaspelayanan_id = $kelaspelayanan_id ?? Params::KELASPELAYANAN_ID_TANPA_KELAS;

                $save = $save && $modDetail->save();

                // simpan riwayat
                $modRiwayat = new PesanmenudietR;
                $modRiwayat->attributes = $model->attributes;
                $modRiwayat->attributes = $modDetail->attributes;
                $modRiwayat->jenismakanan_id = $modDetail->jenismakanan_id;
                $modRiwayat->alatmakanan_id = $modDetail->alatmakanan_id;
                $modRiwayat->ruangan_id = $model->ruangan_id;
                $modRiwayat->tipediet_id = $modDetail->tipediet_id;
                $modRiwayat->jenisdiet_id = $jenisdiet_id;

                $modRiwayat->save();

                $save = $save && $modRiwayat->save();


                // var_dump($save, $modDetail->errors);

                $cnt++;
            }
        }

        // var_dump($jeniswaktu_id, $arr_jenis); die;


    }

    // var_dump($_POST);
    // die;

    
    if($save) {
        if(!empty($pesanmenudiet_id) && $jenisdiet_id) {
            PesanmenudietT::model()->updateByPk($pesanmenudiet_id, ['jenisdiet_id' => $jenisdiet_id]);
        }

        $trans->commit();

        $data['sukses'] = 1;
    } else {
        $data['sukses'] = 0;
    }

    echo json_encode($data);
  }

  function actionCekPemesanan() {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    
    
    $pesan = PesanmenudetailT::model()->countByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id
    ));
    
    if($pesan > 0) {
        $data['sudahpesan'] = 1;
    } else {
        $data['sudahpesan'] = 0;
    }

    echo json_encode($data);
  }
}
