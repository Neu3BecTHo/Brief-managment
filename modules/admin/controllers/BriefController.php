<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\BriefAnswers;
use app\models\BriefQuestions;
use app\models\Briefs;
use app\models\Statuses;
use app\models\TypeFields;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;

class BriefController extends Controller
{
    /**
     * Список всех брифов
     */
    public function actionIndex()
    {
        $briefs = Briefs::find()
            ->with(['user', 'status', 'briefQuestions'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'briefs' => $briefs,
        ]);
    }

    /**
     * Просмотр брифа
     */
    public function actionView($id)
    {
        $brief = $this->findModel($id);

        return $this->render('view', [
            'brief' => $brief,
        ]);
    }

    /**
     * Создание нового брифа
     */
    public function actionCreate()
    {
        $brief = new Briefs();
        $brief->user_id = Yii::$app->user->id;
        $brief->status_id = 1;

        if ($brief->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($brief->save()) {
                    $questions = Yii::$app->request->post('questions', []);
                    $this->saveQuestions($brief->id, $questions);

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Бриф успешно создан.');
                    return $this->redirect(['view', 'id' => $brief->id]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ошибка при создании брифа: ' . $e->getMessage());
            }
        }

        return $this->render('create', [
            'brief' => $brief,
            'statuses' => Statuses::find()->select(['title', 'id'])->indexBy('id')->column(),
            'typeFields' => TypeFields::getTypesDropdown(),
        ]);
    }

    /**
     * Редактирование брифа
     */
    public function actionUpdate($id)
    {
        $brief = $this->findModel($id);

        if ($brief->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Явно обновляем статус, заголовок и описание через QueryBuilder
                Yii::$app->db->createCommand()->update('{{%briefs}}', [
                    'status_id' => (int)$brief->status_id,
                    'title' => $brief->title,
                    'description' => $brief->description,
                ], ['id' => $brief->id])->execute();

                // Дальше работаем с вопросами
                BriefQuestions::deleteAll(['brief_id' => $brief->id]);

                $questions = Yii::$app->request->post('questions', []);
                $this->saveQuestions($brief->id, $questions);

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Бриф успешно обновлён.');
                return $this->redirect(['view', 'id' => $brief->id]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Ошибка при обновлении: ' . $e->getMessage());
            }
        }

        return $this->render('update', [
            'brief' => $brief,
            'statuses' => Statuses::find()->select(['title', 'id'])->indexBy('id')->column(),
            'typeFields' => TypeFields::find()->select(['title', 'id'])->indexBy('id')->column(),
        ]);
    }

    /**
     * Удаление брифа
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Бриф удалён.');

        return $this->redirect(['index']);
    }

    /**
     * Список ответов на бриф
     */
    public function actionResponses($id)
    {
        $brief = $this->findModel($id);

        // Получение всех ответов на вопросы этого брифа
        $answers = BriefAnswers::find()
            ->joinWith(['briefQuestion', 'user'])
            ->where(['{{%brief_questions}}.brief_id' => $brief->id])
            ->orderBy(['{{%brief_answers}}.created_at' => SORT_DESC])
            ->all();

        // Группировка по пользователям
        $userAnswers = [];
        foreach ($answers as $answer) {
            $userId = $answer->user_id;
            if (!isset($userAnswers[$userId])) {
                $userAnswers[$userId] = [
                    'user' => $answer->user,
                    'answers' => [],
                    'created_at' => $answer->created_at,
                ];
            }
            $userAnswers[$userId]['answers'][] = $answer;
        }

        return $this->render('responses', [
            'brief' => $brief,
            'userAnswers' => $userAnswers,
        ]);
    }

    /**
     * Сохранение вопросов
     */
    protected function saveQuestions($briefId, $questions)
    {
        if (empty($questions)) {
            return; // Если вопросов нет, выходим
        }

        foreach ($questions as $index => $questionData) {
            // Проверяем, что данные есть
            if (empty($questionData['question']) || empty($questionData['type_field_id'])) {
                continue; // Пропускаем пустые вопросы
            }

            $question = new BriefQuestions();
            $question->brief_id = $briefId;
            $question->question = $questionData['question'];
            $question->type_field_id = (int)$questionData['type_field_id'];
            $question->is_required = isset($questionData['is_required']) ? 1 : 0;
            $question->sort_order = (int)$index;

            $raw = $questionData['options'] ?? '';
            $options = array_filter(array_map('trim', explode(',', $raw)));
            if (!empty($options)) {
                $question->setOptionsArray($options);
            }

            if (!$question->save()) {
                throw new \Exception('Ошибка сохранения вопроса: ' . Json::encode($question->errors));
            }
        }
    }

    /**
     * Поиск модели по ID
     */
    protected function findModel($id)
    {
        if (($model = Briefs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Бриф не найден.');
    }
}
