<?php

namespace App\Form\Booking;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class InvoiceDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('firstName', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('lastName', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('department', TextType::class, ['constraints' => [
            ]])
            /*
            ->add('telephone', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('street', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('housenumber', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('zipcode', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('country', TextType::class, ['constraints' => [
                new NotBlank()
            ]])
            ->add('email', TextType::class, ['constraints' => [
                new NotBlank(),
                new Email()
            ]])
            ->add('vat', TextType::class, ['constraints' => [
                new NotBlank()
            ]])*/
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
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}