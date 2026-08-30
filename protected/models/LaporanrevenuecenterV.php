<?php

/**
 * This is the model class for table "laporanrevenuecenter_v".
 *
 * The followings are the available columns in table 'laporanrevenuecenter_v':
 * @property integer $bukubesar_id
 * @property string $tglbukubesar
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property boolean $isrevenuecenter
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property double $saldo_rj
 * @property double $saldo_ri
 * @property double $saldo_rd
 * @property double $saldo_vk
 * @property double $saldo_pi
 * @property double $saldo_hd
 * @property double $saldo_fisioterpi
 * @property double $saldo_mcu
 * @property double $saldo_lab
 * @property double $saldo_rad
 * @property double $saldo_ibs
 * @property double $saldo_pemulasaran
 * @property double $saldo_bankdrh
 * @property double $saldo_apotek
 * @property double $saldounitcost_center
 */
class LaporanrevenuecenterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrevenuecenterV the static model class
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
		return 'laporanrevenuecenter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bukubesar_id, ruangan_id, rekening5_id, rekening4_id', 'numerical', 'integerOnly'=>true),
			array('saldo_rj, saldo_ri, saldo_rd, saldo_vk, saldo_pi, saldo_hd, saldo_fisioterpi, saldo_mcu, saldo_lab, saldo_rad, saldo_ibs, saldo_pemulasaran, saldo_bankdrh, saldo_apotek, saldoakun', 'numerical'),
			array('ruangan_nama', 'length', 'max'=>50),
			array('kdrekening5', 'length', 'max'=>20),
			array('nmrekening5', 'length', 'max'=>500),
			array('kdrekening4', 'length', 'max'=>10),
			array('nmrekening4', 'length', 'max'=>400),
			array('tglbukubesar, isrevenuecenter', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bukubesar_id, tglbukubesar, ruangan_id, ruangan_nama, isrevenuecenter, rekening5_id, kdrekening5, nmrekening5, rekening4_id, kdrekening4, nmrekening4, saldo_rj, saldo_ri, saldo_rd, saldo_vk, saldo_pi, saldo_hd, saldo_fisioterpi, saldo_mcu, saldo_lab, saldo_rad, saldo_ibs, saldo_pemulasaran, saldo_bankdrh, saldo_apotek, saldoakun', 'safe', 'on'=>'search'),
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
			'bukubesar_id' => 'Buku Besar',
			'tglbukubesar' => 'Tgl. Buku Besar',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'isrevenuecenter' => 'Is Revenue Center',
			'rekening5_id' => 'Rekening 5',
			'kdrekening5' => 'Kd Rekening 5',
			'nmrekening5' => 'Nm Rekening 5',
			'rekening4_id' => 'Rekening4',
			'kdrekening4' => 'Kd Rekening4',
			'nmrekening4' => 'Nm Rekening4',
			'saldo_rj' => 'Saldo RJ',
			'saldo_ri' => 'Saldo RI',
			'saldo_rd' => 'Saldo Rd',
			'saldo_vk' => 'Saldo VK',
			'saldo_pi' => 'Saldo PI',
			'saldo_hd' => 'Saldo HD',
			'saldo_fisioterpi' => 'Saldo Fisioterapi',
			'saldo_mcu' => 'Saldo MCU',
			'saldo_lab' => 'Saldo Lab',
			'saldo_rad' => 'Saldo Rad',
			'saldo_ibs' => 'Saldo Ibs',
			'saldo_pemulasaran' => 'Saldo Pemulasaran',
			'saldo_bankdrh' => 'Saldo Bank Darah',
			'saldo_apotek' => 'Saldo Apotek',
			'saldoakun' => 'Saldo Akun',
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

		$criteria->compare('bukubesar_id',$this->bukubesar_id);
		$criteria->compare('tglbukubesar',$this->tglbukubesar,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('isrevenuecenter',$this->isrevenuecenter);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('kdrekening5',$this->kdrekening5,true);
		$criteria->compare('nmrekening5',$this->nmrekening5,true);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('kdrekening4',$this->kdrekening4,true);
		$criteria->compare('nmrekening4',$this->nmrekening4,true);
		$criteria->compare('saldo_rj',$this->saldo_rj);
		$criteria->compare('saldo_ri',$this->saldo_ri);
		$criteria->compare('saldo_rd',$this->saldo_rd);
		$criteria->compare('saldo_vk',$this->saldo_vk);
		$criteria->compare('saldo_pi',$this->saldo_pi);
		$criteria->compare('saldo_hd',$this->saldo_hd);
		$criteria->compare('saldo_fisioterpi',$this->saldo_fisioterpi);
		$criteria->compare('saldo_mcu',$this->saldo_mcu);
		$criteria->compare('saldo_lab',$this->saldo_lab);
		$criteria->compare('saldo_rad',$this->saldo_rad);
		$criteria->compare('saldo_ibs',$this->saldo_ibs);
		$criteria->compare('saldo_pemulasaran',$this->saldo_pemulasaran);
		$criteria->compare('saldo_bankdrh',$this->saldo_bankdrh);
		$criteria->compare('saldo_apotek',$this->saldo_apotek);
		$criteria->compare('saldoakun',$this->saldoakun);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}