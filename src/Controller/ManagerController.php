<?php

namespace App\Controller;

use App\Entity\BookingRequest;
use App\Form\BookingType;
use App\Repository\BookingRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/admin", name="homepage_admin")
     */
    public function index(BookingRequestRepository $calendar): Response
    {
        $events = $calendar->findAll();
//        dd($events);

        $rdvs=[];
        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getDateStart()->format('Y-m-d H:i:s'),
                'end' => $event->getDateEnd()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'color'=> sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255)),
            ];
        }

        $data = json_encode($rdvs);
        return $this->render('admin/index.html.twig', compact('data'));
    }

    /**
     * @Route("/new", name="booking_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $booking = new BookingRequest();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('calendar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(BookingRequest $booking): Response
    {
        return $this->render('admin/show.html.twig', [
            'booking' => $booking,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET"})
     */
    public function edit(Request $request, BookingRequest $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $booking->setDateUpdate( new \DateTimeImmutable());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('booking_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/list_admin", name="booking_index_admin", methods={"GET"})
     */
    public function list(BookingRequestRepository $bookingRepository): Response
    {
        return $this->render('admin/booking_list.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}/delete", name="booking_delete", methods={"GET"})
     */
    public function delete(Request $request, BookingRequest $booking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('homepage_admin', [], Response::HTTP_SEE_OTHER);
    }
}
