<?php

namespace App\Controller;

use App\Entity\BookingRequest;
use App\Form\BookingFormType;
use App\Repository\BookingRequestRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("", name="calendar_admin")
     */
    public function index(BookingRequestRepository $calendar): Response
    {
        $events = $calendar->findAll();

        $rdvs=[];
        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getDateStart()->format('Y-m-d H:i:s'),
                'end' => $event->getDateFinish()->format('Y-m-d H:i:s'),
                'title' => $event->getTitle(),
                'color'=> sprintf('#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255)),
            ];
        }

        $data = json_encode($rdvs);
        return $this->render('admin/index.html.twig', compact('data'));
    }

    /**
     * @Route("/new", name="booking_new_admin", methods={"GET", "POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $booking = new BookingRequest();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(BookingFormType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $documentFile = $form->get('document')->getData();
            if ($documentFile) {
                $documentFilename = $fileUploader->upload($documentFile);
                $booking->setDocumentFilename($documentFilename);
            }

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
     * @Route("/show/{id}", name="booking_show_admin", methods={"GET"})
     */
    public function show(BookingRequest $booking): Response
    {
        return $this->render('admin/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/approve/{id}", name="booking_approve_admin", methods={"GET"})
     */
    public function approve(EntityManagerInterface $entityManager, ?BookingRequest $booking): Response
    {
        if ($booking) {
            $booking->setIsApproved(TRUE);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_list_admin');
    }

    /**
     * @Route("/decline/{id}", name="booking_decline_admin", methods={"GET"})
     */
    public function decline(EntityManagerInterface $entityManager, ?BookingRequest $booking): Response
    {
        if ($booking) {
            $booking->setIsApproved(false);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_list_admin');
    }


    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET"})
     */
    public function edit(Request $request, BookingRequest $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookingFormType::class, $booking);
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
     * @Route("/list", name="booking_list_admin", methods={"GET"})
     */
    public function list(BookingRequestRepository $bookingRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $pagination = $paginator->paginate(
            $bookingRepository->findAllUnseen(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/booking_list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/list/archive", name="booking_list_archive_admin", methods={"GET"})
     */
    public function listArchive(BookingRequestRepository $bookingRepository): Response
    {
        return $this->render('admin/archive_booking_list.html.twig', [
            'bookings' => $bookingRepository->findAllSeen(),
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

        return $this->redirectToRoute('calendar_admin', [], Response::HTTP_SEE_OTHER);
    }
}
