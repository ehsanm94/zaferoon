<?php
$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->overload();

return new Zardak\App();