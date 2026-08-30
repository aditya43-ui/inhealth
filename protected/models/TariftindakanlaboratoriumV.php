<?php

/**
 * This is the model class for table "tariftindakanlaboratorium_v".
 *
 * The followings are the available columns in table 'tariftindakanlaboratorium_v':
 * @property integer $pemeriksaanlab_id
 * @property string $pemeriksaanlab_nama
 * @property integer $jenispemeriksaanlab_id
 * @property string $jenispemeriksaanlab_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $jenistarif_id
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property integer $komponentarif_id
 * @property string $komponentarif_nama
 * @property double $harga_tariftindakan
 */
class TariftindakanlaboratoriumV extends CActiveRecord
{
        public $jenispemeriksaanlab_kelompok;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanlaboratoriumV the static model class
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
		return 'tariftindakanlaboratorium_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanlab_id, jenispemeriksaanlab_id, instalasi_id, ruangan_id, kelaspelayanan_id, jenistarif_id, penjamin_id, perdatarif_id, komponentarif_id', 'numerical', 'integerOnly'=>true),
			array('harga_tariftindakan', 'numerical'),
			array('pemeriksaanlab_nama', 'length', 'max'=>500),
			array('jenispemeriksaanlab_nama', 'length', 'max'=>30),
			array('instalasi_nama, ruangan_nama, kelaspelayanan_nama, penjamin_nama', 'length', 'max'=>50),
			array('perdanama_sk', 'length', 'max'=>200),
			array('komponentarif_nama', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanlab_id, pemeriksaanlab_nama, jenispemeriksaanlab_id, jenispemeriksaanlab_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, jenistarif_id, penjamin_id, penjamin_nama, perdatarif_id, perdanama_sk, komponentarif_id, komponentarif_nama, harga_tariftindakan', 'safe', 'on'=>'search'),
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
			'pemeriksaanlab_id' => 'Pemeriksaanlab',
			'pemeriksaanlab_nama' => 'Pemeriksaanlab Nama',
			'jenispemeriksaanlab_id' => 'Jenispemeriksaanlab',
			'jenispemeriksaanlab_nama' => 'Jenispemeriksaanlab Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'jenistarif_id' => 'Jenistarif',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'perdatarif_id' => 'Perdatarif',
			'perdanama_sk' => 'Perdanama Sk',
			'komponentarif_id' => 'Komponentarif',
			'komponentarif_nama' => 'Komponentarif Nama',
			'harga_tariftindakan' => 'Harga Tariftindakan',
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

		$criteria->compare('pemeriksaanlab_id',$this->pemeriksaanlab_id);
		$criteria->compare('pemeriksaanlab_nama',$this->pemeriksaanlab_nama,true);
		$criteria->compare('jenispemeriksaanlab_id',$this->jenispemeriksaanlab_id);
		$criteria->compare('jenispemeriksaanlab_nama',$this->jenispemeriksaanlab_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('perdanama_sk',$this->perdanama_sk,true);
		$criteria->compare('komponentarif_id',$this->komponentarif_id);
		$criteria->compare('komponentarif_nama',$this->komponentarif_nama,true);
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchTindakanMikrobiologi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                $jenispemeriksaanlab = array();
                $cekKelompok = JenispemeriksaanlabM::model()->findAllByAttributes(array('jenispemeriksaanlab_kelompok'=>'MIKROBIOLOGI KLINIK'));
                foreach ($cekKelompok as $value):
                    $jenispemeriksaanlab[] = $value->jenispemeriksaanlab_id;
                endforeach;

                $criteria = new CDbCriteria();
                $criteria->select = 'pemeriksaanlab_id, pemeriksaanlab_nama, jenispemeriksaanlab_id, jenispemeriksaanlab_nama';
                $criteria->addInCondition('jenispemeriksaanlab_id', $jenispemeriksaanlab);
		$criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($this->pemeriksaanlab_nama),true);
		$criteria->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($this->jenispemeriksaanlab_nama),true);
                $criteria->group = 'pemeriksaanlab_id, pemeriksaanlab_nama, jenispemeriksaanlab_id, jenispemeriksaanlab_nama';
                $criteria->order = 'jenispemeriksaanlab_nama ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}