<?php

/**
 * This is the model class for table "pesanmenupegawai_t".
 *
 * The followings are the available columns in table 'pesanmenupegawai_t':
 * @property integer $pesanmenupegawai_id
 * @property integer $kirimmenupegawai_id
 * @property integer $pesanmenudiet_id
 * @property integer $menudiet_id
 * @property integer $jeniswaktu_id
 * @property integer $pegawai_id
 * @property double $jml_pesan_porsi
 * @property string $satuanjml_urt
 */
class PesanmenupegawaiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PesanmenupegawaiT the static model class
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
		return 'pesanmenupegawai_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pesanmenudiet_id, menudiet_id, jeniswaktu_id, jml_pesan_porsi', 'required'),
			array('kirimmenupegawai_id, pesanmenudiet_id, menudiet_id, jeniswaktu_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('jml_pesan_porsi', 'numerical'),
			array('satuanjml_urt', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pesanmenupegawai_id, kirimmenupegawai_id, pesanmenudiet_id, menudiet_id, jeniswaktu_id, pegawai_id, jml_pesan_porsi, satuanjml_urt', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'menudiet'=>array(self::BELONGS_TO, 'MenuDietM', 'menudiet_id'),
                    'jeniswaktu'=>array(self::BELONGS_TO, 'JeniswaktuM','jeniswaktu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pesanmenupegawai_id' => 'Pesan Menu Pegawai',
			'kirimmenupegawai_id' => 'Kirim Menu Pegawai',
			'pesanmenudiet_id' => 'Pesan Menu Diet',
			'menudiet_id' => 'Menu Diet',
			'jeniswaktu_id' => 'Jenis Waktu',
			'pegawai_id' => 'Pegawai',
			'jml_pesan_porsi' => 'Jumlah Pesan Porsi',
			'satuanjml_urt' => 'Satuan Jumlah Urt',
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

		$criteria->compare('pesanmenupegawai_id',$this->pesanmenupegawai_id);
		$criteria->compare('kirimmenupegawai_id',$this->kirimmenupegawai_id);
		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jml_pesan_porsi',$this->jml_pesan_porsi);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pesanmenupegawai_id',$this->pesanmenupegawai_id);
		$criteria->compare('kirimmenupegawai_id',$this->kirimmenupegawai_id);
		$criteria->compare('pesanmenudiet_id',$this->pesanmenudiet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jml_pesan_porsi',$this->jml_pesan_porsi);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}