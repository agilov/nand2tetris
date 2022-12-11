# Xor gate

We have `Nand`, `Not`, `And` and `Or` and that's a huge toolset.

Let's take a look at the `Xor` boolean function [truth table](https://en.wikipedia.org/wiki/Truth_table)
and create its [canonical representation](https://en.wikipedia.org/wiki/Canonical_normal_form):

| a   | b   | out | minterm |
|-----|-----|-----|--------|
| 0   | 0   | 0   |        |
| 0   | 1   | 1   | a'b    |
| 1   | 0   | 1   | ab'    |
| 1   | 1   | 0   |        |

The canonical form is: `Xor(a,b) = a'b + ab'` and we already have all the building blocks to implement this.

Physical implementation: `Xor(a,b) = Or(And(Not(a), b), And(a, Not(b)))`;

