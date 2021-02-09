<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "masterlist_pero".
 *
 * @property int $id
 * @property int|null $staff_id
 * @property int|null $bahagian_id
 * @property string $no_fail
 * @property string $no_pero
 * @property string $tajuk_pero
 * @property string|null $perihal_pero
 * @property int|null $kaedah_id
 * @property int|null $kategori_id
 * @property int|null $jenis_id
 * @property int|null $status_id
 * @property string|null $jangka_pelawa
 * @property string|null $jangka_sst
 * @property float|null $anggarankos
 * @property int|null $peringkat_penilaian
 * @property int|null $perakuan_subkukp
 * @property string|null $catatan_subkukp
 * @property int|null $perakuan_subw
 * @property string|null $catatan_subw
 * @property int|null $perakuan_ksu
 * @property string|null $catatan_ksu
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property KonfRujukan $staff
 * @property KonfRujukan $perakuanKsu
 * @property KonfRujukan $bahagian
 * @property KonfRujukan $kaedah
 * @property KonfRujukan $kategori
 * @property KonfRujukan $jenis
 * @property KonfRujukan $status
 * @property KonfRujukan $peringkatPenilaian
 * @property KonfRujukan $perakuanSubkukp
 * @property KonfRujukan $perakuanSubw
 * @property ProsesPerolehan[] $prosesPerolehans
 */
class MasterlistPero extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'masterlist_pero';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'bahagian_id', 'kaedah_id', 'kategori_id', 'jenis_id', 'status_id', 'peringkat_penilaian', 'perakuan_subkukp', 'perakuan_subw', 'perakuan_ksu'], 'integer'],
            [['no_fail', 'no_pero', 'tajuk_pero'], 'required'],
            [['jangka_pelawa', 'jangka_sst', 'created_at', 'updated_at'], 'safe'],
            [['anggarankos'], 'number'],
            [['catatan_subkukp', 'catatan_subw', 'catatan_ksu'], 'string'],
            [['no_fail', 'no_pero'], 'string', 'max' => 100],
            [['tajuk_pero', 'perihal_pero'], 'string', 'max' => 255],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['perakuan_ksu'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['perakuan_ksu' => 'id']],
            [['bahagian_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['bahagian_id' => 'id']],
            [['kaedah_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['kaedah_id' => 'id']],
            [['kategori_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['kategori_id' => 'id']],
            [['jenis_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['jenis_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['peringkat_penilaian'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['peringkat_penilaian' => 'id']],
            [['perakuan_subkukp'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['perakuan_subkukp' => 'id']],
            [['perakuan_subw'], 'exist', 'skipOnError' => true, 'targetClass' => KonfRujukan::className(), 'targetAttribute' => ['perakuan_subw' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Bil',
            'staff_id' => 'Nama Penyedia',
            'bahagian_id' => 'Bahagian/Unit/Jabatan',
            'no_fail' => 'No Fail',
            'no_pero' => 'No Perolehan',
            'tajuk_pero' => 'Tajuk Perolehan',
            'perihal_pero' => 'Perihal Perolehan',
            'kaedah_id' => 'Kaedah Perolehan',
            'kategori_id' => 'Kategori Perolehan',
            'jenis_id' => 'Jenis Peruntukan',
            'status_id' => 'Status Perolehan',
            'jangka_pelawa' => 'Jangkaan Pelawaan ',
            'jangka_sst' => 'Jangkaan Tawaran SST',
            'anggarankos' => 'Anggaran Kos (RM)',
            'peringkat_penilaian' => 'Peringkat Penilaian',
            'perakuan_subkukp' => 'Perakuan SUB/KU/KP',
            'catatan_subkukp' => 'Ulasan SUB/KU/KP',
            'perakuan_subw' => 'Perakuan SUB(W)',
            'catatan_subw' => 'Ulasan SUB(W)',
            'perakuan_ksu' => 'Perakuan KSU',
            'catatan_ksu' => 'Keputusan dan Ulasan KSU',
            'created_at' => 'Tarikh Dicipta',
            'updated_at' => 'Tarikh Dikemaskini',
        ];
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'staff_id']);
    }

    /**
     * Gets query for [[PerakuanKsu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerakuanKsu()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'perakuan_ksu']);
    }

    /**
     * Gets query for [[Bahagian]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBahagian()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'bahagian_id']);
    }

    /**
     * Gets query for [[Kaedah]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKaedah()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'kaedah_id']);
    }

    /**
     * Gets query for [[Kategori]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'kategori_id']);
    }

    /**
     * Gets query for [[Jenis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenis()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'jenis_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[PeringkatPenilaian]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeringkatPenilaian()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'peringkat_penilaian']);
    }

    /**
     * Gets query for [[PerakuanSubkukp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerakuanSubkukp()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'perakuan_subkukp']);
    }

    /**
     * Gets query for [[PerakuanSubw]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerakuanSubw()
    {
        return $this->hasOne(KonfRujukan::className(), ['id' => 'perakuan_subw']);
    }

    /**
     * Gets query for [[ProsesPerolehans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProsesPerolehans()
    {
        return $this->hasMany(ProsesPerolehan::className(), ['pero_id' => 'id']);
    }
}
