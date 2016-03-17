<?php

if (getenv('ENVIRONMENT') !== 'prod') {
    error_reporting(E_ALL);
}