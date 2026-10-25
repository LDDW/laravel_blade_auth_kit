<?php

namespace App\Support;

class UserAgent
{
    public function __construct(public string $userAgent) {}

    public function isDesktop(): bool
    {
        return ! preg_match('/Mobile|Android|iP(hone|od|ad)|IEMobile|BlackBerry/i', $this->userAgent);
    }

    public function platform(): ?string
    {
        return match (true) {
            str_contains($this->userAgent, 'Windows') => 'Windows',
            str_contains($this->userAgent, 'Macintosh') => 'macOS',
            str_contains($this->userAgent, 'Linux') => 'Linux',
            str_contains($this->userAgent, 'Android') => 'Android',
            str_contains($this->userAgent, 'iPhone') || str_contains($this->userAgent, 'iPad') => 'iOS',
            default => null,
        };
    }

    public function browser(): ?string
    {
        return match (true) {
            str_contains($this->userAgent, 'Edg/') => 'Edge',
            str_contains($this->userAgent, 'Chrome/') => 'Chrome',
            str_contains($this->userAgent, 'Firefox/') => 'Firefox',
            str_contains($this->userAgent, 'Safari/') && ! str_contains($this->userAgent, 'Chrome/') => 'Safari',
            default => null,
        };
    }
}
