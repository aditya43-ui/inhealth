<?php

/**
 * This is the model class for table "respontime_r".
 *
 * The followings are the available columns in table 'respontime_r':
 * @property integer $respontime_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $tgldatang
 * @property string $tglperiksa
 * @property string $tglkonsul
 * @property string $tglrespon
 * @property string $tglkeluar
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RespontimeR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'respontime_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, ruangan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pegawai_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tgldatang, tglperiksa, tglkonsul, tglrespon, tglkeluar, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('respontime_id, pendaftaran_id, pegawai_id, ruangan_id, tgldatang, tglperiksa, tglkonsul, tglrespon, tglkeluar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'respontime_id' => 'Respontime',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'tgldatang' => 'Tgldatang',
			'tglperiksa' => 'Tglperiksa',
			'tglkonsul' => 'Tglkonsul',
			'tglrespon' => 'Tglrespon',
			'tglkeluar' => 'Tglkeluar',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('respontime_id',$this->respontime_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tgldatang',$this->tgldatang,true);
		$criteria->compare('tglperiksa',$this->tglperiksa,true);
		$criteria->compare('tglkonsul',$this->tglkonsul,true);
		$criteria->compare('tglrespon',$this->tglrespon,true);
		$criteria->compare('tglkeluar',$this->tglkeluar,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RespontimeR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public static function daftarRespon($model) {
		$respon = new RespontimeR;
		$respon->pendaftaran_id = $model->pendaftaran_id;
		$respon->tgldatang = $model->tgl_pendaftaran;
		$respon->ruangan_id = $model->ruangan_id;
		// $respon->pegawai_id = $model->pegawai_id;
		$respon->create_time = date('Y-m-d H:i:s');
		$respon->create_loginpemakai_id = Yii::app()->user->id ?? 1;
		$respon->create_ruangan = Yii::app()->user->getState('ruangan_id') ?? 1;
		$respon->save();

		return $respon;
	}

	public static function setPeriksaPasien($pendaftaran_id, $tgl = null) {
		if (empty($tgl)) {
			$tgl = date('Y-m-d H:i:s');
		}
		$respon = RespontimeR::model()->findByAttributes(array(
			'pendaftaran_id'=>$pendaftaran_id
		));

		if (empty($respon)) {
			$daftar = PendaftaranT::model()->findByPk($pendaftaran_id);
			$respon = self::daftarRespon($daftar);
		}

		if (empty($respon->tglperiksa)) {
			$respon->tglperiksa = $tgl;
			$respon->update_time = date('Y-m-d H:i:s');
			$respon->update_loginpemakai_id = Yii::app()->user->id ?? 1;
			$respon->save(false);
		}
	}

	public static function setPasienKeluar($pendaftaran_id, $tgl = null) {
		if (empty($tgl)) {
			$tgl = date('Y-m-d H:i:s');
		}
		$respon = RespontimeR::model()->findByAttributes(array(
			'pendaftaran_id'=>$pendaftaran_id
		));

		if (empty($respon)) {
			$daftar = PendaftaranT::model()->findByPk($pendaftaran_id);
			$respon = self::daftarRespon($daftar);
		}
		
		$respon->tglkeluar = $tgl; 
		$respon->update_time = date('Y-m-d H:i:s');
		$respon->update_loginpemakai_id = Yii::app()->user->id ?? 1;
		$respon->save(false);

	}

	public function getResponTime($tipe, $satuan = null) {

		if ($tipe == 1) {
			if (empty($this->tgldatang) || empty($this->tglperiksa)) {
				return "-";
			}
			$selisih = strtotime($this->tglperiksa) - strtotime($this->tgldatang);

			return ceil($selisih / 60).(empty($satuan) ? "" : (" ".$satuan));
		}

		if ($tipe == 2) {
			if (empty($this->tglrespon) || empty($this->tglkonsul)) {
				return "-";
			}
			$selisih = strtotime($this->tglrespon) - strtotime($this->tglkonsul);

			return ceil($selisih / 60).(empty($satuan) ? "" : (" ".$satuan));
		}

		if ($tipe == 3) {
			if (empty($this->tgldatang) || empty($this->tglkeluar)) {
				return "-";
			}
			$selisih = strtotime($this->tglkeluar) - strtotime($this->tgldatang);

			return ceil($selisih / 60).(empty($satuan) ? "" : (" ".$satuan));
		}

		return "-";	

	}

}
