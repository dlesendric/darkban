<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 12/27/2018
 * Time: 11:23 PM.
 */

namespace App\Controller\Api;

use App\Entity\Board;
use App\Form\BoardType;
use App\Util\Board\BoardManagerInterface;
use App\Util\Helpers\FormHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * @Security("is_granted('ROLE_USER')")
 * Class BoardController
 */
class BoardController extends AbstractController
{
    /**
     * @Route("/boards", name="api-boards-new", methods={"POST"})
     *
     * @param Request               $request
     * @param BoardManagerInterface $boardManager
     *
     * @return JsonResponse
     */
    public function newAction(Request $request, BoardManagerInterface $boardManager)
    {
        $user = $this->getUser();
        $board = $boardManager->createBoard($user);

        return $this->handleBoardForm($boardManager, $request, $board);
    }

    /**
     * @param BoardManagerInterface $boardManager
     * @param Request               $request
     *
     * @return JsonResponse
     * @Route("/boards", name="api-boards-list", methods={"GET"})
     */
    public function listAction(BoardManagerInterface $boardManager, Request $request)
    {
        $user = $this->getUser();
        $page = (int) $request->get('page');
        if (!$page) {
            $page = 1;
        }
        $perPage = 25;
        $data = $boardManager->getBoardsForUser($user, $page, $perPage);

        return new JsonResponse($data);
    }

    /**
     * @Route("/boards/{board}", methods={"PATCH"}, name="api-board-update")
     *
     * @param Board                 $board
     * @param Request               $request
     * @param BoardManagerInterface $boardManager
     *
     * @return JsonResponse
     */
    public function updateAction(Board $board, Request $request, BoardManagerInterface $boardManager)
    {
        if (!$this->isGranted('BOARD_EDIT', $board)) {
            // TODO uncomment on access denied handler listener and comment JsonResponse - related to symfony 4 throws exception in unit test
            //throw $this->createAccessDeniedException();
            return new JsonResponse('403 Unauthorized', 403);
        }

        return $this->handleBoardForm($boardManager, $request, $board);
    }

    private function handleBoardForm(BoardManagerInterface $boardManager, Request $request, Board $board)
    {
        $form = $this->createForm(BoardType::class, $board, [
            'method' => 'PATCH' === $request->getMethod() ? 'PATCH' : 'POST',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $boardManager->save($board, true);

            $json = $boardManager->serialize($board, 'json');

            return JsonResponse::fromJsonString($json);
        }
        $errors = FormHelper::getFormErrors($form);

        return new JsonResponse($errors, 400);
    }
}
