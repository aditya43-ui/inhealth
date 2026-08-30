<?php

/**
 * This is the model class for table "verifikasitagihan_t".
 *
 * The followings are the available columns in table 'verifikasitagihan_t':
 * @property integer $verifikasitagihan_id
 * @property string $tglverifikasi
 * @property string $noverifikasi
 * @property integer $verifikasioleh_id
 * @property integer $mengetahuioleh_id
 * @property string $keteranganverifikasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property TindakanpelayananT[] $tindakanpelayananTs
 */
class VerifikasitagihanT extends CActiveRecord
{
        public $notemp;
        public $detail;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasitagihanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'verifikasitagihan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keteranganverifikasi, tglverifikasi, noverifikasi, verifikasioleh_id, create_time, create_loginpemakai_id', 'required'),
			array('verifikasioleh_id, mengetahuioleh_id', 'numerical', 'integerOnly'=>true),
			array('noverifikasi', 'length', 'max'=>50),
			array('update_time, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasitagihan_id, tglverifikasi, noverifikasi, verifikasioleh_id, mengetahuioleh_id, keteranganverifikasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'obatalkespasienTs' => array(self::HAS_MANY, 'ObatalkespasienT', 'verifikasitagihan_id'),
			'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'verifikasitagihan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verifikasitagihan_id' => 'Verifikasitagihan ID',
			'tglverifikasi' => 'Tanggal Verifikasi',
			'noverifikasi' => 'No. Verifikasi',
			'verifikasioleh_id' => 'Verifikasi Oleh',
			'mengetahuioleh_id' => 'Mengetahui',
			'keteranganverifikasi' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('verifikasitagihan_id',$this->verifikasitagihan_id);
		$criteria->compare('tglverifikasi',$this->tglverifikasi,true);
		$criteria->compare('noverifikasi',$this->noverifikasi,true);
		$criteria->compare('verifikasioleh_id',$this->verifikasioleh_id);
		$criteria->compare('mengetahuioleh_id',$this->mengetahuioleh_id);
		$criteria->compare('keteranganverifikasi',$this->keteranganverifikasi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPegawaiItems($ruangan=null) {
            if ($ruangan != null){
                return PegawairuanganV::model()->findAll("pegawai_aktif = TRUE AND ruangan_id = ".$ruangan." ORDER BY nama_pegawai ASC");
            }else{
                return PegawaiM::model()->findAll('pegawai_aktif=TRUE ORDER BY nama_pegawai');
            }
    }
    
    public function loadDetail() {
        $this->detail = VerifikasitagihantindakanR::model()->findAllByAttributes(array(
            'verifikasitagihan_id'=>$this->verifikasitagihan_id
        ));
        
        foreach ($this->detail as $idx=>$item) {
            $this->detail[$idx]->loadKomponen();
        }
    }
    
    public function getModel($id) {
        $model = self::model()->findByPk($id);
        $model->loadDetail();
        
        
        return $model;
    }
}