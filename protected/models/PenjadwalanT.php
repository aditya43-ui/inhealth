<?php

/**
 * This is the model class for table "penjadwalan_t".
 *
 * The followings are the available columns in table 'penjadwalan_t':
 * @property integer $penjadwalan_id
 * @property string $tglbuatjadwal
 * @property string $no_pembuatanjadwal
 * @property string $periodebuatjadwal
 * @property string $sampaidengan
 * @property string $keterangan_penjadwalan
 * @property integer $mengetahui_id
 * @property string $tglmengetahui
 * @property integer $menyetujiu_id
 * @property string $tglmenyetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenjadwalanT extends CActiveRecord
{
	public $tglawaltemp;
	public $tglakhirtemp;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenjadwalanT the static model class
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
		return 'penjadwalan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglbuatjadwal, no_pembuatanjadwal, periodebuatjadwal, sampaidengan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('mengetahui_id, menyetujiu_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('no_pembuatanjadwal', 'length', 'max'=>100),
			array('keterangan_penjadwalan, tglmengetahui, tglmenyetujui, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penjadwalan_id, tglbuatjadwal, no_pembuatanjadwal, periodebuatjadwal, sampaidengan, keterangan_penjadwalan, mengetahui_id, tglmengetahui, menyetujiu_id, tglmenyetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'createRuanganNama' => array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penjadwalan_id' => 'Penjadwalan',
			'tglbuatjadwal' => 'Tanggal Buat Jadwal',
			'no_pembuatanjadwal' => 'No. Pembuatan Jadwal',
			'periodebuatjadwal' => 'Periode Penjadwalan',
			'sampaidengan' => 'Sampai Dengan',
			'keterangan_penjadwalan' => 'Keterangan Penjadwalan',
			'mengetahui_id' => 'Mengetahui',
			'tglmengetahui' => 'Tanggal Mengetahui',
			'menyetujiu_id' => 'Menyetujui',
			'tglmenyetujui' => 'Tanggal Menyetujui',
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

		if(!empty($this->penjadwalan_id)){
			$criteria->addCondition('penjadwalan_id = '.$this->penjadwalan_id);
		}
		$criteria->compare('LOWER(tglbuatjadwal)',strtolower($this->tglbuatjadwal),true);
		$criteria->compare('LOWER(no_pembuatanjadwal)',strtolower($this->no_pembuatanjadwal),true);
		$criteria->compare('LOWER(periodebuatjadwal)',strtolower($this->periodebuatjadwal),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('LOWER(keterangan_penjadwalan)',strtolower($this->keterangan_penjadwalan),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(tglmengetahui)',strtolower($this->tglmengetahui),true);
		if(!empty($this->menyetujiu_id)){
			$criteria->addCondition('menyetujiu_id = '.$this->menyetujiu_id);
		}
		$criteria->compare('LOWER(tglmenyetujui)',strtolower($this->tglmenyetujui),true);
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