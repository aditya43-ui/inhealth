<?php

/**
 * This is the model class for table "biayapelatihan_t".
 *
 * The followings are the available columns in table 'biayapelatihan_t':
 * @property integer $biayapelatihan_id
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
 * @property integer $rencanadiklat_id
 * @property double $total_biaya
 *
 * The followings are the available model relations:
 * @property RencanadiklatT $rencanadiklat
 */
class BiayapelatihanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BiayapelatihanT the static model class
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
		return 'biayapelatihan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanadiklat_id', 'required'),
			array('rencanadiklat_id', 'numerical', 'integerOnly'=>true),
			array('internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, eksternal_totbiayapelatihan, eksternal_totbiayatransportasi, eksternal_totbiayapenginapan, eksternal_totbiayaperjalanan, eksternal_totbiayalainlain, total_biaya', 'numerical'),
			array('internal_keteranganlainlain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('biayapelatihan_id, internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, internal_keteranganlainlain, eksternal_totbiayapelatihan, eksternal_totbiayatransportasi, eksternal_totbiayapenginapan, eksternal_totbiayaperjalanan, eksternal_totbiayalainlain, rencanadiklat_id, total_biaya', 'safe', 'on'=>'search'),
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
			'rencanadiklat' => array(self::BELONGS_TO, 'RencanadiklatT', 'rencanadiklat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'biayapelatihan_id' => 'Biayapelatihan',
			'internal_biayapemateri' => 'Biaya Pemateri',
			'internal_biayakonsumsi' => 'Biaya Konsumsi',
			'internal_biayaalatperaga' => 'Biaya Alat Peraga',
			'internal_biayalainlain' => 'Biaya Lain - Lain',
			'internal_keteranganlainlain' => 'Keterangan Lain - Lain',
			'eksternal_totbiayapelatihan' => 'Total Biaya Pelatihan',
			'eksternal_totbiayatransportasi' => 'Total Biaya Transportasi',
			'eksternal_totbiayapenginapan' => 'Total Biaya Penginapan',
			'eksternal_totbiayaperjalanan' => 'Total Biaya Perjalanan',
			'eksternal_totbiayalainlain' => 'Total Biaya Lain - Lain',
			'rencanadiklat_id' => 'Rencana Diklat',
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

		$criteria->compare('biayapelatihan_id',$this->biayapelatihan_id);
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
		$criteria->compare('rencanadiklat_id',$this->rencanadiklat_id);
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