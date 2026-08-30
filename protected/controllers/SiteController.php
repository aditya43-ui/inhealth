<?php
class SiteController extends Controller
{
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('login'));
        }
        $this->layout = '//layouts/column1';
        $kelompokModuls = KelompokmodulK::model()->findAll('kelompokmodul_aktif = true');
        $moduls = ModulK::model()->findAllByAttributes(array('modul_aktif' => true), array('order' => 'modul_urutan ASC, modul_nama')); //modul_kategori , t.kelompokmodul_id, 
        $kategoriModuls = LookupM::getItems('kategorimodul');
        $this->render('index', array(
            'kelompokModuls' => $kelompokModuls,
            'moduls' => $moduls,
            'kategoriModuls' => $kategoriModuls,
        ));
    }
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        $this->layout = "//layouts/iframe";
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $headers = "From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }
    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = '//layouts/loginNeon';
        $model = new LoginForm;
        if (Yii::app()->request->isAjaxRequest) {
            $model = new LoginForm;
            $model->attributes = $_POST['LoginForm'];
            $resp = array();
            //	$resp['submitted_data'] = $_POST;
            $login_status = 'invalid';
            $login_pesan = 'Maaf, <b>username</b> atau <b>password</b> tidak ditemukan, silakan coba kembali.';
            if ($model->validate() && $model->login()) {
                Yii::app()->session['timeout'] = time();
                Yii::app()->session['inactive'] = Params::DEFAULT_SESSION_INACTIVE * 60;
                $login_status = 'success';
                if (isset($model->modul) && $model->modul != "") {
                    // Yii::app()->session['modulId'] = $_POST['LoginForm']['modul'];
                    $modModulK = ModulK::model()->findByPk($model->modul, 'modul_aktif = TRUE');
                    $url = Yii::app()->createUrl($modModulK->url_modul, array('modul_id' => $model->modul));
                } else {
                    $url = Yii::app()->user->returnUrl;
                }
                $login_pesan = 'Sukses';
                $resp['redirect_uri'] = $url;
            } else {
                $login_status = 'invalid';
                //$login_pesan = $model->getCodeError();
            }
            $resp['login_status'] = $login_status;
            $resp['login_pesan'] = $login_pesan;
            // Login Success URL
            if ($login_status == 'success') {
                LoginpemakaiK::model()->updateByPk(Yii::app()->user->getState('loginpemakai_id'), array('lastlogin' => date('Y-m-d H:i:s'), 'statuslogin' => true));
            } else {
            }
            echo CJSON::encode($resp);
            Yii::app()->end();
        }
        // display the login form
        $this->render('loginNeonBaru', array('model' => $model));
    }
    /**
     * ===========================================================
     * Lupa password
     * ===========================================================
     */ /*
        public function actionLupaPassword()
        {
            $this->layout = '//layouts/login';
            $model = new LupaPasswordForm;
            if (isset($_POST['LupaPasswordForm'])) {
                $model->attributes = $_POST['LupaPasswordForm'];
                if ($model->validate()) {
                    $this->setPassword($model);
                    Yii::app()->user->setFlash('success', 'Segera <strong>login</strong> jika pesan sudah diterima di HP Anda.');
                    $this->redirect(array('site/login'));
                }
            }
            //die;
            $this->render('lupaPassword',array('model'=>$model));
        } */
    public function setPassword($model)
    {
        $char = str_split("abcdefghijklmnopqrstuvwxyz1234567890");
        $str = "";
        for ($i = 0; $i < 8; $i++) {
            $str .= $char[rand(0, count((array)$char) - 1)];
        }
        $this->kirimSMS($model, $str);
        LoginpemakaiK::model()->updateByPk($model->loginpemakai_id, array(
            'katakunci_pemakai' => LoginpemakaiK::model()->encrypt($str),
            'loginpemakai_update' => null,
        ));
        // var_dump($str, md5($str), $model->attributes); die;
    }
    public function kirimSMS($model, $str)
    {
        $lp = LoginpemakaiK::model()->findByPk($model->loginpemakai_id);
        $no_hp = $model->no_hp;
        $dat = "Password untuk user '" . $lp->nama_pemakai . "' adalah '$str'. "
            . "Segera login untuk mengubah password.";
        $model = new Outbox;
        $model->CreatorID = Yii::app()->user->name;
        $model->UDH = "";
        $model->DestinationNumber = $no_hp;
        $model->TextDecoded = $dat;
        $model->save();
    }
    /**
     * ===========================================================
     * End Lupa password
     * ===========================================================
     */
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        LoginpemakaiK::model()->updateByPk(Yii::app()->user->id, array('lastlogin' => date('Y-m-d H:i:s'), 'statuslogin' => FALSE));
        Yii::app()->user->logout();
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->homeUrl);
    }
    /**
     * ajax untuk mengambil loginpemakai_id berdasarkan username
     * digunakan di site/login handling after blur input username
     */
    public function actionAjaxCekUsername()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $username = (isset($_POST['username'])) ? $_POST['username'] : null;
            $is_exist = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username));
            if ($is_exist) {
                $data['id'] = $is_exist->loginpemakai_id;
                $ruangan = RuanganpemakaiK::model()->findAllByAttributes(array('loginpemakai_id' => $data['id']));
            } else {
                $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan', 'ruangan_id', array('empty' => '-- Pilih --'));
                $data['modul'] = CHtml::dropdownlist('LoginForm_modul', 'modul_id', array('empty' => '-- Pilih --'));
                $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi', 'instalasi_id', array('empty' => '-- Pilih --'));
                echo json_encode($data);
                exit;
            }
            $arrInstalasi = array();
            $valInstalasi = array();
            $x = 0;
            if (count((array)$ruangan) > 0) {
                foreach ($ruangan as $i => $ruanganNya) {
                    $ruang = RuanganM::model()->findByPk($ruanganNya->ruangan_id, 'ruangan_aktif =TRUE');
                    if (!empty($ruang)) {
                        if (isset($ruang->instalasi_id)) {
                            $arrInstalasi[$ruang->instalasi_id] = $ruang->instalasi->instalasi_nama;
                            $valInstalasi[$x] = $ruang->instalasi_id;
                        }
                    }
                    $x++;
                }
            }
            if (count((array)$arrInstalasi) > 0) {
                asort($arrInstalasi);
                if (count((array)$arrInstalasi) == 1) {
                    $data['instalasi'] = CHtml::dropdownlist(
                        'LoginForm_instalasi',
                        'instalasi_id',
                        $arrInstalasi,
                        array(
                            'ajax' => array(
                                'type' => 'POST',
                                'url' =>  CController::createUrl('site/dynamicRuangan'),
                                'update' => '#LoginForm_ruangan',
                            )
                        )
                    );
                } else {
                    $data['instalasi'] = CHtml::dropdownlist(
                        'LoginForm_instalasi',
                        'instalasi_id',
                        $arrInstalasi,
                        array(
                            'empty' => '-- Pilih --',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' =>  CController::createUrl('site/dynamicRuangan'),
                                'update' => '#LoginForm_ruangan',
                            )
                        )
                    );
                }
            }
            $arrRuangan = array();
            $dataRuangan = $ruangan;
            if (count((array)$dataRuangan) > 0) {
                foreach ($dataRuangan as $i => $ruanganNya) {
                    $arrRuangan[$ruanganNya->ruangan_id] = $ruanganNya->ruangan->ruangan_nama;
                }
            }
            if (count((array)$arrRuangan) > 0) {
                asort($arrRuangan);
                if (count((array)$arrRuangan) == 1) {
                    $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan', 'ruangan_id', $arrRuangan);
                } else {
                    $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan', 'ruangan_id', $arrRuangan, array('empty' => '-- Pilih --'));
                }
            }
            if (!empty($data['id'])) {
                $criModul = new CDbCriteria();
                $criModul->join = " JOIN modul_k m ON m.modul_id = t.modul_id ";
                $criModul->addCondition(" m.modul_aktif = TRUE ");
                $criModul->addCondition(" t.loginpemakai_id = '" . $data['id'] . "' ");
                $modul = ModuluserK::model()->findAll($criModul);
            }
            $arrModul = array();
            if (count((array)$modul) > 0) {
                foreach ($modul as $i => $modulNya) {
                    $modModulK = ModulK::model()->findByPk($modulNya->modul_id, 'modul_aktif = TRUE');
                    if (!empty($modModulK)) {
                        $arrModul[$modModulK->modul_id] = $modModulK->modul_nama;
                    }
                }
            }
            if (count((array)$arrModul) > 0) {
                if (count((array)$arrModul) == 1) {
                    $data['modul'] = CHtml::dropdownlist('LoginForm_modul', 'modul_id', $arrModul);
                } else {
                    $data['modul'] = CHtml::dropdownlist('LoginForm_modul', 'modul_id', $arrModul, array('empty' => '-- Pilih --',));
                }
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    public function actionDynamicInstalasi()
    {
        $data = array();
        $username = (isset($_POST['username'])) ? $_POST['username'] : null;
        $instalasi_id = (isset($_POST['instalasi'])) ? $_POST['instalasi'] : null;
        $ruangan_id = (isset($_POST['ruangan'])) ? $_POST['ruangan'] : null;
        $modul_id = (isset($_POST['modul'])) ? $_POST['modul'] : null;
        $is_exist = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username));
        if ($is_exist) {
            $data['id'] = $is_exist->loginpemakai_id;
            $ruangan = RuanganpemakaiK::model()->findAllByAttributes(array('loginpemakai_id' => $data['id']));
        } else {
            $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan', 'ruangan_id', array('empty' => '-- Pilih --'));
            $data['modul'] = CHtml::dropdownlist('LoginForm_modul', 'modul_id', array('empty' => '-- Pilih --'));
            $data['instalasi'] = CHtml::dropdownlist('LoginForm_instalasi', 'instalasi_id', array('empty' => '-- Pilih --'));
            echo json_encode($data);
            exit;
        }
        $arrInstalasi = array();
        $valInstalasi = array();
        $x = 0;
        if (count((array)$ruangan) > 0) {
            foreach ($ruangan as $i => $ruanganNya) {
                $ruang = RuanganM::model()->findByPk($ruanganNya->ruangan_id, 'ruangan_aktif =TRUE');
                if ((bool)count((array)$ruang)) {
                    if (isset($ruang->instalasi_id)) {
                        $arrInstalasi[$ruang->instalasi_id] = $ruang->instalasi->instalasi_nama;
                        $valInstalasi[$x] = $ruang->instalasi_id;
                    }
                }
                $x++;
            }
        }
        if (count((array)$arrInstalasi) > 0) {
            asort($arrInstalasi);
            if (count((array)$arrInstalasi) == 1) {
                $data['instalasi'] = CHtml::dropdownlist(
                    'LoginForm_instalasi',
                    'instalasi_id',
                    $arrInstalasi,
                    array(
                        'ajax' => array(
                            'type' => 'POST',
                            'url' =>  CController::createUrl('site/dynamicRuangan'),
                            'update' => '#LoginForm_ruangan',
                        ),
                        "options" => array($instalasi_id => array("selected" => true))
                    )
                );
            } else {
                $data['instalasi'] = CHtml::dropdownlist(
                    'LoginForm_instalasi',
                    'instalasi_id',
                    $arrInstalasi,
                    array(
                        'empty' => '-- Pilih --',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' =>  CController::createUrl('site/dynamicRuangan'),
                            'update' => '#LoginForm_ruangan',
                        ),
                        "options" => array($instalasi_id => array("selected" => true))
                    )
                );
            }
        }
        $arrRuangan = array();
        $dataRuangan = $ruangan;
        if (count((array)$dataRuangan) > 0) {
            foreach ($dataRuangan as $i => $ruanganNya) {
                $arrRuangan[$ruanganNya->ruangan_id] = $ruanganNya->ruangan->ruangan_nama;
            }
        }
        if (count((array)$arrRuangan) > 0) {
            asort($arrRuangan);
            if (count((array)$arrRuangan) == 1) {
                $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan', 'ruangan_id', $arrRuangan, array("options" => array($ruangan_id => array("selected" => true))));
            } else {
                $data['ruangan'] = CHtml::dropdownlist('LoginForm_ruangan', 'ruangan_id', $arrRuangan, array('empty' => '-- Pilih --'));
            }
        }
        if (!empty($data['id'])) {
            $modul = ModuluserK::model()->findAllByAttributes(array('loginpemakai_id' => $data['id']));
        }
        $arrModul = array();
        if (count((array)$modul) > 0) {
            foreach ($modul as $i => $modulNya) {
                $modModulK = ModulK::model()->findByPk($modulNya->modul_id, 'modul_aktif = TRUE');
                if ((bool)count((array)$modModulK)) {
                    $arrModul[$modModulK->modul_id] = $modModulK->modul_nama;
                }
            }
        }
        if (count((array)$arrModul) > 0) {
            if (count((array)$arrModul) == 1) {
                $data['modul'] = CHtml::dropdownlist('LoginForm_modul', 'modul_id', $arrModul, array("options" => array($modul_id => array("selected" => true))));
            } else {
                $data['modul'] = CHtml::dropdownlist('LoginForm_modul', 'modul_id', $arrModul, array('empty' => '-- Pilih --', 'options' => array($modul_id => array("selected" => true))));
            }
        }
        echo json_encode($data);
        Yii::app()->end();
    }
    public function actionDynamicRuangan()
    {
        $dataRuangan = array();
        if (isset($_POST['LoginForm']['instalasi'])) {
            $user = $_POST['LoginForm']['username'];
            $pemakai = LoginpemakaiK::model()->find(array('condition' => 'nama_pemakai = \'' . $user . '\' and loginpemakai_aktif = true'));
            $criRP = new CDbCriteria();
            $criRP->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id ";
            $criRP->addCondition(" r.ruangan_aktif = TRUE  ");
            $criRP->addCondition(" loginpemakai_id = '" . $pemakai->loginpemakai_id . "'  ");
            $criRP->order = 'r.ruangan_nama ASC';
            //$ruanganPemakai = RuanganpemakaiK::model()->findAll(array('condition'=>'loginpemakai_id = '.$pemakai->loginpemakai_id));
            $ruanganPemakai = RuanganpemakaiK::model()->findAll($criRP);
            $arrRuangan = array();
            foreach ($ruanganPemakai as $item) {
                array_push($arrRuangan, $item->ruangan_id);
            }
            $instalasi = (int)$_POST['LoginForm']['instalasi'];
            $dataRuangan = RuanganM::model()->findAll(
                'ruangan_aktif = TRUE AND instalasi_id=:instalasi_id AND ruangan_id in (' . implode(',', $arrRuangan) . ') order by ruangan_nama',
                array(':instalasi_id' => $instalasi)
            );
        }
        $data = CHtml::listData($dataRuangan, 'ruangan_id', 'ruangan_nama');
        if (count((array)$data) > 0) {
            if (count((array)$data) > 1) {
                echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            }
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
    }
    public function actionDynamicPropinsi()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('propinsi');
        $criteria->compare('propinsi.propinsi_nama', $_POST['RegistrasidemoS']['propinsi']);
        $criteria->order = 'kabupaten_nama';
        $data = KabupatenM::model()->findAll($criteria);
        $data = CHtml::listData($data, 'kabupaten_nama', 'kabupaten_nama');
        if (empty($data)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        }
    }
    public function actionSetKertas()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (isset($_POST['ukuranKertas'])) {
                $session = new CHttpSession;
                $session->open();
                $_SESSION['ukuran_kertas'] = $_POST['ukuranKertas'];
                $_SESSION['posisi_kertas'] = $_POST['posisiKertas'];
                $data['pesan'] = 'Ukuran ' . $_POST['ukuranKertas'] . ' dan posisi ' . $_POST['posisiNama'] . ' Berhasil Diset';
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    //        Registrasi Demo sudah tidak digunakan lagi
    //        RND-4611
    //        public function actionRegistrasi()
    //        {
    //            $this->layout = '//layouts/login';
    //
    //            $modRegistrasi = new RegistrasidemoS;
    //            $modKomen = new KomentarS;
    //
    //            $model=new LoginForm;
    //
    //            // collect user input data
    //            if(isset($_POST['RegistrasidemoS']))
    //            {
    //                    $modRegistrasi->attributes=$_POST['RegistrasidemoS'];
    //                    $modRegistrasi->tglregisterdemo = date('Y-m-d');
    //                    // validate user input and redirect to the previous page if valid
    //
    //                    if($modRegistrasi->validate()){
    //                        $modRegistrasi->save();
    //                        Yii::app()->user->setFlash('info', '<strong>Registrasi</strong> berhasil.');
    //                        $this->redirect(array('login'));  
    //                    } else {
    //                        Yii::app()->user->setFlash('error', '<strong>Registrasi</strong> gagal.');
    //                    }
    //
    //            }
    //            // display the login form
    //            $this->render('login',array('model'=>$model,
    //                                        'modRegistrasi'=>$modRegistrasi,
    //                                        'modRegistrasi'=>$modRegistrasi));
    //        }
    public function actionTestimonial()
    {
        //echo '<pre>'.print_r($_POST['RegistrasidemoS'],1).'</pre>';
        $this->layout = '//layouts/login';
        //          RND-4611 >>  $modRegistrasi = new RegistrasidemoS;
        $modKomen = new KomentarS;
        $model = new LoginForm;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'testimonial-form') {
            echo CActiveForm::validate($modKomen);
            Yii::app()->end();
        }
        // collect user input data
        if (isset($_POST['KomentarS'])) {
            $modKomen->attributes = $_POST['KomentarS'];
            $modKomen->tglkomentar = date('Y-m-d');
            $modKomen->komentar_tampilkan = false;
            // validate user input and redirect to the previous page if valid
            if ($modKomen->validate()) {
                $modKomen->save();
                Yii::app()->user->setFlash('info', '<strong>Terimakasih</strong> Anda telah memberi testimoni.');
                $this->redirect(array('login'));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Testimoni</strong> gagal disimpan.');
            }
        }
        // display the login form
        $this->render('login', array(
            'model' => $model,
            //                                      RND-4611 >>  'modRegistrasi'=>$modRegistrasi,
            'modKomen' => $modKomen
        ));
    }
    public function actionViewTestimoni()
    {
        $this->layout = '//framedialog';
        $criteria = new CDbCriteria;
        $criteria->addCondition('komentar_tampilkan = TRUE');
        $criteria->order = 'komentar_id DESC';
        $criteria->limit = 10;
        $modTestimonis = KomentarS::model()->findAll($criteria);
        $this->render('viewTestimoni', array('modTestimonis' => $modTestimonis));
    }
    public function actionAjaxViewTestimoni()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $this->layout = '//framedialog';
            $criteria = new CDbCriteria;
            $criteria->addCondition('komentar_tampilkan = TRUE');
            $criteria->order = 'komentar_id DESC';
            $criteria->limit = 10;
            $modTestimonis = KomentarS::model()->findAll($criteria);
            $data = '';
            foreach ($modTestimonis as $i => $testimoni) {
                $data .= '<div class="alert alert-info">';
                $data .= '<b>' . $testimoni->namakomentar . ' - ' . $testimoni->instanasi . '</b><br/>';
                $data .= '' . $testimoni->deskripsikomentat . '';
                $data .= '<span class="author-pengumuman">' . $testimoni->emailkomentar . ' - ' . $testimoni->websitekomentar . '</span><br/>';
                $data .= '</div>';
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    public function actionDetailModul()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (isset($_GET['idModul'])) {
                $idModul = $_GET['idModul'];
                $modul = ModulK::model()->findByPk($idModul);
                $data['modul_nama'] = $modul->modul_namalainnya;
                $data['modul_fungsi'] = $modul->modul_fungsi;
                $data['content'] = $this->renderPartial('modul/detail', array('modul' => $modul), true);
                echo CJSON::encode($data);
            }
            Yii::app()->end();
        }
    }
    public function actionInsertNotifikasi()
    {
        $model = new NofitikasiR;
        $model->attributes = $_POST['NofitikasiR'];
        $model->tglnotifikasi = date('Y-m-d H:i:s');
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $is_simpan = false;
        $data = array();
        $transaction = Yii::app()->db->beginTransaction();
        $modKonfig = KonfigsystemK::model()->find();
        try {
            if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                if ($modKonfig->notifikasi) {
                $criteria = new CDbCriteria;
                $criteria->compare('instalasi_id', $model->instalasi_id);
                $criteria->compare('modul_id', $model->modul_id);
                $criteria->compare('LOWER(isinotifikasi)', strtolower($model->isinotifikasi), true);
                $criteria->compare('create_ruangan', $model->create_ruangan);
                $criteria->addCondition("DATE(tglnotifikasi) = DATE(NOW()) AND isread = false");
                $is_exist = NofitikasiR::model()->find($criteria);
                if (!$is_exist) {
                    if ($model->save()) {
                        $is_simpan = true;
                    }
                } else {
                    $attributes = array(
                        'update_time' => date('Y-m-d H:i:s'),
                        'update_loginpemakai_id' => Yii::app()->user->id,
                    );
                    $update = $model::model()->updateByPk($is_exist['nofitikasi_id'], $attributes);
                    if ($update) {
                        $is_simpan = true;
                    }
                }
                $attributes = array(
                    'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
                    'modul_id' => Yii::app()->session['modul_id'],
                    'isread' => false,
                    'tglnotifikasi' => date('Y-m-d')
                );
                $data_notif = NofitikasiR::model()->findAllByAttributes($attributes);
                $isi_notif = "";
                if (count((array)$data_notif) > 0) {
                    foreach ($data_notif as $value) {
                        $isi_notif .= '<li class="read">';
                        $isi_notif .= '<a href="index.php?r=sistemAdministrator/comment/update&id=12">';
                        $isi_notif .= '<span class="sender">' . $value['judulnotifikasi'] . '</span>';
                        $isi_notif .= '<span class="message">' . $value['isinotifikasi'] . '</span>';
                        $isi_notif .= '<span class="time">' . $value['tglnotifikasi'] . '</span>';
                        $isi_notif .= '</a>';
                        $isi_notif .= '</li>';
                    }
                }
                $data['template'] = $isi_notif;
                $data['count_notif'] = count(NofitikasiR::model()->findAllByAttributes($attributes, array('order' => 'create_time desc', 'limit' => 6)));
                $data['modul_id'] = $model->modul_id;
                if ($is_simpan) {
                    $data['pesan'] = 'ok';
                    $transaction->commit();
                } else {
                    $data['pesan'] = 'gagal';
                    $transaction->rollback();
                }
                }else{
                    $data['pesan'] = 'Notifikasi Off';
                }
                echo CJSON::encode($data);
                Yii::app()->end();
            } else {
            }
        } catch (Exception $exc) {
            $transaction->rollback();
        }
    }
    public function actionPilihModul()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $res = null;
            if (isset($_POST['ruangan_id'])) {
                $ruangan = RuanganM::model()->findByPk($_POST['ruangan_id']);
                if (!empty($ruangan)) $res = $ruangan->modul_id;
            }
            echo CJSON::encode(array('modul_id' => $res));
        }
    }
    public function actionGetNotifikasi()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $isi_notif = '';
            $notif_list = array();
            $count_notif = 0;
            $count_notif_raw = 0;
            //$data = '';
            if (!empty(Yii::app()->user->getState('instalasi_id'))) {
                $sql_raw = "
							SELECT count(nofitikasi_id) as total FROM notifikasi_r 
                            where instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND create_ruangan = " . Yii::app()->user->getState('ruangan_id') . " AND modul_id = " . Yii::app()->user->getState('modul_id') . " AND date(tglnotifikasi) = '" . date('Y-m-d') . "' AND isread is false ";
                $data_raw = Yii::app()->db->createCommand($sql_raw)->queryRow();
                $count_notif_raw = $data_raw['total'];
                $sql = "
							SELECT  isread, nofitikasi_id, judulnotifikasi, tglnotifikasi, isinotifikasi FROM notifikasi_r WHERE																			
							isread = false	AND
							instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
							create_ruangan = " . Yii::app()->user->getState('ruangan_id') . " AND
							modul_id = " . Yii::app()->user->getState('modul_id') . " AND
													date(tglnotifikasi) = '" . date('Y-m-d') . "'
							order by tglnotifikasi desc
							limit 20									
					";
                $count = Yii::app()->db->createCommand($sql)->queryAll();
                $records = Yii::app()->db->createCommand($sql)->queryAll();
                $count_notif = "";
                if (count((array)$records) > 0) {
                    foreach ($records as $value) {
                        if ($value['isread']) {
                            $isi_notif .= '<li class="notification-primary">
														<a href="javascript:;" value="' . $value['nofitikasi_id'] . '" onclick= "$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);">
															<span class="line">
																' . $value['judulnotifikasi'] . '
															</span>
															<span class="line small">
																' . CustomFunction::time_since(time() - strtotime($value['tglnotifikasi'])) . '
															</span>
														</a>
													</li>';
                        } else { //$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);set_read_notifikasi(this);return false;
                            $isi_notif .= '<li class="notification-primary">
														<a href="javascript:;" value="' . $value['nofitikasi_id'] . '" onclick= "$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);">
															<span class="line">
																<strong>' . $value['judulnotifikasi'] . '</strong>
															</span>
															<span class="line small">
																' . CustomFunction::time_since(time() - strtotime($value['tglnotifikasi'])) . '
															</span>
														</a>
													</li>';
                            $notif_list[$value['nofitikasi_id']] = '<strong>' . $value['judulnotifikasi'] . '</strong><br/>' . $value['isinotifikasi'];
                        }
                        $count_notif = (count((array)$count) == 0) ? '' : count((array)$count);
                    }
                }
            }
            $data['template'] = $isi_notif;
            $data['count_notif'] = $count_notif;
            $data['count_notif_raw'] = $count_notif_raw;
            $data['notif_list'] = $notif_list;
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    public function actionSetReadNotifikasi()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $id_pesan = $_GET['id_pesan'];
            $attributes = array(
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Yii::app()->user->id,
                'isread' => true
            );
            $update = NofitikasiR::model()->updateByPk($id_pesan, $attributes);
            $data = array(
                'pesan' => ($update == true ? 'ok' : 'not')
            );
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }
    public function actionGetDetailNotifikasi()
    {
        $notifikasi_id = isset($_GET['notifikasi_id']) ? $_GET['notifikasi_id'] : 99999999999;
        $notifikasi = NofitikasiR::model()->findByPk($notifikasi_id);
        $data = '<table width=100%>';
        $data .= '<tr valign="top">';
        $data .= '<td colspan="3" style="font-weight:bold; border-bottom:1px solid black;">' . $notifikasi->judulnotifikasi . '</td>';
        $data .= '</tr>';
        $data .= '<tr valign="top">';
        if (empty($notifikasi->link_proses)) {
            if (strlen($notifikasi->isinotifikasi) >= 200) {
                $data .= '<td colspan="3"><div style="overflow-y:scroll;height:100px;">' . $notifikasi->isinotifikasi . '</div></td>';
            } else {
                $data .= '<td colspan="3">' . $notifikasi->isinotifikasi . '</td>';
            }
        } else {
            $tgl_notif = date('Y-m-d H:i:s', strtotime(" +" . $notifikasi->lamahrnotif . " hours", strtotime($notifikasi->tglnotifikasi)));
            if (strtotime($tgl_notif) >= strtotime(date('Y-m-d H:i:s'))) {
                $url = Yii::app()->getBaseUrl(true) . str_replace(Yii::app()->baseUrl, '', $notifikasi->link_proses);
                $data .= '<td colspan="3">' . CHtml::link('<u>' . $notifikasi->isinotifikasi . '</u>', $url, array("data-toggle" => "tooltip", "data-placement" => "top", "title" => "", "data-original-title" => "Klik link ini, untuk melanjutkan ke menu lain", "data-html" => true)) . '</td>';
            } else {
                $data .= '<td colspan="3">' . CHtml::link('<u>' . $notifikasi->isinotifikasi . '</u>', 'javascript:;', array("data-toggle" => "tooltip", "data-placement" => "top", "title" => "", "data-original-title" => "Klik link ini, untuk melanjutkan ke menu lain", "data-html" => true, 'onclick' => 'alert("Maaf, link sudah tidak aktif, sudah lebih dari ' . $notifikasi->lamahrnotif . ' jam")')) . '</td>';
            }
        }
        $data .= '</tr>';
        /*if (!empty($notifikasi->link_proses)){
				$data .= '<tr valign="top">';			
				$data .= '<td>Link</td>';
				$data .= '<td>:</td>';
				$data .= '<td>'. $notifikasi->link_proses .'</td>';
				$data .= '</tr>';
			}*/
        $data .= '<tr valign="top">';
        $data .= '<td style="border-top: 1px solid black;">Dibuat Oleh</td>';
        $data .= '<td style="border-top: 1px solid black;">:</td>';
        $data .= '<td style="border-top: 1px solid black;">' . $notifikasi->pemakai->PembuatNotifikasi . '</td>';
        $data .= '</tr>';
        $data .= '<tr valign="top">';
        $data .= '<td>Tanggal</td>';
        $data .= '<td>:</td>';
        //$data .= '<td>'. date("d-m-Y h:m:s", strtotime($notifikasi->create_time)) .'</td>';
        $data .= '<td>' . MyFormatter::formatDateTimeForUser($notifikasi->create_time) . '</td>';
        $data .= '</tr>';
        $data .= '<tr>';
        $data .= '</table>';
        echo ($data);
    }
    public function actionSetReadAllNotifikasi()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            $attributes = array(
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id'),
                'isread' => true
            );
            $update = NotifikasiR::model()->updateAll($attributes, " modul_id = '" . Yii::app()->session['modul_id'] . "' AND create_ruangan = '" . Yii::app()->user->getState('ruangan_id') . "' AND instalasi_id = '" . Yii::app()->user->getState('instalasi_id') . "' ");
            $data = array(
                'pesan' => ($update == true ? 'ok' : 'not')
            );
            echo CJSON::encode($data);
            Yii::app()->end();
        }
    }

    /**
         *
         * digunakan untuk menampilkan daftar informasi berita
         */        
        public function actionBlog() {
            $this->layout = "//layouts/iframeBootstarp4";

        $modBlog = PostM::model()->findAllByAttributes(array('post_aktif' => true), array(
            'order' => 'post_tgl desc'));
        $item_count = count($modBlog);
        $page_size = 10;
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
       

        $dataProvider = new CActiveDataProvider('PostM', array(
            'criteria' => array(
                'condition' => 'post_aktif=true',
                'order' => 'post_tgl desc',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

      

        $this->render('blog/index', array(
            'modBlog' => $modBlog,
       
            'pages' => $pages,
            
            'dataProvider' => $dataProvider,
            
        ));
    }

    /**
     * RSST-2445
     * digunakan untuk menampilkan berita berdasarkan id dan fungsi simpan komentar
     * @param type $id integer untuk menati id yang dipilih
     */
    public function actionViewBlog($id = null) {
         $this->layout = "//layouts/iframeBootstarp4";
        $modBlog = PostM::model()->findByPk($id);
        $modComment = new KommentarT();
        if (!empty($_POST['KommentarT'])) {
            $ok=false;
            
            $trans = Yii::app()->db->beginTransaction();
             try {
            $modComment->attributes = $_POST['KommentarT'];
            $modComment->post_id = $id;
            $modComment->kommentar_tampil = true;
            
            $modComment->create_time = date('Y-m-d H:i:s');
            $modComment->create_loginpemakai_id = Yii::app()->user->id;
            $modComment->update_loginpemakai_id = Yii::app()->user->id;
            $modComment->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $ok=$modComment->save();
              
               if ($ok) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Komentar Telah Terkirim");
                     $this->refresh();
                } else {

                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modComment));
                }
            } catch (Exception $e) {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
                //Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
            }
        }

        $this->render('blog/view', array(
            'modBlog' => $modBlog,
            'modComment' => $modComment,
            
        ));
    }

    /**
     * RSST-2445
     * digunakan untuk searching berita 
     * @param type $q string menerima inputan
     */
    public function actionSearchBlog($q = null) {
          $this->layout = "//layouts/iframeBootstarp4";
        $criteria = new CDbCriteria();
        $criteria->addCondition('post_aktif = true');
        $criteria->condition = "LOWER(post_judul) like '%" . $q . "%' or LOWER(post_desc) like '%" . $q . "%'";
        $criteria->order = 'post_tgl desc';
        $criteria->limit = '10';
       
        $modBlog = PostM::model()->findAllByAttributes(array('post_aktif' => true), array(
            'order' => 'post_tgl desc'));

        $item_count = count($modBlog);
        $page_size = 10;
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);

        $dataProvider = new CActiveDataProvider('PostM', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));

        $this->render('blog/search', array(
            'modBlog' => $modBlog,
            'pages' => $pages,
            'dataProvider' => $dataProvider,
            
        ));
    }
}
