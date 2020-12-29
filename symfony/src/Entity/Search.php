<?php 

namespace App\Entity;

class Search{
    /**
     * @var string|null
     */
    private $filiere;
    /**
     * @var string|null
     */
    private $language;
    /**
     * @var string|null
     */
    private $majeure;

    /**
     * @return string|null
     */
    public function getFiliere(): string
    {
        return $this-> $filiere;
    }
    /**
     * @param string|null $filiere
     * @return Search
     */
    public function setFiliere(string $filiere): search
    {
        $this->filiere = $filiere;
        return this;
    }
    /**
     * @return string|null
     */
    public function getLanguage(): string
    {
        return $this-> $language;
    }
    /**
     * @param string|null $language
     * @return Search
     */
    public function setLanguage(string $language): search
    {
        $this->language = $language;
        return this;
    }
    /**
     * @return string|null
     */
    public function getMajeure(): string
    {
        return $this-> $majeure;
    }
    /**
     * @param string|null $majeure
     * @return Search
     */
    public function setMajeure(string $majeure): search
    {
        $this->majeure = $majeure;
        return this;
    }

}


?>