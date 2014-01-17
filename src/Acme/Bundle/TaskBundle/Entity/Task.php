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

use Acme\Bundle\TaskBundle\Model\ExtendTask;

/**
 * Task item
 *
 * @ORM\Table(name="acme_task", indexes={
 *      @ORM\Index(name="acme_task_description_idx", columns={"description"})
 * })
 * @ORM\HasLifecycleCallbacks()
 * @Oro\Loggable
 * @ORM\Entity(repositoryClass="Acme\Bundle\TaskBundle\Entity\Repository\TaskRepository")
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
class Task extends ExtendTask
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
     * @JMS\Type("string")
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={"auditable"=true},
     *      "email"={"available_in_template"=true}
     *  }
     * )
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Oro\Versioned
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={"auditable"=true},
     *      "email"={"available_in_template"=true}
     *  }
     * )
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @var Collection
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\ContactBundle\Entity\Contact")
     * @ORM\JoinColumn(name="relatedContact", referencedColumnName="id", onDelete="SET NULL")
     * @ORM\JoinTable(name="acme_task_contacts",
     *      joinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     * @Oro\Versioned
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getRelatedContactId")
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={"auditable"=true},
     *      "email"={"available_in_template"=true}
     *  }
     * )
     */
    protected $relatedContact;

    /**
     * @var TaskStatus
     *
     * @ORM\ManyToOne(targetEntity="Acme\Bundle\TaskBundle\Entity\TaskStatus")
     * @ORM\JoinColumn(name="status_name", referencedColumnName="name", onDelete="SET NULL")
     * @Oro\Versioned("getLabel")
     * @JMS\Type("string")
     * @JMS\Accessor(getter="getStatusName")
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={"auditable"=true},
     *      "email"={"available_in_template"=true}
     *  }
     * )
     */
    protected $status;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getAssigneeId")
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={"auditable"=true},
     *      "email"={"available_in_template"=true}
     *  }
     * )
     */
    protected $assignee;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @Oro\Versioned("getUsername")
     * @JMS\Type("integer")
     * @JMS\Accessor(getter="getOwnerId")
     * @ConfigField(
     *  defaultValues={
     *      "dataaudit"={"auditable"=true},
     *      "email"={"available_in_template"=true}
     *  }
     * )
     */
    protected $owner;

    /**
     * @var \DateTime $created
     *
     * @ORM\Column(type="datetime")
     * @JMS\Type("DateTime")
     * @ConfigField(
     *  defaultValues={
     *      "email"={"available_in_template"=true}
     *  }
     * )
     */
    protected $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\Type("DateTime")
     * @ConfigField(
     *  defaultValues={
     *      "email"={"available_in_template"=true}
     *  }
     * )
     */
    protected $updatedAt;

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
     * @return Contact
     */
    public function getRelatedContact()
    {
        return $this->relatedContact;
    }

    /**
     * @return Contact
     */
    public function getRelatedContactId()
    {
        return $this->getRelatedContact() ? $this->getRelatedContact()->getId() : null;
    }

    /**
     * @param Contact $contact
     */
    public function setRelatedContact(Contact $contact = null)
    {
        $this->relatedContact = $contact;
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
    public function setAssignee(User $assignee = null)
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
    public function setOwner(User $owner = null)
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
