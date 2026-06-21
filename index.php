<?php
/**
 * Calculadora de Interés Compuesto
 */
header('Content-Type: text/html; charset=utf-8');

$final = null; $invertido = null; $ganado = null;
$capital = $tasa = $tiempo = $aportes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $capital = (float)($_POST['capital'] ?? 0);
    $tasa    = (float)($_POST['tasa'] ?? 0);
    $tiempo  = (int)($_POST['tiempo'] ?? 0);
    $aportes = (float)($_POST['aportes'] ?? 0);
    $tipo    = $_POST['tipo'] ?? 'anual';

    if ($capital >= 0 && $tasa >= 0 && $tiempo > 0) {
        $tasaDecimal = $tasa / 100;
        // Cálculo con aportes mensuales
        $saldo = $capital;
        $tasaPeriodo = $tipo === 'mensual' ? $tasaDecimal : $tasaDecimal / 12;
        $meses = $tipo === 'mensual' ? $tiempo : $tiempo * 12;
        for ($i = 0; $i < $meses; $i++) {
            $saldo = $saldo * (1 + $tasaPeriodo) + $aportes;
        }
        $final = $saldo;
        $invertido = $capital + ($aportes * $meses);
        $ganado = $final - $invertido;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calculadora Interés Compuesto Online | ConfiguroWeb</title>
<meta name="description" content="Calcula cuánto crecerá tu dinero con interés compuesto. Incluye aportes mensuales. Calculadora financiera gratis de ConfiguroWeb.">
<meta name="keywords" content="interes compuesto, calculadora financiera, inversion, ahorro, compound interest">
<meta property="og:type" content="website">
<meta property="og:title" content="Calculadora Interés Compuesto Online">
<meta property="og:description" content="Calcula cuánto crecerá tu dinero con interés compuesto y aportes mensuales.">
<link rel="canonical" href="https://demoscweb.com/github/php-calculadora-interes-compuesto/">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"WebApplication","name":"Calculadora Interés Compuesto","applicationCategory":"FinanceApplication","operatingSystem":"Any","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"},"author":{"@type":"Person","name":"ConfiguroWeb","url":"https://configuroweb.com"}}
</script>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
  <h1>💰 Calculadora de Interés Compuesto</h1>
  <p class="subtitle">Descubre el poder de la inversión a largo plazo.</p>
</header>
<main>
  <form method="POST">
    <label for="capital">Capital inicial ($)</label>
    <input type="number" name="capital" id="capital" step="0.01" value="<?php echo htmlspecialchars($capital); ?>" placeholder="1000" required>

    <label for="aportes">Aporte mensual ($)</label>
    <input type="number" name="aportes" id="aportes" step="0.01" value="<?php echo htmlspecialchars($aportes); ?>" placeholder="100">

    <label for="tasa">Tasa de interés (%)</label>
    <input type="number" name="tasa" id="tasa" step="0.01" value="<?php echo htmlspecialchars($tasa); ?>" placeholder="7" required>

    <label for="tipo">Periodo de la tasa</label>
    <select name="tipo" id="tipo">
      <option value="anual" <?php echo ($_POST['tipo'] ?? 'anual')==='anual'?'selected':''; ?>>Anual (EA)</option>
      <option value="mensual" <?php echo ($_POST['tipo'] ?? '')==='mensual'?'selected':''; ?>>Mensual</option>
    </select>

    <label for="tiempo">Tiempo (<?php echo ($_POST['tipo'] ?? 'anual')==='mensual'?'meses':'años'; ?>)</label>
    <input type="number" name="tiempo" id="tiempo" step="1" value="<?php echo htmlspecialchars($tiempo); ?>" placeholder="10" required>

    <button type="submit" class="btn-primary">💰 Calcular</button>
  </form>

  <?php if ($final !== null): ?>
  <div class="resultados">
    <h2>Resultados</h2>
    <div class="tarjeta-destacada">
      <span class="etiqueta">Total Final</span>
      <span class="valor-grande">$<?php echo number_format($final, 2); ?></span>
    </div>
    <div class="grid-3">
      <div class="tarjeta-sm">
        <span class="etiqueta">Invertido</span>
        <span class="valor-sm">$<?php echo number_format($invertido, 2); ?></span>
      </div>
      <div class="tarjeta-sm">
        <span class="etiqueta">Intereses Ganados</span>
        <span class="valor-sm pos">$<?php echo number_format($ganado, 2); ?></span>
      </div>
      <div class="tarjeta-sm">
        <span class="etiqueta">Rentabilidad</span>
        <span class="valor-sm"><?php echo $invertido > 0 ? round(($ganado/$invertido)*100,1) : 0; ?>%</span>
      </div>
    </div>
    <p class="interpretacion">
      📈 De tu total final, <strong>$<?php echo number_format($invertido,2); ?></strong> es lo que aportaste y
      <strong>$<?php echo number_format($ganado,2); ?></strong> son intereses generados por el interés compuesto.
    </p>
  </div>
  <?php endif; ?>

  <section class="info">
    <h2>¿Qué es el interés compuesto?</h2>
    <p>El interés compuesto es "el interés sobre el interés". Cada periodo, los intereses generados se suman al capital y también generan intereses. Albert Einstein lo llamó "la octava maravilla del mundo".</p>
    <p class="formula">Saldo = Capital × (1 + i)ⁿ</p>
  </section>
</main>
<footer>
  <p>Desarrollado por <a href="https://configuroweb.com" target="_blank">ConfiguroWeb</a> ·
     <a href="https://appscweb.com/citas/" target="_blank">Sistema de Citas</a> ·
     <a href="https://appscweb.com/negocios/" target="_blank">Gestión de Negocios</a></p>
  <p>&copy; <?php echo date('Y'); ?> ConfiguroWeb</p>
</footer>
<script src="assets/script.js"></script>
</body>
</html>