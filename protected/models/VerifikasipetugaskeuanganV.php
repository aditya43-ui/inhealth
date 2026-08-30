<?php

/**
 * This is the model class for table "verifikasipetugaskeuangan_v".
 *
 * The followings are the available columns in table 'verifikasipetugaskeuangan_v':
 * @property string $nama_pasien
 * @property string $no_pendaftaran
 * @property string $no_nota
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $qty_tindakan
 * @property integer $pegawai_id
 */
class VerifikasipetugaskeuanganV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $tgl_awal, $tgl_akhir, $billing, $jml_tarif_tindakan;

	public function tableName()
	{
		return 'verifikasipetugaskeuangan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, penjamin_id, qty_tindakan, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('nama_pasien', 'length', 'max'=>100),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_nota', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nama_pasien, no_pendaftaran, no_nota, carabayar_id, penjamin_id, qty_tindakan, pegawai_id', 'safe', 'on'=>'search'),
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
			'nama_pasien' => 'Nama Pasien',
			'no_pendaftaran' => 'No Pendaftaran',
			'no_nota' => 'No Nota',
			'carabayar_id' => 'Carabayar',
			'penjamin_id' => 'Penjamin',
			'qty_tindakan' => 'Qty Tindakan',
			'pegawai_id' => 'Pegawai',
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

		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('no_nota',$this->no_nota,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporan()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->select = 'no_pendaftaran, no_nota, nama_pasien, carabayar_nama, penjamin_nama, sum(tarif_tindakan) as jml_tarif_tindakan';
		$criteria->group = 'no_pendaftaran, no_nota, nama_pasien, carabayar_nama, penjamin_nama';

		if($this->billing == 'rj') {
			$criteria->addCondition('pasienadmisi_id IS NULL');
		} else if($this->billing == 'ri') {
			$criteria->addCondition('pasienadmisi_id IS NOT NULL');
		}

		// $criteria->compare('nama_pasien',$this->nama_pasien,true);
		// $criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->addBetweenCondition('DATE(tglverifikasirenc)', $this->tgl_awal, $this->tgl_akhir);
		// $criteria->compare('no_nota',$this->no_nota,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		// $criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'no_nota desc'
			),
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'no_pendaftaran, no_nota, nama_pasien, carabayar_nama, penjamin_nama, sum(tarif_tindakan) as jml_tarif_tindakan';
		$criteria->group = 'no_pendaftaran, no_nota, nama_pasien, carabayar_nama, penjamin_nama';

		if($this->billing == 'rj') {
			$criteria->addCondition('pasienadmisi_id IS NULL');
		} else if($this->billing == 'ri') {
			$criteria->addCondition('pasienadmisi_id IS NOT NULL');
		}

		// $criteria->compare('nama_pasien',$this->nama_pasien,true);
		// $criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->addBetweenCondition('DATE(tglverifikasirenc)', $this->tgl_awal, $this->tgl_akhir);
		// $criteria->compare('no_nota',$this->no_nota,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		// $criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'no_nota desc'
			),
			'pagination'=>false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerifikasipetugaskeuanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
