<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="platform_user")
 */
class User implements EncoderAwareInterface, UserInterface
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=64, nullable=true)
   */
  private $username;

  /**
   * @ORM\Column(type="string", length=128)
   */
  private $email;

  /**
   * @ORM\Column(type="string", length=512)
   */
  private $password;

  /**
   * @ORM\Column(type="string", length=32, nullable=true)
   */
  private $plainPassword;

  /**
   * @ORM\Column(type="string", length=128, nullable=true)
   */
  private $firstName;

  /**
   * @ORM\Column(type="string", length=128, nullable=true)
   */
  private $lastName;

  /**
   * @ORM\Column(type="array", nullable=true)
   * @var array
   */
  private $roles;

  /**
   * @ORM\Column(type="datetime", nullable=false)
   */
  private $dateOfCreation;

  /**
   * @ORM\Column(type="datetime", nullable=false)
   */
  private $dateOfChange;

  /**
   * User constructor
   */
  public function __construct()
  {
    $this->addRole("ROLE_USER");

    $currentDate = new \DateTime('NOW');
    $this->dateOfCreation = $currentDate;
    $this->dateOfChange   = $currentDate;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getUsername(): ?string
  {
    return $this->username;
  }

  public function setUsername(?string $username): self
  {
    $this->username = $username;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;

    return $this;
  }

  public function getPlainPassword(): ?string
  {
    return $this->plainPassword;
  }

  public function setPlainPassword(?string $plainPassword): self
  {
    $this->plainPassword = $plainPassword;

    return $this;
  }

  public function getFirstName(): ?string
  {
    return $this->firstName;
  }

  public function setFirstName(?string $firstName): self
  {
    $this->firstName = $firstName;

    return $this;
  }

  public function getLastName(): ?string
  {
    return $this->lastName;
  }

  public function setLastName(?string $lastName): self
  {
    $this->lastName = $lastName;

    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getDateOfCreation(): \DateTime
  {
    return $this->dateOfCreation;
  }

  /**
   * @param \DateTime $dateOfCreation
   * @return $this
   */
  public function setDateOfCreation(\DateTime $dateOfCreation)
  {
    $this->dateOfCreation = $dateOfCreation;
    return $this;
  }

  /**
   * @return \DateTime
   */
  public function getDateOfChange(): \DateTime
  {
    return $this->dateOfChange;
  }

  /**
   * @param \DateTime $dateOfChange
   * @return $this
   */
  public function setDateOfChange(\DateTime $dateOfChange)
  {
    $this->dateOfChange = $dateOfChange;
    return $this;
  }

  /**
   * Interface methods
   */

  /**
   * @return string
   */
  public function getEncoderName()
  {
//        if ($this->isAdmin()) {
//            return 'harsh';
//        }
//
//        return null;
    return 'harsh';
  }

  /**
   * {@inheritdoc}
   */
  public function getRoles()
  {
    $roles = $this->roles;

    // we need to make sure to have at least one role
//    $roles[] = static::ROLE_DEFAULT;

    return array_unique($roles);
  }

  /**
   * {@inheritdoc}
   */
  public function setRoles(array $roles)
  {
    $this->roles = array();

    foreach ($roles as $role) {
      $this->addRole($role);
    }

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function addRole($role)
  {
//    $role = strtoupper($role);
//    if ($role === static::ROLE_DEFAULT) {
//      return $this;
//    }
//
//    if (is_array($this->roles)) {
//      if (!in_array($role, $this->roles, true)) {
//        $this->roles[] = $role;
//      }
//    }
//    else {
//      $this->roles = [$role];
//    }

    $this->roles[] = $role;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function eraseCredentials()
  {
    $this->plainPassword = null;
  }

  /**
   * @return string
   */
  public function getSalt()
  {
    return "";
  }
}
