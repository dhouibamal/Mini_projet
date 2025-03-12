<?php

// src/Controller/HotelController.php
namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    // Route pour afficher la liste des hôtels
    #[Route('/hotel', name: 'app_hotel')]
    public function index(HotelRepository $hotelRepository): Response
    {
        // Récupérer tous les hôtels depuis la base de données
        $hotels = $hotelRepository->findAll();

        // Passer les hôtels à la vue
        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotels,
        ]);
    }

    // Route pour afficher un hôtel
    #[Route('/hotel/view/{id}', name: 'view_hotel')]
    public function viewHotel(Hotel $hotel): Response
    {
        return $this->render('hotel/view.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    // Route pour afficher et ajouter un hôtel
    #[Route('/hotel/ajout', name: 'ajout')]
    public function ajoutHotel(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hotel = new Hotel();

        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('app_hotel');
        }

        return $this->render('hotel/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour éditer un hôtel
    #[Route('/hotel/edit/{id}', name: 'edit_hotel')]
    public function editHotel(Request $request, Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush(); // Met à jour l'hôtel existant
            return $this->redirectToRoute('app_hotel');
        }

        return $this->render('hotel/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour supprimer un hôtel
    #[Route('/hotel/delete/{id}', name: 'delete_hotel', methods: ['POST'])]
    public function deleteHotel(Hotel $hotel, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($hotel);
        $entityManager->flush();

        return $this->redirectToRoute('app_hotel');
    }
}
