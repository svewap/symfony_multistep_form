<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('lastName', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('email', EmailType::class, ['constraints' => [
                new NotBlank(),
                new Email()
            ]])
        ;

        /** @var FormBuilderInterface $element */
        foreach ($builder->all() as $element) {
            $element->addModelTransformer(new CallbackTransformer(
                function($originalInput){
                    return $originalInput;
                },
                function($submittedValue){
                    // When null is cast to a string, it will be empty.
                    return (string) $submittedValue;
                }
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Participant::class,
        ));
        $resolver->setRequired('entityManager');
    }
}