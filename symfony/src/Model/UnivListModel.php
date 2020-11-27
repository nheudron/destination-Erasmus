<?php

namespace App\Model;

use App\Entity\Universities;
use Symfony\Component\Form\FormView;

class UnivListModel
{
    /** @var FormView */
    private $univForm;
    /** @var Universities[] */
    private $univList;

    /**
     * @return FormView
     */
    public function getUnivForm(): FormView
    {
        return $this->univForm;
    }

    /**
     * @param FormView $univForm
     * @return UnivListModel
     */
    public function setUnivForm(FormView $univForm): UnivListModel
    {
        $this->univForm = $univForm;
        return $this;
    }

    /**
     * @return Universities[]
     */
    public function getUnivList(): array
    {
        return $this->univList;
    }

    /**
     * @param Universities[] $univList
     * @return UnivListModel
     */
    public function setUnivList(array $univList): UnivListModel
    {
        $this->univList = $univList;
        return $this;
    }
}