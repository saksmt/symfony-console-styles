<?php

namespace Smt\Component\Console\Style;

use Smt\Component\Console\Reader\ReaderInterface;
use Smt\Component\Console\Writer\ComponentWriterInterface;
use Smt\Component\Console\Writer\WriterInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

/**
 * Improved style interface
 * @api
 * @package Smt\Component\Console\Style
 */
interface ImprovedStyleInterface extends OutputInterface, StyleInterface, ReaderInterface, WriterInterface, ComponentWriterInterface
{
}