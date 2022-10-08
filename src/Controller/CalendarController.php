<?php

namespace App\Controller;

//use App\Entity\Booking;
use App\Entity\BookingRequest;
use App\Form\BookingType;
//use App\Repository\BookingRepository;
use App\Repository\BookingRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/", name="calendar_index")
     */
    public function calendar(BookingRequestRepository $calendar): Response
    {
        $events = $calendar->findAll();

        $rdvs=[];
//        foreach($events as $event){
//            $rdvs[] = [
//                'id' => $event->getId(),
//                'start' => $event->getDateStart()->format('Y-m-d H:i:s'),
//                'end' => $event->getDateEnd()->format('Y-m-d H:i:s'),
//                'title' => $event->getTitle(),
//                'color'=> sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255)),
//            ];
//        }

        $data = json_encode($rdvs);
        return $this->render('main/index.html.twig', compact('data'));
    }

    /**
     * @Route("/list", name="booking_index", methods={"GET"})
     */
    public function list(BookingRequestRepository $bookingRepository): Response
    {
        return $this->render('main/booking_list.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(BookingRequest $booking): Response
    {
        return $this->render('main/show.html.twig', [
            'booking' => $booking,
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

        return $this->redirectToRoute('calendar_index', [], Response::HTTP_SEE_OTHER);
    }
}
