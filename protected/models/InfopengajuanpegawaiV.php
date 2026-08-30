<?php

/**
 * This is the model class for table "infopengajuanpegawai_v".
 *
 * The followings are the available columns in table 'infopengajuanpegawai_v':
 * @property integer $pengajuanpegawai_t_id
 * @property string $tglpengajuan
 * @property string $nopengajuan
 * @property integer $id_pegmengajukan
 * @property string $nip_pegmengajukan
 * @property string $gelardepan_pegmengajukan
 * @property string $nama_pegmengajukan
 * @property integer $idgelar_pegmengajukan
 * @property string $gelar_pegmengajukan
 * @property integer $idjab_pegmengajukan
 * @property string $jab_pegemngajukan
 * @property integer $id_pegmengetahui
 * @property string $nip_pegmengetahui
 * @property string $gelardepan_pegmengetahui
 * @property string $nama_pegmengetahui
 * @property integer $idgelar_pegmengetahui
 * @property string $gelar_pegmengetahui
 * @property integer $idjab_pegmengetahui
 * @property string $jab_pegmengetahui
 * @property integer $id_pegmenyetujui
 * @property string $nip_pegmenyetujui
 * @property string $gelardepan_pegmenyetujui
 * @property string $nama_pegmenyetujui
 * @property integer $idgelar_pegmenyetujui
 * @property string $gelar_pegmenyetujui
 * @property integer $idjab_pegmenyetujui
 * @property string $jab_pegmenyetujui
 * @property integer $pengpegawaidet_t_id
 * @property string $nourut
 * @property integer $jmlorang
 * @property string $untukkeperluan
 * @property string $keterangan
 * @property boolean $disetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class InfopengajuanpegawaiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopengajuanpegawaiV the static model class
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
		return 'infopengajuanpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuanpegawai_t_id, id_pegmengajukan, idgelar_pegmengajukan, idjab_pegmengajukan, id_pegmengetahui, idgelar_pegmengetahui, idjab_pegmengetahui, id_pegmenyetujui, idgelar_pegmenyetujui, idjab_pegmenyetujui, pengpegawaidet_t_id, jmlorang, loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('nopengajuan, nama_pegmengajukan, nama_pegmengetahui, nama_pegmenyetujui, ruangan_nama', 'length', 'max'=>50),
			array('nip_pegmengajukan, nip_pegmengetahui, nip_pegmenyetujui', 'length', 'max'=>30),
			array('gelardepan_pegmengajukan, gelardepan_pegmengetahui, gelardepan_pegmenyetujui', 'length', 'max'=>10),
			array('gelar_pegmengajukan, gelar_pegmengetahui, gelar_pegmenyetujui', 'length', 'max'=>15),
			array('jab_pegemngajukan, jab_pegmengetahui, jab_pegmenyetujui', 'length', 'max'=>100),
			array('nourut', 'length', 'max'=>3),
			array('nama_pemakai', 'length', 'max'=>20),
			array('tglpengajuan, untukkeperluan, keterangan, disetujui, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanpegawai_t_id, tglpengajuan, nopengajuan, id_pegmengajukan, nip_pegmengajukan, gelardepan_pegmengajukan, nama_pegmengajukan, idgelar_pegmengajukan, gelar_pegmengajukan, idjab_pegmengajukan, jab_pegemngajukan, id_pegmengetahui, nip_pegmengetahui, gelardepan_pegmengetahui, nama_pegmengetahui, idgelar_pegmengetahui, gelar_pegmengetahui, idjab_pegmengetahui, jab_pegmengetahui, id_pegmenyetujui, nip_pegmenyetujui, gelardepan_pegmenyetujui, nama_pegmenyetujui, idgelar_pegmenyetujui, gelar_pegmenyetujui, idjab_pegmenyetujui, jab_pegmenyetujui, pengpegawaidet_t_id, nourut, jmlorang, untukkeperluan, keterangan, disetujui, create_time, update_time, loginpemakai_id, nama_pemakai, ruangan_id, ruangan_nama, tgl_mengetahui, tgl_menyetujui', 'safe', 'on'=>'search'),
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
			'pengajuanpegawai_t_id' => 'Pengajuanpegawai T',
			'tglpengajuan' => 'Tanggal Pengajuan',
			'nopengajuan' => 'No. Pengajuan',
			'id_pegmengajukan' => 'Yang Mengajukan',
			'nip_pegmengajukan' => 'Nip Pegmengajukan',
			'gelardepan_pegmengajukan' => 'Gelardepan Pegmengajukan',
			'nama_pegmengajukan' => 'Nama Pegmengajukan',
			'idgelar_pegmengajukan' => 'Idgelar Pegmengajukan',
			'gelar_pegmengajukan' => 'Gelar Pegmengajukan',
			'idjab_pegmengajukan' => 'Idjab Pegmengajukan',
			'jab_pegemngajukan' => 'Jab Pegemngajukan',
			'id_pegmengetahui' => 'Mengetahui',
			'nip_pegmengetahui' => 'Nip Pegmengetahui',
			'gelardepan_pegmengetahui' => 'Gelardepan Pegmengetahui',
			'nama_pegmengetahui' => 'Nama Pegmengetahui',
			'idgelar_pegmengetahui' => 'Idgelar Pegmengetahui',
			'gelar_pegmengetahui' => 'Gelar Pegmengetahui',
			'idjab_pegmengetahui' => 'Idjab Pegmengetahui',
			'jab_pegmengetahui' => 'Jab Pegmengetahui',
			'id_pegmenyetujui' => 'Id Pegmenyetujui',
			'nip_pegmenyetujui' => 'Nip Pegmenyetujui',
			'gelardepan_pegmenyetujui' => 'Gelardepan Pegmenyetujui',
			'nama_pegmenyetujui' => 'Nama Pegmenyetujui',
			'idgelar_pegmenyetujui' => 'Idgelar Pegmenyetujui',
			'gelar_pegmenyetujui' => 'Gelar Pegmenyetujui',
			'idjab_pegmenyetujui' => 'Idjab Pegmenyetujui',
			'jab_pegmenyetujui' => 'Jab Pegmenyetujui',
			'pengpegawaidet_t_id' => 'Pengpegawaidet T',
			'nourut' => 'Nourut',
			'jmlorang' => 'Jmlorang',
			'untukkeperluan' => 'Untukkeperluan',
			'keterangan' => 'Keterangan',
			'disetujui' => 'Disetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'loginpemakai_id' => 'Loginpemakai',
			'nama_pemakai' => 'Nama Pemakai',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('pengajuanpegawai_t_id',$this->pengajuanpegawai_t_id);
		$criteria->compare('tglpengajuan',$this->tglpengajuan,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('id_pegmengajukan',$this->id_pegmengajukan);
		$criteria->compare('nip_pegmengajukan',$this->nip_pegmengajukan,true);
		$criteria->compare('gelardepan_pegmengajukan',$this->gelardepan_pegmengajukan,true);
		$criteria->compare('nama_pegmengajukan',$this->nama_pegmengajukan,true);
		$criteria->compare('idgelar_pegmengajukan',$this->idgelar_pegmengajukan);
		$criteria->compare('gelar_pegmengajukan',$this->gelar_pegmengajukan,true);
		$criteria->compare('idjab_pegmengajukan',$this->idjab_pegmengajukan);
		$criteria->compare('jab_pegemngajukan',$this->jab_pegemngajukan,true);
		$criteria->compare('id_pegmengetahui',$this->id_pegmengetahui);
		$criteria->compare('nip_pegmengetahui',$this->nip_pegmengetahui,true);
		$criteria->compare('gelardepan_pegmengetahui',$this->gelardepan_pegmengetahui,true);
		$criteria->compare('nama_pegmengetahui',$this->nama_pegmengetahui,true);
		$criteria->compare('idgelar_pegmengetahui',$this->idgelar_pegmengetahui);
		$criteria->compare('gelar_pegmengetahui',$this->gelar_pegmengetahui,true);
		$criteria->compare('idjab_pegmengetahui',$this->idjab_pegmengetahui);
		$criteria->compare('jab_pegmengetahui',$this->jab_pegmengetahui,true);
		$criteria->compare('id_pegmenyetujui',$this->id_pegmenyetujui);
		$criteria->compare('nip_pegmenyetujui',$this->nip_pegmenyetujui,true);
		$criteria->compare('gelardepan_pegmenyetujui',$this->gelardepan_pegmenyetujui,true);
		$criteria->compare('nama_pegmenyetujui',$this->nama_pegmenyetujui,true);
		$criteria->compare('idgelar_pegmenyetujui',$this->idgelar_pegmenyetujui);
		$criteria->compare('gelar_pegmenyetujui',$this->gelar_pegmenyetujui,true);
		$criteria->compare('idjab_pegmenyetujui',$this->idjab_pegmenyetujui);
		$criteria->compare('jab_pegmenyetujui',$this->jab_pegmenyetujui,true);
		$criteria->compare('pengpegawaidet_t_id',$this->pengpegawaidet_t_id);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('jmlorang',$this->jmlorang);
		$criteria->compare('untukkeperluan',$this->untukkeperluan,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('disetujui',$this->disetujui);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNamaLengkapMengajukan()
        {
            return $this->gelardepan_pegmengajukan.' '.$this->nama_pegmengajukan.' '.$this->gelar_pegmengajukan;
        }
        
        public function getNamaLengkapMengetahui()
        {
            return $this->gelardepan_pegmengetahui.' '.$this->nama_pegmengetahui.' '.$this->gelar_pegmengetahui;
        }
        
        public function getNamaLengkapMenyetujui()
        {
            return $this->gelardepan_pegmenyetujui.' '.$this->nama_pegmenyetujui.' '.$this->gelar_pegmenyetujui;
        }
}