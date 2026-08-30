<?php

/**
 * This is the model class for table "informasisetorankasir_v".
 *
 * The followings are the available columns in table 'informasisetorankasir_v':
 * @property integer $setorankasir_id
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $profilrs_id
 * @property integer $closingkasir_id
 * @property string $nosetorankasir
 * @property string $tglsetorankasir
 * @property double $jmluangsetorankasir
 * @property integer $bendaharapenerima_id
 * @property string $gelardepan_bendahara
 * @property string $nama_bendahara
 * @property string $gelarbelakang_bendahara
 * @property string $tglditerimabendahara
 * @property string $tglprintsetoran
 * @property integer $jmlprintsetoran
 * @property string $setorankasirdari
 * @property string $sampaidengan
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InformasisetorankasirV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisetorankasirV the static model class
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
		return 'informasisetorankasir_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setorankasir_id, pegawai_id, ruangan_id, profilrs_id, closingkasir_id, bendaharapenerima_id, jmlprintsetoran, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmluangsetorankasir', 'numerical'),
			array('gelardepan, gelardepan_bendahara', 'length', 'max'=>10),
			array('nama_pegawai, ruangan_nama, nosetorankasir, nama_bendahara', 'length', 'max'=>50),
			array('gelarbelakang_nama, gelarbelakang_bendahara', 'length', 'max'=>15),
			array('tglsetorankasir, tglditerimabendahara, tglprintsetoran, setorankasirdari, sampaidengan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setorankasir_id, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, ruangan_id, ruangan_nama, profilrs_id, closingkasir_id, nosetorankasir, tglsetorankasir, jmluangsetorankasir, bendaharapenerima_id, gelardepan_bendahara, nama_bendahara, gelarbelakang_bendahara, tglditerimabendahara, tglprintsetoran, jmlprintsetoran, setorankasirdari, sampaidengan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'setorankasir_id' => 'Setorankasir',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Pegawai Setoran',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'ruangan_id' => 'Ruangan Setoran',
			'ruangan_nama' => 'Ruangan Setoran',
			'profilrs_id' => 'Profilrs',
			'closingkasir_id' => 'Closingkasir',
			'nosetorankasir' => 'No. Setoran',
			'tglsetorankasir' => 'Tgl. Setoran',
			'jmluangsetorankasir' => 'Jumlah Setoran',
			'bendaharapenerima_id' => 'Bendaharapenerima',
			'gelardepan_bendahara' => 'Gelardepan Bendahara',
			'nama_bendahara' => 'Nama Bendahara',
			'gelarbelakang_bendahara' => 'Gelarbelakang Bendahara',
			'tglditerimabendahara' => 'Tglditerimabendahara',
			'tglprintsetoran' => 'Tglprintsetoran',
			'jmlprintsetoran' => 'Jmlprintsetoran',
			'setorankasirdari' => 'Setoran Dari Tgl.',
			'sampaidengan' => 'Sampai Tgl.',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('setorankasir_id',$this->setorankasir_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('nosetorankasir',$this->nosetorankasir,true);
		$criteria->compare('tglsetorankasir',$this->tglsetorankasir,true);
		$criteria->compare('jmluangsetorankasir',$this->jmluangsetorankasir);
		$criteria->compare('bendaharapenerima_id',$this->bendaharapenerima_id);
		$criteria->compare('gelardepan_bendahara',$this->gelardepan_bendahara,true);
		$criteria->compare('nama_bendahara',$this->nama_bendahara,true);
		$criteria->compare('gelarbelakang_bendahara',$this->gelarbelakang_bendahara,true);
		$criteria->compare('tglditerimabendahara',$this->tglditerimabendahara,true);
		$criteria->compare('tglprintsetoran',$this->tglprintsetoran,true);
		$criteria->compare('jmlprintsetoran',$this->jmlprintsetoran);
		$criteria->compare('setorankasirdari',$this->setorankasirdari,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}