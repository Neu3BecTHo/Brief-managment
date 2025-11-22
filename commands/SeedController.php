<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use app\models\User;
use yii\console\Controller;
use yii\helpers\Console;
use Exception;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SeedController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        if ($authManager->getRoles()) {
            $authManager->removeAll();
            Console::output('Роли удалены.');
        }

        try {
            if (!$user = $authManager->createRole('user')) {
                Console::error('Роль "Пользователь" не создана.');
            }
            $user->name = 'Пользователь';
            $user->description = 'Пользователь с базовыми правами.';

            if (!$manager = $authManager->createRole('manager')) {
                Console::error('Роль "Менеджер" не создана.');
            }
            $manager->name = 'Менеджер';
            $manager->description = 'Менеджер с правами на рассмотрение брифов.';

            if (!$admin = $authManager->createRole('admin')) {
                Console::error('Роль "Администратор" не создана.');
            }
            $admin->name = 'Администратор';
            $admin->description = 'Администратор с правами на все.';

            $authManager->add($user);
            $authManager->add($manager);
            $authManager->add($admin);

            $authManager->addChild($manager, $user);
            $authManager->addChild($admin, $manager);

            Console::output('Роли созданы.');
        } catch (Exception $e) {
            Console::error($e->getMessage());
        }
    }

    public function actionCreateAdmin()
    {
        $user = User::findOne(['username' => 'admin']);
        if (!$user) {
            $user = new User();
            $user->username = 'admin';
            $user->email = 'admin@admin.com';
            $user->setPassword('admin');
            $user->generateAuthKey();
            $user->generateAccessToken();
            $user->save(false);
            Console::output('Администратор создан.');
        }
    }
}
