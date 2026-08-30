<?php

/**
 * This is the model class for table "pesanperlinensteril_t".
 *
 * The followings are the available columns in table 'pesanperlinensteril_t':
 * @property integer $pesanperlinensteril_id
 * @property integer $ruangan_id
 * @property string $pesanperlinensteril_no
 * @property string $pesanperlinensteril_tgl
 * @property string $pesanperlinensteril_ket
 * @property integer $pegmengetahui_id
 * @property integer $pegpemesan_id
 * @property boolean $iskirimperlinensteril
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PesanperlinensterilT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanperlinensterilT the static model class
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
		return 'pesanperlinensteril_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegmengetahui_id,pegawaimengetahui_nama,ruangan_id, pesanperlinensteril_no, pesanperlinensteril_tgl, pegpemesan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pegmengetahui_id, pegpemesan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pesanperlinensteril_no', 'length', 'max'=>20),
			array('pesanperlinensteril_ket', 'length', 'max'=>500),
			array('iskirimperlinensteril, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanperlinensteril_id, ruangan_id, pesanperlinensteril_no, pesanperlinensteril_tgl, pesanperlinensteril_ket, pegmengetahui_id, pegpemesan_id, iskirimperlinensteril, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
			'pegawaiMemesan'=>array(self::BELONGS_TO,'PegawaiM','pegpemesan_id'),
			'pegawaiMengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanperlinensteril_id' => 'Pesanperlinensteril',
			'ruangan_id' => 'Ruangan',
			'pesanperlinensteril_no' => 'No. Pemesanan',
			'pesanperlinensteril_tgl' => 'Tanggal Pemesanan',
			'pesanperlinensteril_ket' => 'Keterangan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'pegpemesan_id' => 'Pegawai Pemesan',
			'iskirimperlinensteril' => 'Iskirimperlinensteril',
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

		if(!empty($this->pesanperlinensteril_id)){
			$criteria->addCondition('pesanperlinensteril_id = '.$this->pesanperlinensteril_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(pesanperlinensteril_no)',strtolower($this->pesanperlinensteril_no),true);
		$criteria->compare('LOWER(pesanperlinensteril_tgl)',strtolower($this->pesanperlinensteril_tgl),true);
		$criteria->compare('LOWER(pesanperlinensteril_ket)',strtolower($this->pesanperlinensteril_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpemesan_id)){
			$criteria->addCondition('pegpemesan_id = '.$this->pegpemesan_id);
		}
		$criteria->compare('iskirimperlinensteril',$this->iskirimperlinensteril);
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