symfony-console-styles
======================

Small set of styles for symfony/console, currently containing gentoo and linux kernel styles.

Installation
============

    composer require smt/symfony-console-styles
    
Usage
=====

    use Smt\Component\Console\Style\GentooStyle; // Or KernelStyle

    // ...
    
    public function execute(InputInterface $input, OutputInterface $output) {

        // ...

        $dialog = new GentooStyle($output, $input);
        $dialog->success('Hello world!');
        

Quick overview
--------------

    use Smt\Component\Console\Test\VisualTest;
    
    // ...
    
    $test = new VisualTest();
    $test->run($gentooStyle);
    $test->run($kernelStyle);
    
API
===

All from `Symfony\Component\Style\OutputStyle` and some additions.

Let's say that we wrote `use Smt\Component\Console\Style\GentooStyle as Style` or `use Smt\Component\Console\Style\KernelStyle as Style`

Messages
--------

Here `$message` can be string or array of strings.

 * `Style::message($message, $type, $prefix)` - allows to print messages with some prefix, mostly used internally;
 * `Style::success($message)` - Prints success message;
 * `Style::info($message)` - Prints info message;
 * `Style::text($message)` - Inherited from `OutputStyle`, just an alias for `Style::info($message)`;
 * `Style::note($message)` - Prints note message;
 * `Style::warning($message)` - Prints warning message;
 * `Style::important($message)` - Prints important warning;
 * `Style::error($message)` - Prints error message;
 * `Style::caution($message)` - Prints caution message;
 
Headings
--------

Here `$message` can only be string.

 * `Style::title($message)` - Prints title;
 * `Style::section($message)` - Prints section title;

Components
----------

 * `Style::listing($items)` - Prints list (multidimensional array support);
 * `Style::nestedList($items, $level = 1)` - Prints nested list at some level (multidimensional array support);
 * `Style::table($headers, $rows)` - Prints table;
 * `Style::progressStart($max = 0)` - Start progress (progressbar);
 * `Style::progressAdvance($step = 1)` - Advance progress (progressbar);
 * `Style::progressFinish()` - Finish progress (progressbar);
 
Interact
--------

 * `Style::ask($question, $default = null, $validator = null)` - Asks user a question;
 * `Style::askHidden($question, $default = null, $validator = null)` - Asks user a question and hides input;
 * `Style::confirm($question, $default = true)` - Asks user to confirm;
 * `Style::choice($question, $choices, $default = null)` - Asks user to select from choice list;
