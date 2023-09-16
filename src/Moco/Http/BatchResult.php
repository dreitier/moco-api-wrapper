<?php
declare(strict_types=1);

namespace Dreitier\Moco\Http;

class BatchResult
{
    private array $succeeded = [];
    private array $failed = [];

    public function ok($element): BatchResult
    {
        $this->succeeded[] = $element;
        return $this;
    }

    public function fail(...$args): BatchResult
    {
        $this->failed[] = $args;
        return $this;
    }

    public function getSucceeded(): array
    {
        return $this->succeeded;
    }

    public function getFailed(): array
    {
        return $this->failed;
    }

    public function hasErrors(): bool
    {
        return sizeof($this->failed) > 0;
    }

    public function expectOk()
    {
        if ($this->hasErrors()) {
            throw new \Exception("Batch result did not succeed: " . sizeof($this->succeeded) . " ok, " . sizeof($this->failed) . " failed");
        }
    }
}
