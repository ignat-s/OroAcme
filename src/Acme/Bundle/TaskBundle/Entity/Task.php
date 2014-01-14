<?php

namespace Acme\Bundle\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use JMS\Serializer\Annotation as JMS;

use OroCRM\Bundle\ContactBundle\Entity\Contact;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

use Oro\Bundle\DataAuditBundle\Metadata\Annotation as Oro;

use Oro\Bundle\UserBundle\Entity\User;

/**
 * Task item
 *
 * @ORM\Table(name="acme_task", indexes={
 *      @ORM\Index(name="acme_task_description_idx", columns={"description"})
 * })
 * @ORM\HasLifecycleCallbacks()
 * @Oro\Loggable
 * @ORM\Entity
 * @Config(
 *  defaultValues={
 *      "ownership"={
 *          "owner_type"="USER",
 *          "owner_field_name"="owner",
 *          "owner_column_name"="owner_id"
 *      },
 *      "security"={
 *          "type"="ACL"
 *      },
 *      "dataaudit"={"auditable"=true}
 *  }
 * )
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Oro\Versioned
     * @ConfigField(defaultValues={"dataaudit"={"auditable"=true}})
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @ConfigField(defaultValues={"dataaudit"={"auditable"=true}})
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="OroCRM\Bundle\ContactBundle\Entity\Contact")
     * @ORM\JoinTable(name="acme_task_contacts",
     *      joinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     * @Oro\Versioned
     * @ConfigField(defaultValues={"dataaudit"={"auditable"=true}})
     * @JMS\Exclude
     */
    protected $relatedContacts;

    /**
     * @var TaskStatus
     *
     * @ORM\ManyToOne(targetEntity="Acme\Bundle\TaskBundle\Entity\TaskStatus")
     * @ORM\JoinColumn(name="status_name", referencedColumnName="name", onDelete="SET NULL")
     * @Oro\Versioned("getLabel")
     * @ConfigField(defaultValues={"dataaudit"={"auditable"=true}})
     * @JMS\Type("string")
     * @JMS\Accessor(getter="getStatusName")
     */
    protected $status;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @ConfigField(defaultValues={"dataaudit"={"auditable"=true}})
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getAssigneeId")
     */
    protected $assignee;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @ConfigField(defaultValues={"dataaudit"={"auditable"=true}})
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getOwnerId")
     */
    protected $owner;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     * @JMS\Type("DateTime")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->relatedContacts = new ArrayCollection();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Collection
     */
    public function getRelatedContacts()
    {
        return $this->relatedContacts;
    }

    /**
     * @param Contact $contact
     */
    public function addRelatedContact(Contact $contact)
    {
        if (!$this->relatedContacts->contains($contact)) {
            $this->relatedContacts->add($contact);
        }
    }

    /**
     * @param Contact $contact
     */
    public function removeRelatedContact(Contact $contact)
    {
        if ($this->relatedContacts->contains($contact)) {
            $this->relatedContacts->removeElement($contact);
        }
    }

    /**
     * @param TaskStatus $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return TaskStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return $this->getStatus() ? $this->getStatus()->getName() : null;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param User $assignee
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return int
     */
    public function getAssigneeId()
    {
        return $this->getAssignee() ? $this->getAssignee()->getId() : null;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->getOwner() ? $this->getOwner()->getId() : null;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
