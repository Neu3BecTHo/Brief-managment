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
use Faker\Factory;

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
            $user = $authManager->createRole('user');
            Console::error('Роль "Пользователь" не создана.');
            $user->description = 'Пользователь с базовыми правами.';

            $manager = $authManager->createRole('manager');
            Console::error('Роль "Менеджер" не создана.');
            $manager->description = 'Менеджер с правами на рассмотрение брифов.';

            $admin = $authManager->createRole('admin');
            Console::error('Роль "Администратор" не создана.');
            $admin->description = 'Администратор с правами на все.';

            $authManager->add($user);
            $authManager->add($manager);
            $authManager->add($admin);

            $authManager->addChild($manager, $user);
            $authManager->addChild($admin, $manager);

            Console::output('Роли созданы.');
        } catch (Exception $e) {
            Console::error('Ошибка при создании ролей: ' . $e->getMessage());
        }
    }

    public function actionCreateAdmin()
    {
        $user = User::findOne(['username' => 'admin']);
        $faker = Factory::create('ru_RU');

        if (!$user) {
            $user = new User();
            $user->username = 'admin';
            $user->password = 'admin';
            $user->email = 'admin@admin.com';
            $user->phone = $faker->phoneNumber;

            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->patronymic = $faker->sentence(1);

            if ($user->save()) {
                try {
                    $authManager = Yii::$app->authManager;
                    $adminRole = $authManager->getRole('admin');

                    if (!$adminRole) {
                        Console::error('Роль "admin" не найдена. Сначала выполните php yii seed/init');
                        return;
                    }

                    $authManager->assign($adminRole, $user->id);
                    Console::output('Администратор ' . $user->username . ' создан.');
                    Console::output('Пароль: admin');
                } catch (Exception $e) {
                    Console::error($e->getMessage());
                }
            } else {
                $errorMessages = [];
                foreach ($user->errors as $field => $errors) {
                    $errorMessages = array_merge($errorMessages, $errors);
                }
                Console::error('Администратор ' . $user->username . ' не создан из-за ошибок: ' .
                implode(', ', $errorMessages));
            }
        } else {
            Console::output('Администратор ' . $user->username . ' уже существует.');
        }
    }

    public function actionCheckRoles()
    {
        $authManager = Yii::$app->authManager;
        $roles = $authManager->getRoles();
        foreach ($roles as $role) {
            Console::output($role->name);
        }
    }
}
