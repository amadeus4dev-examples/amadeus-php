<?php declare(strict_types=1);

namespace Amadeus;

class Response
{
    private array $info;
    private object $result;

    /**
     * @param array $info
     * @param object $result
     */
    public function __construct(array $info, object $result)
    {
        $this->info = $info;
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getInfo(): array
    {
        return $this->info;
    }

    /**
     * @return object
     */
    public function getResult(): object
    {
        return $this->result;
    }
}