<?php

namespace App\Controller\Api;

use App\Entity\Lists;
use App\Entity\Task;
use App\Form\TaskType;
use App\Util\Helpers\FormHelper;
use App\Util\Lists\ListsManagerInterface;
use App\Util\Task\TaskManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/tasks")
 * Class TaskController
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/lists/{lists}", name="api-tasks-new", methods={"POST"})
     *
     * @param Lists                $lists
     * @param TaskManagerInterface $taskManager
     * @param Request              $request
     *
     * @return JsonResponse
     */
    public function newAction(Lists $lists, TaskManagerInterface $taskManager, Request $request)
    {
        $task = $taskManager->createTask($lists);

        return $this->handleTaskForm($task, $request, $taskManager);
    }

    /**
     * @Route("/{task}", name="api-taks-update", requirements={"task":"\d+"}, methods={"PATCH"})
     *
     * @param Task                 $task
     * @param TaskManagerInterface $taskManager
     * @param Request              $request
     *
     * @return JsonResponse
     */
    public function updateAction(Task $task, TaskManagerInterface $taskManager, Request $request)
    {
        return $this->handleTaskForm($task, $request, $taskManager);
    }

    /**
     * @Route("/{task}", name="api-tasks-delete", requirements={"task":"\d+"}, methods={"DELETE"})
     *
     * @param Task                  $task
     * @param ListsManagerInterface $listsManager
     *
     * @return Response
     */
    public function deleteAction(Task $task, ListsManagerInterface $listsManager)
    {
        $list = $task->getList();
        if (!$list) {
            return new JsonResponse('404 Not Found', 404);
        }
        $board = $list->getBoard();
        if (!$board) {
            return new JsonResponse('404 Not Found', 404);
        }
        if (!$this->isGranted('BOARD_VIEW', $board)) {
            return new JsonResponse('403 Unauthorized', 403);
        }
        $listsManager->delete($task);

        return new Response('', 204);
    }

    private function handleTaskForm(Task $task, Request $request, TaskManagerInterface $taskManager)
    {
        $form = $this->createForm(TaskType::class, $task, [
            'method' => 'PATCH' == $request->getMethod() ? 'PATCH' : 'POST',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $taskManager->save($task, true);
            $json = $taskManager->serialize($task, 'json');

            return JsonResponse::fromJsonString($json);
        }
        $errors = FormHelper::getFormErrors($form);

        return new JsonResponse($errors, 400);
    }
}
