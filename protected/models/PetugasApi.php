<?php

class PetugasApi extends CModel {

    public  $kode,
            $nama,
            $uid,
            $pwd,
            $HakAkses,
            $STheme,
            $HakInv,
            $HakLaporan;
            

    public $is_search = true;


    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienAPI the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('kode, nama, uid, pwd, HakAkses, STheme, HakInv, HakLaporan', 'safe'),
		);
	}

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kode' => 'Kode Petugas',
			'nama' => 'Nama Petugas',
			'uid' => 'UID',
			'pwd' => 'PWD',
			'HakAkses' => 'Hak Akses',
			'STheme' => 'STheme',
			'HakInv' => 'HakInv',
            'HakLaporan' => 'Hak Laporan'
		);
	}

    public function attributeNames() {
        return array('kode, nama, uid, pwd, HakAkses, STheme, HakInv, HakLaporan');
    }

    function getBridgingHost() {
        $konfig = KonfigsystemK::model()->find();
        return $konfig->bridging_host;
    }

    public function searchPetugas() {
        $base_url = $this->getBridgingHost() . '/petugas';

        $res = array();

       

          
        $json = $this->loadData($base_url);
        // var_dump($json);die;
        $data = array();
        if (!empty($json)) {
            $data = CJSON::decode($json);
        }

    
            
        if(isset($data['status']['OK']) && $data['status']['OK'] == true) {
            if (!empty($data["data"]["recordsets"][0])) {
                $recordsets = $data["data"]["recordsets"][0];
                // $res = array_slice($recordsets, 0, 10);
                $res = $recordsets;
                
            }
        }
        

        return new CArrayDataProvider($res, array(
            // 'id'=>'tab_pasien_api',
            'keyField'=>'Nama',
            'pagination' => false
        ));
    }

    private function loadData($url) {
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_VERBOSE, true);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($session);
        return $response;
    }

    

}

?>