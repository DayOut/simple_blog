<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 *
 * @ORM\Entity()
 * @ORM\Table(name="comments")
 */
class Comment
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     */
    protected $nickname;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post", inversedBy="comment")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $post;

    public function __construct()
    {
        $this->setDate(new \DateTime());
        $this->setNickname("");
        $this->setBody("");
        //$this->setPost()
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Comment
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Comment
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(\AppBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \AppBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
