<?php

/**
 * This is the model class for table "pembersihan_t".
 *
 * The followings are the available columns in table 'pembersihan_t':
 * @property integer $pembersihan_id
 * @property integer $dekontaminasidetail_id
 * @property string $statusproses
 * @property string $programpembersihan
 * @property integer $namamesin_id
 * @property string $siklusmesin
 * @property string $mulaipembersiha
 * @property string $selesaipembersihan
 * @property boolean $iscuciulang
 * @property integer $cuciulang_id
 * @property string $ind_visual
 * @property string $ind_kimia
 * @property string $ind_protein
 * @property string $ind_character
 * @property integer $petugaspemb_id
 * @property string $statuspembersihan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property DekontaminasidetailT $dekontaminasidetail
 * @property InspeksiinstrumenT[] $inspeksiinstrumenTs
 */
class PembersihanT extends CActiveRecord
{
    public $tgl_awal,$tgl_akhir,$checklist;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembersihanT the static model class
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
		return 'pembersihan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dekontaminasi_id, statusproses, petugaspemb_id, statuspembersihan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('dekontaminasi_id, namamesin_id, cuciulang_id, petugaspemb_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('statusproses, programpembersihan, statuspembersihan', 'length', 'max'=>50),
			array('siklusmesin', 'length', 'max'=>100),
			array('ind_visual, ind_kimia, ind_protein, ind_character', 'length', 'max'=>300),
			array('tgl_pembersihan,dekontaminasi_id,mulaipembersiha, selesaipembersihan, iscuciulang, update_time, programpembersihan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_pembersihan,pembersihan_id, dekontaminasi_id, statusproses, programpembersihan, namamesin_id, siklusmesin, mulaipembersiha, selesaipembersihan, iscuciulang, cuciulang_id, ind_visual, ind_kimia, ind_protein, ind_character, petugaspemb_id, statuspembersihan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'dekontaminasi' => array(self::BELONGS_TO, 'DekontaminasiT', 'dekontaminasi_id'),
			'inspeksiinstrumenTs' => array(self::HAS_MANY, 'InspeksiinstrumenT', 'pembersihan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembersihan_id' => 'Pembersihan',
			'dekontaminasi_id' => 'Dekontaminasi',
			'statusproses' => 'Statusproses',
			'programpembersihan' => 'Programpembersihan',
			'namamesin_id' => 'Namamesin',
			'siklusmesin' => 'Siklusmesin',
			'mulaipembersiha' => 'Mulaipembersiha',
			'selesaipembersihan' => 'Selesaipembersihan',
			'iscuciulang' => 'Iscuciulang',
			'cuciulang_id' => 'Cuciulang',
			'ind_visual' => 'Ind Visual',
			'ind_kimia' => 'Ind Kimia',
			'ind_protein' => 'Ind Protein',
			'ind_character' => 'Ind Character',
			'petugaspemb_id' => 'Petugaspemb',
			'statuspembersihan' => 'Statuspembersihan',
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

		if(!empty($this->pembersihan_id)){
			$criteria->addCondition('pembersihan_id = '.$this->pembersihan_id);
		}
		if(!empty($this->dekontaminasi_id)){
			$criteria->addCondition('dekontaminasi_id = '.$this->dekontaminasi_id);
		}
		$criteria->compare('LOWER(statusproses)',strtolower($this->statusproses),true);
		$criteria->compare('LOWER(programpembersihan)',strtolower($this->programpembersihan),true);
		if(!empty($this->namamesin_id)){
			$criteria->addCondition('namamesin_id = '.$this->namamesin_id);
		}
		$criteria->compare('LOWER(siklusmesin)',strtolower($this->siklusmesin),true);
		$criteria->compare('LOWER(mulaipembersiha)',strtolower($this->mulaipembersiha),true);
		$criteria->compare('LOWER(selesaipembersihan)',strtolower($this->selesaipembersihan),true);
		$criteria->compare('iscuciulang',$this->iscuciulang);
		if(!empty($this->cuciulang_id)){
			$criteria->addCondition('cuciulang_id = '.$this->cuciulang_id);
		}
		$criteria->compare('LOWER(ind_visual)',strtolower($this->ind_visual),true);
		$criteria->compare('LOWER(ind_kimia)',strtolower($this->ind_kimia),true);
		$criteria->compare('LOWER(ind_protein)',strtolower($this->ind_protein),true);
		$criteria->compare('LOWER(ind_character)',strtolower($this->ind_character),true);
		if(!empty($this->petugaspemb_id)){
			$criteria->addCondition('petugaspemb_id = '.$this->petugaspemb_id);
		}
		$criteria->compare('LOWER(statuspembersihan)',strtolower($this->statuspembersihan),true);
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