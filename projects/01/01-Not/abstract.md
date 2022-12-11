# Not gate

We have only `Nand` gate which is:

| a   | b   | out |
|-----|-----|-----|
| 0   | 0   | 1   |
| 0   | 1   | 1   |
| 1   | 0   | 1   |
| 1   | 1   | 0   |

`Not` gate truth table:

| a   | out |
|-----|-----|
| 0   | 1   |
| 1   | 0   |

If we just put **Not** input to the `a` and `b` this will give us this part of **Nand** table:

| a   | b   | out | comment              |
|-----|-----|-----|----------------------|
| 0   | 0   | 1   | <-- Same `Not` row 1 |
| 0   | 1   | 1   |                      |
| 1   | 0   | 1   |                      |
| 1   | 1   | 0   | <-- Same `Not` row 2 |

So we have put `Not` single input to the `Nand` and results will be like this:

| a   | a   | out | comment                |
|-----|-----|-----|------------------------|
| 0   | 0   | 1   |                        |
| 0   | 1   | 1   | <-- this is impossible |
| 1   | 0   | 1   | <-- this is impossible |
| 1   | 1   | 0   |                        |

