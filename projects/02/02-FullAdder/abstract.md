# Full-adder

Adds two bits and outputs one bit sum and carry bit (overflow and carry to the next position).


| a   | b   | c   | sum | carry |
|-----|-----|-----|-----|-------|
| 0   | 0   | 0   | 0   | 0     |
| 0   | 0   | 1   | 1   | 0     |
| 0   | 1   | 0   | 1   | 0     |
| 0   | 1   | 1   | 0   | 1     |
| 1   | 0   | 0   | 1   | 0     |
| 1   | 0   | 1   | 0   | 1     |
| 1   | 1   | 0   | 0   | 1     |
| 1   | 1   | 1   | 1   | 1     |

Well we can just sum two times first a + b and then (a + b) + c. 

The carry can be either in first or the second addition but not in both because maximum number we can get from summing of 3 bits is 11 (maximum 2 positions).

That means we can just put carry bits from both additions to the or gate.

We'll use 2 HalfAdders and 1 Or gate.