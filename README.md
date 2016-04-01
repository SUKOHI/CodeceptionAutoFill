# CodeceptionAutoFill
A PHP Class for filling fields automatically on browser using Codeception Scenario.

# Installation

Execute composer command.

    composer require sukohi/codeception-auto-fill:1.*

# Usage

Set the following code before &lt;/body&gt; in your HTML.  

    <?php echo \Sukohi\CodeceptionAutoFill\CodeceptionAutoFill::js('PATH/TO/YOUR/CODECEPTION/SCENARIO'); ?>

Now the page that you set the above tag has new JavaScript code.  
And then you can fill fields by press `Shift + Enter` like shortcut key.

# Supporting methods

This package supports the next method of Codeception.

1. fillField
2. selectOption
3. checkOption
4. uncheckOption
5. submitForm

# Note

As of now, you possibly can NOT use this package if you use Codeception module like Laravel.

# License

This package is licensed under the MIT License.

Copyright 2016 Sukohi Kuhoh