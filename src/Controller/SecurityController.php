<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        header("Access-Control-Allow-Origin: *");
    }

    /**
     * @Route("/login", name="security_login", methods="POST")
     */
    public function login(Request $request, PasswordEncoderInterface $encoder): Response
    {
        $email = $request->request->get('_email');
        $password = $request->request->get('_password');
        $user = $this->repository->findOneBy(['email' => $email]);
        if ($user instanceof UserInterface) {
            if ($encoder->isPasswordValid($user->getPassword(), $password, null)) {
                $user = [
                    'email' => $user->getEmail(),
                ];
                return (new JsonResponse($user))->setEncodingOptions(JSON_FORCE_OBJECT);
            }
        }
        return new JsonResponse(false);
    }

    /**
     * @Route("/register", name="security_register", methods="POST")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $encodedPassword = $encoder->encodePassword($user, $password);
        $user->setEmail($email)
            ->setNom($nom)
            ->setPrenom($prenom)
            ->setPassword($encodedPassword);
        $em = $this->getDoctrine()->getManager();
        try {
            $em->persist($user);
            $em->flush();
            return new JsonResponse(true);
        } catch (DBALException $e) {
            return new JsonResponse($e);
        }
    }
}
