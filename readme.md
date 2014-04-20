% PhpConnector for Sublime Text 2 & 3
% Richard Lea (chigix@zoho.com)

# PhpConnector for Sublime Text 2 & 3

**VERSION: 2.5 BETA**

Author: Richard Lea (chigix@zoho.com)

Weibo: [@千木郷](http://weibo.com/chigix)

## Introduction
The plugin is to add support for php developers to develop a sublime plugin using php.

## Installation

* With Package Control

	If you have Package Control installed, you can install PhpConnector from inside Sublime Text itself. Open the Command Palette and select “Package Control: Install Package”, then search for PhpConnector.

* Without Package Control

	If you haven't got Package Control installed you will need to make a clone of this repository into your packages folder, like so:

	`git clone https://github.com/chigix/sublime-php-connector.git "Codeigniter Codeintel Helper" `

	If you find error or wathever just fork it and send me a pull request.

## Usage

The only binding key map: `ctrl+shift+r`

You can over ride it via user settings.

## What's new

* Quick panel of commands development support via PHP.

### v0.1.0: Created!
- php connect support

### v2.0: PHP programing interface framework. 

* ADD pandoc convert markdown to html support.

### v2.5: ....

* ADD multi-language support.
* ADD filesystem encoding support.
* ADD configure wizard on php_path and filesystem encoding.

## For Developers

Defaultly, All commands defination were in `sublime_php_command\Commands\` and the `List.json` file in the root directory of `sublime_php_command`, and every execute class should under a unique namespace and within a method called `run`.

Demos are in the `sublime_php_command\Commands\Chigi\`, so as you can see, their namespace was `Chigi`.

# License
The plugin is licensed under the MIT license.


Copyright (C) <2012> Richard Lea <chigix@zoho.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
