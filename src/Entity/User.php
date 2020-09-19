<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=30)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=64)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(type="array")
	 */
	private $favourite_words;

	/**
	 * @inheritDoc
	 */
	public function getUsername() {
		return $this->username;
	}

	public function setName($username){
		$this->username = $username;
		return $this;
	}
	
	public function setPassword($password){
		$this->password = $password;
		return $this;
	}
	public function setEmail($email){
		$this->email = $email;
		return $this;
	}
	public function setFavourite($favourite_words){
		$this->favourite_words = $favourite_words;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getPassword() {
		return $this->password;
	}

	public function serialize() {
		return serialize(
			array(
				$this->id,
				$this->username,
				$this->password,
			)
		);
	}

	/**
	 * @see \Serializable::unserialize()
	 */
	public function unserialize( $serialized ) {
		list (
			$this->id,
			$this->username,
			$this->password,
			) = unserialize( $serialized );
	}


	public function getId(): ?int {
		return $this->id;
	}
}
