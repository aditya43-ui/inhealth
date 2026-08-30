<?php

/**
 * This is the model class for table "laporanpasiendiaredinas_v".
 *
 * The followings are the available columns in table 'laporanpasiendiaredinas_v':
 * @property double $tahun
 * @property double $bulan
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property string $umur
 * @property string $jeniskelamin
 */
class LaporanpasiendiaredinasV extends CActiveRecord
{
	public $tahun;
	public $bulan;
	public $tgl_awal;
	public $tgl_akhir;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $jns_periode;
	public $data;
	public $jumlah;
	
	public $diare_0_5_bln_lk;
	public $diare_0_5_bln_pr;
	public $diare_6_12_bln_lk;
	public $diare_6_12_bln_pr;
	public $diare_2_4_th_lk;
	public $diare_2_4_th_pr;
	public $diare_5_9_th_lk;
	public $diare_5_9_th_pr;
	public $diare_10_14_th_lk;
	public $diare_10_14_th_pr;
	public $diare_15_19_th_lk;
	public $diare_15_19_th_pr;
	public $diare_20_th_lk;
	public $diare_20_th_pr;
	public $diare_tot_lk;
	public $diare_tot_pr;
	
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpasiendiaredinasV the static model class
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
		return 'laporanpasiendiaredinas_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('tahun, bulan', 'numerical'),
			array('umur', 'length', 'max'=>30),
			array('jeniskelamin', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tahun, bulan, instalasi_id, ruangan_id, pendaftaran_id, umur, jeniskelamin', 'safe', 'on'=>'search'),
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
			'tahun' => 'Tahun',
			'bulan' => 'Bulan',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'umur' => 'Umur',
			'jeniskelamin' => 'Jenis Kelamin',
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

		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}