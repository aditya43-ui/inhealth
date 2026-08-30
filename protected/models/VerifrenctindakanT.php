<?php

/**
 * This is the model class for table "verifrenctindakan_t".
 *
 * The followings are the available columns in table 'verifrenctindakan_t':
 * @property integer $verifrenctindakan_id
 * @property string $tglverifikasirenc
 * @property string $noverifikasi_renc
 * @property string $keterangan_verifrenc
 * @property integer $petugas_verif_id
 * @property integer $mengetahui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class VerifrenctindakanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifrenctindakanT the static model class
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
		return 'verifrenctindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglverifikasirenc, noverifikasi_renc, petugas_verif_id, mengetahui_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('petugas_verif_id, mengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('noverifikasi_renc', 'length', 'max'=>50),
			array('keterangan_verifrenc, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifrenctindakan_id, tglverifikasirenc, noverifikasi_renc, keterangan_verifrenc, petugas_verif_id, mengetahui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'petugas'=>array(self::BELONGS_TO,'PegawaiM','petugas_verif_id'),
			'mengetahui'=>array(self::BELONGS_TO,'PegawaiM','mengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verifrenctindakan_id' => 'Verifikasi Rencana Tindakan',
			'tglverifikasirenc' => 'Tanggal Verifikasi',
			'noverifikasi_renc' => 'No. Verifikasi',
			'keterangan_verifrenc' => 'Keterangan',
			'petugas_verif_id' => 'Petugas Verifikasi',
			'mengetahui_id' => 'Mengetahui',
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

		if(!empty($this->verifrenctindakan_id)){
			$criteria->addCondition('verifrenctindakan_id = '.$this->verifrenctindakan_id);
		}
		$criteria->compare('LOWER(tglverifikasirenc)',strtolower($this->tglverifikasirenc),true);
		$criteria->compare('LOWER(noverifikasi_renc)',strtolower($this->noverifikasi_renc),true);
		$criteria->compare('LOWER(keterangan_verifrenc)',strtolower($this->keterangan_verifrenc),true);
		if(!empty($this->petugas_verif_id)){
			$criteria->addCondition('petugas_verif_id = '.$this->petugas_verif_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
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