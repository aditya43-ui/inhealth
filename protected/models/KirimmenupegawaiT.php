<?php

/**
 * This is the model class for table "kirimmenupegawai_t".
 *
 * The followings are the available columns in table 'kirimmenupegawai_t':
 * @property integer $kirimmenupegawai_id
 * @property integer $kirimmenudiet_id
 * @property integer $menudiet_id
 * @property integer $pesanmenupegawai_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $jeniswaktu_id
 * @property double $jml_kirim
 * @property string $satuanjml_urt
 */
class KirimmenupegawaiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimmenupegawaiT the static model class
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
		return 'kirimmenupegawai_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kirimmenudiet_id, menudiet_id, ruangan_id, jeniswaktu_id, jml_kirim', 'required'),
			array('kirimmenudiet_id, menudiet_id, pesanmenupegawai_id, ruangan_id, pegawai_id, jeniswaktu_id', 'numerical', 'integerOnly'=>true),
			array('jml_kirim', 'numerical'),
			array('satuanjml_urt', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kirimmenupegawai_id, kirimmenudiet_id, menudiet_id, pesanmenupegawai_id, ruangan_id, pegawai_id, jeniswaktu_id, jml_kirim, satuanjml_urt', 'safe', 'on'=>'search'),
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
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'menudiet'=>array(self::BELONGS_TO, 'MenuDietM', 'menudiet_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'jeniswaktu'=>array(self::BELONGS_TO, 'JeniswaktuM', 'jeniswaktu_id'),
                    'pesanmenupegawai'=>array(self::BELONGS_TO, 'PesanmenupegawaiT', 'pesanmenupegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimmenupegawai_id' => 'Kirim Menu Pegawai',
			'kirimmenudiet_id' => 'Kirim Menu Diet',
			'menudiet_id' => 'Menu Diet',
			'pesanmenupegawai_id' => 'Pesan Menu Pegawai',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'jeniswaktu_id' => 'Jenis Waktu',
			'jml_kirim' => 'Jml Kirim',
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

		$criteria->compare('kirimmenupegawai_id',$this->kirimmenupegawai_id);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('pesanmenupegawai_id',$this->pesanmenupegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
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
		$criteria->compare('kirimmenupegawai_id',$this->kirimmenupegawai_id);
		$criteria->compare('kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
		$criteria->compare('pesanmenupegawai_id',$this->pesanmenupegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(satuanjml_urt)',strtolower($this->satuanjml_urt),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}