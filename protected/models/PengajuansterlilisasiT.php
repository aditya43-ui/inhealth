<?php

/**
 * This is the model class for table "pengajuansterlilisasi_t".
 *
 * The followings are the available columns in table 'pengajuansterlilisasi_t':
 * @property integer $pengajuansterlilisasi_id
 * @property integer $ruangan_id
 * @property string $pengajuansterlilisasi_no
 * @property string $pengajuansterlilisasi_tgl
 * @property string $pengajuansterlilisasi_ket
 * @property integer $pegmengetahui_id
 * @property integer $pegpengajuan_id
 * @property boolean $issterilisasiperalatan
 * @property boolean $issudahditerima
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PengajuansterlilisasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuansterlilisasiT the static model class
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
		return 'pengajuansterlilisasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pengajuansterlilisasi_no, pengajuansterlilisasi_tgl, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pegmengetahui_id, pegpengajuan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pengajuansterlilisasi_no', 'length', 'max'=>20),
			array('pengajuansterlilisasi_ket, issudahditerima, create_time, update_time, issterilisasiperalatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuansterlilisasi_id, ruangan_id, pengajuansterlilisasi_no, pengajuansterlilisasi_tgl, pengajuansterlilisasi_ket, pegmengetahui_id, pegpengajuan_id, issterilisasiperalatan, issudahditerima, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
            'pegawaiMengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
            'pegawaiMengajukan' => array(self::BELONGS_TO, 'PegawaiM', 'pegpengajuan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuansterlilisasi_id' => 'Pengajuan',
			'ruangan_id' => 'Ruangan',
			'pengajuansterlilisasi_no' => 'No. Pengajuan',
			'pengajuansterlilisasi_tgl' => 'Tanggal Pengajuan',
			'pengajuansterlilisasi_ket' => 'Keterangan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'pegpengajuan_id' => 'Pegawai yang Mengajukan',
			'issterilisasiperalatan' => 'Issterilisasiperalatan',
			'issudahditerima' => 'Issudahditerima',
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

		if(!empty($this->pengajuansterlilisasi_id)){
			$criteria->addCondition('pengajuansterlilisasi_id = '.$this->pengajuansterlilisasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(pengajuansterlilisasi_no)',strtolower($this->pengajuansterlilisasi_no),true);
		$criteria->compare('LOWER(pengajuansterlilisasi_tgl)',strtolower($this->pengajuansterlilisasi_tgl),true);
		$criteria->compare('LOWER(pengajuansterlilisasi_ket)',strtolower($this->pengajuansterlilisasi_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpengajuan_id)){
			$criteria->addCondition('pegpengajuan_id = '.$this->pegpengajuan_id);
		}
		$criteria->compare('issterilisasiperalatan',$this->issterilisasiperalatan);
		$criteria->compare('issudahditerima',$this->issudahditerima);
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