array-object-converter
======================

A module to copy data from an array into an object, vice versa. Requires PHP 5.4+.

You have to provide information for objects to describe how properties are connected to array keys. This can be done in various ways, so you dont have to edit existing classes.

Right now there is just one provider ready: The PhpDocProvider extracts the annotations from the object's methods. Other providers may follow, if I find some time for that.