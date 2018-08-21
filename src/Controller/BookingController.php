<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\BookingContainer;
use App\Entity\Participant;
use App\Form\Booking\InvoiceDataType;
use App\Form\Booking\LegalnoticeType;
use App\Form\Booking\ParticipantsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;


class BookingController extends Controller
{


    /**
     * @Route("/buchen/{force_step}", name="booking")
     * @throws \RuntimeException
     * @throws \LogicException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function book(Request $request, Registry $workflows, $force_step = 0, \Swift_Mailer $mailer)
    {

        $session = $request->getSession();
        if ($session === null) {
            $session = new Session();
            $session->start();
        }


        $entityManager = $this->getDoctrine()->getManager();


        /** @var Booking $booking */
        $booking = $session->get('booking', new Booking());
        if ($booking === null) {

            $booking = new Booking();
        }
        if (\count($booking->getParticipants()) === 0) {
            $booking->addParticipant(new Participant());
        }
        $form = null;

        $forms = [
            'step1' => ['class' => ParticipantsType::class, 'data' => $booking, 'options' => ['entityManager' => $entityManager]],
            'step2' => ['class' => InvoiceDataType::class, 'data' => $booking, 'options' => []],
            'step3' => ['class' => LegalnoticeType::class, 'data' => [], 'options' => []],
        ];


        $bookingContainer = new BookingContainer($booking,$forms);
        $workflow = $workflows->get($bookingContainer);


        // Update the currentState on the booking
        $availablePlaces = ['step1'];
        try {
            $workflow->apply($bookingContainer, 'to_step2');
            $availablePlaces[] = 'step2';
        } catch (LogicException $e) {
        }

        try {
            $workflow->apply($bookingContainer, 'to_step3');
            $availablePlaces[] = 'step3';
        } catch (LogicException $e) {
        }
        try {
            $workflow->apply($bookingContainer, 'to_confirmed');
            $availablePlaces[] = 'confirmed';
        } catch (LogicException $e) {
        }

        // set step if available


        if ($force_step !== 0 && \in_array($force_step,$availablePlaces)) {
            //dump('force step: '.$force_step);
            $bookingContainer->currentPlace = $force_step;
        }


        //dump('currentPlace: '.$bookingContainer->currentPlace);
        $formDef = isset($forms[$bookingContainer->currentPlace]) ? $forms[$bookingContainer->currentPlace] : null;


        if ($formDef) {

            $form = $this->createForm($formDef['class'],$formDef['data'],$formDef['options']);

            // request verarbeiten
            //dump('handle request');
            $form->handleRequest($request);
            //dump('/ handle request');

            if ($form->isSubmitted()) {
                //dump("handled request");
                if ($form->getData() instanceof Booking) {
                    $booking = $form->getData();
                    /** @var Participant $participant */
                    foreach ($booking->getParticipants() as $participant) {
                        $participant->setBooking($booking);
                    }
                    $bookingContainer->booking = $booking;
                }

            }

            if ($form->isSubmitted() && $form->isValid()) {

                if ($bookingContainer->currentPlace === 'step3') {

                    // fertig
                    /*
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($booking);
                    $entityManager->flush();
                    */

                    // Mail an Bucher
                    /*
                    $message = (new \Swift_Message('Ihre Buchungsbestätigung'))
                        ->setFrom($this->getParameter('mail.from'))
                        ->setTo($booking->getEmail())
                        ->setBody(
                            $this->renderView(
                                'emails/order_confirmation.html.twig',
                                ['booking' => $booking]
                            ),
                            'text/plain'
                        )
                    ;

                    $mailer->send($message);
                    */


                    // session
                    $session->set('booking', null);

                    return $this->redirectToRoute('book_completed');

                }


                // goto latest available step
                return $this->redirectToRoute('booking');
            }
        }



        // See all the available transitions for the post in the current state
        $transitions = $workflow->getEnabledTransitions($bookingContainer);

        $session->set('booking', $booking);

        return $this->render('booking/booking.html.twig', [
            'booking' => $booking,
            'transactions' => $transitions,
            'form' => $form ? $form->createView() : null,
            'bookingContainer' => $bookingContainer,
            'availablePlaces' => $availablePlaces,
            'numParticipants' => ($booking !== null) ? count($booking->getParticipants()) : 0,
        ]);
    }


    /**
     * @Route("/buchung-abgeschlossen", name="book_completed")
     */
    public function completed()
    {
        return $this->render('booking/completed.html.twig', [
        ]);
    }


}