<?php

/**
 * This is the model class for table "apifarmasilog_r".
 *
 * The followings are the available columns in table 'apifarmasilog_r':
 * @property integer $apifarmasilog_id
 * @property integer $code
 * @property string $status
 * @property string $tgl_log
 * @property integer $loginpemakai_id
 * @property integer $pendaftaran_id
 * @property integer $penjualanresep_id
 * @property string $json_body_request
 * @property string $json_response
 * @property string $ip_address
 * @property string $url_api
 */
class ApifarmasilogR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'apifarmasilog_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, loginpemakai_id, pendaftaran_id, penjualanresep_id', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>255),
			array('pesan, tgl_log, json_body_request, json_response, url_api', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('apifarmasilog_id, code, pesan, tgl_log, loginpemakai_id, pendaftaran_id, penjualanresep_id, json_body_request, json_response, ip_address, url_api', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'apifarmasilog_id' => 'Apifarmasilog',
			'code' => 'Code',
			'pesan' => 'Pesan',
			'tgl_log' => 'Tgl Log',
			'loginpemakai_id' => 'Loginpemakai',
			'pendaftaran_id' => 'Pendaftaran',
			'penjualanresep_id' => 'Penjualanresep',
			'json_body_request' => 'Json Body Request',
			'json_response' => 'Json Response',
			'ip_address' => 'Ip Address',
			'url_api' => 'Url Api',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('apifarmasilog_id',$this->apifarmasilog_id);
		$criteria->compare('code',$this->code);
		$criteria->compare('pesan',$this->pesan,true);
		$criteria->compare('tgl_log',$this->tgl_log,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('json_body_request',$this->json_body_request,true);
		$criteria->compare('json_response',$this->json_response,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('url_api',$this->url_api,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ApifarmasilogR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	function logFarmasi($response, $request, $modPenjualan, $url_api = null, $no_jual = null) {
		$model = new $this;
		$status = isset($response['status']) ? $response['status'] : null;
		$model->code = isset($status['Code']) ? $status['Code'] : null;
		$model->pesan = isset($status['Message']) ? $status['Message'] : null;
		$model->status_response = isset($status['OK']) ? $status['OK'] : null;
		$model->tgl_log = date('Y-m-d H:i:s');
		$model->loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
		$model->pendaftaran_id = !empty($modPenjualan->pendaftaran_id) ? $modPenjualan->pendaftaran_id : null;
		$model->penjualanresep_id = !empty($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null;
		$model->json_body_request = isset($request) ? json_encode($request) : null;
		$model->json_response = isset($response['data']) ? json_encode($response['data']) : null;
		$host = Yii::app()->request;
		$ipAddress = $host->getUserHostAddress();
		$model->ip_address = $ipAddress;
		$model->url_api = $url_api;
		$model->nojual = $no_jual;
		if(isset($response['metadata'])) {
			$model->code = isset($response['metadata']['code']) ? $response['metadata']['code'] : null;
			$model->pesan = isset($response['metadata']['message']) ? $response['metadata']['message'] : null;
			$model->json_response = json_encode($response); 
		}
		if(isset($response['Status'])) {
			$res = $response['Status'];
			$model->code = isset($res['Code']) ? $res['Code'] : null;
			$model->pesan = isset($res['Message']) ? $res['Message'] : null;
			$model->status_response = isset($res['OK']) ? $res['OK'] : null;
			$model->json_response = isset($res['Message']) ? $res['Message'] : null;
		}
		if(!empty($no_jual) && $model->status_response !== true) {
			// jika no_jual tidak kosong dan status response false
			$this->batalJualResep($modPenjualan);
		}
		$model->save();
		return $model;
	}

	function batalJualResep($modPenjualan) {
		$resepturok_id = '';
		$pengambilanobat_triage_id = [];
		$reseptur_id = ''; 
		if(!empty($modPenjualan->penjualanresep_id)) {
			// resep ok
			if(!empty($modPenjualan->resepturok_id)) {
				$resepturok_id = $modPenjualan->resepturok_id;
			}
			// mengembalikan obat ok
			if(!empty($resepturok_id)) {
				ResepturokT::model()->updateByPk($resepturok_id, ['penjualanresep_id' => null]);
			}

			// reseptur
			if(!empty($modPenjualan->reseptur_id)) {
				$reseptur_id = $modPenjualan->reseptur_id;
			}
			// mengembalikan obat
			if(!empty($reseptur_id)) {
				ResepturT::model()->updateByPk($reseptur_id, ['penjualanresep_id' => null]);
			}

			$modOAPasien = ObatalkespasienT::model()->findAllByAttributes(['penjualanresep_id' => $modPenjualan->penjualanresep_id]);
			if(!empty($modOAPasien)) {
				foreach ($modOAPasien as $i => $data) {
					// resep triage
					if(!empty($data->pengambilanobat_triage_id)) {
						$pengambilanobat_triage_id[] = $data->pengambilanobat_triage_id;
					}

					$modPemberianObat = CatatanpemberianobatT::model()->findByAttributes(['obatalkespasien_id' => $data->obatalkespasien_id]);
					if(!empty($modPemberianObat)) {
						CatatanpemberianobatdetT::model()->deleteAllByAttributes(['catatanpemberianobat_id' => $modPemberianObat->catatanpemberianobat_id]);

						$modPemberianObat->delete();
					}

					$data->delete();
				}
			}

			// mengembalikan obat triage
			if(!empty($pengambilanobat_triage_id)) {
				$attr = [
					'is_jual' => false
				];
				$criteria = new CDbCriteria();
				$criteria->addInCondition('pengambilanobat_triage_id', array_merge($pengambilanobat_triage_id));
				PengambilanobatTriageT::model()->updateAll($attr, $criteria);
			}

			// menghapusTIndkaan
			$modTindakan = TindakanpelayananT::model()->findByAttributes(['penjualanresep_id' => $modPenjualan->penjualanresep_id]);
			if(!empty($modTindakan)) {
				$modTindakan->delete();
			}

			// menghapus penjualanresep_t
			$modPenjualan->delete();

		}
		
	}
}
