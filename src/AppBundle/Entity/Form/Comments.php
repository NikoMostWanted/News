<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 01/06/16
 * Time: 21:59
 */

namespace AppBundle\Entity\Form;

use Symfony\Component\Validator\Constraints as Assert;

class Comments
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 20
     * )
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2
     * )
     */
    protected $text;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
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