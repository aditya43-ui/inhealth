<?php

/**
 * This is the model class for table "invkalibarasi_t".
 *
 * The followings are the available columns in table 'invkalibarasi_t':
 * @property integer $invkalibrasi_id
 * @property integer $invperalatan_id
 * @property string $tglkalibrasi
 * @property string $berlaku_sdtgl
 * @property string $nokalibrasi
 * @property integer $ruangan_id
 * @property integer $teknisikalibrasi_id
 * @property string $invkalibrasi_ket
 * @property boolean $islaikpakai
 * @property string $lampiran_berkas
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TeknisiperalatanM $teknisikalibrasi
 * @property InvperalatanT $invperalatan
 */
class InvkalibarasiT extends CActiveRecord
{
    public $invperalatan_kode, $lokasiaset_namalokasi;
    public $invperalatan_namabrg;
    public $tgl_awal,$tgl_akhir,$invperalatan_nama,$no_aset;
    public $vendor_nama, $pegawai_nama;
    public $temp_lampiran_berkas, $peralatan_noseri;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvkalibarasiT the static model class
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
		return 'invkalibarasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatan_id, tglkalibrasi, nokalibrasi, islaikpakai, create_time, create_loginpemakai_id, create_ruangan', 'required'),			
			array('invperalatan_id, ruangan_id, supplier_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),

			array('nokalibrasi', 'length', 'max'=>50),
			array('pegpelaksana_id,berlaku_sdtgl, invkalibrasi_ket, lampiran_berkas, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.			
			array('invkalibrasi_id, invperalatan_id, tglkalibrasi, berlaku_sdtgl, nokalibrasi, ruangan_id, supplier_id, invkalibrasi_ket, islaikpakai, lampiran_berkas, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
                    'pegpelaksana'=> array(self::BELONGS_TO, 'PegawaiM', 'pegpelaksana_id'),
                    'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
                    'lokasi' => array(self::BELONGS_TO, 'LokasiasetM', 'lokasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invkalibrasi_id' => 'Invkalibrasi',
			'invperalatan_id' => 'Invperalatan',
			'tglkalibrasi' => 'Tglkalibrasi',
			'berlaku_sdtgl' => 'Berlaku Sdtgl',
			'nokalibrasi' => 'Nokalibrasi',
			'ruangan_id' => 'Ruangan',			
			'supplier_id' => 'supplier_id',
			'invkalibrasi_ket' => 'Invkalibrasi Ket',
			'islaikpakai' => 'Islaikpakai',
			'lampiran_berkas' => 'Lampiran Berkas',
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

		if(!empty($this->invkalibrasi_id)){
			$criteria->addCondition('invkalibrasi_id = '.$this->invkalibrasi_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		$criteria->compare('LOWER(tglkalibrasi)',strtolower($this->tglkalibrasi),true);
		$criteria->compare('LOWER(berlaku_sdtgl)',strtolower($this->berlaku_sdtgl),true);
		$criteria->compare('LOWER(nokalibrasi)',strtolower($this->nokalibrasi),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}

		if(!empty($this->teknisikalibrasi_id)){
			$criteria->addCondition('teknisikalibrasi_id = '.$this->teknisikalibrasi_id);
        }
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(invkalibrasi_ket)',strtolower($this->invkalibrasi_ket),true);
		$criteria->compare('islaikpakai',$this->islaikpakai);
		$criteria->compare('LOWER(lampiran_berkas)',strtolower($this->lampiran_berkas),true);
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
        public function searchdata()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria= new CDbCriteria();
            if(!empty($this->invperalatan_id)){
                    $criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
            }
            
            if(!empty($this->ruangan_id)){
                    $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
            }
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
