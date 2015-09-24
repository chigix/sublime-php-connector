% PhpConnector for Sublime Text 2 & 3
% Richard Lea (chigix@zoho.com)

# PhpConnector for Sublime Text 2 & 3

**VERSION: 3.1.1**

Author: Richard Lea (chigix@zoho.com)

Weibo: [\@千木郷](http://weibo.com/chigix)

## Introduction
The plugin is to add support for php developers to develop a sublime plugin using php.

## Installation

* With Package Control

	If you have Package Control installed, you can install PhpConnector from inside Sublime Text itself. Open the Command Palette and select “Package Control: Install Package”, then search for PhpConnector.

* Without Package Control

	If you haven't got Package Control installed you will need to make a clone of this repository into your packages folder, like so:

	`git clone https://github.com/chigix/sublime-php-connector.git "PhpConnector"`

	If you find error or wathever just fork it and send me a pull request.

## Usage

The only binding key map: <kbd>ctrl+shift+r</kbd>(OS X: <kbd>⇧⌘P</kbd>).

You can override it via user settings.

## What's new

* High speed communication towards php interpretor embedded
* Greatly improved developing experience with sophisticated model and command utils.

### v0.1.0: Created!
- php connect support

### v2.0: PHP programing interface framework. 

* ADD pandoc convert markdown to html support.

### v2.5: Welcome

* ADD multi-language support.
* ADD filesystem encoding support.
* ADD configure wizard on php_path and filesystem encoding.
* FIX sublime 3 support.
* IMPROVE error exception catch.
* Game start for hacking sublime with PHP.

### v3.0: Play Gardon

* Thoroughly individual php interpretor embedded 
* Accelerate Communication between PYTHON and PHP.
* Rewrite Markdown building script for the new version.
* Improve the whole framework upon php with Data Model and Command Manager. 

## For Developers

As demo, All built-in commands definition were in `sublime_php_command\Core\Commands\`, and every execute class should be under a unique namespace and extends the abstract class `BaseCommand` to finish the registration into the `PhpConnector Context`.

Demos are in the `sublime_php_command\Core\Commands\`, so as you can see, their namespace was `Chigi\Sublime\Commands`. We suggest you open the COMPOSER support, so that you could define the namespace map by your self, which is though still in Experiment (Really too busy to commit without other supermans π_π).

# License
The plugin is licensed under the MIT license.


Copyright (C) <2014> Richard Lea <chigix@zoho.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
