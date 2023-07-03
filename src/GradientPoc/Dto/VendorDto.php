<?php

namespace App\GradientPoc\Dto;

class VendorDto extends BaseGradientDto
{
    private string $externalIntegrationStatus;
    private array $skus = [];

    /**
     * @param string $description
     * @return VendorDto
     */
    public function setDescription(string $description): VendorDto
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalIntegrationStatus(): string
    {
        return $this->externalIntegrationStatus;
    }

    /**
     * @param string $externalIntegrationStatus
     * @return VendorDto
     */
    public function setExternalIntegrationStatus(string $externalIntegrationStatus): VendorDto
    {
        $this->externalIntegrationStatus = $externalIntegrationStatus;
        return $this;
    }

    /**
     * @return SkuDto[]
     */
    public function getSkus(): array
    {
        return $this->skus;
    }

    /**
     * @param SkuDto[] $skus
     * @return VendorDto
     */
    public function setSkus(array $skus): VendorDto
    {
        $this->skus = $skus;
        return $this;
    }

}
