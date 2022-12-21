# Half-adder

Adds two bits and outputs one bit sum and carry bit (overflow and carry to the next position).

| a   | b   | sum | carry |
|-----|-----|-----|-------|
| 0   | 0   | 0   | 0     |
| 0   | 1   | 1   | 0     |
| 1   | 0   | 1   | 0     |
| 1   | 1   | 0   | 1     |

If we create two separate truth tables for sum and carry separately 
it's not hard to notice that sum representing `Xor` function and carry `And` function:

`Sum(a, b) = Xor(a,b)`:

| a   | b   | sum |
|-----|-----|-----|
| 0   | 0   | 0   |
| 0   | 1   | 1   |
| 1   | 0   | 1   |
| 1   | 1   | 0   |


`Carry(a, b) = And(a, b)`:

| a   | b   | carry |
|-----|-----|-------|
| 0   | 0   | 0     |
| 0   | 1   | 0     |
| 1   | 0   | 0     |
| 1   | 1   | 1     |

So the implementation is pretty simple.

We'll use `Xor` gate and `And` gate.