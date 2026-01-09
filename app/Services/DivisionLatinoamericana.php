<?php
namespace App\Services;
/**
 * Motor de división larga tradicional latinoamericana para uso educativo.
 * Cumple con las restricciones y formato solicitados.
 *
 * Uso: $resultado = DivisionLatinoamericana::resolver('1002', 9);
 * $resultado es un array estructurado con todos los pasos.
 */

class DivisionLatinoamericana
{
    /**
     * Realiza la división larga tradicional paso a paso.
     * @param string $dividendo
     * @param int $divisor
     * @return array
     */
    public static function resolver(string $dividendo, int $divisor): array
    {
        // Validaciones obligatorias
        if (!ctype_digit($dividendo) || $dividendo[0] === '0') {
            throw new \InvalidArgumentException('El dividendo debe ser un entero positivo, sin ceros a la izquierda.');
        }
        if ($divisor <= 0) {
            throw new \InvalidArgumentException('El divisor debe ser un entero positivo mayor que cero.');
        }
        if (bccomp($dividendo, (string)$divisor) <= 0) {
            throw new \InvalidArgumentException('El dividendo debe ser mayor que el divisor.');
        }

        $len = strlen($dividendo);
        $cociente = '';
        $residuo = 0;
        $steps = [];
        $current = '';
        $column = 0;
        $firstNonZero = false;
        for ($i = 0; $i < $len; $i++) {
            $current .= $dividendo[$i];
            $currentInt = (int)$current;
            $bringDown = true;
            // Solo marcar el primer paso donde el dividendo >= divisor
            if (!$firstNonZero && $currentInt >= $divisor) {
                $firstNonZero = true;
            }
            if ($currentInt < $divisor) {
                $quotientDigit = 0;
                $product = 0;
                $reach = $currentInt;
                $formedNext = $current;
                $nextDigit = ($i + 1 < $len) ? $dividendo[$i + 1] : null;
                $cociente .= '0';
            } else {
                $quotientDigit = intdiv($currentInt, $divisor);
                $product = $quotientDigit * $divisor;
                $reach = $currentInt - $product;
                $formedNext = $reach;
                $nextDigit = ($i + 1 < $len) ? $dividendo[$i + 1] : null;
                $cociente .= (string)$quotientDigit;
                $current = (string)$reach;
            }
            $stepIndex = $firstNonZero ? $i : 0;
            // Solo agregar pasos con índice válido
            if ($stepIndex >= 0 && $stepIndex < $len) {
                $step = [
                    'index' => $stepIndex,
                    'current' => $currentInt,
                    'quotientDigit' => $quotientDigit,
                    'product' => $product,
                    'reach' => $reach,
                    'bringDown' => $bringDown,
                    'nextDigit' => $nextDigit,
                    'formedNext' => $nextDigit !== null ? $reach . $nextDigit : (string)$reach,
                    'column' => $stepIndex
                ];
                // Si hay dígito para bajar, marca la posición para la vista
                if ($nextDigit !== null && $quotientDigit !== 0) {
                    $step['bringDownColumn'] = $stepIndex + 1;
                }
                $steps[] = $step;
            }
        }
        // Si el último paso no corresponde al último dígito del cociente, agregarlo manualmente
        if (strlen($cociente) < $len) {
            for ($j = strlen($cociente); $j < $len; $j++) {
                $steps[] = [
                    'index' => $j,
                    'current' => 0,
                    'quotientDigit' => 0,
                    'product' => 0,
                    'reach' => 0,
                    'bringDown' => false,
                    'nextDigit' => null,
                    'formedNext' => '0',
                    'column' => $j
                ];
            }
        }
        $residuo = (int)$current;
        // Eliminar ceros iniciales del cociente
        $cociente = ltrim($cociente, '0');
        if ($cociente === '') $cociente = '0';
        return [
            'dividendo' => $dividendo,
            'divisor' => $divisor,
            'cociente' => $cociente,
            'residuo' => $residuo,
            'steps' => $steps
        ];
    }
}
