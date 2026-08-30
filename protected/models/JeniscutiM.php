<?php

/**
 * This is the model class for table "jeniscuti_m".
 *
 * The followings are the available columns in table 'jeniscuti_m':
 * @property integer $jeniscuti_id
 * @property string $jeniscuti_nama
 * @property string $jeniscuti_namalainnya
 * @property boolean $jeniscuti_aktif
 */
class JeniscutiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniscutiM the static model class
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
		return 'jeniscuti_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniscuti_nama', 'required'),
			array('jeniscuti_nama, jeniscuti_namalainnya', 'length', 'max'=>100),
			array('jeniscuti_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniscuti_id, jeniscuti_nama, jeniscuti_namalainnya, jeniscuti_aktif', 'safe', 'on'=>'search'),
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
			'jeniscuti_id' => 'Jenis Cuti',
			'jeniscuti_nama' => 'Nama Jenis Cuti',
			'jeniscuti_namalainnya' => 'Nama Lain Jenis Cuti',
			'jeniscuti_aktif' => 'Aktif',
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

		$criteria->compare('jeniscuti_id',$this->jeniscuti_id);
		$criteria->compare('LOWER(jeniscuti_nama)',strtolower($this->jeniscuti_nama),true);
		$criteria->compare('LOWER(jeniscuti_namalainnya)',strtolower($this->jeniscuti_namalainnya),true);
		$criteria->compare('jeniscuti_aktif',$this->jeniscuti_aktif);
                $criteria->addCondition('jeniscuti_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->compare('jeniscuti_id',$this->jeniscuti_id);
            $criteria->compare('LOWER(jeniscuti_nama)',strtolower($this->jeniscuti_nama),true);
            $criteria->compare('LOWER(jeniscuti_namalainnya)',strtolower($this->jeniscuti_namalainnya),true);
            $criteria->compare('jeniscuti_aktif',$this->jeniscuti_aktif);
            // Klo limit lebih kecil dari nol itu berarti ga ada limit 
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
        
        /**
         * - digunakan untuk mengenerate total cuti
         * @param type $jeniscuti_id
         * @param type $pegawai_id
         * @param type $tanggal_transaksi
         * @return int
         */
        public function getTotalJenisCuti($jeniscuti_id,$pegawai_id,$tanggal_transaksi,$pegawaicuti_id){
            $cri = new CDbCriteria();
            $cri->addCondition(" jeniscuti_id = '".$jeniscuti_id."' ");
            $cri->addCondition(" pegawai_id = '".$pegawai_id."' ");
            $cri->addCondition(" date(tanggal_transaksi) <= '".$tanggal_transaksi."' ");
//            $cri->addCondition(" pegawaicuti_id != '".$pegawaicuti_id."' ");
             $cri->addCondition(" status_cuti = '".Params::STATUS_CUTI_DISETUJUI."' ");
            $all = KPInfocutipegawaiV::model()->findAll($cri);
            $tot = 0;

            foreach ($all as $det){
                $tot = $tot + $det->lamacuti;
            }                
            
            return $tot;
        }
}