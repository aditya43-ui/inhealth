<?php

/**
 * This is the model class for table "pencatatandpjpdet_t".
 *
 * The followings are the available columns in table 'pencatatandpjpdet_t':
 * @property integer $pencatatandpjpdet_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmorbiditas_id
 * @property integer $diagnosa_id
 * @property integer $dpjp_id
 * @property string $tglmulai_dpjp
 * @property string $tglberakhir_dpjp
 * @property integer $dpjputama_id
 * @property string $tglmulai_dpjputama
 * @property string $tglberakhir_dpjputama
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property DiagnosaM $diagnosa
 * @property PegawaiM $dpjp
 * @property PegawaiM $dpjputama
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmorbiditasT $pasienmorbiditas
 * @property PendaftaranT $pendaftaran
 */
class PencatatandpjpdetT extends CActiveRecord
{
    public $diagnosa_nama, $dpjp_nama, $dpjputama_nama;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pencatatandpjpdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmorbiditas_id, diagnosa_id, dpjp_id, dpjputama_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('tglmulai_dpjp, tglberakhir_dpjp, tglmulai_dpjputama, tglberakhir_dpjputama, keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pencatatandpjpdet_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmorbiditas_id, diagnosa_id, dpjp_id, tglmulai_dpjp, tglberakhir_dpjp, dpjputama_id, tglmulai_dpjputama, tglberakhir_dpjputama, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
			'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
			'dpjputama' => array(self::BELONGS_TO, 'PegawaiM', 'dpjputama_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmorbiditas' => array(self::BELONGS_TO, 'PasienmorbiditasT', 'pasienmorbiditas_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pencatatandpjpdet_id' => 'Pencatatandpjpdet',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'diagnosa_id' => 'Diagnosa',
			'dpjp_id' => 'Dpjp',
			'tglmulai_dpjp' => 'Tglmulai Dpjp',
			'tglberakhir_dpjp' => 'Tglberakhir Dpjp',
			'dpjputama_id' => 'Dpjputama',
			'tglmulai_dpjputama' => 'Tglmulai Dpjputama',
			'tglberakhir_dpjputama' => 'Tglberakhir Dpjputama',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('pencatatandpjpdet_id',$this->pencatatandpjpdet_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('tglmulai_dpjp',$this->tglmulai_dpjp,true);
		$criteria->compare('tglberakhir_dpjp',$this->tglberakhir_dpjp,true);
		$criteria->compare('dpjputama_id',$this->dpjputama_id);
		$criteria->compare('tglmulai_dpjputama',$this->tglmulai_dpjputama,true);
		$criteria->compare('tglberakhir_dpjputama',$this->tglberakhir_dpjputama,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PencatatandpjpdetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

