<?php
namespace App\Listener;

use App\Entity\Container\BookingContainer;
use App\Form\Extension\Validator\ValidatorExtension;
use App\Form\Form;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Workflow\Event\GuardEvent;

class BookingFormListener implements EventSubscriberInterface
{

    public function validateForm(GuardEvent $event)
    {
        /** @var BookingContainer $bookingContainer */
        $bookingContainer = $event->getSubject();


        $forms = $bookingContainer->forms;
        $booking = $bookingContainer->booking;

        $formDef = $forms[$bookingContainer->currentPlace];
        //$formDef['options']['disabled'] = true;

        $validator = Validation::createValidator();


        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new ValidatorExtension($validator))
            ->getFormFactory();

        //dump($formDef['data']);
        $form = $formFactory->create($formDef['class'],$formDef['data'],$formDef['options']);



        //dump("fake submit for form ".$form->getName());
        //dump($values);
        //$form->submit([],false);
        $this->validateWithoutSubmit($form);



        //dump('validate '.$bookingContainer->currentPlace);
        //dump($form);


        $errors = $form->getErrors(true);
        // Validator auf Fehler abfragen
        if (\count($errors) > 0) {
            //dump($bookingContainer->currentPlace." blocked");
            //dump($errors);
            $event->setBlocked(true);
        } else {
            //dump($bookingContainer->currentPlace." not blocked");
        }

        //$event->setBlocked(true);

    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.booking.guard.to_confirmed' => ['validateForm'],
            'workflow.booking.guard.to_step3' => ['validateForm'],
            'workflow.booking.guard.to_step2' => ['validateForm'],
        ];
    }


    private function validateWithoutSubmit(FormInterface $form)
    {

        $config = $form->getConfig();
        $children = $form->all();
        $dispatcher = $config->getEventDispatcher();
        $viewData = $form->getData();

        if ($config->getCompound()) {

            /**
             * @var string $name
             * @var FormInterface $child
             */
            foreach ($children as $name => $child) {
                $this->validateWithoutSubmit($child);
            }
        }

        if ($dispatcher->hasListeners(FormEvents::POST_SUBMIT)) {
            $event = new FormEvent($form, $viewData);
            $dispatcher->dispatch(FormEvents::POST_SUBMIT, $event);
        }

    }

}