<?php
/* For licensing terms, see /license.txt */

use Chamilo\PluginBundle\MigrationMoodle\Task\BaseTask;

$cidReset = true;

ini_set('memory_limit', -1);
ini_set('max_execution_time', 0);

require_once __DIR__.'/../../main/inc/global.inc.php';

if (PHP_SAPI !== 'cli') {
    echo 'Run on CLI.'.PHP_EOL;
    exit;
}

$outputBuffering = false;

$plugin = MigrationMoodlePlugin::create();

//if ('true' != $plugin->get('active')) {
//    echo 'Plugin not active.'.PHP_EOL;
//    exit;
//}

$taskNames = [
    'course_categories',
    'courses',
    'course_introductions',
    'files_for_course_introductions',
    'course_sections',
    'files_for_course_sections',
    'course_modules_lesson',
    'lesson_pages',
    'lesson_pages_document',
    'files_for_lesson_pages',
    'lesson_pages_quiz',
    'lesson_pages_quiz_question',
    'lesson_answers_true_false',
    'lesson_answers_multiple_choice',
    'lesson_answers_multiple_answer',
    'lesson_answers_matching',
    'lesson_answers_essay',
    'lesson_answers_short_answer',
    'files_for_lesson_answers',
    'course_modules_quiz',
    'quizzes',
    'files_for_quizzes',
    'question_categories',
    'questions',
    'question_multi_choice_single',
    'question_multi_choice_multiple',
    'questions_true_false',
    'question_short_answer',
    'question_gapselect',
    'quizzes_scores',
    'course_modules_url',
    'urls',
    'sort_section_modules',
    'course_modules_scorm',
    'scorm_scoes',
    'files_for_scorm_scoes',
    'users',
    'users_last_login',
    'track_login',
    'user_sessions',
    'users_learn_paths',
    'users_learn_paths_lesson_timer',
    'users_learn_paths_lesson_branch',
    'users_learn_paths_lesson_attempts',
    'users_learn_paths_quizzes',
    'users_quizzes_attempts',
    'user_question_attempts_shortanswer',
    'user_question_attempts_gapselect',
    'user_question_attempts_truefalse',
    'users_scorms_view',
    'users_scorms_progress',
];

foreach ($taskNames as $i => $taskName) {
    $taskClass = api_underscore_to_camel_case($taskName).'Task';
    $taskClass = 'Chamilo\\PluginBundle\\MigrationMoodle\\Task\\'.$taskClass;

    echo PHP_EOL.($i + 1).': ';

    if ($plugin->isTaskDone($taskName)) {
        echo "$taskClass already done.".PHP_EOL;
        continue;
    }

    echo "Executing $taskClass.".PHP_EOL;

    /** @var BaseTask $task */
    $task = new $taskClass();
    $task->execute();

    echo "$taskClass end.".PHP_EOL;
}