<?php
/**
 * Kelas Controller untuk mendapatkan informasi mengenai ICD-10
 */
ini_set('memory_limit', '128M');
class MICD10Controller extends Controller
{

    /**
    * action untuk mendapatkan diagnosa
    * @param q, data 
    * @return array of diagnosa
    */
    public function actionGetDiagnosa() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['q'])&&isset($_GET['type'])) {            
            $sql     = $this->getQueryDiagnosaByType($_GET['type']);
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        //echo $sql; 
    }

    /**
    * action untuk mendapatkan blok ICD-10 menggunakan id diagnosa
    * @param id chapter
    * @return array of block ICD-10
    */
    public function actionGetBlockByChapter() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['id'])) {            
            $sql     = "SELECT * FROM dtd_m WHERE tabularlist_id=".$_GET['id']." LIMIT 10";
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
    }

    /**
    * action untuk mendapatkan diagnosa menggunakan Id block
    * @param id block
    * @return array of diagnosa ICD-10
    */

    public function actionGetDiagnosaByBlock() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['id'])) {            
            $sql     = "SELECT * FROM diagnosa_m d JOIN dtddiagnosa_m ddtd ON d.diagnosa_id=ddtd.diagnosa_id WHERE ddtd.dtd_id=".$_GET['id'];
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";   
    }
	
	/**
    * action untuk mendapatkan diagnosa menggunakan Id classification
    * @param id block
    * @return array of diagnosa ICD-10
    */
    public function actionGetDiagnosaByClassification() {
        header("content-type:application/json");
        $format = new MyFormatter();
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data tidak ditemukan!";
        $data['data'] = '';
        if (isset($_GET['klasifikasidiagnosa_id'])) {            
            $sql     = "SELECT * FROM diagnosa_m  WHERE klasifikasidiagnosa_id=".$_GET['klasifikasidiagnosa_id'];
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";    
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";   
    }

    /**
    * action untuk 
    */

    /**
    * private function untuk mendapatkan query diagnosa
    * @param type
    * @return String query
    */
    private function getQueryDiagnosaByType($type=1) {
        switch ($type) {
            case 1:
                $sql = "SELECT * FROM diagnosa_m d WHERE diagnosa_aktif = TRUE AND (LOWER(d.diagnosa_kode) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(d.diagnosa_nama) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(d.diagnosa_namalainnya) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(d.diagnosa_katakunci) LIKE '%".strtolower($_GET['q'])."%') LIMIT 5";
                break;
            case 2: 
                $sql = "SELECT * FROM tabularlist_m tb WHERE tabularlist_aktif = TRUE AND (LOWER(tb.tabularlist_chapter) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(tb.tabularlist_block) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(tb.tabularlist_title) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(tb.tabularlist_revisi) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(tb.tabularlist_versi) LIKE '%".strtolower($_GET['q'])."%') LIMIT 5";
                break;
            case 3:
                $sql = "SELECT * FROM dtd_m dtd WHERE dtd_aktif = TRUE AND (LOWER(dtd.dtd_kode) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(dtd.dtd_nama) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(dtd.dtd_namalainnya) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(dtd.dtd_katakunci) LIKE '%".strtolower($_GET['q'])."%') LIMIT 5";
                break;
			case 4: 
				$sql = "SELECT * FROM klasifikasidiagnosa_m k WHERE klasifikasidiagnosa_aktif = TRUE AND (LOWER(k.klasifikasidiagnosa_kode) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(k.klasifikasidiagnosa_nama) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(k.klasifikasidiagnosa_namalain) LIKE '%".strtolower($_GET['q'])."%' OR LOWER(k.klasifikasidiagnosa_desc) LIKE '%".strtolower($_GET['q'])."%') LIMIT 5";
                break;
        }
        return $sql;
    }
}
