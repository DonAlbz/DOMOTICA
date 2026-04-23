<?php $base = (strpos($_SERVER['PHP_SELF'], '/php/') !== false) ? '../' : ''; ?>
<footer class="footer">
  <div class="wrap">
    <div class="footer-g">
      <div>
        <a href="<?php echo $base; ?>index.php" class="f-brand">
          <div class="f-logo">
            <svg viewBox="0 0 24 24" fill="#fff" width="18" height="18"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <span class="f-name">WiredSpace S.r.l.</span>
        </a>
        <p>Progettiamo e installiamo impianti domotici avanzati per uffici, aziende ed edifici pubblici in tutto il Nord Italia. KNX Partner Certified. ISO 9001:2015.</p>
        <div class="f-soc">
          <a href="#" aria-label="LinkedIn">in</a>
          <a href="#" aria-label="Facebook">fb</a>
          <a href="#" aria-label="Instagram">ig</a>
          <a href="#" aria-label="YouTube">&#9654;</a>
        </div>
      </div>
      <div>
        <h4>Servizi</h4>
        <ul class="fl">
          <li><a href="<?php echo $base; ?>servizi.php?id=1">Domotica Integrata KNX</a></li>
          <li><a href="<?php echo $base; ?>servizi.php?id=2">Sicurezza e Controllo</a></li>
          <li><a href="<?php echo $base; ?>servizi.php?id=3">Efficienza Energetica</a></li>
          <li><a href="<?php echo $base; ?>servizi.php?id=4">Audio e Video Multiroom</a></li>
          <li><a href="<?php echo $base; ?>servizi.php?id=5">Reti e Infrastrutture</a></li>
          <li><a href="<?php echo $base; ?>servizi.php?id=6">Manutenzione H24</a></li>
        </ul>
      </div>
      <div>
        <h4>Azienda</h4>
        <ul class="fl">
          <li><a href="<?php echo $base; ?>chi-siamo.php">Chi siamo</a></li>
          <li><a href="<?php echo $base; ?>settori.php">Settori</a></li>
          <li><a href="<?php echo $base; ?>progetti.php">Portfolio</a></li>
          <li><a href="<?php echo $base; ?>preventivo.php">Preventivo</a></li>
          <li><a href="<?php echo $base; ?>contatti.php">Contatti</a></li>
          <li><a href="<?php echo $base; ?>php/login.php">Area riservata</a></li>
        </ul>
      </div>
      <div>
        <h4>Contatti</h4>
        <ul class="fl">
          <li><a href="tel:+390212345678">&#128222; +39 02 1234567</a></li>
          <li><a href="mailto:info@wiredspace.it">&#9993; info@wiredspace.it</a></li>
          <li style="color:rgba(221,228,240,.35);font-size:.82rem;line-height:1.85;margin-top:.375rem">
            &#128205; Via Tecnologia 12, 25100 Brescia (BS)
          </li>
          <li style="color:rgba(221,228,240,.35);font-size:.82rem;margin-top:.5rem">
            &#128336; Lun&ndash;Ven 8:30&ndash;18:00 | Sab 9:00&ndash;13:00
          </li>
        </ul>
      </div>
    </div>
    <div class="f-bot">
      <span>&copy; <?php echo date('Y'); ?> WiredSpace S.r.l. &mdash; P.IVA 01234567890 &mdash; Tutti i diritti riservati</span>
      <span>Progetto GPOI 2024/2025 &mdash; PHP 8 &middot; MySQL &middot; JavaScript &middot; Animate.css</span>
    </div>
  </div>
</footer>
