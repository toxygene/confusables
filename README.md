# Unicode Confusables

This library is an implementation of the skeleton function described in the [Confusion Detection](http://unicode.org/reports/tr39/#Confusable_Detection) section of the [Unicode Security Mechanisms technical standard](http://unicode.org/reports/tr39/).

> Because Unicode contains such a large number of characters and incorporates the varied writing systems of the world, incorrect usage can expose programs or systems to possible security attacks.
 -- http://unicode.org/reports/tr39/

# Usage
## (Re) Building the Class File
The rules for what characters are confuseable with other characters are [stored on the Unicode website](https://www.unicode.org/Public/security/latest/confusables.txt). The file is large (120k), so it needs to be cached locally. The file could be stored locally and parsed each time it's needed, but the data does not change frequently enough to justify a disk read and parsing overhead. Instead, `bin/build-confusables` can be used to create the entire class file. For each release, I will re-run the build script, but developers can also rebuild the class file when they see fit.

## API
### skeleton(string $a): string
Create the `skeleton` of a string.

Storing this value in the database will give developers a way of doing a visual uniqueness check against existing identifiers.

### isConfusable(string $a, string $b): bool
Check if two strings are confusable for each other.

Under the hood, this is implemented as `skeleton(A) == skeleton(B)`.