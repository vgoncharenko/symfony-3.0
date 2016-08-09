<?php

namespace vgoncharenko\BookmarksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment", uniqueConstraints={@ORM\UniqueConstraint(name="unique_uid", columns={"uid"})})
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50, nullable=false)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=500, nullable=false)
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="bookmark_uid", type="integer", nullable=false)
     */
    private $bookmarkUid;

    /**
     * @var integer
     *
     * @ORM\Column(name="uid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $uid;

    /**
     * @var \vgoncharenko\BookmarksBundle\Entity\Bookmark
     *
     * @ORM\ManyToOne(targetEntity="vgoncharenko\BookmarksBundle\Entity\Bookmark", inversedBy="comment", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bookmark_uid", referencedColumnName="uid")
     * })
     */
    private $bookmark;



    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Comment
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set bookmarkUid
     *
     * @param integer $bookmarkUid
     *
     * @return Comment
     */
    public function setBookmarkUid($bookmarkUid)
    {
        $this->bookmarkUid = $bookmarkUid;

        return $this;
    }

    /**
     * Get bookmarkUid
     *
     * @return integer
     */
    public function getBookmarkUid()
    {
        return $this->bookmarkUid;
    }

    /**
     * Get uid
     *
     * @return integer
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set bookmark
     *
     * @param \vgoncharenko\BookmarksBundle\Entity\Bookmark $bookmark
     *
     * @return Comment
     */
    public function setBookmark(\vgoncharenko\BookmarksBundle\Entity\Bookmark $bookmark = null)
    {
        $this->bookmark = $bookmark;

        return $this;
    }

    /**
     * Get bookmark
     *
     * @return \vgoncharenko\BookmarksBundle\Entity\Bookmark
     */
    public function getBookmark()
    {
        return $this->bookmark;
    }
}
