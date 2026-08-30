<?php

/**
 * This is the model class for table "waktutunggupelayanan_t".
 *
 * The followings are the available columns in table 'waktutunggupelayanan_t':
 * @property integer $waktutunggupelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $task_id
 * @property string $task_name
 * @property string $tanggal
 * @property string $kode_booking
 * @property boolean $statuskirim
 * @property string $response_list
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan_id
 * @property string $waktutunggu
 * @property string $waktutunggu_rs
 */
class WaktutunggupelayananT extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $tglwaktu_awal, $tglwaktu_akhir, $tgl_pendaftaran, $no_pendaftaran, $namadepan ,$nama_pasien, $no_rekam_medik, $ceklis, $ceklisdaftar, $status;
	public $jns_periode, $bln_awal, $sumberantrian;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'waktutunggupelayanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, tanggal, kode_booking, statuskirim, create_time, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, pasien_id, task_id', 'numerical', 'integerOnly'=>true),

			array('kode_booking, waktutunggu_mil', 'length', 'max'=>50),
			array('task_name', 'length', 'max'=>200),
			array('response_list, update_time, update_loginpemakai_id, create_ruangan_id, waktutunggu, waktutunggu_rs', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('waktutunggupelayanan_id, pendaftaran_id, pasien_id, task_id, task_name, tanggal, kode_booking, statuskirim, response_list, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, waktutunggu, waktutunggu_rs, waktutunggu_mil', 'safe', 'on'=>'search'),
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
			'waktutunggupelayanan_id' => 'Waktutunggupelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'task_id' => 'Task',
			'task_name' => 'Task Name',
			'tanggal' => 'Tanggal',
			'kode_booking' => 'Kode Booking',
			'statuskirim' => 'Statuskirim',
			'response_list' => 'Response List',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'waktutunggu' => 'Waktutunggu',
			'waktutunggu_rs' => 'Waktutunggu Rs',
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

		$criteria->compare('waktutunggupelayanan_id',$this->waktutunggupelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('task_id',$this->task_id);
		$criteria->compare('task_name',$this->task_name,true);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('kode_booking',$this->kode_booking,true);
		$criteria->compare('statuskirim',$this->statuskirim);
		$criteria->compare('response_list',$this->response_list,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id,true);
		$criteria->compare('waktutunggu',$this->waktutunggu,true);
		$criteria->compare('waktutunggu_rs',$this->waktutunggu_rs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WaktutunggupelayananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInfo()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "t.pendaftaran_id, pp.tgl_pendaftaran, pp.no_pendaftaran, ps.namadepan ,ps.nama_pasien, ps.no_rekam_medik";
		$criteria->group = $criteria->select;
		$criteria->join="join pendaftaran_t pp on pp.pendaftaran_id = t.pendaftaran_id 
		join pasien_m ps on ps.pasien_id = t.pasien_id";
		
		// if($this->ceklisdaftar){
			$criteria->addBetweenCondition('pp.tgl_pendaftaran::date',$this->tgl_awal,$this->tgl_akhir, true);
		// }
		// if($this->ceklis){
		// 	$criteria->addBetweenCondition('t.waktutunggu_rs::date',$this->tglwaktu_awal,$this->tglwaktu_akhir, true);
		// }

		// $criteria->compare('t.task_id',$this->task_id);
		// $criteria->compare('lower(t.kode_booking)',strtolower($this->kode_booking),true);
		$criteria->compare('lower(pp.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('lower(ps.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('lower(ps.no_rekam_medik)',strtolower($this->no_rekam_medik),true);

		if(!empty($this->status)){
			if($this->status == 1){
				$criteria->addCondition('((select count(waktutunggupelayanan_id) from waktutunggupelayanan_t where pendaftaran_id = t.pendaftaran_id) = (select count(waktutunggupelayanan_id) from waktutunggupelayanan_t where pendaftaran_id = t.pendaftaran_id and statuskirim = true))');
			}else if($this->status == 2){
				$criteria->addCondition('((select count(waktutunggupelayanan_id) from waktutunggupelayanan_t where pendaftaran_id = t.pendaftaran_id) != (select count(waktutunggupelayanan_id) from waktutunggupelayanan_t where pendaftaran_id = t.pendaftaran_id and statuskirim = true))');
			}
		}
		
		$criteria->order = "pp.tgl_pendaftaran desc";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getCountStatusTerkirim($pendaftaran_id){
		$terkirim = false;

		$waktutunggu = WaktutunggupelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		$count_waktu = count((array)$waktutunggu);
		$count_kirim = 0; 

		if(!empty($waktutunggu)){
				foreach($waktutunggu as $waktu){
						if($waktu->statuskirim == true){
								$count_kirim += 1;
						}else{
								if($count_kirim > 0){
										$count_kirim -= 1;
								}else{
										$count_kirim = 0;
								}
						}   
				}
		}

		if($count_kirim == $count_waktu){
			$terkirim = true;
		}else{
			$terkirim = false;
		}

		return $terkirim;
	}

	public function ambilResponseTask($pendaftaran_id){
		$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
		$html = "<ul>";

		$html .= "<li>";
		$html .= 'Tambah Antrian - '.(($modPendaftaran->statuskirim_wsbpjs==true)? "<i class='icon-form-check'></i>": $modPendaftaran->respons_wsbpjs." <i class='icon-form-silang'></i>");
		$html .= "</li>";
    $modWaktuTungguList = WaktutunggupelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id), array('order'=>'task_id ASC'));

    if(!empty($modWaktuTungguList)){
      foreach($modWaktuTungguList as $dataWaktu){
				$html .= "<li>";
				$html .= $dataWaktu->task_id.' - '.(($dataWaktu->statuskirim==true)? "<i class='icon-form-check'></i>": $dataWaktu->response_list." <i class='icon-form-silang'></i>");
				$html .= "</li>";
      }
    }
		$html .= "</ul>";


		return $html;
	}
}
