<?php

namespace App\Application\DTO;

class ProductData
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $link;

    /**
     * @var \DateTime
     */
    public $pubDate;

    /**
     * ProductData constructor.
     * @param int $id
     * @param string $title
     * @param string $link
     * @param \DateTime $pubDate
     */
    public function __construct(int $id, string $title, string $link, \DateTime $pubDate)
    {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
        $this->pubDate = $pubDate;
    }
}
