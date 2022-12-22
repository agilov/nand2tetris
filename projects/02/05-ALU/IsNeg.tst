load IsNeg.hdl,
output-file IsNeg.out,
compare-to IsNeg.cmp,
output-list in%B1.16.1 out%B2.1.2;

set in %B0000000000000001;
eval,
output;

set in %B0000000000000000;
eval,
output;

set in %B1000000000000000;
eval,
output;

set in %B1000001100000000;
eval,
output;
