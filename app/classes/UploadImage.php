<?php

namespace app\classes;

use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use mdm\upload\FileModel;
use yii\validators\ImageValidator;
use yii\imagine\Image;

/**
 * Description of UploadImage
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class UploadImage
{
    /**
     * @param string $name
     * @param array $options
     * @return boolean
     */
    public static function store($name, $options = [])
    {
        $multiple = ArrayHelper::remove($options, 'multiple', false);
        $width = ArrayHelper::remove($options, 'width');
        $height = ArrayHelper::remove($options, 'height');
        $validator = new ImageValidator();
        if ($width !== null || $height !== null) {
            $options['saveCallback'] = function ($model) use($width, $height) {
                return static::resizeImage($model, $width, $height);
            };
        }
        if ($multiple) {
            $files = UploadedFile::getInstancesByName($name);
            foreach ($files as $file) {
                if (!$validator->validate($file)) {
                    return false;
                }
            }
            $result = [];
            foreach ($files as $file) {
                if (false !== ($model = FileModel::saveAs($file, $options))) {
                    $result[] = $model->id;
                } else {
                    return false;
                }
            }
            return $result;
        } else {
            $file = UploadedFile::getInstanceByName($name);
            if ($validator->validate($file) && ($model = FileModel::saveAs($file, $options)) !== false) {
                return $model->id;
            }
        }
        return false;
    }

    /**
     *
     * @param FileModel $model
     * @param integer $width
     * @param integer $height
     */
    public static function resizeImage($model, $width, $height)
    {
        $image = Image::thumbnail($model->file->tempName, $width, $height);
        $image->save($model->filename);
        $model->size = filesize($model->filename);
        return true;
    }
}
