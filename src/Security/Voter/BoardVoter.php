<?php

namespace App\Security\Voter;

use App\Entity\Board;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BoardVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['BOARD_EDIT', 'BOARD_VIEW'])
            && $subject instanceof Board;
    }

    /**
     * @param string         $attribute
     * @param Board          $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'BOARD_EDIT':
                if ($subject->getOwner()->getId() == $user->getId()) {
                    return true;
                }

                return false;
            case 'BOARD_VIEW':
                if ($subject->getOwner() == $user) {
                    return true;
                }
                if (false !== $subject->getUsers()->indexOf($user)) {
                    return true;
                }

                return false;
        }

        return false;
    }
}
