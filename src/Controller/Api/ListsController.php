<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/27/2018
 * Time: 11:23 PM.
 */

namespace App\Controller\Api;

use App\Entity\Board;
use App\Entity\Lists;
use App\Form\ListsType;
use App\Util\Helpers\FormHelper;
use App\Util\Lists\ListsManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/lists")
 * Class ListController
 */
class ListsController extends AbstractController
{
    /**
     * @Route("/board/{board}", methods={"GET"}, name="api-lists-by-board")
     *
     * @param Board                 $board
     * @param ListsManagerInterface $listsManager
     *
     * @return JsonResponse
     */
    public function listsByBoardAction(Board $board, ListsManagerInterface $listsManager)
    {
        if (!$this->isGranted('BOARD_VIEW', $board)) {
            return new JsonResponse('403 Unauthorized', 403);
        }
        $data = $listsManager->getListsForBoard($board);

        return new JsonResponse($data);
    }

    /**
     * @Route("/board/{board}", methods={"POST"}, name="api-new-lists")
     *
     * @param Board                 $board
     * @param Request               $request
     * @param ListsManagerInterface $listsManager
     *
     * @return JsonResponse
     */
    public function newListsAction(Board $board, Request $request, ListsManagerInterface $listsManager)
    {
        if (!$this->isGranted('BOARD_EDIT', $board)) {
            return new JsonResponse('403 Unauthorized', 403);
        }
        $list = $listsManager->createLists($board);

        return $this->handleListForm($list, $request, $listsManager);
    }

    /**
     * @Route("/{list}", methods={"PATCH"}, name="api-update-lists", requirements={"list" : "\d+"})
     *
     * @param Lists                 $list
     * @param Request               $request
     * @param ListsManagerInterface $listsManager
     *
     * @return JsonResponse
     */
    public function updateListsAction(Lists $list, Request $request, ListsManagerInterface $listsManager)
    {
        $board = $list->getBoard();
        if (!$this->isGranted('BOARD_EDIT', $board)) {
            return new JsonResponse('403 Unauthorized', 403);
        }

        return $this->handleListForm($list, $request, $listsManager);
    }

    /**
     * @param Lists                 $list
     * @param Request               $request
     * @param ListsManagerInterface $listsManager
     *
     * @return JsonResponse
     */
    private function handleListForm(Lists $list, Request $request, ListsManagerInterface $listsManager)
    {
        $form = $this->createForm(ListsType::class, $list, [
            'method' => 'PATCH' == $request->getMethod() ? 'PATCH' : 'POST',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //todo calculate order
            $listsManager->save($list, true);
            $json = $listsManager->serialize($list, 'json', ['Default', 'boards', 'tasks']);

            return JsonResponse::fromJsonString($json);
        }
        $errors = FormHelper::getFormErrors($form);

        return new JsonResponse($errors, 400);
    }
}
