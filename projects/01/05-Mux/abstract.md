# Multiplexor

Set of `Nand`, `Not`, `And`, `Or` and `Xor` gates is more than enough to build a `Mux` gate.

Using truth table and normal form construction we can easily come up with the solution:

| a   | b   | sel | out | minterm |
|-----|-----|-----|-----|---------|
| 0   | 0   | 0   | 0   |         |
| 0   | 0   | 1   | 0   |         |
| 0   | 1   | 0   | 0   |         |
| 0   | 1   | 1   | 1   | a'bsel  |
| 1   | 0   | 0   | 1   | ab'sel' |
| 1   | 0   | 1   | 0   |         |
| 1   | 1   | 0   | 1   | absel'  |
| 1   | 1   | 1   | 1   | absel   |

The canonical form is: `Mux(a,b,sel) = (a'bsel + ab'sel') + (absel' + absel)` and sel`a + selb

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

If we implement all this, we get:

```text
CHIP Mux {
    IN a, b, sel;
    OUT out;

    PARTS:
    Not(in=a,out=nota); // Computing Not(a) value
    Not(in=b,out=notb); // Computing Not(b) value
    Not(in=sel,out=notsel); // Computing Not(sel) value
    And(a=b,b=sel,out=bsel); // Computing And(b, sel)
    And(a=notb,b=notsel,out=notbnotsel); // Computing And(Not(b), Not(sel))
    And(a=b,b=notsel,out=bnotsel); // Computing And(b, Not(sel))
    And(a=nota,b=bsel,out=mt1); // Computing first minterm #1 a'bsel
    And(a=a,b=notbnotsel,out=mt2); // Computing first minterm #2 ab'sel'
    And(a=a,b=bnotsel,out=mt3); // Computing first minterm #3 absel'
    And(a=a,b=bsel,out=mt4); // Computing first minterm #4 absel
    Or(a=mt1,b=mt2,out=mt12); // Computing first brackets of the canonical form
    Or(a=mt3,b=mt4,out=mt34); // Computing second brackets of the canonical form
    Or(a=mt12,b=mt34,out=out); // Computing canonical form
}
```

Complicated, right? There is a way to simplify this function.

Let's create a [Karnaugh map](https://en.wikipedia.org/wiki/Karnaugh_map):

| a   | b   | sel | out |
|-----|-----|-----|-----|
| 0   | 0   | 0   | 0   |
| 0   | 0   | 1   | 0   |
| 0   | 1   | 0   | 0   |
| 0   | 1   | 1   | 1   | 
| 1   | 0   | 0   | 1   |
| 1   | 0   | 1   | 0   |
| 1   | 1   | 0   | 1   |
| 1   | 1   | 1   | 1   |
            
From the truth table we can create a map like this:

| a b \ sel | 0   | 1   |
|-----------|-----|-----|
| 0 0       | 0   | 0   |
| 0 1       | 0   | *1* | 
| 1 1       | *1* | *1* |
| 1 0       | *1* | 0   |

And by solving the map we can see that for one group input of *sel* is always 0 and input of *a* is always 1 so
the first part is `sel'a` and for the other group input of *sel* is always 1 and input of b is always 1 so the other
part is `selb`. 

This gives us such function: `Mux(a,b,sel) = sel'a + selb`. Perfect!

Our physical implementation: `Mux(a,b,sel) = Or(And(Not(sel), a), And(sel, b))` 