Animations v2.1
===============

A versatile CSS3 animation pack with over 190 animations for various usages. Trigger CSS3 animations as elements enter the viewport, as you hover with a mouse or by binding them via JavaScript functions/event listeners.

**Demo:** http://www.cloud-eight.com/github/animations/


Usage
=====

<ul>
  <li>Add the class `no-js` to your `html` tag</li>
  <li>Link 'animations.min.css', 'animations.min.js' and 'appear.min.js' to your document</li>
  <li>Follow the guides below depending on what aspect of the plugin you wish to use</li>
</ul>


Animations
==========

<ul>
  <li>Add the class `animate-in` to the desired element</li>
  <li>Add the attribute `data-anim-type` with an animation</li>
  <li>(Optional) Add the attribute `data-anim-delay` if you wish to put a delay (in ms) on the animation</li>
</ul>

The plugin will auto detect elements in view on page load, any other elements assigned with the `animate-in` class will be executed as they enter the viewport upon scrolling.

```
<div class="animate-in" data-anim-type="bounce-in-up" data-anim-delay="200">Bounce In Up</div>
```

By default, animation duration time/speed is 1 second, if you wish to adjust this duration you can add the class `slow-mo` (2 seconds), `super-slow-mo` (3 seconds), `ultra-slow-mo` (4 seconds) or `hyper-slow-mo` (5 seconds).

```
<div class="animate-in slow-mo" data-anim-type="bounce-in-up" data-anim-delay="0">Slow Mo</div>
<div class="animate-in super-slow-mo" data-anim-type="bounce-in-up" data-anim-delay="0">Super Slow Mo</div>
<div class="animate-in ultra-slow-mo" data-anim-type="bounce-in-up" data-anim-delay="0">Ultra Slow Mo</div>
<div class="animate-in hyper-slow-mo" data-anim-type="bounce-in-up" data-anim-delay="0">Hyper Slow Mo</div>
```


Binding
=======

There are 3 JavaScript functions at your disposal `animate`, `animateOut` and `animateEnd`.

To animate an element at any point you can use the `animate` function.
The `animate` function needs 2 variables passed through it, the first being the ID/Class of the target element, the second is the type of animation.
There is the optional 3rd variable to animate the element infinitely.
Multiple elements can be targeted by seperating them with a comma.

```
<button onclick="animate('#element', 'tada');">Tada Once</button>
<button onclick="animate('#element, #tagline', 'tada', true);">Tada Continuously</button>
```

To animate an element out correctly you can use the `animateOut` function.
The `animateOut` function needs 2 variables passed through it, the first being the ID/Class of the target element, the second is the type of animation.
There is the optional 3rd variable to remove the element from the DOM completely after it has animated.

```
<button onclick="animateOut('#element', 'bounce-out');">Bounce Out</button>
<button onclick="animateOut('#element', 'bounce-out', true);">Bounce Out and Remove Element</button>
```

To stop an element animation correctly you can use the `animateEnd` function, for example with animations animating infinitely.
The `animateEnd` function only needs 1 variable passed through it, the ID/Class of the target element.
There is the optional 2nd variable to remove the element completely.

```
<button onclick="animateEnd('#element');">End</button>
<button onclick="animateEnd('#element', true);">End and Remove</button>
```


Hovers
======

You can also use the `hover-*` class to assign the animation to the `:hover` psuedo selector, adding the class `infinite` will continuously loop the animation while hovering.

```
<button class="hover-spin">Spin Once</button>
<button class="hover-spin infinite">Spin Continuously</button>
```

Browser Compatibility
=====================

<ul>
  <li>IE 10+</li>
  <li>Firefox 25+</li>
  <li>Chrome 31+</li>
  <li>Safari 7+</li>
  <li>Opera 18+</li>
  <li>Most mobile browsers</li>
</ul>

Flip animations currently don't work in IE or Firefox, this issue will be fixed soon.


Limitations
===========

Animations executing on elements entering the viewport will not work if JavaScript is disabled.
Animations are currently limited to devices with a viewport of 569px (wide) or higher.


Author
======

Joe Mottershaw, Cloud Eight<br />
http://www.cloud-eight.com


Credits
======

Animate.css, Dan Eden<br />
https://github.com/daneden/animate.css

CSS3 Animation Cheat Sheet, Justin Aguilar<br />
http://www.justinaguilar.com/animations/

jquery.appear, bas2k<br />
https://github.com/bas2k/jquery.appear