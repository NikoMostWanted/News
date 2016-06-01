<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/05/16
 * Time: 19:12
 */

namespace AppBundle\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;


class News
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 80
     * )
     */
    protected $title;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2
     * )
     */
    protected $text;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }
}