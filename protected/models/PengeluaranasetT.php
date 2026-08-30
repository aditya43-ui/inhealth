<?php

/**
 * This is the model class for table "pengeluaranaset_t".
 *
 * The followings are the available columns in table 'pengeluaranaset_t':
 * @property integer $pengeluaranaset_id
 * @property string $tglpengeluaranaset
 * @property string $nopengeluaranaset
 * @property string $kd_lokasi_kode
 * @property string $lokasiaset_kode
 * @property string $lokasipenerima_kode
 * @property string $penerimaaset
 * @property string $jenisperuntukan
 * @property string $no_suratperintah
 * @property string $tglsuratperintah
 * @property string $tglpenyerahan
 * @property string $alasan_pengeluaran
 * @property integer $pegpengeluaran_id
 * @property integer $pegmengetahui_id
 * @property boolean $is_insert_smb
 * @property integer $ruangan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PengeluaranasetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengeluaranasetT the static model class
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
		return 'pengeluaranaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpengeluaranaset, nopengeluaranaset, kd_lokasi_kode, lokasiaset_kode, lokasipenerima_kode, penerimaaset, jenisperuntukan, pegpengeluaran_id, pegmengetahui_id, ruangan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegpengeluaran_id, pegmengetahui_id, ruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopengeluaranaset, kd_lokasi_kode, lokasiaset_kode, lokasipenerima_kode, jenisperuntukan, no_suratperintah', 'length', 'max'=>50),
			array('penerimaaset', 'length', 'max'=>100),
			array('tglpenyerahan, alasan_pengeluaran, is_insert_smb, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengeluaranaset_id, tglpengeluaranaset, nopengeluaranaset, kd_lokasi_kode, lokasiaset_kode, lokasipenerima_kode, penerimaaset, jenisperuntukan, no_suratperintah, tglsuratperintah, tglpenyerahan, alasan_pengeluaran, pegpengeluaran_id, pegmengetahui_id, is_insert_smb, ruangan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengeluaranaset_id' => 'Pengeluaranaset',
			'tglpengeluaranaset' => 'Tglpengeluaranaset',
			'nopengeluaranaset' => 'Nopengeluaranaset',
			'kd_lokasi_kode' => 'Kd Lokasi Kode',
			'lokasiaset_kode' => 'Lokasiaset Kode',
			'lokasipenerima_kode' => 'Lokasipenerima Kode',
			'penerimaaset' => 'Penerimaaset',
			'jenisperuntukan' => 'Jenisperuntukan',
			'no_suratperintah' => 'No Suratperintah',
			'tglsuratperintah' => 'Tglsuratperintah',
			'tglpenyerahan' => 'Tglpenyerahan',
			'alasan_pengeluaran' => 'Alasan Pengeluaran',
			'pegpengeluaran_id' => 'Pegpengeluaran',
			'pegmengetahui_id' => 'Pegmengetahui',
			'is_insert_smb' => 'Is Insert Smb',
			'ruangan_id' => 'Ruangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->pengeluaranaset_id)){
			$criteria->addCondition('pengeluaranaset_id = '.$this->pengeluaranaset_id);
		}
		$criteria->compare('LOWER(tglpengeluaranaset)',strtolower($this->tglpengeluaranaset),true);
		$criteria->compare('LOWER(nopengeluaranaset)',strtolower($this->nopengeluaranaset),true);
		$criteria->compare('LOWER(kd_lokasi_kode)',strtolower($this->kd_lokasi_kode),true);
		$criteria->compare('LOWER(lokasiaset_kode)',strtolower($this->lokasiaset_kode),true);
		$criteria->compare('LOWER(lokasipenerima_kode)',strtolower($this->lokasipenerima_kode),true);
		$criteria->compare('LOWER(penerimaaset)',strtolower($this->penerimaaset),true);
		$criteria->compare('LOWER(jenisperuntukan)',strtolower($this->jenisperuntukan),true);
		$criteria->compare('LOWER(no_suratperintah)',strtolower($this->no_suratperintah),true);
		$criteria->compare('LOWER(tglsuratperintah)',strtolower($this->tglsuratperintah),true);
		$criteria->compare('LOWER(tglpenyerahan)',strtolower($this->tglpenyerahan),true);
		$criteria->compare('LOWER(alasan_pengeluaran)',strtolower($this->alasan_pengeluaran),true);
		if(!empty($this->pegpengeluaran_id)){
			$criteria->addCondition('pegpengeluaran_id = '.$this->pegpengeluaran_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		$criteria->compare('is_insert_smb',$this->is_insert_smb);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
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