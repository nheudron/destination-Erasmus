<?php

namespace App\Model;

use App\Entity\Filiere;
use Symfony\Component\Form\FormView;

class FiliereListModel
{
    /** @var FormView */
    private $filiereForm;
    /** @var Filiere[] */
    private $filiereList;

    /**
     * @return FormView
     */
    public function getFiliereForm(): FormView
    {
        return $this->filiereForm;
    }

    /**
     * @param FormView $filiereForm
     * @return FiliereListModel
     */
    public function setFiliereForm(FormView $filiereForm): FiliereListModel
    {
        $this->filiereForm = $filiereForm;
        return $this;
    }

    /**
     * @return Filiere[]
     */
    public function getFiliereList(): array
    {
        return $this->filiereList;
    }

    /**
     * @param Filiere[] $filiereList
     * @return FiliereListModel
     */
    public function setFiliereList(array $filiereList): FiliereListModel
    {
        $this->filiereList = $filiereList;
        return $this;
    }
}