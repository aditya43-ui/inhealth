<?php

/**
 * This is the model class for table "laporanjumlahresep_v".
 *
 * The followings are the available columns in table 'laporanjumlahresep_v':
 * @property string $tglpenjualan
 * @property string $jumlah_kronis
 * @property string $jumlah_nonkronis
 * @property string $jumlah_umum
 * @property string $jumlah_asuransi
 * @property string $jumlah_bpjs
 */
class LaporanjumlahresepV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanjumlahresep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpenjualan, jumlah_kronis, jumlah_nonkronis, jumlah_umum, jumlah_asuransi, jumlah_bpjs', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tglpenjualan, jumlah_kronis, jumlah_nonkronis, jumlah_umum, jumlah_asuransi, jumlah_bpjs', 'safe', 'on'=>'search'),
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
			'tglpenjualan' => 'Tglpenjualan',
			'jumlah_kronis' => 'Jumlah Kronis',
			'jumlah_nonkronis' => 'Jumlah Nonkronis',
			'jumlah_umum' => 'Jumlah Umum',
			'jumlah_asuransi' => 'Jumlah Asuransi',
			'jumlah_bpjs' => 'Jumlah Bpjs',
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

		$criteria->compare('tglpenjualan',$this->tglpenjualan,true);
		$criteria->compare('jumlah_kronis',$this->jumlah_kronis,true);
		$criteria->compare('jumlah_nonkronis',$this->jumlah_nonkronis,true);
		$criteria->compare('jumlah_umum',$this->jumlah_umum,true);
		$criteria->compare('jumlah_asuransi',$this->jumlah_asuransi,true);
		$criteria->compare('jumlah_bpjs',$this->jumlah_bpjs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporanjumlahresepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
