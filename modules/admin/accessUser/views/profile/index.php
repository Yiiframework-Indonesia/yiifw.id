<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\widgets\Panel;
use rmrevin\yii\fontawesome\component\Icon;
use accessUser\models\User;
use \kartik\tabs\TabsX;

/* @var $this View */
/* @var $model accessUser\models\UserProfile */
$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$email = $model->email;

?>

<?php Panel::begin(
    [
        'header' => 'Your Profile ',
        'icon'   => 'user',
    ]
)?>

<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
    <div class="profile_img">
        <div id="crop-avatar">
            <a data-toggle="modal" data-target="#ChangePhotoProfile" id="btn-change-photo">
                <?= Html::img($model->avatarUrl ? : '@web/img/default.jpg', [
                    'class' => 'img-responsive avatar-view',
                ])?>
            </a>
        </div>
    </div>
    <?= Html::tag('h3',Html::encode($model->fullname)) ?>
    <p>"<?=$model->bio ? $model->bio : 'No description' ?>"</p><br>

    <ul class="list-unstyled user_data">
        <li>
            <?=new Icon('circle user-profile-icon')?> <?=User::getStatusView($model->user->status) ?>
        </li>
        <li>
            <?=new Icon('genderless user-profile-icon')?> <?=$model->gender?>
        </li>
        <li class="m-top-xs">
            <?=new Icon('map-marker user-profile-icon')?> <?=$model->address?>
        </li>
    </ul>
    <br>
    <h4>Contact</h4>
    <ul class="list-unstyled user_data">
        <?php
        foreach ($model->contacts as $contact) {
            $row = null;
            switch ($contact->type) {
                case 'profile':
                    $link = Html::a($contact->value, $contact->value, ['target' => '_blank']);
                    echo "<p>{$contact->name} : {$link} </p>\n";
                    break;
                case 'email':
                    $link = Html::mailto($contact->value, $contact->value);
                    echo "<p>{$link}</p>\n";
                    break;
                default :
            }
        }
        ?>
    </ul>
</div>
<div class="col-md-9 col-sm-9 col-xs-12">
    <?= \kartik\tabs\TabsX::widget([
        'items' => [
            [
                'label' => 'Account',
                'content' => $this->render('profile', ['model' => $model]),
                'active' => true
            ],
            [
                'label' => 'Recent Activity',
                'content' => 'No activity'
            ],
        ],
        'navType' => 'nav nav-tabs bar_tabs'
    ]);?>
</div>
<?php Panel::end() ?>

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
                                 <?= Html::img($model->avatarUrl ? : '@web/img/default.jpg') ?>
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
<?php $this->registerJsFile('@web/plugins/fileinput.min.js', ['depends' => 'app\assets\AdminAsset']); ?>