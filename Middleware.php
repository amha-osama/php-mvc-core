<?php

namespace Osama\phpmvc;

interface Middleware
{
    public function handle(Request $request, callable $next):Response;
}