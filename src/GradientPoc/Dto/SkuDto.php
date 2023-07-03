<?php

namespace App\GradientPoc\Dto;

class SkuDto extends BaseGradientDto
{
    private string $category;
    private string $subcategory;

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return SkuDto
     */
    public function setCategory(string $category): SkuDto
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubcategory(): string
    {
        return $this->subcategory;
    }

    /**
     * @param string $subcategory
     * @return SkuDto
     */
    public function setSubcategory(string $subcategory): SkuDto
    {
        $this->subcategory = $subcategory;
        return $this;
    }
}
