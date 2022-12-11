# Multiplexor

Set of `Nand`, `Not`, `And`, `Or` and `Xor` gates is more than enough to build a `Mux` gate.

Using truth table and normal form construction we can easily come up with the solution:

| a   | b   | sel | out | minterm |
|-----|-----|-----|-----|--------|
| 0   | 0   | 0   | 0   |        |
| 0   | 0   | 1   | 0   |        |
| 0   | 1   | 0   | 0   |        |
| 0   | 1   | 1   | 1   | a'bsel  |
| 1   | 0   | 0   | 1   | ab'sel' |
| 1   | 0   | 1   | 0   |        |
| 1   | 1   | 0   | 1   | absel' |
| 1   | 1   | 1   | 1   | absel  |

The canonical form is: `Mux(a,b,sel) = (a'bsel + ab'sel') + (absel' + absel)` and 

physical implementation: 
```
Mux(a,b,sel) = Or(
    Or(
        And(
            Not(a), 
            And(b, sel)
        ),
        And(
            a, 
            And(Not(b), Not(sel)
        )
    ), 
    Or(
        And(
            a, 
            And(b, Not(sel))
        ),
        And(a, And(b, sel))    
    )
)
```

So we have 3 `Or` gates 3 `Not` gates and 

