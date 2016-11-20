<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model app\models\ar\UserProfile */
$this->title = $model->fullname;
$this->params['breadcrumbs'][] = $this->title;

$email = $model->email;
$isEditable = Yii::$app->user->id == $model->user_id;
?>
<div data-widget-group="group1">
    <div class="row">
        <!--PHOTO BOX|INFO-->
        <div class="col-md-3">
            <div class="panel panel-profile">
                <div class="panel-body">
                    <div class="row">
                        <a data-toggle="modal" data-target="#ChangePhotoProfile" id="btn-change-photo">
                            <?=
                            Html::img($model->avatarUrl ? : '@web/img/default.jpg', [
                                'class' => 'media-object img-responsive img-thumbnail',
                                'width' => '200', 'height' => '400'])
                            ?>
                        </a>
                    </div>

                </div>
            </div>

            <div class="panel panel-profile">
                <div class="panel-body">
                    <div>
                        <div class="personel-info pt-n">
                            <span class="icon" title="Email"><i class="material-icons">email</i></span>
                            <span class="tooltips" data-trigger="hover" data-original-title="<?= Html::encode($email) ?>">
                                <?= Html::mailto(StringHelper::truncate($email, 25, '...'), $email, ['target' => '_blank']) ?>
                            </span>
                        </div>
                        <div class="personel-info ">
                            <span class="icon" title="Username"><i class="material-icons">person</i></span>
                            <span class="tooltips" data-trigger="hover" data-original-title="<?= Html::encode($model->username) ?>">
                                <?= Html::encode(StringHelper::truncate($model->username, 25, '...')) ?>
                            </span>
                        </div>
                        <div class="personel-info">
                            <span class="icon" title="Address"><i class="material-icons">place</i></span>
                            <?php if ($model->address) : ?>
                                <span class="tooltips" data-trigger="hover" data-original-title="<?= Html::encode($model->address) ?>">
                                    <?= Html::encode(StringHelper::truncate($model->address, 25, '...')) ?>
                                </span>
                            <?php else: ?>
                                <span>-</span>
                            <?php endif; ?>
                        </div>
                        <div class="personel-info">
                            <span class="icon" title="Phone"><i class="material-icons">call</i></span>
                            <span>

                            </span>
                        </div>

                    </div>

                </div>
            </div><!-- panel -->
        </div><!-- col-sm-3 -->

        <div class="col-md-9">
            <div class="tab-content">
                <div class="panel-profile">
                    <div class="tab-content">

                        <!--start: TAB ABOUT-->
                        <div class="tab-pane p-md active" id="about">
                            <div class="about-area">
                                <?php if ($isEditable): ?>
                                    <span class="badge badge-primary pull-right">
                                        <a href="<?= Url::to(['update-profile']) ?>" style="color: #fff">
                                            <i class="fa fa-edit"></i> edit profile
                                        </a>
                                    </span>
                                <?php endif; ?>
                                <h4>
                                    About <?= $model->username ?>
                                </h4>
                                <?= $model->bio ?>
                            </div>

                            <div class="about-area">
                                <!--<h4>Personal Information</h4>-->
                                <div class="table-responsive">
                                    <table class="table about-table">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td><?= Html::encode($model->fullname) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Birth Date</th>
                                                <td> <?= Yii::$app->formatter->asDate($model->birth_day, 'php:d/m/Y') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td><?= $model->gender ?></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td><?= Html::encode($model->address) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Username</th>
                                                <td><?= Html::encode($model->username) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?= Html::mailto($model->email, $model->email, ['target' => '_blank']) ?>

                                                    <?php
                                                    if (Yii::$app->user->id == $model->user_id):
                                                        ?>
                                                        <span class="badge badge-primary">
                                                            <a href="<?= Url::to(['update-user-email']) ?>" style="color: #fff">
                                                                <i class="fa fa-edit"></i> edit email
                                                            </a>
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php
                                            foreach ($model->contacts as $contact) {
                                                $row = null;
                                                switch ($contact->type) {
                                                    case 'profile':
                                                        $link = Html::a($contact->value, $contact->value, ['target' => '_blank']);
                                                        echo "<tr><th>{$contact->name}</th><td>{$link}</td></tr>\n";
                                                        break;
                                                    case 'email':
                                                        $link = Html::mailto($contact->value, $contact->value);
                                                        echo "<tr><th></th><td>{$link}</td></tr>\n";
                                                        break;
                                                    default :
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!--end: TAB ABOUT-->

                    </div>
                </div>
            </div><!-- .tab-content -->
        </div><!-- col-sm-8 -->
    </div>
</div>

<?php if ($isEditable): ?>
    <div id="ChangePhotoProfile" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <?=
            Html::beginForm(['upload-photo'], 'post', [
                'class' => 'form-horizontal',
                'enctype' => 'multipart/form-data'
            ]);
            ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h2 class="modal-title">Change photo</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail mb20"
                                 data-trigger="fileinput" style="width: 100%; height: 150px;">
                                     <?php Html::img($model->avatarUrl ? : '@web/img/default.jpg') ?>
                            </div>
                            <div>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">
                                    Remove
                                </a>
                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="image">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-raised btn-primary">Save changes<div class="ripple-container"></div></button>
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    </div>
    <?php $this->registerJsFile('@web/paperadmin/plugins/form-jasnyupload/fileinput.min.js', ['depends' => 'app\assets\PaperAdmin']); ?>
<?php endif; ?>
