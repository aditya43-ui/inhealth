<?php

/**
 * This is the model class for table "simpanan_t".
 *
 * The followings are the available columns in table 'simpanan_t':
 * @property integer $simpanan_id
 * @property integer $jenissimpanan_id
 * @property integer $buktikasmasukkop_id
 * @property integer $keanggotaan_id
 * @property string $nosimpanan
 * @property string $tglsimpanan
 * @property string $satuan
 * @property double $jumlahsimpanan
 * @property string $keterangansimpanan
 * @property string $makstglpenarikan
 * @property integer $jangkawaktusimpanan
 * @property double $persenjasa_thn
 * @property double $persenpajak_thn
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class SimpananT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'simpanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenissimpanan_id, keanggotaan_id, nosimpanan, tglsimpanan, satuan, persenjasa_thn, persenpajak_thn, create_time, create_loginpemakai_id', 'required'),
			array('jenissimpanan_id, buktikasmasukkop_id, keanggotaan_id, jangkawaktusimpanan', 'numerical', 'integerOnly'=>true),
			array('jumlahsimpanan, persenjasa_thn, persenpajak_thn', 'numerical'),
			array('nosimpanan', 'length', 'max'=>20),
			array('satuan', 'length', 'max'=>50),
			array('create_loginpemakai_id, update_loginpemakai_id', 'length', 'max'=>100),
			array('keterangansimpanan, makstglpenarikan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('simpanan_id, jenissimpanan_id, buktikasmasukkop_id, keanggotaan_id, nosimpanan, tglsimpanan, satuan, jumlahsimpanan, keterangansimpanan, makstglpenarikan, jangkawaktusimpanan, persenjasa_thn, persenpajak_thn, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'simpanan_id' => 'Simpanan',
			'jenissimpanan_id' => 'Jenissimpanan',
			'buktikasmasukkop_id' => 'Buktikasmasuk',
			'keanggotaan_id' => 'Keanggotaan',
			'nosimpanan' => 'No Simpanan',
			'tglsimpanan' => 'Tgl. Simpanan',
			'satuan' => 'Satuan',
			'jumlahsimpanan' => 'Jumlah Simpanan',
			'keterangansimpanan' => 'Keterangan Simpanan',
			'makstglpenarikan' => 'Maks Tgl. Penarikan',
			'jangkawaktusimpanan' => 'Jangka Waktu Simpanan',
			'persenjasa_thn' => 'Persen Jasa',
			'persenpajak_thn' => 'Persen Pajak',
			'create_time' => 'Simp Create Time',
			'update_time' => 'Simp Update Time',
			'create_loginpemakai_id' => 'Simp Create Login',
			'update_loginpemakai_id' => 'Simp Update Login',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->simpanan_id))$criteria->addCondition('simpanan_id = '.$this->simpanan_id);
		//$criteria->compare('simpanan_id',$this->simpanan_id);
		if(!empty($this->jenissimpanan_id))$criteria->addCondition('jenissimpanan_id = '.$this->jenissimpanan_id);
		//$criteria->compare('jenissimpanan_id',$this->jenissimpanan_id);
		if(!empty($this->buktikasmasukkop_id))$criteria->addCondition('buktikasmasukkop_id = '.$this->buktikasmasukkop_id);
		//$criteria->compare('buktikasmasukkop_id',$this->buktikasmasukkop_id);
		if(!empty($this->keanggotaan_id))$criteria->addCondition('keanggotaan_id = '.$this->keanggotaan_id);
		//$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('nosimpanan',$this->nosimpanan,true);
		$criteria->compare('tglsimpanan',$this->tglsimpanan,true);
		$criteria->compare('satuan',$this->satuan,true);
		$criteria->compare('jumlahsimpanan',$this->jumlahsimpanan);
		$criteria->compare('keterangansimpanan',$this->keterangansimpanan,true);
		$criteria->compare('makstglpenarikan',$this->makstglpenarikan,true);
		$criteria->compare('jangkawaktusimpanan',$this->jangkawaktusimpanan);
		$criteria->compare('persenjasa_thn',$this->persenjasa_thn);
		$criteria->compare('persenpajak_thn',$this->persenpajak_thn);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SimpananT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	

	public function getJasa() {
		$dAwal = new DateTime($this->tglsimpanan);
		$dSekarang = new DateTime(date('Y-m-d'));
		$tahun = $dAwal->diff($dSekarang, false)->y;

		return $this->jumlahsimpanan * $tahun * ($this->persenjasa_thn/100);
	}
}
