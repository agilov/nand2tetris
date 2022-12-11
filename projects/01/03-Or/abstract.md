# Or gate

We have `Nand`, `Not` and `And` gates implemented on this stage and can do some basic algebra already.

Let's take a look at the `Or` logic function [truth table](https://en.wikipedia.org/wiki/Truth_table)
and create its [canonical representation](https://en.wikipedia.org/wiki/Canonical_normal_form):

| a   | b   | out | minterm |
|-----|-----|-----|---------|
| 0   | 0   | 0   |         |
| 0   | 1   | 1   | a'b     |
| 1   | 0   | 1   | ab'     |
| 1   | 1   | 1   | ab      |

The canonical form is: `Or(a,b) = a'b + ab' + ab` - seems like not so easy to implement because it has `Or` operation
already, and we don't have `Or` yet because we're trying to implement it.

But the inverted function `Nor` (Not or) seems way simpler:

| a   | b   | out | minterm |
|-----|-----|-----|---------|
| 0   | 0   | 1   | a'b'    |
| 0   | 1   | 0   |         |
| 1   | 0   | 0   |         |
| 1   | 1   | o   |         |

Canonical: `Nor(a,b) = a'b'` - there is only `Not` and `And` operations we can build `Nor` gate and then put it's input
to the `Not` gate because **Not Not Or is Or**.

Physical implementation of `Nor` is look like this: `Nor(a,b) = And(Not(a), Not(b))`.

And physical implementation of `Or` is look like this: `Or(a,b) = Not(Nor(a,b)) = Not(And(Not(a), Not(b)))`.

And thus `Not(And(a,b)) = Nand(a,b)` the final short version look like this:  `Or(a,b) = Nand(Not(a), Not(b))`.

So we're just connecting inputs a and b to `Not` gates and then connect outputs to the `Nand` gate.

Thus `Not` gate is actually a single `Nand(a, a)`, we can construct the `Or` gate
using only `Nand`: `Or(a,b) = Nand(Nand(a, a), Nand(b, b))`.
