# Demultiplexor

A demultiplexor performs the opposite function of a multiplexor:
It takes a single input and channels it to one of two possible outputs according to
a selector bit that speciﬁes which output to chose.

We have all gates available to build a demultiplexor.

| in  | sel | a   | b   |
|-----|-----|-----|-----|
| 0   | 0   | 0   | 0   |
| 0   | 1   | 0   | 0   |
| 1   | 0   | 1   | 0   |
| 1   | 1   | 0   | 1   |

Let's create separate truth tables for a and b outputs

| in  | sel | a   | minterm |
|-----|-----|-----|---------|
| 0   | 0   | 0   |         |
| 0   | 1   | 0   |         |
| 1   | 0   | 1   | in sel' |
| 1   | 1   | 0   |         |

| in  | sel | b   | minterm |
|-----|-----|-----|---------|
| 0   | 0   | 0   |         |
| 0   | 1   | 0   |         |
| 1   | 0   | 0   |         |
| 1   | 1   | 0   | in sel  |

We have two simple functions: in AND sel = a and in and Not(sel) = b.

It's pretty easy to implement using only `And` and `Not` gates.

