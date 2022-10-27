<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST", "GET"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             $userRoles = $this->getUser()->getRoles();
             if (in_array("ROLE_ADMIN", $userRoles))
             {
                 return $this->redirectToRoute('calendar_admin');
             }
              else
              {
                  return $this->redirectToRoute('calendar_manager');
              }
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('main/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): RedirectResponse
    {
        $this->addFlash(
            'has-background-info',
            'Запись отклонена'
        );
//        HOW TODO IT?
        return $this->redirectToRoute('app_login');
//        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
