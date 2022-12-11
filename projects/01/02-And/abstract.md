# And gate

We have only `Nand` and `Not` gates implemented on this stage.

Using only `Nand` and `Not` we can write `And` like this `Not(Nand())`
because __Nand__ is __Not And__, so __Not Not And__ is __And__.

So we connect inputs to the `Nand` gate, and then it's output connect to the `Not` gate, that's it.

Thus `Not` gate is actually a single `Nand` gate connected from single input,
so we can only use 2 `Nand` gates to build the gate.