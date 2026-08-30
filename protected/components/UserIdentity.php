<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
                private $_id;
                public $ruangan;
                const ERROR_RUANGAN_INVALID = 'Kesalahan pada Ruangan';


        public function __construct($username,$password,$ruangan)
	{
		$this->username=$username;
		$this->password=$password;
                $this->ruangan=$ruangan;
	}
        
	public function authenticate()
	{
                $user = LoginpemakaiK::model()->findByAttributes(
                    array(
                        'nama_pemakai' => $this->username,
                        'loginpemakai_aktif' =>TRUE
                    )
                );
                
                if($user === null){
                    $this->errorCode = self::ERROR_USERNAME_INVALID;
                }else if(!$user->cekPassword3($this->password)){
                    $this->errorCode = self::ERROR_PASSWORD_INVALID;
                }else{
                    $ruangan_user = RuanganpemakaiK::model()->findByAttributes(
                        array(
                            'loginpemakai_id'=>$user->loginpemakai_id,
                            'ruangan_id'=>$this->ruangan
                        )
                    );
                    if($ruangan_user === null)
                    {
                        $this->errorCode=self::ERROR_RUANGAN_INVALID;
                    }else{
                        
                        $shift_data = null;
                        
						 $this->setState('modul_id', $_POST['LoginForm']['modul']);
						
                        $this->_id = $user->loginpemakai_id;

						$lastLogin =date('Y-m-d H:i:s');
						if(!empty($user->lastlogin)){
							$lastLogin = $user->lastlogin;
						}
												
						$attributes = $user->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $this->setState($attributes, $value);
                            if(isset($user->pegawai)){
                                $attributes_rel = $user->pegawai->getAttributes();
                                foreach($attributes_rel as $attribute_rel => $value_rel){
                                    if ($attribute_rel != 'loginpemakai_id'){
                                        $this->setState($attribute_rel, $value_rel);
                                    }
                                }
                                
                                $shift_data = ShiftM::model()->getShiftLogin($user->pegawai_id);
                            }
                        }
                        $this->setState('lastLoginTime', $lastLogin);
                        
                        //session wilayah berdasarkan data profil rumah sakit
                        $profil = ProfilrumahsakitM::model()->findByPk(
                            Params::getDefaultProfilRS()
                        );
                        $attributes = $profil->getAttributes();
                        foreach($attributes as $attribute=>$value){
                            $this->setState($attribute, $value);
                            if(isset($profil->propinsi)){
                                $attributes_rel = $profil->propinsi->getAttributes();
                                foreach($attributes_rel as $attribute_rel=>$value_rel){
                                    $this->setState($attribute_rel, $value_rel);
                                }
                            }
                            if(isset($profil->kabupaten)){
                                $attributes_rel = $profil->kabupaten->getAttributes();
                                foreach($attributes_rel as $attribute_rel=>$value_rel){
                                    $this->setState($attribute_rel, $value_rel);
                                }
                            }
                            if(isset($profil->kecamatan)){
                                $attributes_rel = $profil->kecamatan->getAttributes();
                                foreach($attributes_rel as $attribute_rel=>$value_rel){
                                    $this->setState($attribute_rel, $value_rel);
                                }
                            }
                            if(isset($profil->kelurahan)){
                                $attributes_rel = $profil->kelurahan->getAttributes();
                                foreach($attributes_rel as $attribute_rel=>$value_rel){
                                    $this->setState($attribute_rel, $value_rel);
                                }
                            }
                        }
                        
                        $kelasPelayananRuangan = CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$_POST['LoginForm']['ruangan'])), 'kelaspelayanan_id', 'kelaspelayanan_id');
                        $this->setState('kelaspelayananruangan',$kelasPelayananRuangan);
                        
                        if (!empty($shift_data)) {
                            $this->setState('shift_id', $shift_data->shift_id);
                        } else {
                            $now = date('H:i:s');
                            $sql = "SELECT * FROM shift_m where '$now' < shift_jamakhir and shift_aktif = true order by shift_jamakhir";
                            $result = Yii::app()->db->createCommand($sql)->queryRow();
                            if(empty($result['shift_id'])){
                                $sql = "SELECT * FROM shift_m where '$now' > shift_jamawal and shift_aktif = true order by shift_jamakhir DESC";
                                $result = Yii::app()->db->createCommand($sql)->queryRow();
                            }
                            $this->setState('shift_id', $result['shift_id']);
                        }
                        
                        $this->setState('ukuran_kertas', Params::DEFAULT_KERTAS_UKURAN);
                        $this->setState('posisi_kertas', Params::DEFAULT_KERTAS_POSISI);
                        
                        $modRuanganLogin = RuanganM::model()->findByPk($_POST['LoginForm']['ruangan']);
                        $attributes = $modRuanganLogin->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $this->setState($attributes, $value);
                        }
                        $modInstalasiLogin = InstalasiM::model()->findByPk($_POST['LoginForm']['instalasi']);
                        $attributes = $modInstalasiLogin->getAttributes();
                        foreach($attributes as $attributes => $value){
                            $this->setState($attributes, $value);
                        }
                        
                        $this->errorCode = self::ERROR_NONE;
						$user->rehashPassword($this->password);
                        $konfig = KonfigsystemK::model()->find();
                        $attributeKonfig = $konfig->getAttributes();
                        foreach($attributeKonfig as $attribute=>$value){
                            $this->setState($attribute, $value);
                        }

                        $konfigFarmasi = KonfigfarmasiK::model()->find();
						
						if (!empty($konfigFarmasi)){
							$attributeKonfigFar = $konfigFarmasi->getAttributes();
							foreach($attributeKonfigFar as $attribute=>$value){
								$this->setState($attribute, $value);
							}
						}
						
						$peranPeng = new CDbCriteria();
						$peranPeng->select = " peranpengguna_id, loginpemakai_id ";
						$peranPeng->addCondition(" loginpemakai_id = '".$user->loginpemakai_id."' ");
						$peranPeng->group = " peranpengguna_id, loginpemakai_id ";
						$peranP = AksespenggunaK::model()->findAll($peranPeng);
						
						if (!empty($peranP)){
							$v = '';
							$z = 1;
							foreach($peranP as $val){								
								
								if (count($peranP) == $z){
									$v .= $val->peranpengguna_id;
								}else{
									$v .= $val->peranpengguna_id.',';
								}
								
								$this->setState('peranpengguna_id', $v);
								$z++;
							}
						}
						
						if (!empty($konfigFarmasi)){
							$attributeKonfigFar = $konfigFarmasi->getAttributes();
							foreach($attributeKonfigFar as $attribute=>$value){
								$this->setState($attribute, $value);
							}
						}
						
                        $modulUser = ModuluserK::model()->findAllByAttributes(array('loginpemakai_id'=>$user->loginpemakai_id));
                        foreach($modulUser as $i=>$modul){
                            //$usersModul[$modul->modul_id] = $modul->modul_id;
                            $usersModul[$modul->modul_id]['modul_id'] = $modul->modul_id;
                            $usersModul[$modul->modul_id]['url_modul'] = $modul->modul->url_modul;
                            $usersModul[$modul->modul_id]['modul_nama'] = $modul->modul->modul_nama;
                            $usersModul[$modul->modul_id]['icon_modul'] = $modul->modul->icon_modul;
                            $modul_id = $modul->modul_id;
                        }
                        $this->setState('usersModul', $usersModul);
						//$this->setState('modul_id', $modul_id);
                        
                        $modPeriode = RekperiodM::model()->findAllByAttributes(array('isclosing'=>false), array('order'=>'perideawal'));
                        $periode = array();
						
						if (!empty($modPeriode)){
							foreach($modPeriode as $x=>$value){
								$periode[$x] = $value->rekperiod_id;
							}
							$this->setState('periode_ids',$periode);
						}else{
							$this->setState('periode_ids','');
						}
                    }
                    //Non aktifkan user dengan aktifitas terakhir >= 24 jam
                    LoginpemakaiK::model()->updateAll(array(
                        'statuslogin'=>false
                    ),"(DATE_PART('hour', '".date('Y-m-d H:i:s')."'::timestamp without time zone - waktuterakhiraktifitas) >= 24) AND statuslogin = TRUE");

                }
                return!$this->errorCode;
	} 
        
        public function getId() {
             return $this->_id;
        }  
        
}