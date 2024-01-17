<?php
namespace App\Entity;

class  BilanVolontaireSearch {
    private ?\DateTimeImmutable $maxDate=null;
    private ?\DateTimeImmutable $minDate=null;
    
    public function getMaxDate(): ?\DateTimeImmutable
    {
        return $this->maxDate;
    }
    
    public function setMaxDate(\DateTimeImmutable $maxDate): static
    {
        $this->maxDate=$maxDate;
        return $this;
    }
    public function getMinDate(): ?\DateTimeImmutable
    {
        return $this->minDate;
    }
    
    public function setMinDate(\DateTimeImmutable $minDate): static
    {
        $this->minDate=$minDate;
        return $this;
    }
    
    
}