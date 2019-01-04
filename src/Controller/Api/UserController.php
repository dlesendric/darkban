<?php

namespace App\Controller\Api;

use App\Util\Helpers\FormHelper;
use App\Util\User\UserManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/users", methods={"POST"})
     *
     * @param Request              $request
     * @param UserManagerInterface $userManager
     *
     * @return JsonResponse|Response
     */
    public function registerAction(Request $request, UserManagerInterface $userManager)
    {
        $user = $userManager->createUser();
        $form = $this->createForm('App\Form\RegistrationFormType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->save($user, true);
            $serializer = SerializerBuilder::create()->build();
            $data = $serializer->serialize($user, 'json');

            return new Response($data);
        }
        $errors = FormHelper::getFormErrors($form);

        return new JsonResponse($errors, 400);
    }

    /**
     * @Route("/api/users/{email}", name="api-user-by-email")
     *
     * @param string               $email
     * @param UserManagerInterface $userManager
     *
     * @return JsonResponse
     */
    public function userByEmailAction(string $email, UserManagerInterface $userManager)
    {
        $user = $userManager->getRepository()->findOneBy([
            'email' => $email,
            'active' => 1,
        ]);
        if (!$user) {
            return new JsonResponse('404 Not Found', 404);
        }
        $serializer = SerializerBuilder::create()->build();
        $json = $serializer->serialize($user, 'json', SerializationContext::create()->setGroups(['Default']));

        return JsonResponse::fromJsonString($json);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/api/users", methods={"GET"}, name="api-users-lists")
     *
     * @param Request              $request
     * @param UserManagerInterface $userManager
     *
     * @return JsonResponse|Response
     */
    public function listAction(Request $request, UserManagerInterface $userManager)
    {
        $users = $userManager->getRepository()->findBy([
            'active' => 1,
        ]);
        $json = $userManager->serialize($users, 'json');

        return JsonResponse::fromJsonString($json);
    }
}
