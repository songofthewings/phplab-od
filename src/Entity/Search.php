<?php

namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SearchRepository::class)
 */
class Search
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $word;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $search_count;

    public function getId(): ?int
    {
        return $this->id;
    }
	public function setWord($word) {
    	$this->word = $word;
    	return $this;
	}

	public function getWord() {
    	return $this->word;
	}

	public function getSearchCount($search_count) {
		$this->search_count = $search_count;
		return $this;
	}

	public function resetSearchCount() {
		$this->search_count = 0;
		return $this;
	}

	public function incrementSearchCount() {
		$this->search_count += 1;
		return $this;
	}
}
