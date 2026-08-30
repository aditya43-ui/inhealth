<?php

/**
 * This is the model class for table "mutasioaruangan_t".
 *
 * The followings are the available columns in table 'mutasioaruangan_t':
 * @property integer $mutasioaruangan_id
 * @property integer $pesanobatalkes_id
 * @property integer $terimamutasi_id
 * @property string $tglmutasioa
 * @property string $nomutasioa
 * @property integer $ruanganasal_id
 * @property integer $ruangantujuan_id
 * @property string $keteranganmutasi
 * @property double $totalharganettomutasi
 * @property double $totalhargajual
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawaimutasi_id
 * @property integer $pegawaimengetahui_id
 *
 * The followings are the available model relations:
 * @property TerimamutasiT[] $terimamutasiTs
 * @property PesanobatalkesT[] $pesanobatalkesTs
 * @property MutasioadetailT[] $mutasioadetailTs
 * @property PesanobatalkesT $pesanobatalkes
 * @property TerimamutasiT $terimamutasi
 * @property RuanganM $ruanganasal
 * @property RuanganM $ruangantujuan
 * @property PegawaiM $pegawaimutasi
 * @property PegawaiM $pegawaimengetahui
 */
class MutasioaruanganT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasioaruanganT the static model class
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
		return 'mutasioaruangan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglmutasioa, nomutasioa, ruanganasal_id, ruangantujuan_id, totalharganettomutasi, totalhargajual, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pesanobatalkes_id, terimamutasi_id, ruanganasal_id, ruangantujuan_id, pegawaimutasi_id, pegawaimengetahui_id', 'numerical', 'integerOnly'=>true),
			array('totalharganettomutasi, totalhargajual', 'numerical'),
			array('nomutasioa', 'length', 'max'=>20),
			array('keteranganmutasi, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mutasioaruangan_id, pesanobatalkes_id, terimamutasi_id, tglmutasioa, nomutasioa, ruanganasal_id, ruangantujuan_id, keteranganmutasi, totalharganettomutasi, totalhargajual, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaimutasi_id, pegawaimengetahui_id', 'safe', 'on'=>'search'),
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
			'terimamutasiTs' => array(self::HAS_MANY, 'TerimamutasiT', 'mutasioaruangan_id'),
			'pesanobatalkesTs' => array(self::HAS_MANY, 'PesanobatalkesT', 'mutasioaruangan_id'),
			'mutasioadetailTs' => array(self::HAS_MANY, 'MutasioadetailT', 'mutasioaruangan_id'),
			'pesanobatalkes' => array(self::BELONGS_TO, 'PesanobatalkesT', 'pesanobatalkes_id'),
			'terimamutasi' => array(self::BELONGS_TO, 'TerimamutasiT', 'terimamutasi_id'),
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
			'pegawaimutasi' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimutasi_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mutasioaruangan_id' => 'Mutasi Obat Alkes',
			'pesanobatalkes_id' => 'Pesan Obat Alkes',
			'terimamutasi_id' => 'Terima Mutasi',
			'tglmutasioa' => 'Tanggal Mutasi',
			'nomutasioa' => 'No. Mutasi',
			'ruanganasal_id' => 'Ruangan Asal',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'keteranganmutasi' => 'Keterangan Mutasi',
			'totalharganettomutasi' => 'Total Harga Netto',
			'totalhargajual' => 'Total Harga Jual',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawaimutasi_id' => 'Pegawai Mutasi',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
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

		$criteria->compare('mutasioaruangan_id',$this->mutasioaruangan_id);
		$criteria->compare('pesanobatalkes_id',$this->pesanobatalkes_id);
		$criteria->compare('terimamutasi_id',$this->terimamutasi_id);
		$criteria->compare('LOWER(tglmutasioa)',strtolower($this->tglmutasioa),true);
		$criteria->compare('LOWER(nomutasioa)',strtolower($this->nomutasioa),true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('LOWER(keteranganmutasi)',strtolower($this->keteranganmutasi),true);
		$criteria->compare('totalharganettomutasi',$this->totalharganettomutasi);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('pegawaimutasi_id',$this->pegawaimutasi_id);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);

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