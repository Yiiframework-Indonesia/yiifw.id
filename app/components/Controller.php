<?php
namespace app\components;

use Yii;

/**
 *  Extend Controller
 *
 *  @author Muhamad Alfan <muhamad.alfan01@gmail.com>
 *  @since  1.0
 */
class Controller extends \yii\web\Controller
{
    /**
     *  Menampilkan url yang sedang aktif
     *
     *  @return string
     */
    public function currentUrl()
    {
        return \yii\helpers\Url::current([], true);
    }

    /**
     *  Mempersingkat penggunaan method void setFlash
     *
     *  @param  string $type [error | danger | success | info | warning]
     *  @param  string $message [pesan yang akan dibuat]
     *  @return boolean
     */
    public function flash($type, $message)
    {
        Yii::$app->getSession()->setFlash($type, $message);
    }

    /**
     *  Method debug biasa digunakan untuk penelusuran data
     *
     *  @param  stirng $data
     *  @param  boolean $tipe [TRUE = var_dump | FALSE = print_r]
     *  @param  boolean $die
     */
    public function debugCode($data, $tipe = false, $die = true)
    {
        echo '<pre>';
        $tipe ? var_dump($data) : print_r($data);
        echo '</pre>';
        $die ? die() : '';
    }

    /**
     *  Reload aplikasi jika ada perubahan data
     *
     *  @return object
     */
    public function reload()
    {
        if (Yii::$app->request->referrer) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->goHome();
        }
    }
}
