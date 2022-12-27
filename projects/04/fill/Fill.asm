// This file is part of www.nand2tetris.org
// and the book "The Elements of Computing Systems"
// by Nisan and Schocken, MIT Press.
// File name: projects/04/Fill.asm

// Runs an infinite loop that listens to the keyboard input.
// When a key is pressed (any key), the program blackens the screen,
// i.e. writes "black" in every pixel;
// the screen should remain fully black as long as the key is pressed. 
// When no key is pressed, the program clears the screen, i.e. writes
// "white" in every pixel;
// the screen should remain fully clear as long as no key is pressed.

// Put your code here.
(SETUP)
    // Set pixel by default white
    @draword
    M=0
    // Set last pressed key value
    @lastkey
    M=0

    // Set words counter to 8191 (screen words capacity)
    @8191 // count of words needed - 1 8191dec = (100 * 20 - 1) hex
    D=A
    @maxwords
    M=D

    @SCREEN
    D=A
    @maxwords
    D=D+M // Add end point of the screen
    @screenend
    M=D // write end point to the memory as counter

// Initially draw white screen
(START)
    // write default counter value (resetting counter)
    @screenend
    D=M
    @counter
    M=D

(DRAW)
    @draword // Load current draw word
    D=M
    @counter // Load current screen end value to A
    A=M // Write current value of @counter to A as address (derefference pointer)
    M=D // Draw black row to the screen word
    D=A-1 // Write decremented screen word address to D
    @counter // Write back decremented value to the end screen
    M=D
    @SCREEN // Load start screen address to A
    D=D-A // calculate screen start address minus screen end address
    @DRAW
    D;JGE // draw again if there are words to fill

// Listen to key press
(READ)
    @KBD
    D=M
    @lastkey
    D=D-M
    @READ
    D;JEQ // read again if nothing changed

    // Update last key pressed
    @KBD
    D=M
    @lastkey
    M=D

    @draword // Set black pixel by default
    M=-1
    @START
    D;JGT // Starting draw black if value read greater than 0

    // Else we set white current pixel and jump to start
    @draword
    M=0
    @START
    0;JMP

// Normally programm will newer get here
(END)
    @END
    0;JMP