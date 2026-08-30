<?php

/**
 * This is the model class for table "rencanatindakan_t".
 *
 * The followings are the available columns in table 'rencanatindakan_t':
 * @property integer $rencanatindakan_id
 * @property integer $ruangan_id
 * @property integer $daftartindakan_id
 * @property integer $verifrenctindakan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $tglperencanaan
 * @property string $tglrencanatindakan
 * @property double $tarifsatuan
 * @property integer $qty_rentindakan
 * @property double $tarif_tindakan
 * @property boolean $iscyto
 * @property string $satuanrenctinda
 * @property string $keteranganrentinda
 * @property integer $ygmerencanakan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pegawai_id
 */
class RencanatindakanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanatindakanT the static model class
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
		return 'rencanatindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, tglperencanaan, tglrencanatindakan, tarifsatuan, tarif_tindakan, ygmerencanakan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, daftartindakan_id, verifrenctindakan_id, pasien_id, pendaftaran_id, qty_rentindakan, ygmerencanakan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('tarifsatuan, tarif_tindakan', 'numerical'),
			array('satuanrenctinda', 'length', 'max'=>10),
			array('iscyto, keteranganrentinda, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanatindakan_id, ruangan_id, daftartindakan_id, verifrenctindakan_id, pasien_id, pendaftaran_id, tglperencanaan, tglrencanatindakan, tarifsatuan, qty_rentindakan, tarif_tindakan, iscyto, satuanrenctinda, keteranganrentinda, ygmerencanakan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawai_id', 'safe', 'on'=>'search'),
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
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
			'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanatindakan_id' => 'Rencana Tindakan',
			'ruangan_id' => 'Ruangan',
			'daftartindakan_id' => 'Daftar TIndakan',
			'verifrenctindakan_id' => 'Verifikasi Rencana Tindakan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'tglperencanaan' => 'Tanggal Perencanaan',
			'tglrencanatindakan' => 'Tanggal Rencana Tindakan',
			'tarifsatuan' => 'Tarif Satuan',
			'qty_rentindakan' => 'Jumlah Tindakan',
			'tarif_tindakan' => 'Nominal Tarif',
			'iscyto' => 'Is Cyto',
			'satuanrenctinda' => 'Satuan Rencana Tindakan',
			'keteranganrentinda' => 'Keterangan Tindakan',
			'ygmerencanakan_id' => 'Yang Merencanakan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawai_id' => 'Pegawai',
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

		if(!empty($this->rencanatindakan_id)){
			$criteria->addCondition('rencanatindakan_id = '.$this->rencanatindakan_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		if(!empty($this->verifrenctindakan_id)){
			$criteria->addCondition('verifrenctindakan_id = '.$this->verifrenctindakan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(tglperencanaan)',strtolower($this->tglperencanaan),true);
		$criteria->compare('LOWER(tglrencanatindakan)',strtolower($this->tglrencanatindakan),true);
		$criteria->compare('tarifsatuan',$this->tarifsatuan);
		if(!empty($this->qty_rentindakan)){
			$criteria->addCondition('qty_rentindakan = '.$this->qty_rentindakan);
		}
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('iscyto',$this->iscyto);
		$criteria->compare('LOWER(satuanrenctinda)',strtolower($this->satuanrenctinda),true);
		$criteria->compare('LOWER(keteranganrentinda)',strtolower($this->keteranganrentinda),true);
		if(!empty($this->ygmerencanakan_id)){
			$criteria->addCondition('ygmerencanakan_id = '.$this->ygmerencanakan_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}

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