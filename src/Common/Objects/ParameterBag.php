<?php

namespace Omniship\Common\Objects;

final class ParameterBag {
    private array $parameters = [];

    public function __construct(array $parameters = []) {
        $this->parameters = $parameters;
    }

    public function get(string $key, $default = null) {
        return $this->parameters[$key] ?? $default;
    }

    public function set(string $key, $value): void {
        $this->parameters[$key] = $value;
    }

    public function all(): array {
        return $this->parameters;
    }

    public function has($key, $value = null) : bool {
        return array_key_exists($key, $this->parameters) && (is_null($value) ?: ($this->parameters[$key] === $value));
    }
}
