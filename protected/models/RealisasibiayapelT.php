<?php

/**
 * This is the model class for table "realisasibiayapel_t".
 *
 * The followings are the available columns in table 'realisasibiayapel_t':
 * @property integer $realisasibiayapel_id
 * @property double $internal_biayapemateri
 * @property double $internal_biayakonsumsi
 * @property double $internal_biayaalatperaga
 * @property double $internal_biayalainlain
 * @property string $internal_keteranganlainlain
 * @property double $eksternal_totbiayapelatihan
 * @property double $eksternal_totbiayatransportasi
 * @property double $eksternal_totbiayapenginapan
 * @property double $eksternal_totbiayaperjalanan
 * @property double $eksternal_totbiayalainlain
 * @property integer $biayapelatihan_id
 * @property integer $realisasidiklat_id
 * @property double $total_biaya
 *
 * The followings are the available model relations:
 * @property RealisasidiklatT $realisasidiklat
 * @property BiayapelatihanT $biayapelatihan
 */
class RealisasibiayapelT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasibiayapelT the static model class
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
		return 'realisasibiayapel_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('biayapelatihan_id, realisasidiklat_id', 'required'),
			array('biayapelatihan_id, realisasidiklat_id', 'numerical', 'integerOnly'=>true),
			array('internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, eksternal_totbiayapelatihan, eksternal_totbiayatransportasi, eksternal_totbiayapenginapan, eksternal_totbiayaperjalanan, eksternal_totbiayalainlain, total_biaya', 'numerical'),
			array('internal_keteranganlainlain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasibiayapel_id, internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, internal_keteranganlainlain, eksternal_totbiayapelatihan, eksternal_totbiayatransportasi, eksternal_totbiayapenginapan, eksternal_totbiayaperjalanan, eksternal_totbiayalainlain, biayapelatihan_id, realisasidiklat_id, total_biaya', 'safe', 'on'=>'search'),
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
			'realisasidiklat' => array(self::BELONGS_TO, 'RealisasidiklatT', 'realisasidiklat_id'),
			'biayapelatihan' => array(self::BELONGS_TO, 'BiayapelatihanT', 'biayapelatihan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realisasibiayapel_id' => 'Realisasibiayapel',
			'internal_biayapemateri' => 'Biaya Pemateri',
			'internal_biayakonsumsi' => 'Biaya Konsumsi',
			'internal_biayaalatperaga' => 'Biaya Alat Peraga',
			'internal_biayalainlain' => 'Biaya Lain - Lain',
			'internal_keteranganlainlain' => 'Keterangan Biaya Lain - lain',
			'eksternal_totbiayapelatihan' => 'Eksternal Totbiayapelatihan',
			'eksternal_totbiayatransportasi' => 'Eksternal Totbiayatransportasi',
			'eksternal_totbiayapenginapan' => 'Eksternal Totbiayapenginapan',
			'eksternal_totbiayaperjalanan' => 'Eksternal Totbiayaperjalanan',
			'eksternal_totbiayalainlain' => 'Eksternal Totbiayalainlain',
			'biayapelatihan_id' => 'Biayapelatihan',
			'realisasidiklat_id' => 'Realisasidiklat',
			'total_biaya' => 'Total Biaya',
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

		$criteria->compare('realisasibiayapel_id',$this->realisasibiayapel_id);
		$criteria->compare('internal_biayapemateri',$this->internal_biayapemateri);
		$criteria->compare('internal_biayakonsumsi',$this->internal_biayakonsumsi);
		$criteria->compare('internal_biayaalatperaga',$this->internal_biayaalatperaga);
		$criteria->compare('internal_biayalainlain',$this->internal_biayalainlain);
		$criteria->compare('internal_keteranganlainlain',$this->internal_keteranganlainlain,true);
		$criteria->compare('eksternal_totbiayapelatihan',$this->eksternal_totbiayapelatihan);
		$criteria->compare('eksternal_totbiayatransportasi',$this->eksternal_totbiayatransportasi);
		$criteria->compare('eksternal_totbiayapenginapan',$this->eksternal_totbiayapenginapan);
		$criteria->compare('eksternal_totbiayaperjalanan',$this->eksternal_totbiayaperjalanan);
		$criteria->compare('eksternal_totbiayalainlain',$this->eksternal_totbiayalainlain);
		$criteria->compare('biayapelatihan_id',$this->biayapelatihan_id);
		$criteria->compare('realisasidiklat_id',$this->realisasidiklat_id);
		$criteria->compare('total_biaya',$this->total_biaya);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * - digunakan untuk menjumlahkan seluurh biaya eksternal dan internal
         * @return type
         */
        public function getTotalSeluruh(){
            $total = $this->internal_biayapemateri + $this->internal_biayakonsumsi + $this->internal_biayaalatperaga + $this->internal_biayalainlain + $this->eksternal_totbiayapelatihan + $this->eksternal_totbiayatransportasi + $this->eksternal_totbiayapenginapan + $this->eksternal_totbiayaperjalanan + $this->eksternal_totbiayalainlain;
            
            return $total;
        }
}