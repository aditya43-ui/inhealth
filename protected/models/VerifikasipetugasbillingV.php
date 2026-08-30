<?php

/**
 * This is the model class for table "verifikasipetugasbilling_v".
 *
 * The followings are the available columns in table 'verifikasipetugasbilling_v':
 * @property string $nama_pasien
 * @property string $no_pendaftaran
 * @property integer $pasienadmisi_id
 * @property string $no_nota
 * @property string $nobuktibayar
 * @property double $jmlpembayaran
 */
class VerifikasipetugasbillingV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $tgl_awal, $tgl_akhir, $billing, $total;
	public $is_umum;

	public function tableName()
	{
		return 'verifikasipetugasbilling_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('jmlpembayaran', 'numerical'),
			array('nama_pasien', 'length', 'max'=>100),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('nobuktibayar', 'length', 'max'=>50),
			array('no_nota', 'safe'),
			array('carabayar_id, penjamin_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nama_pasien, no_pendaftaran, pasienadmisi_id, no_nota, nobuktibayar, jmlpembayaran', 'safe', 'on'=>'search'),
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
			'pasienadmisi_id' => 'Pasienadmisi',
			'no_nota' => 'No Nota',
			'nobuktibayar' => 'Nobuktibayar',
			'jmlpembayaran' => 'Jmlpembayaran',
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
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('no_nota',$this->no_nota,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporan()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'no_pendaftaran, nobuktibayar, nama_pasien, carabayar_nama, penjamin_nama';
		$criteria->group = 'no_pendaftaran, nobuktibayar, nama_pasien, carabayar_nama, penjamin_nama';

		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);

		if($this->billing == 'rj') {
			$criteria->addCondition('pasienadmisi_id IS NULL and instalasi_id = '.Params::INSTALASI_ID_RJ);
		} else if($this->billing == 'ri') {
			$criteria->addCondition('pasienadmisi_id IS NOT NULL');
		} else if ($this->billing == 'rd') {
			$criteria->addCondition('pasienadmisi_id IS NULL and instalasi_id = '.Params::INSTALASI_ID_RD);
		}

		if ($this->is_umum) {
			$criteria->select .= ", (ceil(jmlpembayaran/100) * 100) as jmlpembayaran";
			$criteria->group .= ", (ceil(jmlpembayaran/100) * 100)";
			$criteria->addCondition('carabayar_id = '.Params::CARABAYAR_ID_MEMBAYAR);
		} else {
			$criteria->select .= ", jmlpembayaran";
			$criteria->group .= ", jmlpembayaran";
			$criteria->addCondition('carabayar_id <> '.Params::CARABAYAR_ID_MEMBAYAR);
		}
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);

		$criteria->addBetweenCondition('DATE(tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);
		
		$criteria->compare('no_nota',$this->no_nota,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->order = 'nama_pasien';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = 'no_pendaftaran, nobuktibayar, nama_pasien, carabayar_nama, penjamin_nama';
		$criteria->group = 'no_pendaftaran, nobuktibayar, nama_pasien, carabayar_nama, penjamin_nama';

		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);

		if($this->billing == 'rj') {
			$criteria->addCondition('pasienadmisi_id IS NULL');
		} else if($this->billing == 'ri') {
			$criteria->addCondition('pasienadmisi_id IS NOT NULL');
		} else if ($this->billing == 'rd') {
			$criteria->addCondition('pasienadmisi_id IS NULL and instalasi_id = '.Params::INSTALASI_ID_RD);
		}

		if ($this->is_umum) {
			$criteria->select .= ", (ceil(jmlpembayaran/100) * 100) as jmlpembayaran";
			$criteria->group .= ", (ceil(jmlpembayaran/100) * 100)";
			$criteria->addCondition('carabayar_id = '.Params::CARABAYAR_ID_MEMBAYAR);
		} else {
			$criteria->select .= ", jmlpembayaran";
			$criteria->group .= ", jmlpembayaran";
			$criteria->addCondition('carabayar_id <> '.Params::CARABAYAR_ID_MEMBAYAR);
		}
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);

		$criteria->addBetweenCondition('DATE(tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('no_nota',$this->no_nota,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	public function getTotal() {

		$criteria=new CDbCriteria;
		$criteria->select = 'no_pendaftaran, nobuktibayar, nama_pasien, carabayar_nama, penjamin_nama';
		$criteria->group = 'no_pendaftaran, nobuktibayar, nama_pasien, carabayar_nama, penjamin_nama';

		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		

		if($this->billing == 'rj') {
			$criteria->addCondition('pasienadmisi_id IS NULL and instalasi_id = '.Params::INSTALASI_ID_RJ);
		} else if($this->billing == 'ri') {
			$criteria->addCondition('pasienadmisi_id IS NOT NULL');
		} else if ($this->billing == 'rd') {
			$criteria->addCondition('pasienadmisi_id IS NULL and instalasi_id = '.Params::INSTALASI_ID_RD);
		}

		if ($this->is_umum) {
			$criteria->select .= ", (ceil(jmlpembayaran/100) * 100) as jmlpembayaran";
			$criteria->group .= ", (ceil(jmlpembayaran/100) * 100)";
			$criteria->addCondition('carabayar_id = '.Params::CARABAYAR_ID_MEMBAYAR);
		} else {
			$criteria->select .= ", jmlpembayaran";
			$criteria->group .= ", jmlpembayaran";
			$criteria->addCondition('carabayar_id <> '.Params::CARABAYAR_ID_MEMBAYAR);
		}
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);

		$criteria->addBetweenCondition('DATE(tglbuktibayar)', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('no_nota',$this->no_nota,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);

		$mod = self::model()->findAll($criteria);

		$total = 0;
		if(!empty($mod)) {
			foreach($mod as $m) {
				$total += $m->jmlpembayaran;
			}
		}

		// var_dump($criteria); die;

		return MyFormatter::formatNumberForPrint($total, 2);


	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VerifikasipetugasbillingV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
