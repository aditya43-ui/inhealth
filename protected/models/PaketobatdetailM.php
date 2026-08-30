<?php

/**
 * This is the model class for table "paketobatdetail_m".
 *
 * The followings are the available columns in table 'paketobatdetail_m':
 * @property integer $paketobatdetail_id
 * @property integer $paketobat_id
 * @property integer $obatalkes_id
 * @property double $qtypemakaian
 * @property double $qtystokout
 * @property integer $satuankecil_id
 *
 * The followings are the available model relations:
 * @property PaketobatM $paketobat
 * @property ObatalkesM $obatalkes
 * @property SatuankecilM $satuankecil
 */
class PaketobatdetailM extends CActiveRecord
{

	public $obatalkes_nama;
	public $satuankecil_nama;
	public $r;
	public $temp_permintaan_dosis;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaketobatdetailM the static model class
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
		return 'paketobatdetail_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('paketobat_id, obatalkes_id', 'required'),
			// array('paketobat_id, obatalkes_id, satuankecil_id, racikan_id, resep_ke, rke, jml_permintaan, permintaan_dosis, sediaan, permintaandosis_pembilang, permintaandosis_penyebut', 'numerical', 'integerOnly'=>true),
			array('paketobat_id,obatalkes_id, satuankecil_id,racikan_id, resep_ke, rke, jml_permintaan, permintaandosis_pembilang, permintaandosis_penyebut', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			array('signa_oa', 'length', 'max'=>100),
			array('satuan_jmlpermintaan, satuan_permintaandosis, satuankekuatan', 'length', 'max'=>20),

			array('etiketwaktu, frekuensi, dosis, resepturketerangan, etiket, is_permintaandosispecahan, permintaan_dosis, obatlain_nama', 'safe'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('paketobatdetail_id, paketobat_id, obatalkes_id, jumlah, satuankecil_id, racikan_id, resep_ke, rke, jml_permintaan, permintaan_dosis, sediaan, etiket, satuan_jmlpermintaan, satuan_permintaandosis, is_permintaandosispecahan, permintaandosis_pembilang, permintaandosis_penyebut, satuankekuatan, obatlain_nama', 'safe', 'on'=>'search'),
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
			'paketobat' => array(self::BELONGS_TO, 'PaketobatM', 'paketobat_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
			'racikan' => array(self::BELONGS_TO, 'RacikanM', 'racikan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'paketobatdetail_id' => 'Paketobatdetail',
			'paketobat_id' => 'Paketobat',
			'obatalkes_id' => 'Obatalkes',
			'satuankecil_id' => 'Satuankecil',
			'jumlah' => 'Jumlah',
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

		$criteria->compare('paketobatdetail_id',$this->paketobatdetail_id);
		$criteria->compare('paketobat_id',$this->paketobat_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('qtypemakaian',$this->qtypemakaian);
		$criteria->compare('qtystokout',$this->qtystokout);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}