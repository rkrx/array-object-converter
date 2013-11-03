array-object-converter
======================

A module to copy data from an array into an object, vice versa. Requires PHP 5.4+.

You have to provide information for targeted objects to describe how properties are connected to array keys. This is done through "SpecificationProvider"s.

Right now there is just one provider ready: The PhpDocSpecificationProvider extracts the annotations from the object's methods. Other providers may follow, if I find some time for that.

If all objects are equipped with propper annotations, you can do this:

```$array = (new ArrayObjectConverter($entity))->getArray();```

Or the other way around:

```$object = (new ArrayObjectConverter($entity))->setArray($array);```
