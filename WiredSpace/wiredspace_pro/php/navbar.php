<?php
$pg   = basename($_SERVER['PHP_SELF'], '.php');
$base = (strpos($_SERVER['PHP_SELF'], '/php/') !== false) ? '../' : '';
function na($p,$c){ return $p===$c?' class="active"':''; }
?>
<div class="topbar">
  <div class="wrap tb">
    <div class="tb-l">
      <a href="tel:+390212345678">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
        +39 02 1234567
      </a>
      <a href="mailto:info@wiredspace.it">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
        info@wiredspace.it
      </a>
    </div>
    <div class="tb-r">
      <div class="tb-soc">
        <a href="#" aria-label="LinkedIn">in</a>
        <a href="#" aria-label="Facebook">fb</a>
        <a href="#" aria-label="Instagram">ig</a>
      </div>
      <div class="tb-sep"></div>
      <?php if(auth()): ?>
        <a href="<?php echo $base; ?>dashboard.php">
          <span class="tb-chip">&#128100; <?php echo esc($_SESSION['nome'] ?? 'Area riservata'); ?></span>
        </a>
      <?php else: ?>
        <a href="<?php echo $base; ?>php/login.php">
          <span class="tb-chip">&#128274; Area Clienti</span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<nav class="navbar" role="navigation">
  <div class="wrap nb">
    <a href="<?php echo $base; ?>index.php" class="nb-brand">
      <div class="nb-logo">
        <svg viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
      </div>
      <div>
        <span class="nb-name">WiredSpace</span>
        <span class="nb-tag">Smart Technology Solutions</span>
      </div>
    </a>

    <ul class="nb-menu">
      <li><a href="<?php echo $base; ?>index.php"<?php echo na('index',$pg); ?>>Home</a></li>
      <li><a href="<?php echo $base; ?>chi-siamo.php"<?php echo na('chi-siamo',$pg); ?>>Chi siamo</a></li>
      <li class="dropdown">
        <a href="<?php echo $base; ?>servizi.php"<?php echo na('servizi',$pg); ?>>Servizi &#9662;</a>
        <div class="drop-menu">
          <a href="<?php echo $base; ?>servizi.php?id=1">&#128161; Domotica Integrata</a>
          <a href="<?php echo $base; ?>servizi.php?id=2">&#128274; Sicurezza e Controllo</a>
          <a href="<?php echo $base; ?>servizi.php?id=3">&#127807; Efficienza Energetica</a>
          <a href="<?php echo $base; ?>servizi.php?id=4">&#127925; Audio e Video</a>
          <a href="<?php echo $base; ?>servizi.php?id=5">&#128225; Reti e Infrastrutture</a>
          <a href="<?php echo $base; ?>servizi.php?id=6">&#128295; Manutenzione H24</a>
        </div>
      </li>
      <li><a href="<?php echo $base; ?>settori.php"<?php echo na('settori',$pg); ?>>Settori</a></li>
      <li><a href="<?php echo $base; ?>progetti.php"<?php echo na('progetti',$pg); ?>>Progetti</a></li>
      <li><a href="<?php echo $base; ?>preventivo.php"<?php echo na('preventivo',$pg); ?>>Preventivo</a></li>
      <li><a href="<?php echo $base; ?>contatti.php"<?php echo na('contatti',$pg); ?>>Contatti</a></li>
      <li><a href="<?php echo $base; ?>preventivo.php" class="nb-cta">Preventivo gratuito</a></li>
    </ul>

    <button class="ham" onclick="toggleMenu()" aria-label="Apri menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
