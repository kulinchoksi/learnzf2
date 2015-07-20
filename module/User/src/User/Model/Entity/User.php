<?php
namespace User\Model\Entity;

use Zend\Form\Annotation;

/**
 * @Annotation\Name("users")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 *
 * @Entity @Table(name="users")
 */

class User {

        /**
         * @Annotation\Exclude()
         *
         * @id @GeneratedValue @Column(type="integer")
         */
	protected $id;
	protected $role;
	protected $name;

        /**
         * @Annotation\Flags({"priority" : "500"})
         * @Column(type="string")
         */
	protected $email;

        /**
         * @Annotation\Type("Zend\Form\Element\Text")
         * @Annotation\Options({"label" : "Your phone number: "})
         * @Annotation\Filter({"name" : "StripTags"})
         * @Annotation\Filter({"name" : "StringTrim"})
         * @Annotation\Validator(
         *  {"name" : "RegEx", "options" : {"pattern" : "/^[\d-\/]+$/"}}
         * )
         * @Annotation\Attributes(
         *  {"type" : "tel", "required" : true, "pattern" : "^[\d-/]+$"}
         * )
         *
         * @Column(type="string")
         */
	protected $phone;
	protected $photo;

        /**
         * @Annotation\Options({"label" : "Password:", "priority" : "400"})
         * @Annotation\Flags({"priority" : "400"})
         *
         * @Column(type="string")
         */
	protected $password;

	/**
	 * @return the $id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return the $role
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @return the $email
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return the $phone
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param field_type $role
	 */
	public function setRole($role)
	{
		$this->role = $role;
	}

	/**
	 * @param field_type $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @param field_type $phone
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

	/**
	 * @return the $name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	public function getPhoto()
	{
		return $this->photo;
	}

	public function setPhoto($photo)
	{
		if(isset($photo['tmp_name'])) {
			$this->photo = $photo['tmp_name'];
		}
	}

	/**
	 * Gets the current password hash
	 *
	 * @return the $password
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Sets the password
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $this->hashPassword($password);
	}

	/**
	 * Verifies if the passwords match
	 *
	 * @param string $password
	 * @return boolean
	 */
	public function verifyPassword($password)
	{
		return ($this->password == $this->hashPassword($password));
	}

	/**
	 * Hashes a password
	 * @param string $password
	 * @return string
	 */
	private function hashPassword($password)
	{
		return md5($password);
	}
}
