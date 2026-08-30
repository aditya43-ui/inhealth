<?php

/**
 * This is the model class for table "pajakdokter_t".
 *
 * The followings are the available columns in table 'pajakdokter_t':
 * @property integer $pajakdokter_id
 * @property integer $pegawai_id
 * @property string $tgl_perhitungan
 * @property string $no_perhitungan
 * @property string $periodebulanpajak
 * @property double $penghasilanbruto
 * @property double $pkp
 * @property double $ptkpperbulan
 * @property double $ptkpsetelahpkp
 * @property double $pkpkumulatif
 * @property double $pelapisanpph
 * @property double $pajakprogressif
 * @property integer $petugashitung_id
 * @property string $mengetahui
 * @property string $menyetujui
 * @property integer $mengetahui_id
 * @property integer $menyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property PegawaiM $petugashitung
 * @property PegawaiM $mengetahui0
 * @property PegawaiM $menyetujui0
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 */
class PajakdokterT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PajakdokterT the static model class
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
		return 'pajakdokter_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pajakdokter_id, pegawai_id, petugashitung_id, mengetahui_id, menyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('mengetahui_pt_id, penghasilanbruto, pkp, ptkpperbulan, ptkpsetelahpkp, pkpkumulatif, pelapisanpph, pajakprogressif', 'numerical'),
			array('no_perhitungan', 'length', 'max'=>50),
			array('mengetahui_pt, mengetahui, menyetujui', 'length', 'max'=>100),
			array('tgl_perhitungan, periodebulanpajak, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pajakdokter_id, pegawai_id, tgl_perhitungan, no_perhitungan, periodebulanpajak, penghasilanbruto, pkp, ptkpperbulan, ptkpsetelahpkp, pkpkumulatif, pelapisanpph, pajakprogressif, petugashitung_id, mengetahui, menyetujui, mengetahui_id, menyetujui_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'petugashitung' => array(self::BELONGS_TO, 'PegawaiM', 'petugashitung_id'),
			'mengetahui0' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
			'menyetujui0' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pajakdokter_id' => 'Pajakdokter',
			'pegawai_id' => 'Pegawai',
			'tgl_perhitungan' => 'Tgl. Perhitungan',
			'no_perhitungan' => 'No Perhitungan',
			'periodebulanpajak' => 'Periodebulanpajak',
			'penghasilanbruto' => 'Penghasilan Bruto',
			'pkp' => 'PKP',
			'ptkpperbulan' => 'PTKP Perbulan',
			'ptkpsetelahpkp' => 'PKP setelah PTKP',
			'pkpkumulatif' => 'PKP Kumulatif',
			'pelapisanpph' => 'Pelapisan PPh',
			'pajakprogressif' => 'Pajak Progressif',
			'petugashitung_id' => 'Petugashitung',
			'mengetahui' => 'Mengetahui',
			'menyetujui' => 'Menyetujui',
			'mengetahui_id' => 'Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
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

		$criteria->compare('pajakdokter_id',$this->pajakdokter_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tgl_perhitungan',$this->tgl_perhitungan,true);
		$criteria->compare('no_perhitungan',$this->no_perhitungan,true);
		$criteria->compare('periodebulanpajak',$this->periodebulanpajak,true);
		$criteria->compare('penghasilanbruto',$this->penghasilanbruto);
		$criteria->compare('pkp',$this->pkp);
		$criteria->compare('ptkpperbulan',$this->ptkpperbulan);
		$criteria->compare('ptkpsetelahpkp',$this->ptkpsetelahpkp);
		$criteria->compare('pkpkumulatif',$this->pkpkumulatif);
		$criteria->compare('pelapisanpph',$this->pelapisanpph);
		$criteria->compare('pajakprogressif',$this->pajakprogressif);
		$criteria->compare('petugashitung_id',$this->petugashitung_id);
		$criteria->compare('mengetahui',$this->mengetahui,true);
		$criteria->compare('menyetujui',$this->menyetujui,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}