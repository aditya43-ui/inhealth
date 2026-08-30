<?php
ini_set('memory_limit', '32M');
class MChatController extends MyMobileAuthController
{
	public $layout = "//layouts/iframe";
	
	public function actionIndex()
    {
        $this->render('/default/index');
    }
    /**
     * insert history chat
     * MA-126
     * @param $_GET['chat_from'] 
     * @param $_GET['chat_to'] 
     * @param $_GET['chat_message'] text
     * @return json
     */
    public function actionChat(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['chat_from']) && isset($_GET['chat_to']) && isset($_GET['chat_message'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOChat();
                $model->chat_from = $_GET['chat_from'];
                $model->chat_to = $_GET['chat_to'];
                $model->chat_sent = date("Y-m-d H:i:s");
                $model->chat_message = str_replace('"','',str_replace("'","",$_GET['chat_message']));
                
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Pesan terkirim!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Pesan gagal terkirim!<br>'.CHtml::errorSummary($model);
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Pesan gagal terkirim!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan history chat (keluar dan masuk)
     * MA-183
     * @param $_GET['chat_from'] wajib
     * @param $_GET['chat_to'] wajib
     * @param $_GET['offset']
     * @return json
     */
    public function actionGetChatHistory(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['chat_from']) && isset($_GET['chat_to'])){
            $sql = "SELECT * 
                    FROM chat
                    WHERE (TRIM(chat_from) = '".trim($_GET['chat_from'])."' AND TRIM(chat_to) = '".$_GET['chat_to']."') 
                        OR (TRIM(chat_to) = '".trim($_GET['chat_from'])."' AND TRIM(chat_from) = '".$_GET['chat_to']."')
                    ORDER BY chat_id DESC
					".(isset($_GET['offset']) ? "OFFSET ".$_GET['offset'] : "")."
                    LIMIT 9";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(count($loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$i] = $val;
					$data[$i]['user_1'] = $val['chat_from'];
					$data[$i]['user_2'] = $val['chat_to'];
				}
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    /**
     * menampilkan history chat (keluar dan masuk)
     * MA-183
     * @param $_GET['chat_from'] wajib
     * @param $_GET['chat_to'] wajib
     * @param $_GET['offset']
     * @return json
     */
    public function actionGetChat(){
        header("content-type:application/json");
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
        $menitPesan = '';
        if(isset($_GET['chat_from']) && isset($_GET['chat_to'])){
            $chat_from = isset($_GET['chat_from'])?$_GET['chat_from']:'';
            $chat_to = isset($_GET['chat_to'])?$_GET['chat_to']:'';
            if ($menitPesan=='') {
                $menitPesan = date('H:is');
            }
            $sql = "SELECT * 
                    FROM chat
                    WHERE (chat_from='".$chat_from."' AND chat_to='".$chat_to."') OR (chat_to='".$chat_from."' AND chat_from='".$chat_to."')
                    ORDER BY chat_id ASC";
        
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
           
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackChat(".$encode.")";
        Yii::app()->end();
    }
    
    /**
	 * action untuk mendapatkan pesan lama
	 *
	 * @param chat_id dari chat, eg 635968
	 * @return array dari data chat
	 */
	public function actionGetChatInbox() {
	header("content-type:application/json");
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
        $menitPesan = '';
        if(isset($_GET['chat_from'])&&isset($_GET['chat_to'])&&isset($_GET['last_seen'])){
            $chat_from = isset($_GET['chat_from'])?$_GET['chat_from']:'';
            $chat_to = isset($_GET['chat_to'])?$_GET['chat_to']:'';
            if ($menitPesan=='') {
                $menitPesan = date('H:is');
            }
//             var_dump('bebas');die;
            $sql = "SELECT * FROM(
                    SELECT
                    DISTINCT ON
                    (chat_from, chat_to)chat_from, chat_to, *
                    FROM
                    chat
                    WHERE chat_from='".$chat_from."' or (chat_to='".$chat_to."' AND chat_to='".$chat_from."')
                    ORDER BY chat_from, chat_to, chat_id DESC
                    )a
                    ORDER BY a.chat_sent DESC
                    LIMIT 10";
        
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackInbox(".$encode.")";
        Yii::app()->end();
	}
        public function actionGetContactPerson() {
	header("content-type:application/json");
        $data = array();
        $data['is_found'] = 0;
        $data['pesan'] = "Data not found!";
        $data['data'] = '';
        if(isset($_GET['pegawai_id'])&&isset($_GET['q'])){
            $q = strtolower($_GET['q']);
            
            $sql = "SELECT loginpemakai_k.loginpemakai_id, loginpemakai_k.pegawai_id, loginpemakai_k.nama_pemakai, loginpemakai_k.statuslogin, loginpemakai_k.loginpemakai_aktif, 
                    loginpemakai_k.ruanganaktifitas, pegawai_m.nama_pegawai,ruangan_m.ruangan_nama
                    FROM loginpemakai_k
                    JOIN pegawai_m ON pegawai_m.pegawai_id = loginpemakai_k.pegawai_id
                    JOIN ruangan_m ON ruangan_m.ruangan_id = loginpemakai_k.ruanganaktifitas
                    WHERE loginpemakai_k.statuslogin = TRUE AND loginpemakai_k.loginpemakai_aktif = TRUE AND (LOWER(nama_pegawai) LIKE '%$q%' OR LOWER(ruangan_nama) LIKE '%$q%')
                    ORDER BY ruangan_m.ruangan_nama ASC";
        
            $loadData = Yii::app()->db->createCommand($sql)->queryAll();
           
            $data['data'] = $loadData;
            $n = sizeof($loadData);
            if ($n>0) {
                $data['is_found'] = 1;
                $data['pesan'] = "Data ditemukan!";
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallbackPerson(".$encode.")";
        Yii::app()->end();
	}
}