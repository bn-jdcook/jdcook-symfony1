<?php

namespace App\Message;

class Test2Message
{

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
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
    public function setName(string $name): Test2Message
    {
        $this->name = $name;
        return $this;
    }


}
