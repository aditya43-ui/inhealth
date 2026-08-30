<?php

/**
 * This is the model class for table "penyusutanaset_t".
 *
 * The followings are the available columns in table 'penyusutanaset_t':
 * @property integer $penyusutanaset_id
 * @property string $tgl_penyusutan
 * @property string $no_penyusutan
 * @property integer $barang_id
 * @property double $hargaperolehan
 * @property double $residu
 * @property double $umurekonomis
 * @property double $totalpenyusutan
 * @property integer $invgedung_id
 * @property integer $invjalan_id
 * @property integer $invperalatan_id
 * @property integer $invtanah_id
 * @property integer $invasetlain_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BarangM $barang
 * @property InvgedungT $invgedung
 * @property InvasetlainT $invasetlain
 * @property InvjalanT $invjalan
 * @property InvtanahT $invtanah
 * @property InvperalatanT $invperalatan
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 * @property PenyusutanasetdetailT[] $penyusutanasetdetailTs
 * @property JurnalrekeningT[] $jurnalrekeningTs
 */
class PenyusutanasetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyusutanasetT the static model class
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
		return 'penyusutanaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('barang_id, invgedung_id, invjalan_id, invperalatan_id, invtanah_id, invasetlain_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('hargaperolehan, residu, umurekonomis, totalpenyusutan', 'numerical'),
			array('no_penyusutan', 'length', 'max'=>25),
			array('tgl_penyusutan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyusutanaset_id, tgl_penyusutan, no_penyusutan, barang_id, hargaperolehan, residu, umurekonomis, totalpenyusutan, invgedung_id, invjalan_id, invperalatan_id, invtanah_id, invasetlain_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
			'invgedung' => array(self::BELONGS_TO, 'InvgedungT', 'invgedung_id'),
			'invasetlain' => array(self::BELONGS_TO, 'InvasetlainT', 'invasetlain_id'),
			'invjalan' => array(self::BELONGS_TO, 'InvjalanT', 'invjalan_id'),
			'invtanah' => array(self::BELONGS_TO, 'InvtanahT', 'invtanah_id'),
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'penyusutanasetdetailTs' => array(self::HAS_MANY, 'PenyusutanasetdetailT', 'penyusutanaset_id'),
			'jurnalrekeningTs' => array(self::HAS_MANY, 'JurnalrekeningT', 'penyusutanaset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyusutanaset_id' => 'Penyusutanaset',
			'tgl_penyusutan' => 'Tanggal Penyusutan',
			'no_penyusutan' => 'No Penyusutan',
			'barang_id' => 'Barang',
			'hargaperolehan' => 'Harga Perolehan Barang',
			'residu' => 'Nilai Residu',
			'umurekonomis' => 'Umur Ekonomis',
			'totalpenyusutan' => 'Total Penyusutan',
			'invgedung_id' => 'Invgedung',
			'invjalan_id' => 'Invjalan',
			'invperalatan_id' => 'Invperalatan',
			'invtanah_id' => 'Invtanah',
			'invasetlain_id' => 'Invasetlain',
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

		if(!empty($this->penyusutanaset_id)){
			$criteria->addCondition('penyusutanaset_id = '.$this->penyusutanaset_id);
		}
		$criteria->compare('LOWER(tgl_penyusutan)',strtolower($this->tgl_penyusutan),true);
		$criteria->compare('LOWER(no_penyusutan)',strtolower($this->no_penyusutan),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('hargaperolehan',$this->hargaperolehan);
		$criteria->compare('residu',$this->residu);
		$criteria->compare('umurekonomis',$this->umurekonomis);
		$criteria->compare('totalpenyusutan',$this->totalpenyusutan);
		if(!empty($this->invgedung_id)){
			$criteria->addCondition('invgedung_id = '.$this->invgedung_id);
		}
		if(!empty($this->invjalan_id)){
			$criteria->addCondition('invjalan_id = '.$this->invjalan_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
		}
		if(!empty($this->invtanah_id)){
			$criteria->addCondition('invtanah_id = '.$this->invtanah_id);
		}
		if(!empty($this->invasetlain_id)){
			$criteria->addCondition('invasetlain_id = '.$this->invasetlain_id);
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