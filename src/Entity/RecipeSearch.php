<?php

namespace App\Entity;


class RecipeSearch
{


    /**
     * @var string |null
     */
    private $q = '';

    /**
     * @var string|null
     */
    private $category;

//    /**
//     * @var int|null
//     */
//    private $rating;


    /**
     * @var int|null
     */
    private $difficulty;

    /**
     * @return null|string
     */
    public function getQ(): ?string
    {
        return $this->q;
    }

    /**
     * @param null|string $q
     */
    public function setQ(?string $q): void
    {
        $this->q = $q;
    }



    /**
     * @return null|string
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param null|string $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

//    /**
//     * @return int|null
//     */
//    public function getRating(): ?int
//    {
//        return $this->rating;
//    }
//
//    /**
//     * @param int|null $rating
//     */
//    public function setRating(?int $rating): void
//    {
//        $this->rating = $rating;
//    }

    /**
     * @return int|null
     */
    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    /**
     * @param int|null $difficulty
     */
    public function setDifficulty(?int $difficulty): void
    {
        $this->difficulty = $difficulty;
    }

}
