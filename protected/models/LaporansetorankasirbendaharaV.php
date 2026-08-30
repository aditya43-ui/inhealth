<?php

/**
 * This is the model class for table "laporansetorankasirbendahara_v".
 *
 * The followings are the available columns in table 'laporansetorankasirbendahara_v':
 * @property integer $setorankasir_id
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $nosetorankasir
 * @property string $tglsetorankasir
 * @property double $jmluangsetorankasir
 * @property integer $bendaharapenerima_id
 * @property string $gelardepan_bendahara
 * @property string $nama_bendahara
 * @property string $gelarbelakang_bendahara
 * @property string $tglditerimabendahara
 * @property string $setorankasirdari
 * @property string $sampaidengan
 * @property string $jml_pasien_l
 * @property string $jml_pasien_p
 * @property double $jml_retribusi_pl
 * @property double $jml_retribusi_pb
 * @property double $jml_jasamedis_pl
 * @property double $jml_jasamedis_pb
 * @property double $jml_paramedis_pl
 * @property double $jml_paramedis_pb
 * @property double $jml_administrasi_pl
 * @property double $jml_administrasi_pb
 * @property double $jml_setoran_pl
 * @property double $jml_setoran_pb
 * @property double $totsetkasirruangan
 */
class LaporansetorankasirbendaharaV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporansetorankasirbendaharaV the static model class
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
		return 'laporansetorankasirbendahara_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setorankasir_id, pegawai_id, ruangan_id, bendaharapenerima_id', 'numerical', 'integerOnly'=>true),
			array('jmluangsetorankasir, jml_retribusi_pl, jml_retribusi_pb, jml_jasamedis_pl, jml_jasamedis_pb, jml_paramedis_pl, jml_paramedis_pb, jml_administrasi_pl, jml_administrasi_pb, jml_setoran_pl, jml_setoran_pb, totsetkasirruangan', 'numerical'),
			array('gelardepan, gelardepan_bendahara', 'length', 'max'=>10),
			array('nama_pegawai, ruangan_nama, nosetorankasir, nama_bendahara', 'length', 'max'=>50),
			array('gelarbelakang_nama, gelarbelakang_bendahara', 'length', 'max'=>15),
			array('tglsetorankasir, tglditerimabendahara, setorankasirdari, sampaidengan, jml_pasien_l, jml_pasien_p', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setorankasir_id, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, ruangan_id, ruangan_nama, nosetorankasir, tglsetorankasir, jmluangsetorankasir, bendaharapenerima_id, gelardepan_bendahara, nama_bendahara, gelarbelakang_bendahara, tglditerimabendahara, setorankasirdari, sampaidengan, jml_pasien_l, jml_pasien_p, jml_retribusi_pl, jml_retribusi_pb, jml_jasamedis_pl, jml_jasamedis_pb, jml_paramedis_pl, jml_paramedis_pb, jml_administrasi_pl, jml_administrasi_pb, jml_setoran_pl, jml_setoran_pb, totsetkasirruangan', 'safe', 'on'=>'search'),
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
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'nosetorankasir' => 'No Setoran Kasir',
			'tglsetorankasir' => 'Tgl. Setoran Kasir',
			'jmluangsetorankasir' => 'Jmluangsetorankasir',
			'bendaharapenerima_id' => 'Bendaharapenerima',
			'gelardepan_bendahara' => 'Gelardepan Bendahara',
			'nama_bendahara' => 'Nama Bendahara',
			'gelarbelakang_bendahara' => 'Gelarbelakang Bendahara',
			'tglditerimabendahara' => 'Tglditerimabendahara',
			'setorankasirdari' => 'Setorankasirdari',
			'sampaidengan' => 'Sampaidengan',
			'jml_pasien_l' => 'Jml Pasien L',
			'jml_pasien_p' => 'Jml Pasien P',
			'jml_retribusi_pl' => 'Jml Retribusi Pl',
			'jml_retribusi_pb' => 'Jml Retribusi Pb',
			'jml_jasamedis_pl' => 'Jml Jasamedis Pl',
			'jml_jasamedis_pb' => 'Jml Jasamedis Pb',
			'jml_paramedis_pl' => 'Jml Paramedis Pl',
			'jml_paramedis_pb' => 'Jml Paramedis Pb',
			'jml_administrasi_pl' => 'Jml Administrasi Pl',
			'jml_administrasi_pb' => 'Jml Administrasi Pb',
			'jml_setoran_pl' => 'Jml Setoran Pl',
			'jml_setoran_pb' => 'Jml Setoran Pb',
			'totsetkasirruangan' => 'Totsetkasirruangan',
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
		$criteria->compare('nosetorankasir',$this->nosetorankasir,true);
		$criteria->compare('tglsetorankasir',$this->tglsetorankasir,true);
		$criteria->compare('jmluangsetorankasir',$this->jmluangsetorankasir);
		$criteria->compare('bendaharapenerima_id',$this->bendaharapenerima_id);
		$criteria->compare('gelardepan_bendahara',$this->gelardepan_bendahara,true);
		$criteria->compare('nama_bendahara',$this->nama_bendahara,true);
		$criteria->compare('gelarbelakang_bendahara',$this->gelarbelakang_bendahara,true);
		$criteria->compare('tglditerimabendahara',$this->tglditerimabendahara,true);
		$criteria->compare('setorankasirdari',$this->setorankasirdari,true);
		$criteria->compare('sampaidengan',$this->sampaidengan,true);
		$criteria->compare('jml_pasien_l',$this->jml_pasien_l,true);
		$criteria->compare('jml_pasien_p',$this->jml_pasien_p,true);
		$criteria->compare('jml_retribusi_pl',$this->jml_retribusi_pl);
		$criteria->compare('jml_retribusi_pb',$this->jml_retribusi_pb);
		$criteria->compare('jml_jasamedis_pl',$this->jml_jasamedis_pl);
		$criteria->compare('jml_jasamedis_pb',$this->jml_jasamedis_pb);
		$criteria->compare('jml_paramedis_pl',$this->jml_paramedis_pl);
		$criteria->compare('jml_paramedis_pb',$this->jml_paramedis_pb);
		$criteria->compare('jml_administrasi_pl',$this->jml_administrasi_pl);
		$criteria->compare('jml_administrasi_pb',$this->jml_administrasi_pb);
		$criteria->compare('jml_setoran_pl',$this->jml_setoran_pl);
		$criteria->compare('jml_setoran_pb',$this->jml_setoran_pb);
		$criteria->compare('totsetkasirruangan',$this->totsetkasirruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}