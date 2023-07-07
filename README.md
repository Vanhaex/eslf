# ESLF

[![Psalm Static analysis](https://github.com/Vanhaex/eslf/actions/workflows/main.yml/badge.svg?branch=dev)](https://github.com/Vanhaex/eslf/actions/workflows/main.yml)

### ESLF is a simple framework for writing web applications

## What is ESLF ?

**ESLF** is short for **E**asy, **S**imple and **L**ightweight **F**ramework
It is a framework for creating web applications in PHP that is easy to use and lightweight. It is a framework that can evolve over time and adapts to all uses.
Its architecture is based on the principle of MVC for Model, View, Controller. It therefore separates the processing from the display by using the **Smarty** templating engine.
Some classes have been created to secure the processing of user data by POST or GET methods, for example. They also make it easier to control the data entered by users.

**This framework is brought to you with [TailwindCSS](https://tailwindcss.com)**

## Why a handmade framework? Why not use a better known framework?

My goal from the start was to create a framework by myself, inspired by my experience in the field of web development. Above all, I wanted something light with the bare minimum. It makes it much easier for me to build web apps and add functionality where needed.
I am inspired by the **Laravel** framework for certain parts. The second objective is to allow the developer to be able to use this framework, through command line tools or libraries.
For example, ESLF comes without a CSS framework such as Bootstrap for example. So you can use whatever you want.

## ESbuilder

ESbuilder is a command line interface included in the framework. It provides commands that can help you build your project. It allows for example to create controllers, models, generate keys, empty the cache, etc...
To run a command to get the framework version, just type :

`php esbuilder version`

Which will allow you to get the framework version as output

## Used dependencies

ESLF requires PHP 7.4 at least as well as the other dependencies below:

* PHPMailer 6.4
* Smarty 4.3.0
* ESDBaccess 1.0.2
* psr/http-server-middleware 1.0.1
* symfony/console 5.4.21
* ua-parser/uap-php 3.9
