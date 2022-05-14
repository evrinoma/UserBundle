<?php

namespace Evrinoma\UserBundle\Voter;

use Evrinoma\UserBundle\Entity\User;
use Evrinoma\SecurityBundle\Voter\RoleInterface as SuperUserRoleInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{

//region SECTION: Protected
    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [RoleInterface::ROLE_USER_EDIT, RoleInterface::ROLE_USER_CREATE])) {
            return false;
        }

        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user->hasRole(SuperUserRoleInterface::ROLE_SUPER_ADMIN) || $user->hasRole(RoleInterface::ROLE_USER_EDIT) || $user->hasRole(RoleInterface::ROLE_USER_CREATE)) {
            return true;
        }

        throw new \LogicException('You don\'t have specific permission');
    }
//endregion Protected
}