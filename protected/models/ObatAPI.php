<?php

class ObatAPI extends CModel {

    public  $HJual,
            $HPP,
            $Kode,
            $Nama,
            $StFornas,
            $StRes,
            $StStock,
            $jenis,
            $jmlStok,
            $satuan,
            $ruanganapotektujuan_id,
            $ruangan_id;

    public $is_search = true;

    public $kode_repo = true;


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
			array('HJual, HPP, Kode, Nama, StFornas, StRes, StStock, jenis, jmlStok, satuan', 'safe'),
		);
	}

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'HJual' => 'Harga Jual',
			'HPP' => 'HPP',
			'Kode' => 'Kode Obat',
			'Nama' => 'Nama Obat',
			'StFornas' => 'Jenis Fornas',
			'StRes' => 'Stok Res',
			'StStock' => 'St Stok',
            'jenis' => 'Jenis',
            'jmlStok' => 'Jumlah Stok',
            'satuan' => 'Satuan'
		);
	}

    public function attributeNames() {
        return array('HJual', 'HPP', 'Kode', 'Nama', 'StFornas', 'StRes', 'StStock', 'jenis', 'jmlStok', 'satuan');
    }

    function getBridgingHost() {
        $konfig = KonfigsystemK::model()->find();
        return $konfig->bridging_host;
    }

    public function searchObat() {

        $base_url = $this->getBridgingHost() . '/stok';

        $res = array();

        if ($this->is_search) {

           if(!empty($this->Nama)) {
                $nama = str_replace(' ', '%20', $this->Nama);

                $base_url .= "/".$nama;
           }
    
            $json = $this->loadData($base_url);
            // var_dump($json);die;
            $data = array();
            if (!empty($json)) {
                $data = CJSON::decode($json);
            }
    
            
            if (!empty($data["data"]["recordsets"][0])) {
                $recordsets = $data["data"]["recordsets"][0];
                // $res = array_slice($recordsets, 0, 10);
                $res = $recordsets;
              
            }
        }

        return new CArrayDataProvider($res, array(
            // 'id'=>'tab_pasien_api',
            'keyField'=>'Nama',
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchObatRuangan($ruangan_id) {

        // ini digunakan untuk fitur ketika pilih ruangan apotek tujuan maka data obat berganti sesuai depo ruangan tujuan yang di pilih
        if(!empty($this->ruanganapotektujuan_id)) {
            $ruangan_id = $this->ruanganapotektujuan_id;
        }

        // ini hanya sekedar untuk mencegah error takutnya ruangan_id nya kosong
        if(empty($ruangan_id)) {
            $ruangan_id = Yii::app()->user->getState('ruangan_id');
        }

        $ruangan = RuanganM::model()->findByPk($ruangan_id);


        $action = "stokdepo";
        $base_url = $this->getBridgingHost() . '/{action}/'.$ruangan->kodedepo_inventory;

        $res = array();

        $nama_cari = "";

        if ($this->is_search) {

            if(!empty($this->Nama) && trim($this->Nama) != "") {

                $action = "stokdepobyname";

                $nama = str_replace(' ', '%20', $this->Nama);

                $nama_cari = "/".$nama;

                $base_url .= $nama_cari;
            }

            $base_url = str_replace("{action}", $action, $base_url);


            // var_dump($base_url); die;
    
            $json = $this->loadData($base_url);
            // var_dump($base_url, $json);die;
            $data = array();
            if (!empty($json)) {
                $data = CJSON::decode($json);
            }

            // var_dump($data); die;
    
            
            if (!empty($data["data"]["recordsets"][0])) {
                $recordsets = $data["data"]["recordsets"][0];
                // $res = array_slice($recordsets, 0, 10);
                $res = $recordsets;
              
            }
        }

        return new CArrayDataProvider($res, array(
            // 'id'=>'tab_pasien_api',
            'keyField'=>'Nama',
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchStokDariApi($nama_cari, $sumberdana_id) {
        // echo '<pre>';var_dump($sumberdana_id);die;
        $base_url = $this->getBridgingHost() . '/stokdepobyname/'. Yii::app()->user->getState('kodedepo_inventory');

        $res = array();

        $this->Nama = $nama_cari;

        if (!empty($this->Nama)) {

           if(!empty($this->Nama)) {
                $nama = str_replace(' ', '%20', $this->Nama);

                $base_url .= "/".$nama;
           }
    
            $json = $this->loadData($base_url);
            // var_dump($json);die;
            $data = array();
            if (!empty($json)) {
                $data = CJSON::decode($json);
            }
    
            
            if (!empty($data["data"]["recordsets"][0])) {

                // jika data obat di temukan lebih dari satu maka diseleksi berdasarkan sumberdana_id
                if(count($data['data']["recordsets"][0]) > 1) {
                    foreach($data['data']["recordsets"][0] as $i => $val) {
                        if($val['kodeStok'] == $sumberdana_id) {
                            $res = $val;
                        }
                    }
                } else {
                    // kalo yang didapat hanya satu data obat
                    $recordsets = $data["data"]["recordsets"][0][0];
                    $res = $recordsets;
                }
            }
        }

        return $res;
    }

    public function searchStokDariApiGlobalByName($nama_cari, $sumberdana_id) {
        // echo '<pre>';var_dump($sumberdana_id);die;
        $base_url = $this->getBridgingHost().'/stok';

        $res = array();

        $this->Nama = $nama_cari;

        if (!empty($this->Nama)) {

           if(!empty($this->Nama)) {
                $nama = str_replace(' ', '%20', $this->Nama);

                $base_url .= "/".$nama;
           }
    
            $json = $this->loadData($base_url);
            // var_dump($json);die;
            $data = array();
            if (!empty($json)) {
                $data = CJSON::decode($json);
            }
    
            
            if (!empty($data["data"]["recordsets"][0])) {

                // jika data obat di temukan lebih dari satu maka diseleksi berdasarkan sumberdana_id
                if(count($data['data']["recordsets"][0]) > 1) {
                    foreach($data['data']["recordsets"][0] as $i => $val) {
                        if($val['kodeStok'] == $sumberdana_id) {
                            $res = $val;
                        }
                    }
                } else {
                    // kalo yang didapat hanya satu data obat
                    $recordsets = $data["data"]["recordsets"][0][0];
                    $res = $recordsets;
                }
            }
        }

        return $res;
    }

    function searchStokByDepo($stStock, $kodeobat_inventory) {
        $kode_depo = Yii::app()->user->getState('kodedepo_inventory');

        $base_url = $this->getBridgingHost(). '/stok_advanced/{depo}/{ststok}/{kode_obat}';

        $res = array();

        if(!empty($kode_depo) && !empty($stStock) && !empty($kodeobat_inventory)) {
            $base_url = str_replace("{depo}", $kode_depo, $base_url);
            $base_url = str_replace("{ststok}", $stStock, $base_url);
            $base_url = str_replace("{kode_obat}", $kodeobat_inventory, $base_url);
        }

        // echo '<pre>';var_dump($base_url);die;
        $json = $this->loadData($base_url);
        // var_dump($json);die;
        $data = array();
        if (!empty($json)) {
            $data = CJSON::decode($json);
        }

        // echo '<pre>';var_dump($data["data"]['recordset'][0]);die;
        if (!empty($data["data"]["recordset"][0])) {
            // kalo yang didapat hanya satu data obat
            $recordsets = $data["data"]["recordset"][0];
            $res = $recordsets;
        }
        
        // echo '<pre>';var_dump($res);die;
        return $res;

    }

    function searchStokByStStock($stStock, $kodeobat_inventory) {

        $base_url = $this->getBridgingHost() . '/stok_advanced/{ststok}/{kode_obat}';

        $res = array();

        if(!empty($stStock) && !empty($kodeobat_inventory)) {
            $base_url = str_replace("{ststok}", $stStock, $base_url);
            $base_url = str_replace("{kode_obat}", $kodeobat_inventory, $base_url);
        }

        // echo '<pre>';var_dump($base_url);die;
        $json = $this->loadData($base_url);
        // var_dump($json);die;
        $data = array();
        if (!empty($json)) {
            $data = CJSON::decode($json);
        }

        // echo '<pre>';var_dump($data["data"]['recordset'][0]);die;
        if (!empty($data["data"]["recordset"][0])) {
            // kalo yang didapat hanya satu data obat
            $recordsets = $data["data"]["recordset"][0];
            $res = $recordsets;
        }
        
        // echo '<pre>';var_dump($res);die;
        return $res;

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