<?php
/**
 * MEJORA SUGERIDA: Validación de coherencia fecha vs edad
 * Agregar este método a tu clase Person
 */

/**
 * Validar coherencia entre fecha de nacimiento y edad manual
 */
public function validarCoherenciaEdad()
{
    $errores = [];
    
    if ($this->fecha_nacimiento && $this->edad !== null) {
        $edadCalculada = $this->getEdad(); // Desde fecha_nacimiento
        $edadManual = $this->edad;         // Campo edad
        
        $diferencia = abs($edadCalculada - $edadManual);
        
        // Permitir diferencia de máximo 1 año (por meses no exactos)
        if ($diferencia > 1) {
            $errores[] = "Inconsistencia: La fecha de nacimiento indica {$edadCalculada} años, pero se ingresó {$edadManual} años";
        }
    }
    
    return $errores;
}

/**
 * Validación completa (original + coherencia)
 */
public function validarCompleto()
{
    $errores = $this->validar(); // Validación original
    $erroresCoherencia = $this->validarCoherenciaEdad(); // Nueva validación
    
    return array_merge($errores, $erroresCoherencia);
}
?>