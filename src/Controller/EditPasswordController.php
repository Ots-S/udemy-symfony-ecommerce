<?php

namespace App\Controller;

use App\Form\EditPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditPasswordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/profile/password", name="edit_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if ($encoder->isPasswordValid($user, $oldPassword)) {
                $newPassword = $form->get('newPassword')->getData();
                $password = $encoder->encodePassword($user, $newPassword);
                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = "Votre mot de passe a bien été mis à jour";
            } else {
                $notification = "Votre mot passe actuel n'est pas le bon";
            }
        }

        return $this->render('profile/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
