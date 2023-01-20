<?php

namespace App\Security\Voter;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class SubscriberVoter extends Voter
{
    public const INPROGRESS = 'IN_PROGRESSS';

    private $session;
    private $security;

    public function __construct(RequestStack $requestStack, Security $security)
    {
        $this->session = $requestStack->getSession();
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return $attribute === self::INPROGRESS;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // if user has valid subscription
        if( $this->session->has('subscribe') ) {
            return true;
        }

        // if user is admin
        if( $this->security->isGranted('ROLE_ADMIN') ) {
            return true;
        }

        return false;
    }
}
