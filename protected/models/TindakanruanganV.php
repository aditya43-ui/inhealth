<?php

/**
 * This is the model class for table "tindakanruangan_v".
 *
 * The followings are the available columns in table 'tindakanruangan_v':
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_nama
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $kelaspelayanan_id
 * @property double $harga_tariftindakan
 * @property integer $persendiskon_tind
 * @property double $hargadiskon_tind
 * @property integer $persencyto_tind
 * @property integer $kelompoktindakan_id
 * @property string $kelompoktindakan_nama
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $tindakanmedis_nama
 */
class TindakanruanganV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanruanganV the static model class
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
		return 'tindakanruangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, kategoritindakan_id, kelaspelayanan_id, persendiskon_tind, persencyto_tind, kelompoktindakan_id, komponentarif_id, ruangan_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan, hargadiskon_tind', 'numerical'),
			array('daftartindakan_nama, tindakanmedis_nama', 'length', 'max'=>200),
			array('kategoritindakan_nama', 'length', 'max'=>30),
			array('kelompoktindakan_nama, ruangan_nama', 'length', 'max'=>50),
			array('komponentarif_nama', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftartindakan_id, daftartindakan_nama, kategoritindakan_id, kategoritindakan_nama, kelaspelayanan_id, harga_tariftindakan, persendiskon_tind, hargadiskon_tind, persencyto_tind, kelompoktindakan_id, kelompoktindakan_nama, komponentarif_id, komponentarif_nama, ruangan_id, ruangan_nama, instalasi_id, tindakanmedis_nama', 'safe', 'on'=>'search'),
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
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'kategoritindakan_id' => 'Kategoritindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'harga_tariftindakan' => 'Harga Tariftindakan',
			'persendiskon_tind' => 'Persendiskon Tind',
			'hargadiskon_tind' => 'Hargadiskon Tind',
			'persencyto_tind' => 'Persencyto Tind',
			'kelompoktindakan_id' => 'Kelompoktindakan',
			'kelompoktindakan_nama' => 'Kelompoktindakan Nama',
			'komponentarif_id' => 'Komponentarif',
			'komponentarif_nama' => 'Komponentarif Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'tindakanmedis_nama' => 'Tindakanmedis Nama',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
		$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function searchTindakanAsesmen() {
            $prov = $this->search();
            
            $prov->criteria->group = 'daftartindakan_id, daftartindakan_nama, kategoritindakan_nama, '
                . 'daftartindakan_kode, daftartindakan_nama';
            $prov->criteria->select = $prov->criteria->group;
            
            return $prov;
        }

		public function searchDialog()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->select = '	daftartindakan_id, 
									daftartindakan_nama,
									kategoritindakan_id,
									kategoritindakan_nama,
									kelaspelayanan_id,
									harga_tariftindakan,
									persendiskon_tind,
									hargadiskon_tind,
									persencyto_tind,
									kelompoktindakan_id,
									kelompoktindakan_nama,
									komponentarif_id,
									komponentarif_nama,
									tindakanmedis_nama,
									daftartindakan_kode';
			$criteria->group = $criteria->select;
			$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
			$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
			$criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
			$criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
			$criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
			if(!empty($this->kelaspelayanan_id)) {
				$criteria->addCondition('kelaspelayanan_id='.$this->kelaspelayanan_id);

			}
			$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
			$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
			$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
			$criteria->compare('persencyto_tind',$this->persencyto_tind);
			$criteria->compare('kelompoktindakan_id',$this->kelompoktindakan_id);
			$criteria->compare('LOWER(kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
			$criteria->compare('komponentarif_id',$this->komponentarif_id);
			$criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
			$criteria->compare('ruangan_id',$this->ruangan_id);
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			$criteria->compare('instalasi_id',$this->instalasi_id);
			$criteria->compare('LOWER(tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
			// echo '<pre>';var_dump($this->kelaspelayanan_id);die;
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
}