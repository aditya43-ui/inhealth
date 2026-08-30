<?php

/**
 * This is the model class for table "alokasidana_t".
 *
 * The followings are the available columns in table 'alokasidana_t':
 * @property integer $alokasidana_id
 * @property integer $carabayar_id
 * @property integer $ruangan_id
 * @property integer $penjamin_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property string $noresep
 * @property double $totalbiayatindakan
 * @property double $totalbiayapelayanan
 * @property double $totalbiayaoa
 * @property double $total_inacbg
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totalbayartindakan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $tgljatuhtempo
 * @property string $keteranganberhutang
 * @property string $jaminanygditinggal
 * @property string $penanggungjawabhutang
 * @property string $noktp_hutang
 * @property string $notelp_hutang
 * @property string $create_ruangan
 * @property integer $pembebasantarif_id
 */
class AlokasidanaT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alokasidana_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, ruangan_id, penjamin_id, pasien_id, tglpembayaran, totalbiayatindakan, totalbiayapelayanan, totalbiayaoa, total_inacbg, totalsubsidiasuransi, totalsubsidirs, totaliurbiaya, totalbayartindakan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('alokasidana_id, carabayar_id, ruangan_id, penjamin_id, pendaftaran_id, pasienadmisi_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, pembebasantarif_id', 'numerical', 'integerOnly'=>true),
			array('totalbiayatindakan, totalbiayapelayanan, totalbiayaoa, total_inacbg, totalsubsidiasuransi, totalsubsidirs, totaliurbiaya, totalbayartindakan', 'numerical'),
			array('nopembayaran, tglpembayaran, noresep, keteranganberhutang, jaminanygditinggal, penanggungjawabhutang, noktp_hutang, notelp_hutang', 'length', 'max'=>255),
			array('update_time, tgljatuhtempo, totalinacbg_naikkelasperawatan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alokasidana_id, carabayar_id, ruangan_id, penjamin_id, pendaftaran_id, pasienadmisi_id, pasien_id, nopembayaran, tglpembayaran, noresep, totalbiayatindakan, totalbiayapelayanan, totalbiayaoa, total_inacbg, totalsubsidiasuransi, totalsubsidirs, totaliurbiaya, totalbayartindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, tgljatuhtempo, keteranganberhutang, jaminanygditinggal, penanggungjawabhutang, noktp_hutang, notelp_hutang, create_ruangan, pembebasantarif_id', 'safe', 'on'=>'search'),
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
			'alokasidana_id' => 'Alokasidana',
			'carabayar_id' => 'Carabayar',
			'ruangan_id' => 'Ruangan',
			'penjamin_id' => 'Penjamin',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'nopembayaran' => 'Nopembayaran',
			'tglpembayaran' => 'Tglpembayaran',
			'noresep' => 'Noresep',
			'totalbiayatindakan' => 'Totalbiayatindakan',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totalbiayaoa' => 'Totalbiayaoa',
			'total_inacbg' => 'Total Inacbg',
			'totalsubsidiasuransi' => 'Totalsubsidiasuransi',
			'totalsubsidirs' => 'Totalsubsidirs',
			'totaliurbiaya' => 'Totaliurbiaya',
			'totalbayartindakan' => 'Totalbayartindakan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'tgljatuhtempo' => 'Tgljatuhtempo',
			'keteranganberhutang' => 'Keteranganberhutang',
			'jaminanygditinggal' => 'Jaminanygditinggal',
			'penanggungjawabhutang' => 'Penanggungjawabhutang',
			'noktp_hutang' => 'Noktp Hutang',
			'notelp_hutang' => 'Notelp Hutang',
			'create_ruangan' => 'Create Ruangan',
			'pembebasantarif_id' => 'Pembebasantarif',
			'totalinacbg_naikkelasperawatan' => 'Inacbgs Kelas Perawatan'
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

		$criteria->compare('alokasidana_id',$this->alokasidana_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('tglpembayaran',$this->tglpembayaran,true);
		$criteria->compare('noresep',$this->noresep,true);
		$criteria->compare('totalbiayatindakan',$this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalbiayaoa',$this->totalbiayaoa);
		$criteria->compare('total_inacbg',$this->total_inacbg);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totalbayartindakan',$this->totalbayartindakan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganberhutang',$this->keteranganberhutang,true);
		$criteria->compare('jaminanygditinggal',$this->jaminanygditinggal,true);
		$criteria->compare('penanggungjawabhutang',$this->penanggungjawabhutang,true);
		$criteria->compare('noktp_hutang',$this->noktp_hutang,true);
		$criteria->compare('notelp_hutang',$this->notelp_hutang,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pembebasantarif_id',$this->pembebasantarif_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AlokasidanaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
