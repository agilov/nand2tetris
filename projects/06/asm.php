<?php
$commands = [
    // a = 0
    '0' => '0101010',
    '1' => '0111111',
    '-1' => '0111010',
    'D' => '0001100',
    'A' => '0110000',
    '!D' => '0001101',
    '!A' => '0110001',
    '-D' => '0001111',
    '-A' => '0110011',
    'D+1' => '0011111',
    'A+1' => '0110111',
    'D-1' => '0001110',
    'A-1' => '0110010',
    'D+A' => '0000010',
    'D-A' => '0010011',
    'A-D' => '0000111',
    'D&A' => '0000000',
    'D|A' => '0010101',

    // a =1
    'M' => '1110000',
    '!M' => '1110001',
    '-M' => '1110011',
    'M+1' => '1110111',
    'M-1' => '1110010',
    'D+M' => '1000010',
    'D-M' => '1010011',
    'M-D' => '1000111',
    'D&M' => '1000000',
    'D|M' => '1010101',
];

$destinations = [
    '' => '000',
    'M' => '001',
    'D' => '010',
    'MD' => '011',
    'A' => '100',
    'AM' => '101',
    'AD' => '110',
    'AMD' => '111',
];

$jumps = [
    '' => '000',
    'JGT' => '001',
    'JEQ' => '010',
    'JGE' => '011',
    'JLT' => '100',
    'JNE' => '101',
    'JLE' => '110',
    'JMP' => '111',
];

$symbols = [
    'SP' => 0,
    'LCL' => 1,
    'ARG' => 2,
    'THIS' => 3,
    'THAT' => 4,
    'SCREEN' => 16384,
    'KBD' => 24576,
];

// R0-R15
for ($i = 0; $i <= 15; $i++) {
    $symbols["R$i"] = $i;
}

function clean(string $line): string
{
    $line = preg_replace('/\/\/.*/', '', $line);
    $line = preg_replace('/ /', '', $line);
    return trim($line);
}


/**
 * @param array $lines
 * @return array
 * @throws Exception
 */
function createLabels(array $lines): array
{
    $i = 0;
    $labels = [];
    $rom = 0;

    foreach ($lines as $line) {
        $i++;
        $line = clean($line);
        if (empty($line)) {
            continue;
        }

        if (!str_starts_with($line, '(')) {
            $rom++;
            continue;
        }

        $label = str_replace(['(', ')'], '', $line);

        if (!empty($labels[$label])) {
            throw new Exception("Label $label is already declared. Line $i: $line");
        } else {
            $labels[$label] = $rom;
        }
    }

    return $labels;
}

/**
 * @param array $lines
 * @param array $labels
 * @param array $commands
 * @param array $symbols
 * @param array $destinations
 * @param array $jumps
 * @return array
 * @throws Exception
 */
function compile(array $lines, array $labels, array $commands, array $symbols, array $destinations, array $jumps): array
{
    $output = [];
    $i = 0;
    $ram = 16;

    foreach ($lines as $line) {
        $i++;
        $line = clean($line);

        if (empty($line) || str_starts_with($line, '(')) {
            continue;
        }

        if (str_starts_with($line, '@')) {
            $symbol = str_replace('@', '', $line);

            if (is_numeric($symbol)) {
                $output[] = "0" . str_pad(decbin($symbol), 15, '0', STR_PAD_LEFT);
                continue;
            }

            if (array_key_exists($symbol, $labels)) {
                $output[] = "0" . str_pad(decbin($labels[$symbol]), 15, '0', STR_PAD_LEFT);
                continue;
            }
            if (!array_key_exists($symbol, $symbols)) {
                $symbols[$symbol] = $ram;
                $ram++;
            }

            $output[] = "0" . str_pad(decbin($symbols[$symbol]), 15, '0', STR_PAD_LEFT);
            continue;
        }

        $result = explode(';', $line);
        $destcomp = $result[0];
        $jump = $result[1] ?? '';

        $result = explode('=', $destcomp);
        $dest = $result[0];
        $comp = $result[1] ?? '';

        if ($comp === '' && $dest !== '') {
            $comp = $dest;
            $dest = '';
        }

        $destCode = $destinations[$dest] ?? throw new Exception("Unknown destination: $dest at line $i");
        $compCode = $commands[$comp] ?? throw new Exception("Unknown computation $comp  at line $i");
        $jumpCode = $jumps[$jump] ?? throw new Exception("Unknown jump: $jump  at line $i");

        $output[] = "111$compCode$destCode$jumpCode";
    }

    return $output;
}

$lines = explode("\n", file_get_contents($argv[1]));

$labels = createLabels($lines);

$output = compile($lines, $labels, $commands, $symbols, $destinations, $jumps);

echo implode("\n", $output) . "\n";