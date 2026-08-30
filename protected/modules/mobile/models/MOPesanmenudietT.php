<?php

class MOPesanmenudietT extends PesanmenudietT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MOPesanmenudietT the static model class
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
		return 'pesanmenudiet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, jenispesanmenu, nopesanmenu, tglpesanmenu, nama_pemesan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, kirimmenudiet_id, jenisdiet_id, bahandiet_id, totalpesan_org', 'numerical', 'integerOnly'=>true),
			array('jenispesanmenu, nopesanmenu', 'length', 'max'=>50),
			array('adaalergimakanan, nama_pemesan', 'length', 'max'=>100),
			array('keterangan_pesan, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanmenudiet_id, ruangan_id, kirimmenudiet_id, jenisdiet_id, bahandiet_id, jenispesanmenu, nopesanmenu, tglpesanmenu, adaalergimakanan, keterangan_pesan, nama_pemesan, totalpesan_org, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pesanmenupegawaiTs' => array(self::HAS_MANY, 'PesanmenupegawaiT', 'pesanmenudiet_id'),
			'bahandiet' => array(self::BELONGS_TO, 'BahandietM', 'bahandiet_id'),
			'jenisdiet' => array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
			'kirimmenudiet' => array(self::BELONGS_TO, 'KirimmenudietT', 'kirimmenudiet_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'kirimmenudietTs' => array(self::HAS_MANY, 'KirimmenudietT', 'pesanmenudiet_id'),
			'pesanmenudetailTs' => array(self::HAS_MANY, 'PesanmenudetailT', 'pesanmenudiet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanmenudiet_id' => 'Pesanmenudiet',
			'ruangan_id' => 'Ruangan',
			'kirimmenudiet_id' => 'Kirimmenudiet',
			'jenisdiet_id' => 'Jenisdiet',
			'bahandiet_id' => 'Bahandiet',
			'jenispesanmenu' => 'Jenispesanmenu',
			'nopesanmenu' => 'Nopesanmenu',
			'tglpesanmenu' => 'Tglpesanmenu',
			'adaalergimakanan' => 'Adaalergimakanan',
			'keterangan_pesan' => 'Keterangan Pesan',
			'nama_pemesan' => 'Nama Pemesan',
			'totalpesan_org' => 'Totalpesan Org',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('bahandiet_id',$this->bahandiet_id);
		$criteria->compare('LOWER(jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(nopesanmenu)',strtolower($this->nopesanmenu),true);
		$criteria->compare('LOWER(tglpesanmenu)',strtolower($this->tglpesanmenu),true);
		$criteria->compare('LOWER(adaalergimakanan)',strtolower($this->adaalergimakanan),true);
		$criteria->compare('LOWER(keterangan_pesan)',strtolower($this->keterangan_pesan),true);
		$criteria->compare('LOWER(nama_pemesan)',strtolower($this->nama_pemesan),true);
		$criteria->compare('totalpesan_org',$this->totalpesan_org);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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