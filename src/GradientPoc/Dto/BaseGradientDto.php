<?php

namespace App\GradientPoc\Dto;

class BaseGradientDto
{
    private string $id;
    private string $name;
    private string $description;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return BaseGradientDto
     */
    public function setId(string $id): BaseGradientDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return BaseGradientDto
     */
    public function setName(string $name): BaseGradientDto
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return BaseGradientDto
     */
    public function setDescription(string $description): BaseGradientDto
    {
        $this->description = $description;
        return $this;
    }
}
