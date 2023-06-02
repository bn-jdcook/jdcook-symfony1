<?php

namespace App\Message;

class TestMessage
{

    public function __construct(private string $name)
    {
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
     * @return TestMessage
     */
    public function setName(string $name): TestMessage
    {
        $this->name = $name;
        return $this;
    }


}
