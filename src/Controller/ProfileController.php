<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function show(ReservationRepository $res): Response
    {
        $currentDate = new \DateTime();
        $userReservation = $res->findBy(['user' => $this->getUser()], ['updated_at' => 'DESC']);

        return $this->render('profile/show.html.twig', ['userReservation' => $userReservation, 'currentDate' => $currentDate]);
    }

    #[Route('/profile/img', name: 'app_profile_img')]
    public function uploadImg(Request $request, EntityManagerInterface $em, UserRepository $ur): Response
    {
        $file = $request->files->get('file');
        if ($file->getClientMimeType() == "image/png" || $file->getClientMimeType() == "image/jpg" || $file->getClientMimeType() == "image/jpeg" || $file->getClientMimeType() == "image/webp") {
            //Logique d'enregistrement de l'image
            $nameFile = $fileName = uniqid() . '-' . $file->getClientOriginalName();
            // Définir le chemin où enregistrer l'image
            $destinationPath = $this->getParameter('kernel.project_dir') . '/assets/images/';

            try {
                // Déplacer le fichier vers le répertoire de destination
                $file->move($destinationPath, $fileName);
            } catch (FileException $e) {
                // Gérer l'exception en cas d'erreur lors du déplacement du fichier
                return new Response('Erreur lors de l\'enregistrement du fichier : ' . $e->getMessage(), 500);
            }

            // BDD
            $user = $ur->findOneById($this->getUser());
            if ($user->getImage() !== null) {
                // Supprimer l'image précédente
                unlink($destinationPath . $user->getImage());
            }

            $user->setImage($nameFile);
            $em->persist($user);
            $em->flush();


            $this->addFlash('success', "Votre image de profile a bien été modifié.");
            return $this->redirectToRoute('app_profile');
        } else {

            $this->addFlash('error', "Une erreur est survenue lors de votre changement d'avatar.");
            return $this->redirectToRoute('app_profile');
        }
    }
}
