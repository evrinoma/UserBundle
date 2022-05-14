<?php

namespace Evrinoma\UserBundle\Voter;

use App\Fcr\Voter\RoleInterface as FcrRoleInterface;
use Evrinoma\UserBundle\Voter\RoleInterface as UserRoleInterface;
use App\Voter\Privileges\RoleInterface;
use Evrinoma\SecurityBundle\Voter\RoleInterface as SuperUserRoleInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RevokeRole extends Voter
{

//region SECTION: Protected
    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [RoleInterface::ROLE_REVOKE_PRIVILEGES])) {
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

        switch (true) {
            case $user->hasRole(SuperUserRoleInterface::ROLE_SUPER_ADMIN):
                return true;
            case $user->hasRole(UserRoleInterface::ROLE_USER_CREATE):
            case $user->hasRole(UserRoleInterface::ROLE_USER_EDIT):
                return str_starts_with($subject, FcrRoleInterface::ROLE_FCR_);
            default:
                return false;
        }
    }
//endregion Protected
}