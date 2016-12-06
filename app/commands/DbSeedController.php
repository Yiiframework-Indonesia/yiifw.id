<?php

namespace app\commands;

use accessUser\models\User;
use accessUser\models\UserProfile;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Description of DbSeedController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class DbSeedController extends Controller
{

    public function actionInitUser()
    {
        if (!Console::confirm('Are you sure you want to create some user')) {
            return self::EXIT_CODE_NORMAL;
        }
        $rows    = is_file(__DIR__ . '/data/user.php') ? require __DIR__ . '/data/user.php' : [];
        $total   = count($rows);
        $created = [];
        if ($total) {
            echo "\ninsert table 'user'";
            Console::startProgress(0, $total);
            foreach ($rows as $i => $row) {
                $row  = $this->assoc($row, ['username', 'fullname', 'email', 'password']);
                $user = new User([
                    'scenario' => User::SCENARIO_INIT_CMD,
                    'username' => $row['username'],
                    'email'    => $row['email'],
                    'status'   => User::STATUS_ACTIVE,
                ]);
                $user->setPassword($row['password']);
                $user->generateAuthKey();

                if ($user->save()) {
                    $created[] = $row['username'];
                    $profile   = new UserProfile(['fullname' => $row['fullname']]);
                    $user->link('profile', $profile);
                }
                Console::updateProgress($i + 1, $total);
            }
            Console::endProgress();
        }
        if (count($created)) {
            echo "user was created are \"" . implode('", "', $created) . "\"\n";
        }
    }

    protected function assoc($row, $columns)
    {
        $result = [];
        foreach ($columns as $i => $column) {
            $result[$column] = $row[$i];
        }
        return $result;
    }
}
