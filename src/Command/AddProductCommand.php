<?php

namespace App\Command;

use App\Entity\Product;
use App\Service\ProductService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddProductCommand extends Command
{

    private ProductService $productService;
    protected static $defaultName = 'app:newproduct';

    public function __construct(ProductService $productService, string $name = null)
    {
        parent::__construct($name);
        $this->productService = $productService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $random = random_int(1, 20000);
        $name = "name".$random;
        $type = "type$random";
        $product = (new Product())->setName($name)->setType($type);
        try {
            $this->productService->addProduct($product);
            $output->writeln("Added new Product: $name");
            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
