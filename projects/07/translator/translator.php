<?php

function clean(string $line): string
{
    $line = preg_replace('/\/\/.*/', '', $line);
    //$line = preg_replace('/ /', '', $line);
    return trim($line);
}


function add(array &$result)
{
    stackPop($result);
    stackPop($result);

    $result[] = "@0\nA=M"; // Load current stack pointer
    $result[] = 'A=A-1'; // A points to first operand now
    $result[] = 'D=M'; // Load first operand
    $result[] = 'A=A-1'; // A point to second operand now
    $result[] = 'D=D+M'; // Add first operand in D and second operand directly from memory
    $result[] = "@0\nA=M"; // Load current stack pointer
    $result[] = 'M=D'; // Write under current stack pointer

    stackPush($result);
}

/**
 * @param array $result
 * @param string $constant
 * @return void
 */
function writeConstant(array &$result, string $constant)
{
    $result[] = '@' . $constant; // loading constant to register А
    $result[] = 'D=A'; // Then copy constant to D (we cant directly load to D)
    $result[] = "@0\nA=M"; // Load current stack pointer
    $result[] = 'M=D'; // Write to memory under stack pointer constant value

    stackPush($result); // push stack pointer
}

// Shift stack pointer to the lower address
function stackPush(array &$result)
{
    $result[] = '@0';
    $result[] = 'D=M';
    $result[] = 'D=D+1';
    $result[] = 'M=D';
}

// Shift stack pointer to the upper address
function stackPop(array &$result)
{
    $result[] = '@0';
    $result[] = 'D=M';
    $result[] = 'D=D-1';
    $result[] = 'M=D';
}

$lines = explode("\n", file_get_contents($argv[1]));


$result = [];

foreach ($lines as $line) {
    $line = clean($line);

    if (empty($line)) {
        continue;
    }

    if (str_starts_with($line, 'push constant ')) {
        writeConstant($result, trim(str_replace('push constant ', '', $line)));
    }

    if ($line === 'add') {
        add($result);
    }
}

echo implode("\n", $result);

echo "\n(END)
@END
0;JMP";