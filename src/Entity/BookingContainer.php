<?php
/**
 * Created by PhpStorm.
 * User: svewap
 * Date: 23.03.18
 * Time: 11:05
 */

namespace App\Entity;


class BookingContainer
{

    public function __construct($booking, $forms)
    {
        $this->booking = $booking;
        $this->forms = $forms;
    }

    /**
     * @var Booking
     */
    public $booking;


    /**
     * @var array
     */
    public $forms;


    /* workflow marking store */
    public $currentPlace;

}