<?php

namespace App\Models;


class Speciality
{
    public int $specialityId;
    public string $name;
    public string $flag;


    public function getSpecialityId(): int
    {
        return $this->specialityId;
    }

    public function setSpecialityId(int $specialityId): void
    {
        $this->specialityId = $specialityId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): void
    {
        $this->flag = $flag;
    }

    

    
    




    
    
}