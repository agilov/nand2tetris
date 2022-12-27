// This file is part of www.nand2tetris.org
// and the book "The Elements of Computing Systems"
// by Nisan and Schocken, MIT Press.
// File name: projects/04/Mult.asm

// Multiplies R0 and R1 and stores the result in R2.
// (R0, R1, R2 refer to RAM[0], RAM[1], and RAM[2], respectively.)
//
// This program only needs to handle arguments that satisfy
// R0 >= 0, R1 >= 0, and R0*R1 < 32768.

// Put your code here.
(SETUP)
    // Set product to 0
    @R2
    M=0

    // If first operand is 0 result is 0
    @R0
    D=M
    @END
    D;JEQ

    // If second operand is 0 result is 0
    @R1
    D=M
    @END
    D;JEQ

// Multiplication loop
(LOOP)
    // Load current product to the regiser D
    @R2
    D=M

    @R0 // Load first operand to the register A
    D=D+M // Add first operand and product

    @R2
    M=D // Save product to memory (@R2) from register D

    // Decrement second operand
    @R1
    D=M-1
    M=D
    @LOOP // Repeat if second repeat is not 0
    D;JGT
(END)
    @END
    0;JMP