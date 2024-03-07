<?php
class Jit
{
    public function index()
    {
        $timeStart = microtime(true);
        for ($y = -39; $y < 39; $y++) {
            printf("\n");

            for ($x = -39; $x < 39; $x++) {
                $i = $this->mandelbrot(
                    $x / 40.0,
                    $y / 40.0
                );

                if ($i == 0) {
                    printf("*");
                } else {
                    printf(" ");
                }
            }
        }

        printf("\n");
        $timeEnd = microtime(true);
        printf($timeEnd - $timeStart);
        // with opcache: 0.53269481658936%
        // without opcache & jit: 0.57809996604919
        // with opcache & jit = function: 0.17820882797241%
        // with opcache & jit = tracing: 0.13781785964966%
    }

    private function mandelbrot($x, $y)
    {
        $cr = $y - 0.5;
        $ci = $x;
        $zi = 0.0;
        $zr = 0.0;
        $i = 0;

        while (1) {
            $i++;

            $temp = $zr * $zi;

            $zr2 = $zr * $zr;
            $zi2 = $zi * $zi;

            $zr = $zr2 - $zi2 + $cr;
            $zi = $temp + $temp + $ci;

            if ($zi2 + $zr2 > 16) {
                return $i;
            }

            if ($i > 5000) {
                return 0;
            }
        }
    }

}

$jit = new Jit();
$jit->index();