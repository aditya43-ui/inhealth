<?php

/**
 * This is the model class for table "rencanakebfarmasi_t".
 *
 * The followings are the available columns in table 'rencanakebfarmasi_t':
 * @property integer $rencanakebfarmasi_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $otorisasipimpinan_id
 * @property integer $otorisasikeuangan_id
 * @property string $tglperencanaan
 * @property string $noperencnaan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $statusrencana
 * @property string $tglmengetahui
 * @property string $tglmenyetujui
 * @property integer $jmlwaktupemakaian
 * @property integer $leadtime_lt
 * @property string $alasan_statusrencana
 *
 * The followings are the available model relations:
 * @property OtorisasikeuanganT[] $otorisasikeuanganTs
 * @property OtorisasipimpinanT[] $otorisasipimpinanTs
 * @property PermintaanpembelianT[] $permintaanpembelianTs
 * @property RencdetailkebT[] $rencdetailkebTs
 * @property PermintaanpenawaranT[] $permintaanpenawaranTs
 * @property OtorisasipimpinanT $otorisasipimpinan
 * @property OtorisasikeuanganT $otorisasikeuangan
 * @property PegawaiM $pegawai
 * @property RuanganM $ruangan
 * @property PegawaiM $pegawaimengetahui
 * @property PegawaiM $pegawaimenyetujui
 */
class RencanakebfarmasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanakebfarmasiT the static model class
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
		return 'rencanakebfarmasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pegawaimenyetujui_id, ruangan_id, tglperencanaan, noperencnaan, create_time, create_loginpemakai_id, create_ruangan, sumberdana_id', 'required'),
			array('ruangan_id, pegawai_id, otorisasipimpinan_id, otorisasikeuangan_id, pegawaimengetahui_id, pegawaimenyetujui_id, jmlwaktupemakaian, leadtime_lt, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('noperencnaan', 'length', 'max'=>50),
			array('statusrencana', 'length', 'max'=>20),
			array('update_time, update_loginpemakai_id, tglmengetahui, tglmenyetujui, alasan_statusrencana, sumberdana_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanakebfarmasi_id, ruangan_id, pegawai_id, otorisasipimpinan_id, otorisasikeuangan_id, tglperencanaan, noperencnaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaimengetahui_id, pegawaimenyetujui_id, statusrencana, tglmengetahui, tglmenyetujui, jmlwaktupemakaian, leadtime_lt, alasan_statusrencana, sumberdana_id', 'safe', 'on'=>'search'),
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
			'otorisasikeuanganTs' => array(self::HAS_MANY, 'OtorisasikeuanganT', 'rencanakebfarmasi_id'),
			'otorisasipimpinanTs' => array(self::HAS_MANY, 'OtorisasipimpinanT', 'rencanakebfarmasi_id'),
			'permintaanpembelianTs' => array(self::HAS_MANY, 'PermintaanpembelianT', 'rencanakebfarmasi_id'),
			'rencdetailkebTs' => array(self::HAS_MANY, 'RencdetailkebT', 'rencanakebfarmasi_id'),
			'permintaanpenawaranTs' => array(self::HAS_MANY, 'PermintaanpenawaranT', 'rencanakebfarmasi_id'),
			'otorisasipimpinan' => array(self::BELONGS_TO, 'OtorisasipimpinanT', 'otorisasipimpinan_id'),
			'otorisasikeuangan' => array(self::BELONGS_TO, 'OtorisasikeuanganT', 'otorisasikeuangan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
                    'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanakebfarmasi_id' => 'ID',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai Gudang',
			'otorisasipimpinan_id' => 'Otorisasi Pimpinan',
			'otorisasikeuangan_id' => 'Otorisasi Keuangan',
			'tglperencanaan' => 'Tanggal Perencanaan',
			'noperencnaan' => 'No. Perencanaan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'statusrencana' => 'Status Rencana',
			'tglmengetahui' => 'Tanggal Mengetahui',
			'tglmenyetujui' => 'Tanggal Menyetujui',
			'jmlwaktupemakaian' => 'Jumlah Waktu Pemakaian',
			'leadtime_lt' => 'Lead Time',
			'alasan_statusrencana' => 'Alasan Status Rencana',
                    'sumberdana_id' => 'Sumber Dana',
                    
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rencanakebfarmasi_id)){
			$criteria->addCondition('rencanakebfarmasi_id = '.$this->rencanakebfarmasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->otorisasipimpinan_id)){
			$criteria->addCondition('otorisasipimpinan_id = '.$this->otorisasipimpinan_id);
		}
		if(!empty($this->otorisasikeuangan_id)){
			$criteria->addCondition('otorisasikeuangan_id = '.$this->otorisasikeuangan_id);
		}
		$criteria->compare('LOWER(tglperencanaan)',strtolower($this->tglperencanaan),true);
		$criteria->compare('LOWER(noperencnaan)',strtolower($this->noperencnaan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
		}
		$criteria->compare('LOWER(statusrencana)',strtolower($this->statusrencana),true);
		$criteria->compare('LOWER(tglmengetahui)',strtolower($this->tglmengetahui),true);
		$criteria->compare('LOWER(tglmenyetujui)',strtolower($this->tglmenyetujui),true);
		if(!empty($this->jmlwaktupemakaian)){
			$criteria->addCondition('jmlwaktupemakaian = '.$this->jmlwaktupemakaian);
		}
		if(!empty($this->leadtime_lt)){
			$criteria->addCondition('leadtime_lt = '.$this->leadtime_lt);
		}
		$criteria->compare('LOWER(alasan_statusrencana)',strtolower($this->alasan_statusrencana),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}